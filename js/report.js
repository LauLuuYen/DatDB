var app = angular.module("myApp", ["ngRoute"]);

/*
*
*/
app.factory("master", function() {
	var data = {
        //No data yet
	};

	return data;
});


app.config(function($routeProvider) {
    $routeProvider
        .when("/", {
            templateUrl: "main.html",
            controller: "Main"
        })

        .when("/submit", {
            templateUrl: "submit.html",
            controller: "Submit"
        })
        
        .when("/assessments", {
            templateUrl: "assessments.html",
            controller: "Assessments"
        })
        
        .when("/marks", {
            templateUrl: "marks.html",
            controller: "Marks"
        })
        .otherwise({
            redirectTo: "/"
        });
    }
);

app.controller("Main", function ($scope, master) {


});

app.controller("Submit", function ($scope, master) {
    
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
            case "xml":
                break;
            default:
                $scope.updatefeedback("Please use the right file extension.");
                $("#btn_uploadfile").attr("disabled","disabled");
                return;
        }

        //TODO check file size
        //var byte = $("#uploadfile")[0].files[0].size; //5000000 (5mb)

        $("#btn_uploadfile").removeAttr("disabled");


    });
    


    $scope.send = function() {
    	
        var formData = new FormData($('form')[0]);
	formData.append("userID", 21);
        $.ajax({
            type: "POST",
            url: "http://lauluuyen.azurewebsites.net/php/upload.php",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            
            xhr: function() {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){ // Check if upload property exists
                    myXhr.upload.addEventListener('progress',function(e) {
                        if(e.lengthComputable){
                            var progress = "Progress: "+ (e.loaded/e.total)*100 + "%";
                            $scope.updatefeedback(progress);

                        }
                    }, false);
                }
                return myXhr;
            },
            
            success: function(data) {
                if (data.success) {
               	alert(data.message);
                    $scope.updatefeedback("Upload Complete");

                } else {
                    //Error occurred
                    $scope.updatefeedback(data.message);

                }
            },
            
            error:  function(xhr, status, error) {
                alert("error:" + JSON.stringify(xhr) + "," + status + "," + error);
            }

        });
    }
    
    $scope.updatefeedback = function(message) {
        $scope.$apply(function() {
            $scope.feedback = message;
        });
    }
    
});

app.controller("Assessments", function ($scope, master) {

});

app.controller("Marks", function ($scope, master) {

});

