/* Sidebar Controller */

mainApp.controller('SidebarCtrl', ['$scope', '$http','Translate',
  function ($scope, $http, Translate) {
      
     /* Translation Setup,fill $scope with language words */
      Translate.getTranslation($scope,appConfig.language);
      

  }]);