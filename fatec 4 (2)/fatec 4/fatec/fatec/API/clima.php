<?php
header('Content-Type: application/json; charset=utf-8');

$apiKey = '5fd8b43c3872a9ee64fdcd64284f45e4';

$cidade = $_GET['Americana'] ?? 'Americana';

if (!$cidade) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Cidade obrigatória']);
    exit;
}

$url = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($cidade) . "&appid=$apiKey&units=metric&lang=pt_br";

$response = file_get_contents($url);

if ($response === FALSE) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro na API externa']);
    exit;
}

$data = json_decode($response, true);

if ($data['cod'] != 200) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => $data['message'] ?? 'Cidade não encontrada']);
    exit;
}

echo json_encode([
    'success' => true,
    'cidade' => $data['name'],
    'temp' => round($data['main']['temp']),
    'desc' => ucfirst($data['weather'][0]['description'])
]);
