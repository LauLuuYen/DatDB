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
        firstname:"", lastname:"", email:"", password: "", groupname:"",
        role:"student"
    };

    $scope.submit = function() {
        $.ajax({
            type: "POST",
            url:"http://lauluuyen.azurewebsites.net/php/signup.php" ,
            crossDomain: true,
            data: { name:$scope.account.firstname,
                    lastname:$scope.account.lastname,
                    email: $scope.account.email,
                    password:$scope.account.password,
                    password:$scope.account.password,
                    groupname:$scope.account.groupname,
                    role:$scope.account.role
                },
            dataType: "json",
            async: true,
            timeout: 10000,

            success: function (result)
            {
                alert("result: " + result.success + ", message: " +result.message);
            },

            error: function(xhr, status, error)
            {
                alert("error:" + JSON.stringify(xhr) + "," + status + "," + error);
            }
        });
    };
    
    
});

app.controller("Assignment", function ($scope, master) {
    $scope.navigation = "Home > Admin > Create Assignment";
    $scope.assignment = {
        title:"", content:"", date:""
    };
});

app.controller("Groups", function ($scope, master) {
    $scope.navigation = "Home > Admin > View groups";

    //alert("Testff");
});

