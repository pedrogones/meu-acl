<?php
// app/Listeners/LogErrorListener.php

namespace App\Listeners;

use Illuminate\Log\Events\MessageLogged;

class LogErrorNotify
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Log\Events\MessageLogged  $event
     * @return void
     */
    public function handle(MessageLogged $event)
    {
        $emojis = [
            'error'     => '🚨',
            'warning'   => '⚠️',
            'info' => 'ℹ️'
        ];
        $emoji = $emojis[$event->level] ?? '⚠️';

      try {
        $messageToSend = $this->messageOrganized($event->message);
        $this->sendNotification($event->level, $emoji, $messageToSend);
      } catch (\Throwable $e) {
        require_once app_path('Helpers/telegramHelper.php');
        sendErrorMessage("🚨 Erro interno 🚨\nOcorreu um erro ao tentar comunicar com o chatbot, provavelmente ao tentar enviar uma mensagem muito grande.\n", $e->getMessage());
    }
    }

    private function sendNotification($level, $emoji, $message)
    {
        require_once app_path('Helpers/telegramHelper.php');

        if ($level === 'warning') {
            sendErrorMessage($emoji . "\t Warning \t" . $emoji . "\n", $message);
        } else if ($level === 'error') {
            sendErrorMessage("$emoji\t Aconteceu um Erro \t$emoji\n", $message);
        }else if($level === 'info'){
            sendErrorMessage("$emoji\t Info \t$emoji\n", $message);
        }
    }

    /**
     * Se a mensagem for muito longa(Se tiver sendo passada uma Exception na string) n é possivel mandar no grupo,
     * aqui verifica e faz alguns ajustes nela
     *
     * @param string $message
     * @return string
     */
    private function messageOrganized($message)
    {
        if (strlen($message) < 4060) {
            return $message;
        } else {
            //tem q ver isso aq por q testei com alguns casos bem específicos, talvez n sirva p tudo
            $pattern = '/(.*?)in (.*?):(\d+)/s';
            if (preg_match($pattern, $message, $matches)) {
                return "Detalhes do erro:\n$matches[1]\nLocalizado em:\n$matches[2]$matches[3]";
            }
        }
    }
}
