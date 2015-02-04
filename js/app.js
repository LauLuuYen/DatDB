var app = angular.module('myApp', []);

/*
*
*/
app.factory('master', function() {  
	var data = {
        //No data yet
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
            url:"http://lauluuyen.azurewebsites.net/php/login.php",
            //crossDomain: true,
            data: {email: email, password: password},
            dataType: 'json',
            async: true,
            timeout: 10000,

            success: function (result)
            {
                //alert("success");
                //alert("success: " + result.success + "," + result.message);
                window.location.href="home/index.html";
            },

            error: function(xhr, status, error)
            {
                alert("error:" + JSON.stringify(xhr) + "," + status + "," + error);
            }
            }
        );
    }

});


/*
*   Home Controller
*/
app.controller('Home', function ($scope, master) {


});