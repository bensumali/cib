angular.module("serviceModule")
.factory("phpService", function($http){
    return {
        getDepartmentEmployees: function(department) {
            return $http({
                url: "./php/index.php?id=getDepartmentEmployees",
                method: "POST",
                data: {
                    "department": department
                }
            })
        }
    }
});
