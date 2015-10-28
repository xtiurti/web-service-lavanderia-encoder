/**
 * include CSS application
 * 
 * @param {type} css
 * @returns {undefined}
 */
function css(css) {
    for (i = 0; i < css.length; i++)
        $('<link/>', {rel: 'stylesheet', type: 'text/css', href: 'app/assets/css/' + css[i] + '.css'}).appendTo('head');
}

/**
 * incluindo JS application
 * 
 * @param {type} js
 * @returns {undefined}
 */
function js(js) {
    for (i = 0; i < js.length; i++)
        $('<script/>', {type: 'text/javascript', src: 'app/assets/js/' + js[i] + '.js'}).appendTo('head');
}

/**
 * encrypt string
 * 
 * @param {type} str
 * @param {type} method: md5, sha1, b64enc
 * @returns {unresolved}
 */
function encrypt(str, method) {
    return $().crypt({method: method, source: str});
}

/**
 * decrypt string
 * 
 * @param {type} str
 * @param {type} method: md5, sha1, b64enc
 * @returns {unresolved}
 */
function decrypt(encrypted, method) {
    return $().crypt({method: method, source: encrypted});
}

/**
 * 
 * @param {type} str
 * @returns {Boolean}
 */
function empty(str) {
    return !$.trim(str);
}

function pad(input, pad_length, pad_string, pad_type) {
    var output = input.toString();
    if (pad_string === undefined) {
        pad_string = ' ';
    }
    if (pad_type === undefined) {
        pad_type = 'STR_PAD_RIGHT';
    }
    if (pad_type == 'STR_PAD_RIGHT') {
        while (output.length < pad_length) {
            output = output + pad_string;
        }
    } else if (pad_type == 'STR_PAD_LEFT') {
        while (output.length < pad_length) {
            output = pad_string + output;
        }
    } else if (pad_type == 'STR_PAD_BOTH') {
        var j = 0;
        while (output.length < pad_length) {
            if (j % 2) {
                output = output + pad_string;
            } else {
                output = pad_string + output;
            }
            j++;
        }
    }
    return output;
}


function money_to_float(money) {
    money = money.replace(/\./g, "");
    return parseFloat(money.replace(/\,/g, "."));
}

function float_to_money(float) {
    return float.toFixed(2);
}

/**
 * Obtém os paramentros GET passados pela URL.
 * 
 * @returns {object}
 */
function get_params() {
    var urlParams;
    (window.onpopstate = function () {
        var match,
                pl = /\+/g, // Regex for replacing addition symbol with a space
                search = /([^&=]+)=?([^&]*)/g,
                decode = function (s) {
                    return decodeURIComponent(s.replace(pl, " "));
                },
                query = window.location.search.substring(1);

        urlParams = {};
        while (match = search.exec(query))
            urlParams[decode(match[1])] = decode(match[2]);
    })();

    return urlParams;
}

/**
 * Obtém a URL da rota atual.
 * 
 * @returns {string}
 */
function url_context() {
    var url = window.location.href;

    if (!url.indexOf('?'))
        return url;

    url = url.split('?');
    return url[0];
}

/**
 * Table quick filter, overwrite jQuery method to search table content.
 * 
 * @returns {void}
 */
(function () {
    // NEW selector
    jQuery.expr[':'].Contains = function (a, i, m) {
        return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
    };

    // OVERWRITES old selecor
    jQuery.expr[':'].contains = function (a, i, m) {
        return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
    };

    $('[filter-in-table]').keyup(function () {
        var trs = $(this).attr('filter-in-table') + ' tbody tr';
        $(trs).not(":contains('" + $(this).val() + "')").hide();
        $(trs + ":contains('" + $(this).val() + "')").show();
    });
})(jQuery);


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
})(jQuery);


/**
 * Zipcode Functions
 * 
 * @returns {void}
 */
(function () {

    /**
     * Identificador do elemento que ao ser clicado 
     * buscará os dados e enviará para seus elementos destinos.
     * 
     * @type string
     */
    var submit = '.zipcode_submit';

    /**
     * Identificador do elemento que o usuário irá entrar o CEP.
     * 
     * @type string
     */
    var cep = '.zipcode_zipcode';

    /**
     * Identificador do elemento que receberá a rua.
     * 
     * @type string
     */
    var street = '.zipcode_street';

    /**
     * Identificador do elemento que receberá a bairro.
     * 
     * @type string
     */
    var neighborhood = '.zipcode_neighborhood';

    /**
     * Identificador do elemento que receberá a cidade.
     * 
     * @type string
     */
    var city = '.zipcode_city';

    /**
     * Identificador do elemento que receberá o estado.
     * 
     * @type string
     */
    var state = '.zipcode_state';

    /**
     * URL que será requisitada para obter os dados stringdo endereço.
     * 
     * @type url
     */
    var url = 'http://clareslab.com.br/ws/cep/json/';

    /**
     * Mensagens que será retornado para o usuário caso ocarra algum erro.
     * not_count: CEP não identificado.
     * connection: Cliente sem conexão com a internet.
     */
    var message = {
        not_fount: 'O cep informado não foi localizado. Por favor, preencha os dados manualmente.',
        connection: 'Não foi possível buscar os dados, verifique sua Conexão e se o CEP informado é válido, ou preencha manualmente os dados.',
    };

    var load = '.zipcode_load';
    var val = $(cep).val();

    $(cep).keyup(function () {
        var val = $(this).val() + "";

        if (val.replace(/[^0-9\-]/g, '').length == 9)
            set_zipcode();
    });

    /**
     * Evento click no elemento de submit do CEP.
     */
    function set_zipcode() {
        $.ajax({
            async: false,
            dataType: 'JSON',
            url: url + "" + $(cep).val(),
            success: function (data) {

                // Cep não encontrado
                if (data == 0)
                    return alert(message.not_fount);

                // preenchendo valores
                $(street).val(data.endereco).focus();
                $(neighborhood).val(data.bairro).focus();
                $(city).val(data.cidade).focus();
                $(state).val(data.uf).focus();
                $(cep).focus();
            },
            // Sem conexão com a internet, ou algum erro desconhecido.
            error: function () {
                alert(message.connection);
            }
        });
    }

})(jQuery);