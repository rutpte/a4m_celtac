<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
# [Database host name]
define('DB_HOST', 'localhost');

//*------------------------------------------------------------------------------ 
# [Database user name]
define('DB_USER', 'postgres');

//if (strtoupper(substr(php_uname('n'), 0, 3)) === 'PTE') {

define('DB_PASS', 'pgpteadmin');

//*------------------------------------------------------------------------------

# [Database name]
define('PRJ_DB_NAME', 'a4m_celtac');

//*-------------------------------------------------------------------------------

# [DSN]
define('DSN_PROJ', "pgsql:host=" . DB_HOST . ";dbname=" . PRJ_DB_NAME);

//--------------------------------------------------------------------------------
# [dblink]
// define('DB_PORT', '5432');
// define('DB_CLD_LINK','dbname=' . CLD_DB_NAME . ' port=' . DB_PORT . ' user=' . DB_USER . ' password=' . DB_PASS);
//--------------------------------------------------------------------------------

// Define project name
define("PROJ_NAME", '/a4m_celtac');

// Document root
define("DOC_ROOT", $_SERVER['DOCUMENT_ROOT']);

//defne TMP 
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    // Temp file directory.
    define("TMP_FILE", 'C:/tmp');
    define("VIDEO_PATH", 'D:/xxx');

    
} else {
    // Temp file directory.
    define("TMP_FILE", '/tmp');
    define("VIDEO_PATH", '/xxx');

}