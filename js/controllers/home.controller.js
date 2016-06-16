angular.module("controllerModule")
  .controller("homeController", ["$scope", "$location", "phpService", function($scope, $location, phpService) {
    $scope.getParentEmployeesListSize = function() {
      return $scope.getEmployeesListSize();
    }
    $scope.generateFullName = function(nf, nm, nl) {
      var name = "";
      if(nm)
        name = nf + " " + nm + " " + nl;
      else
        name = nf + " " + nl;
      return name;
    }
    phpService.getDepartmentEmployees($scope.getDepartment()).then(
      function(d) {
        console.log(d);
        if(d.data.error) {
          // If there is an error present, we need to alert the user through a modal
          $scope.displayErrorFull(d.data.error);
        }
        else {
          // If there aren't any errors, then we can update our array of employees
          $scope.updateEmployeeList(d.data.result);
        }
      }
    )
  }]);
