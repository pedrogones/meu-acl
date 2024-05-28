<?php

namespace App\config;

use App\Exceptions\Handler;
trait MessageTrait
{
    private function messageStatus($status, $message = null)
    {
        if ($status === 'error') {
            app(Handler::class)->report();
        }
    }
}
