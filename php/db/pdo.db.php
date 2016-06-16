<?php
    require_once("db/config.db.php");
    class PDOConnection {
        public $connection;
        function PDOConnection() {
            $dbconfig = new DbConfig();
            $this->connection = new \PDO("mysql:host=" . $dbconfig->host . ";dbname=" . $dbconfig->db . ";port=3306;", $dbconfig->user, $dbconfig->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if(!$this->connection) {
                exit();
            }
        }
        function getLevenshtein($word)
        {
            $words = array();
            for ($i = 0; $i < strlen($word); $i++) {
                // insertions
                $words[] = substr($word, 0, $i) . '_' . substr($word, $i);
                // deletions
                $words[] = substr($word, 0, $i) . substr($word, $i + 1);
                // substitutions
                $words[] = substr($word, 0, $i) . '_' . substr($word, $i + 1);
                $words[] = substr($word, 0, $i) . substr($word, $i+1, 1) . '_' . substr($word, $i + 2);
            }
            // last insertion
            $words[] = $word . '_';
            return $words;
        }
    }

?>
