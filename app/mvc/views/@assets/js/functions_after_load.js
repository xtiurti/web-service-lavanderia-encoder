/**
 * 
 * Controlador do elemento de carregamento de página.
 */
(function () {
    $(window).on('beforeunload', function () {
        //$('.page_content').hide();
        $('page-loader').show();
        $('html, body').css('overflow', 'hidden');
    });

    $(window).bind('load', function () {
        $('body').css('overflow-y', 'scroll');
        $('page-loader').hide();
        //$('.page_content').show();
    });
})(jQuery);

/**
 * Vertical element align method.
 * 
 * @returns {void}
 */
(function () {
    $(window).bind('load', function () {
        var element = '.vertical.align';

        $(element).each(function (k, e) {
            var margin_top = $(window).height() / 2 - $(e).height() / 2;
            margin_top = margin_top < 0 ? 0 : margin_top;
            $(e).attr('style', 'margin-top: ' + margin_top + 'px;');
        });
    });
})(jQuery);


/**
 * Paginate input options
 */
(function () {

    if ($('.paginate').length > 0) {
        var total = parseInt($('.paginate').attr('total'));
        var current = parseInt($('.paginate').attr('current'));

        $('input', $('.paginate')).keypress(function (e) {
            if (e.keyCode == 13) {
                var page = parseInt($(this).val());
                
                if (page == current) {
                    $('.message_page_not_found', '.paginate').hide();
                    return $('.message_current_page', '.paginate').show();
                } else if (page <= 0 || page > total) {
                    $('.message_current_page', '.paginate').hide();
                    return $('.message_page_not_found', '.paginate').show();
                }

                // gerando o query dos parametros GET sobreescrevendo a página
                var query = "";
                $.each(get_params(), function (key, value) {
                    query += key + '=' + (key == 'page' ? page : value) + '&';
                });

                if (empty(query))
                    query = 'page=' + page;

                window.location.href = url_context() + '?' + query;
            }
        });
    }
})(jQuery);