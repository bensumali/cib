<?php
require_once("db/pdo.db.php");
class EmployeesDb
{
    public $pdo;

    function EmployeesDb()
    {
        $this->pdo = new PDOConnection();
    }
    function getDepartmentEmployees($department) {
        $result = array();
        try {
          $q = "
            SELECT e.name_first, e.name_middle, e.name_last, e.ucinetid, e.email, e.id, e.type, d.department,
              s.status, s.estimated_return, s.location
            FROM employee AS e
            JOIN employee_of_department AS d ON e.ucinetid = d.ucinetid
            LEFT JOIN employee_status AS s ON s.ucinetid = e.ucinetid
            WHERE d.department = :department
            AND e.removed_by IS NULL
            AND e.current = 1
            AND d.removed_by IS NULL
            AND s.current = 1
            AND s.removed_by IS NULL
            ORDER BY s.created_when DESC
          ";
          $eq = $this->pdo->connection->prepare($q);
          $eq->bindParam(":department", $department, PDO::PARAM_STR);
          $eq->execute();
          while($er = $eq->fetch(\PDO::FETCH_ASSOC)) {
            array_push($result, $er);
          }
        }
        catch(PDOException $e) {
          error_log($e);
          $result = false;
        }
        return $result;
    }
}

?>
