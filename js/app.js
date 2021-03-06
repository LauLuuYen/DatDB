(function(){

var app = angular.module("myApp", []);

/*
*
*/
app.factory("master", function() {
	var data = {};
	return data;
});


/*
*   Login Controller
*/
app.controller("Login", function ($scope, master) {
    console.log("Main");
    
    $scope.account = {
        email:"", password: ""
    };

    $scope.onChange = function(id) {
        var id = "#"+id;
        if (!$(id).hasClass("invisible")) {
            $(id).addClass("invisible");
        }
    };
    
    $scope.validEmail = function(email) {
        var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    };
 
    $scope.validate = function() {
        var pass = true;
        if ($scope.account.email=="") {
            $("#e1").html("Error: Please enter your email address");
            $("#e1").removeClass("invisible");
            pass = false;
        } else if (!$scope.validEmail($scope.account.email)) {
            $("#e1").html("Error: Please enter a valid email address");
            $("#e1").removeClass("invisible");
            pass = false;
        }
        if ($scope.account.password=="") {
            $("#e2").removeClass("invisible");
            pass = false;
        }
        return pass;
    };
    

    $scope.submit = function(input) {
        if ($scope.validate()) {
        
            var email =  $scope.account.email;
            var password =  $scope.account.password;
            
            showLoading();

            $.ajax({
                type: "POST",
                url:"http://lauluuyen.azurewebsites.net/php/login.php" ,
                crossDomain: true,
                data: {email: email, password: password},
                dataType: "json",
                async: true,
                timeout: 10000,

                success: function (result)
                {
                    if (result.success) {
                        console.log(result.message);
                        window.location.href=result.message;
                    } else {
                        hideLoading();
                        alert(result.message);
                    }
                },

                error: function(xhr, status, error) {
                    
                    console.log("Testing"+JSON.stringify(xhr));
                    hideLoading();
                    alert("An error occurred.  Please try again in a few moments.");
                }
            });
        }
    };
    

});

})();