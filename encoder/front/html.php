<?php

class Html {

        /**
     * Insere um ou mais arquivos CSS na página. 
     * O Caminho deve informado a partir da pasta views/assets.
     * 
     * @param <string || array> $files
     * @return <string>
     */
    static function css($files) {
        if (!is_array($files))
            return "<link href='" . ASSETS . "css/$files.css' rel='stylesheet'>\n";

        foreach ($files as $file)
            @$html .= "<link href='" . ASSETS . "css/$file.css' rel='stylesheet'>\n";

        return $html;
    }

    /**
     * Insere um ou mais arquivos JS na página. 
     * O Caminho deve informado a partir da pasta app/assets.
     * 
     * @param <string || array> $files
     * @return <string>
     */
    static function js($files) {
        if (!is_array($files))
            return "<script src='" . ASSETS . "js/$files.js'></script>\n";

        foreach ($files as $file)
            @$html .= "<script src='" . ASSETS . "js/$file.js'></script>\n";

        return $html;
    }


    /**
     * Incluí um ou mais arquivos js's na view.
     * 
     * @param type $files: Arquivo(s) que deseja incluir o js.
     * @return string
     */
    static function image($path, $class = '') {
        return '<img class="' . $class . '" src="' . ASSETS . 'img/' . $path . '" />';
    }

    /**
     * Gera um botão que dará submit a um formulário.
     * 
     * @return <string>
     */
    static function post_button($form_content, $url = null, $attrs = '') {
        $html = '<form action="' . url($url) . '" method="post" class="m-t" ' . $attrs . ' style="display: inline;">';
        $html .= $form_content;
        $html .= input_csfr();
        return $html .= '</form>';
    }

}
