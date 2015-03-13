var app = angular.module("myApp", ["ngRoute"]);

/*
*
*/
app.factory("master", function() {
	var data = {
        "profile" : {
            "userID": 123,
            "name": "tuan",
            "lastname": "nguyen",
            "groupid": 3
        }
        
        
	};

	return data;
});


app.config(function($routeProvider) {
    $routeProvider
        .when("/", {
            templateUrl: "main.php",
            controller: "Main"
        })

        .when("/user", {
            templateUrl: "user.php",
            controller: "User"
        })
        
        .when("/assignments", {
            templateUrl: "assignment.php",
            controller: "Assignment"
        })
        
        .when("/groups", {
            templateUrl: "groups.php",
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
    $scope.grouplist = [
        {name: "Zordon"}
    ];
    $scope.account = {
        firstname:"", lastname:"", email:"", password: "", groupname:"",
        role:"", grouplist:{name:""}
    };


    $scope.submit = function() {
        return;
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

            success: function (result) {
                alert("result: " + result.success + ", message: " +result.message);
            },
            error: function(xhr, status, error) {
                alert("An error occurred.  Please try again in a few moments.");
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

