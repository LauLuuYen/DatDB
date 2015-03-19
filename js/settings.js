var app = angular.module("myApp", ["ngRoute"]);



/*
*
*/
app.factory("master", function() {
    
	return data;
});


app.config(function($routeProvider, $locationProvider) {
    $routeProvider
        .when("/", {
            templateUrl: "main.php",
            controller: "Main"
        })

        .otherwise({
            redirectTo: "/"
        });
    }
);

app.controller("Main", function ($scope, master) {
    $scope.profile = master.profile;
    
    
});

