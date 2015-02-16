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

        .when("/users", {
            templateUrl: "user.html",
            controller: "CreateUser"
        })
        
        .when("/", {
            templateUrl: "assignment.html",
            controller: "CreateAssignment"
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

});

app.controller("User", function ($scope, master) {
    $scope.account = {
        firstname:"", lastname:"", email:"", password: ""
    };
    
});

app.controller("Assignment", function ($scope, master) {
    $scope.account = {
        firstname:"", lastname:"", email:"", password: ""
    };
});

app.controller("Groups", function ($scope, master) {
    //alert("Testff");
});

