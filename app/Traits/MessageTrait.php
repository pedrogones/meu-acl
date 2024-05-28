<?php

namespace App\Traits;

use App\Exceptions\Handler;

trait MessageTrait
{
    private function messageStatus($status, $message = null)
    {
        $messageToast = config("message.{$status}.message");

        if (isset($message)) {
            $messageToast = $message;
        }
        if ($status === 'error') {
         //  return toastr()->$status($messageToast);
        }

    }

    /**
     * Envia uma mensagem de erro ao Telegram.
     *
     * @param string $message
     * @return void
     */

}
