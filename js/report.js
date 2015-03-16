var app = angular.module("myApp", ["ngRoute"]);


app.factory("master", function() {
    
	return data;
});


app.config(function($routeProvider, $locationProvider) {
    $routeProvider
        .when("/", {
            templateUrl: "main.php",
            controller: "Main"
        })

        .when("/submit", {
            templateUrl: "submit.php",
            controller: "Submit"
        })
        
        .when("/assessments", {
            templateUrl: "assessments.php",
            controller: "Assessments"
        })
        
        .when("/assessments/:id", {
            templateUrl: "makeassessment.php",
            controller: "MakeAssessment"
        })
        
        .when("/marks", {
            templateUrl: "marks.php",
            controller: "Marks"
        })
        
        .when("/marks/:id", {
            templateUrl: "viewassessment.php",
            controller: "ViewAssessment"
        })
        
        .otherwise({
            redirectTo: "/"
        });
    }
);

app.controller("Main", function ($scope, master) {


});

app.controller("Submit", function ($scope, master) {
    $scope.assignments = null;
    $scope.selection = null;
    $scope.feedback = "";
    $scope.reportID = -1;
    $scope.list = [];
    
    
    $scope.selectAssignment = function() {
        for (i = 0; i<$scope.assignments.length; i++) {
            if ($scope.selection.name == $scope.assignments[i].title) {
                $scope.showAssignment(i);
                return;
            }
        }
        
        $("#submission").hide();
    };
    
    $scope.showAssignment = function(index) {
        $("#submission").show();
        $("#report").show();
        $("#uploadsection").show();
        
        var assignment = $scope.assignments[index];
        var status = assignment.report.status;
        $scope.reportID = assignment.report.reportID;
        
        $("#deadline").html(assignment.deadline);
        $("#status").html(status);
        $("#task").html(assignment.task);
        $(".fullreport").html(assignment.report.content);
        $("#name").html(assignment.report.fullname);

        
        //Show report if filled in
        if (status == "Incomplete") {
            $("#report").hide();
        }

        if (status == "Complete") {
            $("#submitsection").hide();
            $("#uploadsection").hide();
        }
    };

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
        formData.append("reportID", $scope.reportID);
        
        showLoading();
        
        $.ajax({
            type: "POST",
            url: "http://lauluuyen.azurewebsites.net/php/uploadreport.php",
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
                    window.location.href="/report/";

                } else {
                    hideLoading();
                    $scope.updatefeedback(data.message);

                }
            },
            
            error:  function(xhr, status, error) {
                hideLoading();
                $scope.updatefeedback("Please try again in a few moments");
            }

        });
    };
    
    $scope.submit = function() {
        showLoading();
        
        $.ajax({
            type: "POST",
            url:"http://lauluuyen.azurewebsites.net/php/finalisereport.php" ,
            crossDomain: true,
            data: {reportID: $scope.reportID},
            dataType: "json",
            async: true,
            timeout: 10000,

            success: function (result) {
                if (result.success) {
                    window.location.href="/report/";
               
                } else {
                    hideLoading();
                    alert(result.message);
                }
            },

            error: function(xhr, status, error) {
                hideLoading();
                alert("An error occured. Please try again in a few moments.");
            }
        });
    };
    
    $scope.updatefeedback = function(message) {
        $(".error").html("Error: "+ message);
        $(".error").removeClass("invisible");
    };
    
    $scope.onChange = function(id) {
        var id = "#"+id;
        if (!$(id).hasClass("invisible")) {
            $(id).addClass("invisible");
        }
    };
    
    getData(function(assignments) {
        console.log(JSON.stringify(assignments));
        $scope.assignments = assignments;
        var temp = [];
        
        for (i = 0; i< assignments.length; i++) {
            temp.push({name:assignments[i].title});
        }
        
        $scope.$apply(function() {
            $scope.list = temp;
        });
    });
    
});


app.controller("Assessments", function ($scope, master, $location) {
    $scope.assessments = []

    $scope.next = function(id) {
        $location.path("/assessments/"+id);
    };
    
    getData(function(assessments) {
        console.log(JSON.stringify(assessments));
        $scope.$apply(function() {
            $scope.assessments = assessments;
            master.assessments = assessments;
        });
    });
    
});


