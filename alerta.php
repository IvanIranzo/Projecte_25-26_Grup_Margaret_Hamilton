<?php
// Config
$telegram_token   = "8668641100:AAGUPWA_YPx4KpK8tqUs1hsy_ERdnPDO1Ao";
$telegram_chat_id = "8536070467";

// Acepta POST con campo "distancia"
$distancia = $_POST['distancia'] ?? null;
if ($distancia === null) {
    http_response_code(400);
    exit("Falta distancia");
}

// Responde al ESP32 inmediatamente y cierra la conexión
ignore_user_abort(true);
ob_start();
echo "OK";
header('Content-Length: ' . ob_get_length());
header('Connection: close');
ob_end_flush();
@ob_flush();
flush();

// A partir de aquí, el ESP32 ya recibió "OK" y desconectó.
// El PHP sigue trabajando para enviar el Telegram.

$texto = "🚨 Movimiento detectado a " . $distancia . " cm";

$url = "https://api.telegram.org/bot{$telegram_token}/sendMessage";
$data = [
    'chat_id' => $telegram_chat_id,
    'text'    => $texto,
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_exec($ch);
curl_close($ch);
