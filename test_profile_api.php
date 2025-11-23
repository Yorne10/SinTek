<?php
/**
 * Script de prueba para API de perfil
 * Ejecutar: php test_profile_api.php
 */

$baseUrl = 'http://100.100.162.15:8000/api';

// Paso 1: Login
echo "=== PASO 1: LOGIN ===\n";
$loginData = [
    'email' => 'trabajador@sintek.test',
    'password' => 'Worker2025!'
];

$ch = curl_init($baseUrl . '/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($loginData));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Status Code: $httpCode\n";
echo "Response: $response\n\n";

$loginResponse = json_decode($response, true);

if (!isset($loginResponse['data']['token'])) {
    die("Error: No se pudo obtener el token. Verifica las credenciales.\n");
}

$token = $loginResponse['data']['token'];
echo "Token obtenido: " . substr($token, 0, 20) . "...\n\n";

// Paso 2: Ver perfil actual
echo "=== PASO 2: VER PERFIL ACTUAL ===\n";
$ch = curl_init($baseUrl . '/my-profile');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Status Code: $httpCode\n";
echo "Response: " . json_encode(json_decode($response), JSON_PRETTY_PRINT) . "\n\n";

// Paso 3: Actualizar perfil
echo "=== PASO 3: ACTUALIZAR PERFIL ===\n";
$updateData = [
    'name' => 'Nombre Actualizado ' . date('H:i:s'),
    'phone' => '555' . rand(1000000, 9999999),
    'curp' => 'TEST123456HDFRNN01',
    'adress' => 'Calle de Prueba #' . rand(1, 999)
];

echo "Datos a enviar:\n";
echo json_encode($updateData, JSON_PRETTY_PRINT) . "\n\n";

$ch = curl_init($baseUrl . '/my-profile');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($updateData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Status Code: $httpCode\n";
echo "Response: " . json_encode(json_decode($response), JSON_PRETTY_PRINT) . "\n\n";

// Paso 4: Verificar cambios
echo "=== PASO 4: VERIFICAR CAMBIOS ===\n";
$ch = curl_init($baseUrl . '/my-profile');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Status Code: $httpCode\n";
echo "Response: " . json_encode(json_decode($response), JSON_PRETTY_PRINT) . "\n\n";

echo "=== PRUEBA COMPLETADA ===\n";
