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
<<<<<<< HEAD
                        //window.location.href="/report/";
=======
                       // window.location.href="/report/";
>>>>>>> da075e4125782630e63d7334c3e3a739e6d75db3
                        alert(result.message);
                    } else {
                        hideLoading();
                        alert(result.message);
                    }
                },

                error: function(xhr, status, error) {
                    hideLoading();
                    console.log(JSON.stringify(xhr));
                    alert("An error occurred.  Please try again in a few moments.");
                }
            });

    };
    

});
