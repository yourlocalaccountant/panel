<?php

namespace Pterodactyl\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Throwable;

class HealthController extends Controller
{
    /**
     * Return readiness for load balancers and uptime monitors without exposing
     * infrastructure details to an unauthenticated caller.
     */
    public function __invoke(): JsonResponse
    {
        $ready = $this->databaseIsReachable() && $this->cacheIsReachable();

        return response()->json(['status' => $ready ? 'ok' : 'unavailable'], $ready ? 200 : 503);
    }

    private function databaseIsReachable(): bool
    {
        try {
            DB::select('SELECT 1');

            return true;
        } catch (Throwable) {
            return false;
        }
    }

    private function cacheIsReachable(): bool
    {
        try {
            Cache::store()->get('pterodactyl:healthz');

            return true;
        } catch (Throwable) {
            return false;
        }
    }
}
