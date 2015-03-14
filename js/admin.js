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
        {name: "TODO pull real data"}
    ];
    $scope.account = {
        firstname:"", lastname:"", email:"", password: "", groupname:"",
        role:"", grouplist:{name:""}
    };

    $scope.onChange = function(id) {
        var id = "#"+id;
        if (!$(id).hasClass("invisible")) {
            $(id).addClass("invisible");
        }
    };
    
    $scope.validate = function() {
        var pass = true;
        if ($scope.account.firstname == "") {
            $("#e1").removeClass("invisible");
            pass = false;
        }
        if ($scope.account.lastname == "") {
            $("#e2").removeClass("invisible");
            pass = false;
        }
        if ($scope.account.email == "") {
            $("#e3").html("Error: Please type in the email address");
            $("#e3").removeClass("invisible");
            pass = false;
        } else if (!validateEmail($scope.account.email)) {
            $("#e3").html("Error: Please type in a valid email address");
            $("#e3").removeClass("invisible");
            pass = false;
        }
        if ($scope.account.password == "") {
            $("#e4").removeClass("invisible");
            pass = false;
        }
        if ($scope.account.role == "") {
            $("#e5").removeClass("invisible");
            pass = false;
        } else if ($scope.account.role == "student") {
            if ($scope.account.groupname == "" && $scope.account.grouplist.name == "") {
                $("#e6").removeClass("invisible");
                pass = false;
            }
        }
        
        return pass;
    }
    
    $scope.submit = function() {
        if ($scope.validate()) {

            var firstname = $scope.account.firstname;
            var lastname = $scope.account.lastname;
            var email = $scope.account.email;
            var password = $scope.account.password;
            var role = $scope.account.role;
            var groupname = $scope.account.grouplist.name;
            if ($scope.account.groupname != "") {
                groupname = $scope.account.groupname;
            }
            var data =  {
                    name: firstname,
                    lastname: lastname,
                    email: email,
                    password: password,
                    groupname: groupname,
                    role:role
            };

            $.ajax({
                type: "POST",
                url:"http://lauluuyen.azurewebsites.net/php/signup.php" ,
                crossDomain: true,
                data: data,
                dataType: "json",
                async: true,
                timeout: 10000,

                success: function (result) {
                    if (result.success) {
                        window.location.href="/admin/";
                    } else {
                        alert(result.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert("An error occurred.  Please try again in a few moments.");
                }
            });
        
        
        }

    };
    
    
});

app.controller("Assignment", function ($scope, master) {
    $scope.assignment = {
        title:"", content:"", date:""
    };
    
    $scope.randomise = function() {
        var list = ["GroupA", "GroupG", "GroupB","GroupD","GroupE"];
        var data =  getAssignList(list, 3);

        var script = "<table class='randomtable'>"+
                        "<tr class='head'>"+
                        "<td>Group</td>"+
                        "<td>Assessing (1)</td>"+
                        "<td>Assessing (2)</td>"+
                        "<td>Assessing (3)</td>"+
                        "</tr>";
        
        var i=0;
        for (var key in data) {
            var row = data[""+key];
            script += "<tr class='r"+i+"'>"+
                        "<td>"+key+"</td><td>"+row[0]+"</td><td>"+row[1]+"</td><td>"+row[2]+"</td>"+
                      "</tr>";
            i = (i+1)%2;
        }
        
        script += "</table>";

        $("#randomsection").html(script);
    };
    
    $scope.onChange = function(id) {
        var id = "#"+id;
        if (!$(id).hasClass("invisible")) {
            $(id).addClass("invisible");
        }
    };
    
    $scope.validate = function() {
        var pass = true;
        if ($scope.assignment.title == "") {
            $("#e1").removeClass("invisible");
            pass = false;
        }
        if ($scope.assignment.content == "") {
            $("#e2").removeClass("invisible");
            pass = false;
        }
        if ($scope.assignment.date == "") {
            $("#e3").html("Error: Please select a date");
            $("#e3").removeClass("invisible");
            pass = false;
        } else if (!isDateAfter($scope.assignment.date)) {
            $("#e3").html("Error: Please select a future date");
            $("#e3").removeClass("invisible");
            pass = false;
        }
        return pass;
    }
    
    $scope.submit = function() {
        if ($scope.validate()) {
            alert("pass: " + $scope.assignment.date);
        }
    };
    $scope.randomise();
});

app.controller("Groups", function ($scope, master) {
    $scope.navigation = "Home > Admin > View groups";

    //alert("Testff");
});

