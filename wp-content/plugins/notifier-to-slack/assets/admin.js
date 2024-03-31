/**
 * Use to set currnet in admin menu
 */
document.addEventListener('DOMContentLoaded', function () {
    var li = document.querySelectorAll('#toplevel_page_wpnts_notifier li a');
    // Function to update the 'current' class based on the current page URL
    function updateCurrentClass() {
        var currentPageURL = window.location.href;
        li.forEach(function (menuItem) {
            var menuItemURL = menuItem.getAttribute('href');
            if (currentPageURL.includes(menuItemURL)) {
                // Remove the 'current' class from all menu items
                document.querySelectorAll('#toplevel_page_wpnts_notifier li').forEach(function (liItem) {
                    liItem.classList.remove('current');
                });
                // Add the 'current' class to the parent of the menu item that matches the current URL
                menuItem.parentElement.classList.add('current');
            }
        });
    }

    updateCurrentClass();

    li.forEach(function (menuItem) {
        menuItem.addEventListener('click', function () {
            // Remove the 'current' class from all menu items except the clicked one
            document.querySelectorAll('#toplevel_page_wpnts_notifier li').forEach(function (liItem) {
                if (liItem !== menuItem.parentElement) {
                    liItem.classList.remove('current');
                }
            });
            // Add the 'current' class to the parent of the clicked menu item
            menuItem.parentElement.classList.add('current');
        });
    });
    
});