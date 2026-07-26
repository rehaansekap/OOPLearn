<?php

/**
 * Laravel - Azure App Service Entrypoint & Auto-Setup
 */

// Hapus file placeholder hostingstart.html bawaan Azure jika ada
if (file_exists(__DIR__ . '/hostingstart.html')) {
    @unlink(__DIR__ . '/hostingstart.html');
}

// Pastikan folder & file database SQLite persisten di /home/database sudah ada
$dbDir = '/home/database';
$dbFile = '/home/database/database.sqlite';

if (!file_exists($dbDir)) {
    @mkdir($dbDir, 0755, true);
}
if (!file_exists($dbFile)) {
    @touch($dbFile);
}

// Teruskan ke Laravel Public Index
require_once __DIR__ . '/public/index.php';
