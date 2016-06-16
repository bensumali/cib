angular.module("controllerModule")
  .controller("cibController", ["$scope", "$location", function($scope, $location) {
    $scope.updateEmployeeList = function(data) {
      for(var k in data) {
        // Go through each employee
        // See if the employee type already exists in our employees obj
        // If it does not exist, instantiate it
        if(!$scope.employees[data[k].type])
          $scope.employees[data[k].type] = [];
        // Add the employee to the correct type in our obj
        $scope.employees[data[k].type].push(data[k]);
      }
      console.log($scope.employees);
    };
    $scope.displayErrorFull = function(message) {
      $scope.error = message;
      $('#error-full').modal('toggle')
    }
    $scope.getDepartment = function() {
      return $scope.department;
    }
    $scope.getEmployeesListSize = function() {
      var i = 0;
      for(var k in $scope.employees) {
        i++;
      }
      return i;
    }
    $scope.department = "STUDENT AFFAIRS IT";
    $scope.employees = {};
    $scope.employeesIndex;
  }]);
