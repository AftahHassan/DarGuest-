<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiAnalysis extends Model
{
    use HasFactory;

    protected $table = 'ai_analyses';

    protected $fillable = [
        'message_id', 'detected_language', 'category', 'urgency',
        'generated_response', 'structured_output', 'confidence', 'analyzed_at',
    ];

    protected function casts(): array
    {
        return [
            'urgency' => 'boolean',
            'structured_output' => 'array',
            'confidence' => 'decimal:3',
            'analyzed_at' => 'datetime',
        ];
    }

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
