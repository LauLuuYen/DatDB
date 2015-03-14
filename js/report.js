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
        .otherwise({
            redirectTo: "/"
        });
    }
);

app.controller("Main", function ($scope, master) {
    $scope.profile = master.profile;


});

app.controller("Submit", function ($scope, master) {
    $scope.assignments = [];
    $scope.selection = null;
    $scope.feedback = "";
    $scope.reportID = -1;
    

    for (i = 0; i<master.assignments.length; i++) {
        $scope.assignments.push({name:master.assignments[i].title});
    }
    
    $scope.selectAssignment = function() {
        for (i = 0; i<master.assignments.length; i++) {
            if ($scope.selection.name == master.assignments[i].title) {
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
        
        var assignment = master.assignments[index];
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
    
});


app.controller("Assessments", function ($scope, master, $location) {
    
    
    $scope.injectScript = function(assign_no) {
        var assignment = master.assignments[assign_no];
        var assessments = assignment.assessments;
        var script = "";
        
        //Dynamically construct the assessments
        for (i = 0; i < assessments.length; i++) {
            script += "<div class='item' ng-click='next("+assessments[i].reportID+")'>" +
                        "<div class='name'>Group: <span>"+assessments[i].groupname+"</span></div>"+
                        "<div class='linebreak'></div>"+
                        "<div class='assignment'>Assignment:"+assignment.title+"</div>"+
                        "<div class='feedback'>" +assessments[i].feedback+ "</div>"+
                        "<div class='status'>Status: "+assessments[i].status+"</div>"+
                        "<div class='score'>Score: "+assessments[i].score+"/5</div>"+
                        "<div class='more'>More ></div>"+
                      "</div>";
        }
        
        $scope.itemlist = script;
    };
    
    //TODO find for all assessments and right assign
    $scope.injectScript(0);
    
    
    $scope.next = function(id) {
        $location.path("/assessments/"+id);

    };
    
});


app.controller("MakeAssessment", function ($scope, master, $routeParams, $location) {

    var assessment = null;
    
    $scope.reroute = function(assign_no) {
        var assessments = master.assignments[assign_no].assessments;
        var id = $routeParams.id;
        
        for (i = 0; i < assessments.length; i++) {
            if (id == assessments[i].reportID) {
                assessment = assessments[i];
                $scope.injectScript();
                return;
            }
        }
        
        //Couldn't find a matching reportid
        $location.path("/assessments");
    };
    
    $scope.injectScript = function() {
        $("#groupname").html(assessment["groupname"]);
        $("#status").html(assessment["status"]);
        $("#report").html(assessment["content"]);

    };
    
    //TODO find right assigment index
    $scope.reroute(0);
        
});


app.controller("Marks", function ($scope, master) {

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

