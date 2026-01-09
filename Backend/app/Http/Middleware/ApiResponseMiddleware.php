<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Si c'est une réponse JSON, on s'assure qu'elle a la bonne structure
        if ($request->expectsJson()) {
            $content = $response->getContent();
            
            // Si la réponse n'est pas déjà au format attendu, on la formate
            if (!empty($content) && !$this->isValidApiResponse($content)) {
                try {
                    $data = json_decode($content, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        // C'est du JSON valide, on vérifie la structure
                        if (!isset($data['success'])) {
                            $data = [
                                'success' => true,
                                'data' => $data
                            ];
                            $response->setContent(json_encode($data));
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Erreur dans ApiResponseMiddleware: ' . $e->getMessage());
                }
            }
        }

        return $response;
    }

    /**
     * Vérifie si la réponse a déjà le bon format API
     */
    private function isValidApiResponse(string $content): bool
    {
        try {
            $data = json_decode($content, true);
            return json_last_error() === JSON_ERROR_NONE && isset($data['success']);
        } catch (\Exception $e) {
            return false;
        }
    }
}
