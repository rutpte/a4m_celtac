<?php
class DBConnection
{
    /**
     * Stores a database object
     * 
     * @var object A database object
     */
    public $db;

    /**
     * __construct — Initialization connect to database. 
     *
     * @param object $dbo a database object
     * @return No value is returned.
     */
    public function __construct($pdo=null)
    {
        // Checks for a DB object or creates one if one isn't found
        if (is_object($pdo)) {
            $this->db = $pdo;
        } else {
            $dsn = "pgsql:host=" . DB_HOST . ";dbname=" . PRJ_DB_NAME;
            try {
                // connect to postgres object databse
                $this->db = new PDO($dsn, DB_USER, DB_PASS);
            } catch (PDOException $e) {
                // if can't connect display error message
                echo 'Connection failed: <pre>' . $e->getMessage();
            }
        }
    }

    /**
     * __destruct — Database close connection
     *
     * @return No value is returned.
     */
    public function __destruct() 
    {
        // database disconnect
        if (!empty($this->db)) $this->db = null;
    }
}