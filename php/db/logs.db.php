<?php

    require_once("db/pdo.db.php");
    class LogsDb
    {
        private $pdo;
        function LogsDb()
        {
            $this->pdo = new PDOConnection();
        }
        function insertLog($message, $type, $user) {
            $result;
            try {
                $q = "INSERT INTO log(type, message, user, created_by) VALUES(:type, :message, :user, :created_by)";
                if(!$user)
                    $q = "INSERT INTO log(type, message, created_by) VALUES(:type, :message, :created_by)";
                $lq = $this->pdo->connection->prepare($q);
                $lq->bindParam(":type", $type, PDO::PARAM_STR);
                $lq->bindParam(":message", $message, PDO::PARAM_STR);
                $lq->bindParam(":created_by", $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
                if($user)
                   $lq->bindParam(":user", $user, PDO::PARAM_STR);
                $lq->execute();
                $result = true;
            }
            catch(PDOException $e) {
                error_log($e);
                $result = false;
            }
        }

    }

?>
