var app = angular.module("myApp", ["ngRoute", "ngSanitize"]);



/*
*
*/
app.factory("master", function() {

	return data;
});


app.config(function($routeProvider, $locationProvider) {
    $routeProvider
        .when("/", {
            templateUrl: "main.php",
            controller: "Main"
        })

        .when("/thread", {
            templateUrl: "createthread.php",
            controller: "CreateThread"
        })
        
        .when("/thread/:id", {
            templateUrl: "viewthread.php",
            controller: "ViewThread"
        })
        
        .otherwise({
            redirectTo: "/"
        });

    }
);

app.controller("Main", function ($scope, master, $location) {
    console.log("View all threads");

    $scope.threads = [];
    $scope.orderList = "started";
  
    $scope.getThreads = function() {
        if (master.forum == null) {
            return;
        }
        var threads = master.forum.threads;
        var temp = [];
        
        for (i = 0; i < threads.length; i++) {
            var thread = threads[i];
            var c_len = thread.comments.length;
            var comment = thread.comments[c_len-1];
            
            var id = thread.threadID;
            var title = thread.title;
            var fullname = comment.fullname;
            var timestamp = comment.timestamp;
    
            var row = {threadID:id, title:title, timestamp:timestamp, count:c_len, fullname:fullname};
            temp.push(row);
        }

        $scope.$apply(function() {
            $scope.threads = temp;
        });
    };
    
    $scope.newThread = function() {
        $location.path("/thread");
    };

    $scope.viewThread = function(id) {
        $location.path("/thread/"+id);
    };
    

    getData(function(forum) {
        master["forum"] = forum;
        $scope.getThreads();
    });


});

app.controller("CreateThread", function ($scope, master) {
    console.log("Create thread");
    $scope.thread = {
        title:"", comment:""
    };
    
    $scope.back=function(){
    window.location.href="/forum/";
    };

    $scope.onChange = function(id) {
        var id = "#"+id;
        if (!$(id).hasClass("invisible")) {
            $(id).addClass("invisible");
        }
    };
    
    $scope.validate = function() {
        var pass = true;
        if ($scope.thread.title == "") {
            $("#title_e").removeClass("invisible");
            pass = false;
        }
        if ($scope.thread.comment == "") {
            $("#comment_e").removeClass("invisible");
            pass = false;
        }
        return pass;
    }
    
    $scope.submit = function() {
        if ($scope.validate()) {
            showLoading();
            
            var title =  $scope.thread.title;
            var comment =  $scope.thread.comment;

            
            $.ajax({
                type: "POST",
                url:"http://lauluuyen.azurewebsites.net/php/threads.php" ,
                crossDomain: true,
                data: {title: title, comment: comment},
                dataType: "json",
                async: true,
                timeout: 10000,

                success: function (result) {
                    if (result.success) {
                        window.location.href="/forum/";
                   
                    } else {
                        hideLoading();
                        alert(result.message);
                    }
                },

                error: function(xhr, status, error) {
                    hideLoading();
                    console.log(JSON.stringify(xhr));
                    alert("An error occured. Please try again in a few moments.");
                }
            });

        }
    };
});

app.controller("ViewThread", function ($scope, master, $routeParams) {
    console.log("View thread");
    $scope.thread = {
        comment:""
    };
    $scope.comments = [];
    
    $scope.back=function(){
    	window.location.href="/forum/";
    };
    
    $scope.reroute = function() {
        console.log(master.forum);
        
        if (master.forum == null) {
            return $scope.back();
        }
        
        var threads = master.forum.threads;
        var id = $routeParams.id;
        
        for (i = 0; i < threads.length; i++) {
            var thread = threads[i];
            if (id == thread.threadID) {
                $scope.getComments(thread.title, thread.comments);
                return;
            }
        }
        
        //Couldn't find a matching forum id
        window.location.href="/forum/";
    };
    
    
    $scope.getComments = function(title, comments) {
        $(".heading").html("Thread: " + title);
        $("#txt").html(comments[0].content);
        $("#date").html("By " + comments[0].fullname +" at " +comments[0].timestamp);
        var temp = [];
        
        for (i=1; i<comments.length; i++) {
                var row = { commentID:comments[i].commentID,
                            content:comments[i].content,
                            fullname:comments[i].fullname,
                            timestamp:comments[i].timestamp,
                            candelete:comments[i].candelete? "candelete":"" };
                temp.push(row);
        }
        
        console.log(JSON.stringify(temp));

        $scope.comments = temp;
        
    };

    
    $scope.onChange = function(id) {
        var id = "#"+id;
        if (!$(id).hasClass("invisible")) {
            $(id).addClass("invisible");
        }
    };
    
    $scope.validate = function() {
        var pass = true;
        if ($scope.thread.comment == "") {
            $("#comment_e").removeClass("invisible");
            pass = false;
        }
        return pass;
    };
    
    $scope.submit = function() {
        if ($scope.validate()) {
            showLoading();
            
            var id = $routeParams.id;
            var comment = $scope.thread.comment;

            $.ajax({
                type: "POST",
                url:"http://lauluuyen.azurewebsites.net/php/comment.php" ,
                crossDomain: true,
                data: {threadID: id, comment: comment},
                dataType: "json",
                async: true,
                timeout: 10000,

                success: function (result) {
                    if (result.success) {
                        window.location.href="/forum/";
                   
                    } else {
                        hideLoading();
                        alert(result.message);
                    }
                },

                error: function(xhr, status, error) {
                    hideLoading();
                    console.log(JSON.stringify(xhr));
                    alert("An error occured. Please try again in a few moments.");
                }
            });
            
        }
    };

    $scope.deleteComment = function(id) {
        showLoading();
        $.ajax({
            type: "POST",
            url:"http://lauluuyen.azurewebsites.net/php/deleteComment.php" ,
            crossDomain: true,
            data: {commentID: id},
            dataType: "json",
            async: true,
            timeout: 10000,

            success: function (result) {
                if (result.success) {
                    window.location.href="/forum/";
               
                } else {
                    hideLoading();
                    alert(result.message);
                }
            },

            error: function(xhr, status, error) {
                hideLoading();
                console.log(JSON.stringify(xhr));
                alert("An error occured. Please try again in a few moments.");
            }
        });
            
    };

    $scope.reroute();
        
});


