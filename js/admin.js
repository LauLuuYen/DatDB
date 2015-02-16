var app = angular.module("myApp", ["ngRoute"]);

/*
*
*/
app.factory("master", function() {
	var data = {
        //No data yet
	};

	return data;
});


app.config(function($routeProvider) {
    $routeProvider
        .when("/", {
            templateUrl: "main.html",
            controller: "Main"
        })

        .when("/user", {
            templateUrl: "user.html",
            controller: "User"
        })
        
        .when("/assignments", {
            templateUrl: "assignment.html",
            controller: "Assignment"
        })
        
        .when("/groups", {
            templateUrl: "groups.html",
            controller: "Groups"
        })
        .otherwise({
            redirectTo: "/"
        });
    }
);

app.controller("Main", function ($scope, master) {
    $scope.navigation = "Home > Admin";
});

app.controller("User", function ($scope, master) {
    $scope.navigation = "Home > Admin > Create User";
    $scope.account = {
        firstname:"", lastname:"", email:"", password: ""
    };
    
});

app.controller("Assignment", function ($scope, master) {
    $scope.navigation = "Home > Admin > Create Assignment";
    $scope.account = {
        firstname:"", lastname:"", email:"", password: ""
    };
});

app.controller("Groups", function ($scope, master) {
    $scope.navigation = "Home > Admin > View groups";

    //alert("Testff");
});

