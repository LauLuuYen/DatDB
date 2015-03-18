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
    if (master.profile.role == "student") {
        $("#forumlink").show();
        $("#logoutlink").removeClass("col-xs-offset-4");
        $("#logoutlink").addClass("col-xs-offset-2");
    }

});
