var app = angular.module("myApp", ["ngRoute"]);

/*
*
*/
app.factory("master", function() {

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
        
        .when("/all", {
            templateUrl: "all.php",
            controller: "All"
        })
        
        .when("/search", {
            templateUrl: "search.php",
            controller: "Search"
        })
        
        .otherwise({
            redirectTo: "/"
        });
    }
);

app.controller("Main", function ($scope, master) {

    /*
    getData(function(data1,data2,data3) {

        master["assignments"] = data1["assignments"];
        master["groups"] = data3["groups"];
        console.log(JSON.stringify(master));
    });
    */
});

app.controller("User", function ($scope, master) {
    console.log("viewing users");
    
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

            showLoading();
            
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
                        hideLoading();
                        alert(result.message);
                    }
                },
                error: function(xhr, status, error) {
                    hideLoading();
                    alert("An error occurred.  Please try again in a few moments.");
                }
            });
        
        
        }

    };
    
    getData(function(groups) {
        console.log(groups);
        $scope.$apply(function() {
            $scope.grouplist = groups;
        });
    });
    
});

app.controller("Assignment", function ($scope, master) {
    console.log("viewing assignments");
    $scope.assignment = {
        title:"", content:"", date:"", assessment_list: "",
    };
    
    //Consider when there is no group
    $scope.randomise = function() {
        console.log("randomising list...");
        var data =  getAssignList($scope.grouplist, 3);
        $scope.assignment.assessment_list = data;

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
            var title = $scope.assignment.title;
            var content = $scope.assignment.content;
            var deadline = $scope.assignment.date;
            var assessment_list = JSON.stringify($scope.assignment.assessment_list);
            console.log(assessment_list);
            
            showLoading();
            $.ajax({
                type: "POST",
                url:"http://lauluuyen.azurewebsites.net/php/assignments.php" ,
                crossDomain: true,
                data: {
                    title:title, task:content,
                    deadline:deadline, assessment_list:assessment_list
                },
                dataType: "json",
                async: true,
                timeout: 120000,

                success: function (result) {
                    if (result.success) {
                        window.location.href="/admin/";
                    } else {
                        hideLoading();
                        alert(result.message);
                    }
                },
                error: function(xhr, status, error) {
                    hideLoading();
                    alert("An error occurred.  Please try again in a few moments.");
                }
            });
        }
    };
    
    getData(function(grouplist) {
        console.log(JSON.stringify(grouplist));
        $scope.$apply(function() {
            $scope.grouplist = grouplist;
            //Todo consider when there is no group
            $scope.randomise();
        });
    });

});

app.controller("All", function ($scope, master) {
    console.log("view all");
});


app.controller("Search", function ($scope, master) {
    console.log("search");
    $scope.users = [
        {userID:12, name:"adf", lastname:"sfg", email:"sfg@sfg", groupID:15, created:"831 usfsdfh d"},
        {userID:432, name:"adsfdf", lastname:"ouyi", email:"@slgdn", groupID:52, created:"sglknsklg f"},
        {userID:43, name:"linlkf", lastname:"fhsf", email:"sglj2@xv.om", groupID:32, created:"sdlnsg sdo foid"},
    ];
    
    
});

