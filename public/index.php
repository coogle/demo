<?php

require_once '../library/coogle/coogle.php';

define('COOGLE_APP_DIR', __DIR__ . '/../');

$app = new Coogle();

echo $app->initApp()->run();

