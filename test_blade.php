<?php
// Teste rápido do BladeOne

require __DIR__ . '/bootstrap.php';

use App\library\View;

echo "<h1>Teste BladeOne</h1>";

try {
    View::render('test', ['name' => 'Usuário Teste']);
} catch (\Exception $e) {
    echo "Erro: " . $e->getMessage();
}
