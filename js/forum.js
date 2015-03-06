var app = angular.module("myApp", ["ngRoute"]);



/*
*
*/
app.factory("master", function() {
	var data = {

	};
    
	return data;
});


app.config(function($routeProvider, $locationProvider) {
    $routeProvider
        .when("/", {
            templateUrl: "main.html",
            controller: "Main"
        })



    }
);

app.controller("Main", function ($scope, master) {
    alert("testing");


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

