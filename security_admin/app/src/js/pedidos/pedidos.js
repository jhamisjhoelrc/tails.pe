
///------------ SELECT-------------/
var app = angular.module('peidos-app', []);
app.controller('listController', function ($scope, $http) {
    const location = window.location.origin +  window.location.pathname

    $scope.pedidoLists = '';
    var getAllTable = function () {
        $scope.pedidoLists = [];
        $http({

            method: 'GET',
            url: window.location.origin + '/security_admin/v1/pedidos/10',

        }).then(function success(response) {
            console.log('response:::',response.data);
            $scope.pedidoLists = response.data;
            console.log('pedidoLists:::', $scope.pedidoLists);
        }, function error(response) {
            
        });
    }
    angular.element(window.document.body).ready(function () {
        getAllTable();
    });
    ///new table
    // pop-up confirm foreingkeys;
});
