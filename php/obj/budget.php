<?php
    require_once("db/budget.db.php");
    require_once("obj/logs.php");
    class Budget
    {
        public $logs;
        function Budget() {
            $this->budgetDb = new BudgetDb();
            $this->logs = new Logs();
        }
        function getCurrentBudget() {
          $result = array();
          $result["result"];
          $budget = $this->budgetDb->getCurrentBudget();
          if(!$budget)
            $result["error"] = "Could not retrieve budget";
          else
            $result["result"] = $budget;
          return $result;
        }
        function setNewBudget($budget, $username) {
          $result = array();
          $result["result"];
          $result["error"];
          $budget = $this->budgetDb->setNewBudget($budget, $username);
          if(!$budget) {
            $this->logs->createLog("Failed to update budget to value '$budget'", "error", $username);
            $result["error"] = "Failed to update budget";
          }
          else
            $result["result"] = $budget;
          return $result;
        }
    }



?>
