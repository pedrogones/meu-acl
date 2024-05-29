<?php

namespace App\Logging;
require_once app_path('Helpers/telegramHelper.php');

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Handler\HandlerInterface;
use Monolog\LogRecord;

class TelegramLogger extends AbstractProcessingHandler implements HandlerInterface
{
    /**
     * Construtor
     *
     * @param int|string $level Nível de log
     * @param bool $bubble Indica se o log deve borbulhar até os manipuladores superiores
     */
    public function __construct($level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);
    }

    /**
     * Manipula o registro de log
     *
     * @param LogRecord $record Registro de log
     * @return void
     */
    protected function write(LogRecord $record): void
    {
       
        /*

        // Verifica se é um erro ou um aviso
        if ($level === 'ERROR' || $level === 'WARNING') {
            // Obtém o local da exceção (caminho do erro)
            $context = $record['context'];
            $localDaExcecao = $context['file'] . ':' . $context['line'];

            // Monta a mensagem a ser enviada para o Telegram
            $telegramMessage = "Erro!\n";
            $telegramMessage .= "Tipo de erro: $message\n";
            $telegramMessage .= "Path: $localDaExcecao\n";
            $telegramMessage .= "Mais informações que podem ajudar a encontrar e solucionar o erro...";

            // Envia a mensagem para o Telegram
            sendErrorMessage($localDaExcecao, $telegramMessage);
        }
        */
    }
}
