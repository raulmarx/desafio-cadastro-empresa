<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VerifyCNPJ implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $cnpj;

    public function __construct($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    public function handle()
    {
        try {
            $response = Http::get("https://receitaws.com.br/v1/cnpj/{$this->cnpj}");

            if ($response->successful()) {
                Cache::put("cnpj_{$this->cnpj}", $response->json(), now()->addDay());
            } else {
                Log::error("Failed to fetch data for CNPJ: {$this->cnpj}. Response: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error("Exception while fetching data for CNPJ: {$this->cnpj}. Exception: " . $e->getMessage());
        }
    }
}
