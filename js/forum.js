var app = angular.module("myApp", ["ngRoute"]);



/*
*
*/
app.factory("master", function() {
	var data =
        {
            "userID": 234,
            "name": "Keiten",
            "lastname": "Luu",
            "groupID": 13,
            "forum": {
                "threads": [
                    {
                        "threadID": 12,
                        "title": "gayboy",
                        "timestamp": "06/07/2015",
                        "comments": [
                            {
                                "commentID": 41,
                                "fullname": "Rex Lau",
                                "content": "sdgsfgsdf sfd sdf is fuuk",
                                "timestamp": "06/06/2015"
                            },
                            {
                                "commentID": 51,
                                "fullname": "Kei Lau",
                                "content": "sdfgdfgm efkle f",
                                "timestamp": "06/06/2015"
                            }
                        ]
                    },
                    {
                        "threadID": 12,
                        "title": "gayboy2",
                        "timestamp": "06/08/2015",
                        "comments": [
                            {
                                "commentID": 41,
                                "fullname": "Tuan Ng",
                                "content": "sdgsfgsdf sfd sdf is fuuk",
                                "timestamp": "06/06/2015"
                            }
                        ]
                    }
                ]
            }
        };
    
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

