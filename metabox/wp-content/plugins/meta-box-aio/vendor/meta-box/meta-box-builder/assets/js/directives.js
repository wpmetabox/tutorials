angular.module( 'builderDirectives', [] )

    .directive('offClick', ['$document', function ($document) {

        function targetInFilter(target,filter){
            if(!target || !filter) return false;
            var elms = angular.element(filter);
            var elmsLen = elms.length;
            for (var i = 0; i< elmsLen; ++i)
                if(elms[i].contains(target)) return true;
            return false;
        }
        
        return {
            restrict: 'A',
            scope: {
                offClick: '&',
                offClickIf: '&'
            },
            link: function (scope, elm, attr) {

                if (attr.offClickIf) {
                    scope.$watch(scope.offClickIf, function (newVal, oldVal) {
                            if (newVal && !oldVal) {
                                $document.on('click', handler);
                            } else if(!newVal){
                                $document.off('click', handler);
                            }
                        }
                    );
                } else {
                    $document.on('click', handler);
                }

                function handler(event) {
                    var target = event.target || event.srcElement;
                    if (!(elm[0].contains(target) || targetInFilter(target, attr.offClickFilter))) {
                        scope.$apply(scope.offClick());
                    }
                }
            }
        };
    }])
    
    .directive('ngReallyClick', [function() {
        return {
            restrict: 'A',
            link: function(scope, element, attrs) {
                element.bind('click', function() {
                    var message = attrs.ngReallyMessage;
                    if (message && confirm(message)) {
                        scope.$apply(attrs.ngReallyClick);
                    }
                });
            }
        }
    }])

    .directive('ngEnter', function() {
        return function(scope, element, attrs) {
            element.bind("keydown keypress", function(event) {
                if(event.which === 13) 
                {
                    scope.$apply(function(){
                       scope.$eval(attrs.ngEnter);
                    });
                    
                    event.preventDefault();
                }
            });
        };
    })

    .directive('focusOn', function() {
       return function(scope, elem, attr) {
          scope.$on('focusOn', function(e, name) {
            if(name === attr.focusOn) {
              elem[0].focus();
            }
          });
       };
    })
;