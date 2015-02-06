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
            url:"http://lauluuyen.azurewebsites.net/php/login.php" ,
            crossDomain: true,
            data: {email: email, password: password},
            dataType: 'json',
            async: true,
            timeout: 10000,

            success: function (result)
            {
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
    
    $scope.feedback = "Please upload something";

    $("#uploadfile").change(function() {
    
        //Check file exist
    	var filename = $(this).val();
        if (filename == "") {
            $("#btn_uploadfile").attr("disabled","disabled");
            return;
        }
        
        //Check file extension
        var extension = filename.replace(/^.*\./, '').toLowerCase();
        switch (extension) {
            //Valid file extensions
            case 'xml':
                break;
            default:
                $("#feedback").html("Please use the right file extension.");
                $("#btn_uploadfile").attr("disabled","disabled");
                return;
        }

        $("#btn_uploadfile").removeAttr("disabled");



//        alert("change");

    });
    


    $scope.send = function() {
    	
        var formData = new FormData($('form')[0]);

        $.ajax({
            type: "POST",
            url: "http://lauluuyen.azurewebsites.net/php/test.php",
            data: formData,

            //Options to tell jQuery not to process data or worry about content-type.
            cache: false,
            contentType: false,
            processData: false,
            xhr: function() {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){ // Check if upload property exists
                    myXhr.upload.addEventListener('progress',function(e) {
                        if(e.lengthComputable){
                            console.log({value:e.loaded,max:e.total});
                        }
                    }, false); // For handling the progress of the upload
                }
                return myXhr;
            },
            
            success: function(data) {
                alert("r: " + data);
            },
            
            error:  function(xhr, status, error) {
                console.log("error:" + JSON.stringify(xhr) + "," + status + "," + error);
            }

        });

                

        
    }

});
