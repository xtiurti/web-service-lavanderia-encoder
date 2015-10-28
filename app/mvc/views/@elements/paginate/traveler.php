<?php
$url_back = paginate_href_page_back();
$back_message = $url_back ? "Retornar para pág. " . paginate_page_back() : 'Não há página anterior.';

$url_forward = paginate_href_page_forward();
$forward_message = $url_forward ? "Ir para pág. " . paginate_page_forward() : 'Não há página posterior.';
?>

<?php // l:desktop m:tablet s:mobile  ?>

<div class="row paginate" current="<?php echo paginate_page_current(); ?>" total="<?php echo paginate_total_pages(); ?>">

    <div class="col l9 m6 s0">&nbsp;</div>
    <div class="col l3 m6 s12">

        <div class="row">
            <a <?php echo $url_back; ?> class="input-field col s2">
                <div class="center-align">
                    <i class="material-icons tooltipped grey-text <?php echo $url_back ? 'text-darken-2' : 'text-lighten-2 disabled' ?>" data-position="top" data-delay="50" data-tooltip="<?php echo $back_message; ?>">arrow_back</i>
                </div>
            </a>

            <div class="input-field col s8 tooltipped" data-position="top" data-delay="50" data-tooltip="Digite a pág. que deseja acessar e pressione <enter>">
                <input id="paginate_page" type="text" style="text-align: center;" value="<?php echo paginate_page_current(); ?>" class="mask natural number" />

                <label for="paginate_page">
                    Página
                </label>

                <small class="red-text relative message_current_page animated bounceIn" style="top: -10px; display: none; font-size: 70%;">
                    <br/>
                    <i class="material-icons" style="font-size: 16px; margin-right: 3px;">error</i>
                    <span class="relative" style="top: -4px;">
                        <b>Esta é a página atual</b>
                    </span>
                </small>
                
                <small class="red-text relative message_page_not_found animated bounceIn" style="top: -10px; display: none; font-size: 70%;">
                    <br/>
                    <i class="material-icons" style="font-size: 16px; margin-right: 3px;">error</i>
                    <span class="relative" style="top: -4px;">
                        <b>Esta página não existe</b>
                    </span>
                </small>
            </div>

            <a <?php echo $url_forward; ?> class="input-field col s2">
                <div class="center-align">
                    <i class="material-icons grey-text tooltipped <?php echo $url_forward ? 'text-darken-2' : 'text-lighten-2 disabled' ?>" data-position="left" data-delay="50" data-tooltip="<?php echo $forward_message; ?>">arrow_forward</i>
                </div>
            </a>
        </div>

        <div class="center-align relative" style="top: -30px;">
            <small class="grey-text">
                <b style="font-size: 90%;">
                    Pág. 
                    <b class="black-text">
                        <?php echo paginate_page_current(); ?>
                    </b> 
                    de 
                    <b class="black-text">
                        <?php echo paginate_total_pages(); ?>
                    </b> 
                    | 
                    <b class="black-text">
                        <?php echo paginate_total_records(); ?>
                    </b>
                    Registros, mostrando do 
                    <b class="black-text">
                        <?php echo paginate_record_start(); ?>
                    </b> 
                    ao 
                    <b class="black-text">
                        <?php echo paginate_record_forward(); ?>
                    </b>
                </b>
            </small>
        </div>
    </div>
</div>