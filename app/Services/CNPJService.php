<?php

namespace App\Services;

use App\Jobs\VerifyCNPJ;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CNPJService
{
    public function checkCNPJ($cnpj)
    {
        $cacheKey = "cnpj_{$cnpj}";

        // Verificar se o CNPJ já está em cache
        if (Cache::has($cacheKey)) {
            return [
                'status' => 'success',
                'data' => Cache::get($cacheKey)
            ];
        }

        // Disparar o Job para buscar os dados do CNPJ
        try {
            VerifyCNPJ::dispatch($cnpj);

            return [
                'status' => 'job_dispatched',
                'message' => 'Job dispatched to verify CNPJ. Please try again in a few minutes.'
            ];
        } catch (\Exception $e) {
            Log::error("Failed to dispatch VerifyCNPJ job: " . $e->getMessage());

            return [
                'status' => 'error',
                'message' => 'Failed to dispatch job to verify CNPJ.'
            ];
        }
    }

    public function getCNPJData($cnpj)
    {
        $cacheKey = "cnpj_{$cnpj}";

        if (Cache::has($cacheKey)) {
            return [
                'status' => 'success',
                'data' => Cache::get($cacheKey)
            ];
        }

        return [
            'status' => 'not_found',
            'message' => 'CNPJ data not found in cache.'
        ];
    }
}
