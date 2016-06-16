<?php 

    require_once("db/logs.db.php");
    class Logs
    {
        public $logsDb;
        function Logs() {
            $this->logsDb = new LogsDb();   
        }
        function createLog($message, $type, $user) {
            $l = $this->logsDb->insertLog($message, $type, $user);
        }
    }

    

?>