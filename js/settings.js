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
        $("#logoutlink").removeClass("col-xs-offset-2");
    }
    
    $scope.profile = master.profile;
    $scope.pw = { o:"", p1:"", p2:""};
    
    $scope.onChange = function(id) {
        var id = "#"+id;
        if (!$(id).hasClass("invisible")) {
            $(id).addClass("invisible");
        }
    };
    
    $scope.validate = function() {
        var pass = true;
        if ($scope.pw.o == "") {
            $("#e1").removeClass("invisible");
            pass = false;
        }
        if ($scope.pw.p1 == "") {
            $("#e2").removeClass("invisible");
            pass = false;
        } else if ($scope.pw.p1 != $scope.pw.p2) {
            $("#e3").removeClass("invisible");
            pass = false;
        }
    
        return pass;
    };
    
    $scope.submit = function() {
        if ($scope.validate()) {

            showLoading();
            $.ajax({
                type: "POST",
                url:"http://lauluuyen.azurewebsites.net/php/changePw.php" ,
                crossDomain: true,
                data: {
                    pwo:$scope.pw.o, pw1:$scope.pw.p1,
                    pw2:$scope.pw.p2
                },
                dataType: "json",
                async: true,
                timeout: 120000,

                success: function (result) {
                    if (result.success) {
                        window.location.href="/settings/";
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
});

