<?php
include 'config.php';

function sendMessageToTelegram($botToken, $chatId, $message) {
    $apiUrl = "https://api.telegram.org/bot" . $botToken . "/sendMessage";
    $postData = [
        'chat_id' => $chatId,
        'text' => $message
    ];

    $options = [
        'http' => [
            'method'  => 'POST',
            'header'  => "Content-Type:application/json\r\n",
            'content' => json_encode($postData),
        ],
    ];

    $context  = stream_context_create($options);
    $response = file_get_contents($apiUrl, false, $context);

    if ($response === FALSE) {
        echo "Erro ao enviar mensagem ao grupo.";
        exit;
    } else {
        $data = json_decode($response, true);
        if (!$data['ok']) {
            echo "Erro ao enviar mensagem: " . $data['description'];
            exit;
        }
    }
}

$apiUrl = "https://api.telegram.org/bot" . $BOT_TOKEN . "/getMe";

$response = file_get_contents($apiUrl);
if ($response === false) {
    echo "Erro ao conectar-se com o bot";
    exit;
} else {
    // Decodificar a resposta JSON e exibir
    $data = json_decode($response, true);
    if ($data['ok'] == true) {
        echo "Bot name: " . $data['result']['username'];
        echo "<br>";
        echo "Bot id: " . $data['result']['id'] . "\n";

        // Enviar uma mensagem ao grupo informando que o script foi executado com sucesso
        $message = "O script foi executado com sucesso.";
        sendMessageToTelegram($BOT_TOKEN, $CHAT_ID, $message);
    } else {
        echo "Erro ao obter informações do bot";
        exit;
    }
}

// Corrigir escopo global das variáveis
function sendErrorMessage($locale, $bodyMessage, $botToken, $chatId) {
    $message = "Ocorreu um erro na classe " . $locale . "\nO erro diz: " . $bodyMessage;
    sendMessageToTelegram($botToken, $chatId, $message);
}

// Exemplo de uso da função sendErrorMessage
try {
    // Código que pode lançar uma exceção
    throw new Exception("Mensagem de erro de exemplo.");
} catch (Exception $e) {
    sendErrorMessage('infoBot.php', $e, $BOT_TOKEN, $CHAT_ID);
}
