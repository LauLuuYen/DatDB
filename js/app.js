var app = angular.module('myApp', []);

/*
*
*/
app.factory('master', function() {  
	var data = {

        
        
	};

	return data;
});


/*
*   Login Controller
*/
app.controller('Login', function ($scope, master) {
    $scope.account = {
        email:"", password: ""
    };

    $scope.submit = function(input) {
        var email =  $scope.account.email;
        var password =  $scope.account.password;
        
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
                    window.location.href="home/index.html";
                } else {
                    alert("wrong credentials");
                }
            },

            error: function(xhr, status, error)
            {
                alert("error:" + JSON.stringify(xhr) + "," + status + "," + error);
            }
        });
    };

});
