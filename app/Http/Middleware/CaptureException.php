<?php
// app/Http/Middleware/CaptureExceptionMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Throwable;

class CaptureException
{
    public function handle(Request $request, Closure $next)
    {

    }
}
