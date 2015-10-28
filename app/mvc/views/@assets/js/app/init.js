// headers include
// $('<script/>', {type: 'text/javascript', src: 'app/assets/js/core/functions.js'}).appendTo('head');

// arquivo necessário para o loader
/*css([
 '../inspina/css/bootstrap.min',
 '../inspina/css/style'
 ]);
 $('.page_load').show();
 
 css([
 '../inspina/font-awesome/css/font-awesome',
 '../inspina/css/plugins/morris/morris-0.4.3.min',
 '../inspina/css/animate',
 '../inspina/css/plugins/toastr/toastr.min',
 '../inspina/js/plugins/gritter/jquery.gritter',
 'style'
 ]);
 
 js([
 '../inspina/js/bootstrap.min',
 '../inspina/js/plugins/metisMenu/jquery.metisMenu',
 '../inspina/js/plugins/slimscroll/jquery.slimscroll.min',
 '../inspina/js/plugins/flot/jquery.flot',
 '../inspina/js/plugins/flot/jquery.flot.tooltip.min',
 '../inspina/js/plugins/flot/jquery.flot.spline',
 '../inspina/js/plugins/flot/jquery.flot.resize',
 '../inspina/js/plugins/flot/jquery.flot.pie',
 '../inspina/js/plugins/flot/jquery.flot.symbol',
 '../inspina/js/plugins/flot/curvedLines',
 '../inspina/js/plugins/peity/jquery.peity.min',
 '../inspina/js/demo/peity-demo',
 '../inspina/js/inspinia',
 '../inspina/js/plugins/pace/pace.min',
 '../inspina/js/plugins/jquery-ui/jquery-ui.min',
 '../inspina/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min',
 '../inspina/js/plugins/jvectormap/jquery-jvectormap-world-mill-en',
 '../inspina/js/plugins/sparkline/jquery.sparkline.min',
 '../inspina/js/demo/sparkline-demo',
 '../inspina/js/plugins/chartJs/Chart.min',
 '../inspina/js/plugins/gritter/jquery.gritter.min',
 '../inspina/js/plugins/toastr/toastr.min',
 'core/lib/openssl',
 'app/openssl',
 'app/messages',
 ]);*/

(function () {
    // input masks
    $('.date.mask').mask('99/99/9999');
    $('.date_hour.mask').mask('99/99/9999 99:99');
    $('.hour.mask').mask('99:99');
    $('.cpf.mask').mask('999.999.999-99');
    $('.cnpj.mask').mask('99.999.999/9999-99');
    $('.rg.mask').mask('99.999.999-9');
    $('.phone.mask').mask('(99) 9999-9999');
    $('.cep.mask').mask('99999-999');
    $('.mask.money').attr('data-thousands', '.');
    $('.mask.money').attr('data-decimal', ',');
    $('.mask.money').maskMoney();
    $('.mask.number').keydown(function (e) {
        allow_key_code = [8, 9, 13, 37, 38, 39, 40, 46, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 116, 109, 189];
        return $.inArray(e.keyCode, allow_key_code) == -1 ? false : true;
    });
    $('.mask.natural.number').keydown(function (e) {
        allow_key_code = [8, 9, 13, 37, 38, 39, 40, 46, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 116];
        return $.inArray(e.keyCode, allow_key_code) == -1 ? false : true;
    });

    $("[confirm]").click(function () {
        return confirm($(this).attr("confirm"));
    });

    // flash messages
    toastr.options = {closeButton: true, debug: false, progressBar: true, positionClass: 'toast-top-center', onclick: null, showDuration: '400', hideDuration: '1000', timeOut: '20000', extendedTimeOut: '1000', showEasing: 'swing', hideEasing: 'linear', showMethod: 'fadeIn', hideMethod: 'fadeOut', preventDuplicates: false};
    $('.toastr').each(function (k, i) {
        toastr[$(i).attr('type')]($(i).attr('message'));
    });

    // encrypt password on login pages
    $('form.encrypt_password').submit(function () {
        $('[type="password"]', $(this)).each(function (k, i) {
            if (!empty($(i).val()))
                $(i).val(encrypt($(i).val(), 'md5'));
        });
    });

    /**
     * Materialize components initializer
     */
    $(".button-collapse").sideNav();
})(jQuery);
