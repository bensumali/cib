var cib = angular.module("cib", ["controllerModule", "ngRoute"])
    .config(['$routeProvider', function($routeProvider) {
        $routeProvider
            .when('/', {
                templateUrl: 'partials/home.html',
                controller: "homeController"
            })
            .otherwise({
                redirectTo: "/"
            });
    }]);
