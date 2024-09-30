<?php
function loadEnv() {
	if (file_exists(__DIR__ . '/../../.env')) {
		$lines = file(__DIR__ . '/../../.env');
		foreach ($lines as $line) {
			list($key, $value) = explode('=', $line, 2);
			putenv(trim($key) . '=' . trim($value));
        }
    }
}

loadEnv();
// Configuración de la base de datos
$host = getenv('DB_HOST');
$db   = getenv('DB_DATABASE');
$user = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

