<?php

namespace config;

use \PDO;

class SqlitePDOConn extends PDO
{
    private $dsn = null;

    public function __construct($db)
    {
        $this->dsn =  "sqlite:" . __DIR__ . "/../$db.db";

        try {
            parent::__construct($this->dsn);
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, pdo::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
}
