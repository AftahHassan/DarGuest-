<?php

namespace App\Services;

use App\Models\Message;
use App\Models\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqAnalysisService
{
    protected const CATEGORIES = [
        'accommodation', 'check_in', 'check_out', 'wifi', 'parking',
        'restaurant', 'taxi', 'beach', 'surf_school', 'house_rules',
        'technical_problem', 'emergency', 'other',
    ];

    public function analyze(Message $message): void
    {
        $property = $message->conversation->reservation->property;

        $context = [
            'title' => $property->title,
            'wifi_name' => $property->info?->wifi_name,
            'wifi_password' => $property->info?->wifi_password,
            'check_in' => $property->info?->check_in,
            'check_out' => $property->info?->check_out,
            'parking' => $property->info?->parking,
            'parking_info' => $property->info?->parking_info,
            'access_instructions' => $property->info?->access_instructions,
            'house_rules' => $property->info?->house_rules,
            'recommendations' => $property->recommendations->map(fn ($r) => [
                'category' => $r->category,
                'name' => $r->title,
                'address' => $r->address,
            ])->toArray(),
        ];

        try {
            $response = Http::withToken(config('services.groq.api_key'))
                ->timeout(20)
                ->baseUrl(config('services.groq.base_url'))
                ->post('/chat/completions', [
                    'model' => config('services.groq.model'),
                    'temperature' => 0.3,
                    'response_format' => ['type' => 'json_object'],
                    'messages' => [
                        ['role' => 'system', 'content' => $this->systemPrompt()],
                        ['role' => 'user', 'content' => $this->userPrompt($message->message, $context)],
                    ],
                ]);

            if (! $response->successful()) {
                throw new \RuntimeException('Groq API error: '.$response->status());
            }

            $raw = $response->json('choices.0.message.content');
            $data = json_decode($raw, true);

            $this->validate($data);

            $message->aiAnalysis()->create([
                'detected_language' => $data['language'],
                'category' => $data['category'],
                'urgency' => (bool) $data['urgent'],
                'generated_response' => $data['response'],
                'structured_output' => $data,
                'confidence' => $data['confidence'] ?? null,
                'analyzed_at' => now(),
            ]);

            if ($data['urgent']) {
                $this->notifyOwner($message);
            }
        } catch (\Throwable $e) {
            Log::error('Groq analysis failed', [
                'message_id' => $message->id,
                'error' => $e->getMessage(),
            ]);

            $message->aiAnalysis()->create([
                'category' => 'other',
                'urgency' => false,
                'generated_response' => "Nous ne pouvons pas générer de réponse automatique pour le moment. Le propriétaire vous contactera sous peu.",
                'analyzed_at' => now(),
            ]);
        }
    }

    protected function systemPrompt(): string
    {
        $categories = implode(', ', self::CATEGORIES);

        return <<<PROMPT
Tu es l'assistant IA de conciergerie DarGuest pour des locations saisonnières à Agadir et Taghazout.

Règles strictes :
1. Tu ne dois JAMAIS inventer d'information. Utilise UNIQUEMENT les informations du contexte logement fourni.
2. Si une information demandée n'existe pas dans le contexte, réponds poliment que le propriétaire sera contacté.
3. Réponds dans la langue du message du voyageur si tu la reconnais, sinon en anglais.
4. Détecte si le message décrit une urgence réelle (incendie, fuite d'eau, panne électrique, porte cassée, perte de clés, urgence médicale). Ne classe PAS comme urgent une simple question sur les horaires ou équipements.
5. Réponds UNIQUEMENT avec un objet JSON valide, sans texte avant ou après, avec exactement ces champs :
{
  "language": "nom de la langue détectée en anglais, ex: French, English, Spanish, Arabic, German",
  "category": "une valeur parmi : {$categories}",
  "urgent": true ou false,
  "confidence": nombre décimal entre 0 et 1,
  "response": "la réponse à envoyer au voyageur, concise et chaleureuse"
}
PROMPT;
    }

    protected function userPrompt(string $message, array $context): string
    {
        $contextJson = json_encode($context, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return "Contexte du logement :\n{$contextJson}\n\nMessage du voyageur :\n{$message}";
    }

    protected function validate(?array $data): void
    {
        if (! is_array($data)) {
            throw new \RuntimeException('Groq did not return valid JSON.');
        }

        foreach (['language', 'category', 'urgent', 'response'] as $field) {
            if (! array_key_exists($field, $data)) {
                throw new \RuntimeException("Missing field in Groq response: {$field}");
            }
        }

        if (! in_array($data['category'], self::CATEGORIES, true)) {
            $data['category'] = 'other';
        }
    }

    protected function notifyOwner(Message $message): void
    {
        $owner = $message->conversation->reservation->property->owner;

        Notification::create([
            'user_id' => $owner->id,
            'title' => 'Urgence détectée',
            'content' => "Message urgent reçu : \"{$message->message}\"",
            'type' => 'emergency',
        ]);
    }
}