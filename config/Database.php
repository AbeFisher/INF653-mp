<?php
    class Database {
        private $cn;
        private $host;
        private $port;
        private $dbName;
        private $user;
        private $pw;

        public function __construct() {
        $this->user = getenv('USERNAME');
        $this->pw = getenv('PASSWORD');
        $this->dbName = getenv('DBNAME');
        $this->host = getenv('HOST');
        $this->port = getenv('PORT');
        }

        public function connect() {
        if ($this->cn) {
            //  connection already exists, so return it
            return $this->cn;
        }
        else {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbName};";

            try {
            $this->cn = new PDO($dsn, $this->user, $this->pw);
            $this->cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->cn;
            }
            catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
            }
        }
        }

    }