app.controller("MakeAssessment", function ($scope, master, $routeParams, $location) {
    $scope.group = {
        rating:"", feedback:""
    };
    $scope.stars = [{state:"_off"}, {state:"_off"}, {state:"_off"}, {state:"_off"}, {state:"_off"}];
    
    $scope.reroute = function() {
        if (master.assessments == null) {
            $location.path("/assessments");
            return;
        }
        
        var assessments = master.assessments;
        var id = $routeParams.id;
        
        for (i = 0; i < assessments.length; i++) {
            if (id == assessments[i].reportID) {
                $scope.assessment = master.assessments[i];
                $("#report").html($scope.assessment.content);
               
                if ($scope.assessment._status != "Complete") {
                    $("#editmode").show();
                } else {
                    $("#viewmode").show();
                    $(".feedback").html($scope.assessment.feedback);
                    $scope.showStars($scope.assessment.score);
                }
               
                return;
            }
        }
        
        //Couldn't find a matching reportid
        $location.path("/assessments");
    };
    
    $scope.showStars = function(count) {
        //show stars
        for (i=0; i<count; i++) {
            $scope.stars[i].state = "_on";
        }
    }
    
    $scope.onChange = function(id) {
        var id = "#"+id;
        if (!$(id).hasClass("invisible")) {
            $(id).addClass("invisible");
        }
    };
    
    $scope.validate = function() {
        var pass = true;
        if ($scope.group.rating == "") {
            $("#e1").removeClass("invisible");
            pass = false;
        }
        if ($scope.group.feedback == "") {
            $("#e2").removeClass("invisible");
            pass = false;
        }
        return pass;
    }
    
    $scope.submit = function() {
        if ($scope.validate()) {
            showLoading();
            
            var reportID = parseInt($scope.assessment.reportID);
            var score = $scope.group.rating;
            var feedback =  $scope.group.feedback;
            console.log(reportID);
            
            $.ajax({
                type: "POST",
                url:"http://lauluuyen.azurewebsites.net/php/makeassessment.php" ,
                crossDomain: true,
                data: {reportID: reportID, score: score, feedback:feedback},
                dataType: "json",
                async: true,
                timeout: 15000,

                success: function (result) {
                    if (result.success) {
                        window.location.href="/report/";

                   
                    } else {
                        hideLoading();
                        alert(result.message);
                    }
                },

                error: function(xhr, status, error) {
                    hideLoading();
                    alert("An error occured. Please try again in a few moments.");
                }
            });

        }
    };


    $scope.reroute();
        
});


app.controller("Marks", function ($scope, master, $location) {
    $scope.groupassessments = [];

    $scope.next = function(id) {
        $location.path("/marks/"+id);
    };
    
    getData(function(data) {
        $scope.$apply(function() {
            $scope.groupassessments = data;
            master.groupassessments = data;
        });
    });
});


app.controller("ViewAssessment", function ($scope, master) {
    $scope.stars = [{state:"_off"}, {state:"_off"}, {state:"_off"}, {state:"_off"}, {state:"_off"}];
    
    $scope.reroute = function() {
        if (master.groupassessments == null) {
            $location.path("/marks");
            return;
        }
        
        var assessments = master.groupassessments;
        var id = $routeParams.id;
        
        for (i = 0; i < assessments.length; i++) {
            if (id == assessments[i].assessmentID) {
                $scope.assessment = master.groupassessments[i];
               

                $(".feedback").html($scope.assessment.feedback);
                $scope.showStars($scope.assessment.score);
                return;
            }
        }
        
        //Couldn't find id
        $location.path("/marks");
    };
    
    $scope.showStars = function(count) {
        //show stars
        for (i=0; i<count; i++) {
            $scope.stars[i].state = "_on";
        }
    }
    
    $scope.reroute();
});

/*
*   Compile angularjs scripts
*/
app.directive("dynamic", function ($compile) {
  return {
    restrict: 'A',
    replace: true,
    link: function (scope, ele, attrs) {
      scope.$watch(attrs.dynamic, function(html) {
        ele.html(html);
        $compile(ele.contents())(scope);
      });
    }
  };
});

