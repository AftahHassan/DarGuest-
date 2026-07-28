<?php

namespace App\Jobs;

use App\Models\Message;
use App\Services\GroqAnalysisService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AnalyzeMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 5;

    public function __construct(public Message $message) {}

    public function handle(GroqAnalysisService $groq): void
    {
        $groq->analyze($this->message);
    }
}