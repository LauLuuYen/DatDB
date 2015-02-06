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
    
    $("#uploadfile").change(function() {
        alert("test");
    });

    $scope.send = function() {
    	
    	var filename = $("#uploadfile").val();
        // Use a regular expression to trim everything before final dot
        var extension = filename.replace(/^.*\./, '');

        // Iff there is no dot anywhere in filename, we would have extension == filename,
        // so we account for this possibility now
        if (extension == filename) {
            extension = '';
        } else {

            extension = extension.toLowerCase();
        }

        switch (extension) {
            case 'xml':
               //Check file size 
               var byte = $("#uploadfile")[0].files[0].size; //5000000 (5mb)
               
               //var formData = new FormData($("#uploadfile")[0]);
               var formData = new FormData($('form')[0]);
            
 $.ajax({
        url: 'http://lauluuyen.azurewebsites.net/php/test.php',  //Server script to process data
        type: 'POST',
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
        //Ajax events
        beforeSend:  function(data) {alert("before");},
        success: function(data) {alert("r: " + data);},
        error:  function(xhr, status, error)
            {
	          console.log("error:" + JSON.stringify(xhr) + "," + status + "," + error);
            },
        // Form data
        data: formData,
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false
    });
		break;

            default:
                // Cancel the form submission
                alert("wrong extension");
                submitEvent.preventDefault();
                
        }
        
    }

});
