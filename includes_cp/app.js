var app = angular.module('angularApp', ['ngMaterial'])
    .config(function ($mdThemingProvider) {
        $mdThemingProvider.theme('default')
            .primaryPalette('light-green');
    })
    .config(['$compileProvider', function ($compileProvider) {
        $compileProvider.debugInfoEnabled(false);
    }]);

app.controller('ContactsController', ContactsController);
ContactsController.$inject = ['$scope', '$http'];

function ContactsController($scope, $http) {
    
	$scope.seleccionados = [];
	$scope.loading = false;
	$scope.send =  false;
	
	var url= window.location.href;
	var indice= url.split("/");
	
    /**Tablas */
    $scope.contactos = [];
    $http({
        method: 'GET',
        url: 'https://colombiapreviene.com/test-meta/?all'
    }).then(function successCallback(response) {
           $scope.contactos = response.data;
        
    }, function errorCallback(response) {
        console.log('fallo cargando contactos', response);            
    });
	
  	/*contacto objeto contacto*/
    $scope.agregarContacto = function(contacto){
		
		if($scope.seleccionados.indexOf(contacto) === -1) $scope.seleccionados.push(contacto);
	}
	$scope.eliminarContacto = function(i){
		$scope.seleccionados.splice(i, 1);
	}
	$scope.enviarContactos = function(){
		$scope.send = true;
		$scope.message = '';
		
		
		
		$http.post('https://colombiapreviene.com/test-meta/?contacts='+indice[4], {
			data: $scope.seleccionados
		}).then(function successCallback(response) {
			$scope.send = false;
           $scope.message = response.data + ' correos enviados';
		}, function errorCallback(response) {
			console.log('fallo cargando contactos', response);            
		});
		
	}

}