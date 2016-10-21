var redisApp = angular.module('redis', ['ui.bootstrap']);


redisApp.controller('RedisCtrl', function ($scope, $http) {
	$scope.message = [];	
	$scope.submit = function(){
	  $scope.logininfo = {
	   firstname : "",
	   lastname : "",
	   sex: "",
	   email: "",
	   password: "",
	   confirmpassword: "",
	   address: "",
	   city: "",
	   state: "",
	   zipcode: "",
	   dateofbirth: ""
	};

	
        angular.forEach($scope.info, function(value, key){

            $http.get("app.php?cmd=append&key=messages&value="+value)
            .success(function (data, status, headers, config) {
                $scope.redisResponse = "Updated.";
            });
            $http.get("app.php?cmd=get&key=messages")
                .success(function (data, status, headers, config) {
                    $scope.logininfo[key] = data.data;

                })
                .error(function (data, status, header, config) {
                    console.log(data);
            });
            
        });
        
        $scope.message.push($scope.logininfo);

    }


});


