<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Dotenv\Dotenv;

class LoadDomainSpecificEnv
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $domain = $request->getHost();
        
        // If the domain starts with "www", redirect to non-www version
        if (strpos($domain, 'www.') === 0) {
            $domain = str_replace('www.', '', $domain);
            return redirect()->secure($domain);
        }
        
        // Path to the domain-specific .env file
        $envFile = base_path("env/.env.{$domain}");
        
        

        // Check if the .env file for the domain exists
        if (file_exists($envFile)) {
            dd($envFile);
            // Load the environment variables for the specific domain
            $dotenv = Dotenv::createImmutable(base_path(), "env/.env.{$domain}");
            $dotenv->load();
        } else {
            // Redirect to a fallback domain if the environment file doesn't exist
            return redirect('https://zo.tc');
        }

        // Proceed with the request
        return $next($request);
    }
}
