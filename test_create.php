<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$controller = $app->make(\App\Http\Controllers\Admin\ArtikelController::class);
try {
    $response = $controller->create();
    echo substr($response->render(), 0, 100);
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}
