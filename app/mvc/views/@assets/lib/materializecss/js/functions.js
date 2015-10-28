/**
 * Dropdow jQuery script controllers.
 * 
 * @returns {void}
 */
(function () {

    function dropdown_menu_set_on_top(menu) {
        menu.attr('style', menu.attr('style') + '; top: -' + (menu.height() + 2) + 'px !important;');
    }

    function dropdown_menu_vertical_center(menu) {
        menu.attr('style', menu.attr('style') + '; left: calc(50% - ' + (menu.width() / 2) + 'px);');
    }

    $('.dropdown.center.bottom').click(function () {
        var menu = $('.menu', $(this));
        dropdown_menu_vertical_center(menu);
        menu.show();
    });

    $('.dropdown.center.top').click(function () {
        var menu = $('.menu', $(this));
        dropdown_menu_set_on_top(menu);
        dropdown_menu_vertical_center(menu);
        menu.show();
    });

    // hidden options on click out of dropdown menu.
    $(document).mouseup(function (e) {
        var container = $(".dropdown .menu");

        if (!container.is(e.target)) // if the target of the click isn't the container...
            if (container.has(e.target).length === 0) // ... nor a descendant of the container
                container.hide();
    });
})();

/**
 * Vertical element align method.
 * 
 * @returns {void}
 */
(function () {
    var element = '.vertical.align';
    var margin_top = $(window).height() / 2 - $(element).height() / 2;
    margin_top = margin_top < 0 ? 0 : margin_top;
    $(element).attr('style', 'margin-top: ' + margin_top + 'px;');
})();