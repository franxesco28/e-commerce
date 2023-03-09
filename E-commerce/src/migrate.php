<?php

require_once 'src/pdo/config.inc.php';
require_once 'src/mysqli/mysqli.php';
require_once 'Services/ImageService.php';

$db = connectMySQLi( HOST, PORT, USER, PASSWORD, DB );

echo "migrating table for pictures......";

ImageDbService::CreateImageTable($db, 'contacts');

echo "done";