<?php

namespace App\Http\Middleware;

use App\Traits\DatabaseRoutingTrait;
use Closure;

class DatabaseRouting
{

    use DatabaseRoutingTrait;


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string
     * @return mixed
     */
    public function handle($request, Closure $next, $conn = null)
    {
        if( !empty($conn) ) {

            $this->setDatabaseConnection($conn);

        }

        return $next($request);
    }
}
