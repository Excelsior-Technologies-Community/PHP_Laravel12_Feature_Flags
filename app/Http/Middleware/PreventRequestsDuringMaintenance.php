<?php

namespace App\Http\Middleware;

use YlsIdeas\FeatureFlags\Middlewares\PreventRequestsDuringMaintenance as Middleware;
use YlsIdeas\FeatureFlags\Facades\Features;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Example: If a critical feature is disabled, block the request
        // Replace 'critical_system' with your actual feature name
        if (Features::accessible('critical_system') === false) {
            return response('This feature is currently under maintenance or disabled.', 503);
        }

        return parent::handle($request, $next);
    }
}