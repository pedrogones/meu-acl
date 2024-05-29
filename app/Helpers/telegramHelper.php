<?php

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
        error_log("Erro ao enviar mensagem ao grupo.");
    } else {
        $data = json_decode($response, true);
        if (!$data['ok']) {
            error_log("Erro ao enviar mensagem: " . $data['description']);
        }
    }
}
function sendErrorMessage($locale, $bodyMessage) {
    $BOT_TOKEN = config('services.telegram.bot_token');
    $CHAT_ID = config('services.telegram.chat_id');
    $message = "Erro: ".$locale."\nO erro diz: " . $bodyMessage;
    sendMessageToTelegram($BOT_TOKEN, $CHAT_ID, $message);
}
