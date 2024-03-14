<?php
    class Database {
        private $cn;
        private $host;
        private $port;
        private $dbName;
        private $user;
        private $pw;

        public function __construct() {
        $this->user = getenv('USER_NAME');
        $this->pw = getenv('PASSWORD');
        $this->dbName = getenv('DBNAME');
        $this->host = getenv('HOST');
        $this->port = getenv('PORT');

        // echo "\nuser:    " . $this->user;
        // echo "\npw:      " . $this->pw;
        // echo "\ndbName:  " . $this->dbName;
        // echo "\nhost     " . $this->host;
        // echo "\nport:    " . $this->port;

        }


        public function connect() {
        if ($this->cn) {
            //  connection already exists, so return it
            echo "\n\nConnection already exists!  Returning existing connection.";
            return $this->cn;
        }
        else {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbName};";
            echo "\n\nAttempting to connect database:\n";
            echo "\tdsn: " . $dsn;

            try {
                echo "\n\tusername: " . $this->user;
                echo "\n\tpassword: " . $this->pw;
                $this->cn = new PDO($dsn, $this->user, $this->pw);
                $this->cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "\n\n\tDatabase connect function completed successfully.  Returning new connection.\n";
                echo "\n\tcn: " . json_encode($this->cn);

                return $this->cn;
            }
            catch (PDOException $e) {
                echo "\n\nConnection Error: \n\t" . $e->getMessage();
            }
        }
        }

    }