/**
 * Created by aalliot on 8/31/16.
 */

(function(){
    var button = document.getElementById('mobile-nav-icon');
    var menu = document.getElementById('menu');
    var isOpen = false;

    button.addEventListener('click', function () {
        if (isOpen)
            menu.className = menu.className.replace('open', '');
        else
            menu.classList += ' open';

        isOpen = !isOpen;
    });

})();
