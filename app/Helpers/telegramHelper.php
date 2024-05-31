<?php
function sendMessageToTelegram($botToken, $chatId, $message) {
    $apiUrl = "https://api.telegram.org/bot$botToken/sendMessage";
    $postData = json_encode(['chat_id' => $chatId, 'text' => $message]);

    $options = ['http' => [
        'method' => 'POST',
        'header' => "Content-Type:application/json\r\n",
        'content' => $postData
        ]
    ];
    $response = file_get_contents($apiUrl, false, stream_context_create($options));

    if ($response === FALSE || !($data = json_decode($response, true)) || !$data['ok']) {
        error_log($response ? "Erro ao enviar mensagem: " . $data['description'] : "Erro ao enviar mensagem ao grupo.");
    }
}

function sendErrorMessage($headerMessage, $bodyMessage) {
    $botToken = config('services.telegram.bot_token');
    $chatId = config('services.telegram.chat_id');
    sendMessageToTelegram($botToken, $chatId, "$headerMessage\n$bodyMessage");
}

