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
    $scope.send = function() {
    	
    	var filename = $("#uploadfile").val();
        // Use a regular expression to trim everything before final dot
        var extension = filename.replace(/^.*\./, '');

        // Iff there is no dot anywhere in filename, we would have extension == filename,
        // so we account for this possibility now
        if (extension == filename) {
            extension = '';
        } else {
            // if there is an extension, we convert to lower case
            // (N.B. this conversion will not effect the value of the extension
            // on the file upload.)
            extension = extension.toLowerCase();
        }

        switch (extension) {
            case 'jpg':
            case 'jpeg':
            case 'png':
                alert("it's got an extension which suggests it's a PNG or JPG image (but N.B. that's only its name, so let's be sure that we, say, check the mime-type server-side!)");
               
               //Check file size 
               var byte = $("#uploadfile")[0].files[0].size; //5000000 (5mb)
               var formData = new FormData($("#uploadfile")[0]);

               /*
                $.ajax({
                url: 'http://lauluuyen.azurewebsites.net/php/test.php',  //server script to process data
                type: 'POST',
                xhr: function() {  // custom xhr
                    myXhr = $.ajaxSettings.xhr();
                    console.log("uploading..." + myXhr.upload);
                    return myXhr;
                },
                //Ajax events
                success: completeHandler = function(data) {
                     //workaround for crome browser // delete the fakepath

                   	alert("uploaded: " + data);

                },
            error: function(xhr, status, error)
            {
	          console.log("error:" + JSON.stringify(xhr) + "," + status + "," + error);
            },
                // Form data
                data: formData,
                //Options to tell JQuery not to process data or worry about content-type
                cache: false,
                contentType: false,
                processData: false
            }, 'json');
            */
            
            //var formData = new FormData($('form')[0]);
    $.ajax({
        url: 'http://lauluuyen.azurewebsites.net/php/login.php',  //Server script to process data
        type: 'POST',
        xhr: function() {  // Custom XMLHttpRequest
            var myXhr = $.ajaxSettings.xhr();
            if(myXhr.upload){ // Check if upload property exists
                myXhr.upload.addEventListener('progress',function(e){
             if(e.lengthComputable){
       			console.log({value:e.loaded,max:e.total});
    			}
                	
                }, false); // For handling the progress of the upload
            }
            return myXhr;
        },
        //Ajax events
        beforeSend: function (data) { alert("before"); },
        success: function (data) { alert("success: " + data); },
        error: function(xhr, status, error)
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
