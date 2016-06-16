<?php
    // Require the WebAuth class
    require_once("WebAuth/WebAuth5.php");
    require_once("obj/employees.php");
    $wa                                 = new WebAuth(); // Instantiate a new WebAuth obj
    $authObj                            = array(); // This will be actual authentication obj we will use, not WebAuth. Well, I guess we will be using webauth as well, just in conjunction with this

    if(stripos($_SERVER["CONTENT_TYPE"], "application/json") === 0) {
        $_POST = json_decode(file_get_contents("php://input"), true); // This will allow us to properly obtain POST values
    }

    if($wa->isLoggedIn()) { // Check to see if the user is logged in with WebAuth. This will take precedence over our custom login

    }

    // We will do a switch case on get params. However, according to Jackie Chu, if statements are much more efficient :v
    if($_GET["id"] === "getDepartmentEmployees") {
        $employees = new Employees();
        $department = $_POST["department"];

        $return = $employees->getDepartmentEmployees($department);

    }
    else {
          // If the user is not an admin, then send back an error message.
          $return = array();
          $return["error"] = "You do not have sufficient priviledges to access this area. To request permissions, please contact Student Affairs.";
    }
    echo json_encode($return);



?>
