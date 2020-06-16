<?php

class SqlitePDOConn extends \PDO
{
    private $dsn = null;

    public function __construct($db)
    {
        $this->dsn =  "sqlite:" . __DIR__ . "/../$db.db";

        try {
            parent::__construct($this->dsn);
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
}
