<?php

    require_once("db/pdo.db.php");
    class BudgetDb
    {
        private $pdo;
        function BudgetDb()
        {
            $this->pdo = new PDOConnection();
        }
        function getCurrentBudget() {
          $result;
          try {
            $currentAcademicYear = date("Y");
            $currentMonth = date("m");
            if($currentMonth === "6") {
              $currentDay = date("d");
              if($currentDay === "30")
                $currentAcademicYear = date("Y") + 1;
            }
            else if($currentMonth > 6)
              $currentAcademicYear = date("Y") + 1;

            $bq = $this->pdo->connection->prepare("SELECT * FROM total_budget WHERE academic_year = :index_id AND current = 1 AND removed_by IS NULL");
            $bq->bindParam(":index_id", $currentAcademicYear, PDO::PARAM_INT);
            $bq->execute();
            $result = $bq->fetch(\PDO::FETCH_ASSOC);
          }
          catch(PDOException $e) {
            error_log($e);
            $result = false;
          }
          return $result;
        }
        function setNewBudget($budget, $username) {
          $result;
          $continue = true;
          // First we need to set previous budget records to null
          try {
            $currentAcademicYear = date("Y");
            $currentMonth = date("m");
            if($currentMonth === "6") {
              $currentDay = date("d");
              if($currentDay === "30")
                $currentAcademicYear = date("Y") + 1;
            }
            else if($currentMonth > 6)
              $currentAcademicYear = date("Y") + 1;
            $bq = $this->pdo->connection->prepare("
              UPDATE total_budget
              SET current = 0
              WHERE academic_year = :academic_year
              AND current = 1
              AND removed_by IS NULL
            ");
            $bq->bindParam(":academic_year", $currentAcademicYear, PDO::PARAM_INT);
            $bq->execute();
          }
          catch(PDOException $e) {
            error_log($e);
            $result = false;
            $continue = false;
          }
          // If we successfully set the other current year's budgets to not current, we can then add the new budget
          if($continue) {
            try {
              $bq1 = $this->pdo->connection->prepare("
                INSERT INTO total_budget(academic_year, value, created_by)
                VALUES(:academic_year, :value, :created_by)
              ");
              $bq1->bindParam(":academic_year", $currentAcademicYear, PDO::PARAM_INT);
              $bq1->bindParam(":value", $budget, PDO::PARAM_INT);
              $bq1->bindParam(":created_by", $username, PDO::PARAM_STR);
              $bq1->execute();
              $result = $budget;
            }
            catch(PDOException $e) {
              error_log($e);
              $result = false;
            }
          }
          return $result;
        }
    }

?>
