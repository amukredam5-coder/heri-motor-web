<?php
// Memaksa Laravel menganggap permintaan datang ke /api/cek-database
$_SERVER['REQUEST_URI'] = '/api/cek-database';

require __DIR__ . '/../public/index.php';