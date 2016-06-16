<?php
require_once("db/employees.db.php");
require_once("obj/logs.php");
require_once("inc/PHPMailerAutoload.php");
class Employees
{
    private $employeesDb;
    private $logs;
    function Employees()
    {
        $this->employeesDb = new EmployeesDb();
        $this->logs = new Logs();
    }
    function getDepartmentEmployees($department) {
      $result = array();
      $result["result"];
      $result["error"];

      $employees = $this->employeesDb->getDepartmentEmployees($department);
      if(!$employees && !is_array($employees)) {
          $result["error"] = "There was an issue retrieving this department's employees. Please contact Student Affairs IT";
      }
      else
        $result["result"] = $employees;
      return $result;
    }
}

?>
