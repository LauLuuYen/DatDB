var app = angular.module("myApp", ["ngRoute"]);



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

        .otherwise({
            redirectTo: "/"
        });
    }
);

app.controller("Main", function ($scope, master) {
    if (master.profile.role == "student") {
        $("#forumlink").show();
        $("#logoutlink").removeClass("col-xs-offset-2");
    }

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

