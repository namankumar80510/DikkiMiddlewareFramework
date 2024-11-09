<?php

declare(strict_types=1);

/**
 * A simple middleware framework for PHP, inspired by Mezzio.
 */

use App\Bootstrap;

// require paths constants
require_once __DIR__ . '/../paths_constants.php';

// require vendor autoload
require_once VENDOR_PATH . 'autoload.php';

// run bootstrap
$app = new Bootstrap();
$app->run();
