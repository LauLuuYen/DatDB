var app = angular.module("myApp", ["ngRoute"]);



/*
*
*/
app.factory("master", function() {
    data["forum"]["threads"]=[];
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

    $scope.injectScript = function() {
        var threads = master.forum.threads;
        var script = "";

        //Dynamically construct the thread list
        for (i = 0; i < threads.length; i++) {
            var thread = threads[i];
            var c_len = thread.comments.length;
            var comment = thread.comments[c_len-1];

            script += "<div class='item' ng-click='viewThread("+thread.threadID+");'>"+
                        "<div class='_left'>"+
                        "<div class='title'>"+thread.title+"</div>"+
                        "<div class='date'>Last post: "+comment.fullname+" at "+comment.timestamp+"</div>"+
                        "</div>"+
                        "<div class='_right'>" +
                        "<div class='n'>"+c_len+"</div>"+
                        "<div class='post'>Post(s)</div>"+
                        "</div>"+
                      "</div>";
        }
        
        console.log(script);
        $scope.$apply(function() {
            $scope.itemlist = script;
        });
    };
    
    
    $scope.newThread = function() {
        $location.path("/thread");
    };

    $scope.viewThread = function(id) {
        $location.path("/thread/"+id);
    };
    

    getData(function(forum) {
        console.log(forum);
        master["forum"] = forum;
        //$scope.injectScript();
    });
});

app.controller("CreateThread", function ($scope, master) {
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
                    alert("An error occured. Please try again in a few moments.");
                }
            });

        }
    };
});

app.controller("ViewThread", function ($scope, master, $routeParams) {
    $scope.thread = {
        comment:""
    };
    
    $scope.back=function(){
    	window.location.href="/forum/";
    };
    
    $scope.reroute = function() {
        console.log("sgsg");
        console.log(master.forum.threads);
        
        if (master.forum.threads == null) {
            return $scope.back();
        }
        
        var threads = master.forum.threads;
        var id = $routeParams.id;
        
        for (i = 0; i < threads.length; i++) {
            var thread = threads[i];
            if (id == thread.threadID) {
                $scope.injectScript(thread.title, thread.comments);
                return;
            }
        }
        
        //Couldn't find a matching forum id
        window.location.href="/forum/";
    };
    
    $scope.injectScript = function(title, comments) {
        $(".heading").html("Thread: " + title);
        $("#txt").html(comments[0].content);
        $("#date").html("By " + comments[0].fullname +" at " +comments[0].timestamp);
        var script = "<div>Comments:</div>";

        for (i = 1;i<comments.length; i++) {
            script += "<div class='comment'>"+
                        "<div>"+comments[i].content+"</div><br>"+
                        "<div>By " + comments[i].fullname +" at " +comments[i].timestamp+"</div>"+
                      "</div>";
        }
        
        if (comments.length > 1){
            $scope.itemlist = script;
        }
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
                    alert("An error occured. Please try again in a few moments.");
                }
            });
            
        }
    };


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

