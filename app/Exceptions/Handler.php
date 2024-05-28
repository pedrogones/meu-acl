<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
   /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    /*
    public function register(): void
    {

            $this->reportable(function (Throwable $e) {
            // Carrega o helper do Telegram
            require_once app_path('Helpers/telegramHelper.php');

            // Configuração do bot - recuperando as informações do .env
            $BOT_TOKEN = config('services.telegram.bot_token');
            $CHAT_ID = config('services.telegram.chat_id');

            // Envia a mensagem de erro para o Telegram
            sendErrorMessage($e->getMessage(), $BOT_TOKEN, $CHAT_ID);
        });

    }
    */

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {

        });
    }
    public function report($e){
        require_once app_path('Helpers/telegramHelper.php');
        // Envia a mensagem de erro para o Telegram
        sendErrorMessage("Método update, classe UserController", $e->getMessage());
    }
}
