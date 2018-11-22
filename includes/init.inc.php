<?php
// Set header charset.
header('Content-Type: text/html; charset=utf-8');

// Include database configuration
require_once dirname(__FILE__) . '/dbconfig.inc.php';

// Create a PDO object
try {
    $pdo  = new PDO(DSN_PROJ, DB_USER, DB_PASS);

} catch(PDOException $e) {
    echo 'Connection failed: init.inc.php(14) <pre>' .  $e->getMessage();
}

// Automatically called in case you are trying to use a class.
function __autoload($classname) 
{
    $filename = DOC_ROOT . PROJ_NAME . '/classes/' . $classname . '.class.php';

    if(file_exists($filename)) {
        include $filename;
    } else {
        throw new Exception('Unable to load ' . $filename);
    }
}