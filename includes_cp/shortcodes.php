<?php 

function fn_count_ser_shortcode( $atts = '') {
    
    
    return 2;
    // Genero los valores por defecto de los parámetros
    $params = shortcode_atts( array(
        'LIMIT'        => 12  
    ), $atts );

    global $wpdb;
    
    $consulta   =    'SELECT * FROM  `'.$wpdb->prefix.'posts` WHERE (`post_type` = "colegios" AND `post_status` = "publish") ORDER BY ID DESC LIMIT '.$params['LIMIT'].'';
    $colegios   =   $wpdb->get_results($consulta);
   
    $itemsCarrusel = '';

    foreach ($colegios as $key => $value) {
                
        $urlImg = get_the_post_thumbnail_url( $value->ID);
        $itemsCarrusel .= '<div class="swiper-slide"><img src="'.$urlImg.'" class="img-responsive" alt=""
        style="max-height: 60px"></div>';

    }
    
    return '<!-- Partners Slider -->
            <section class="section">
                <div class="container py-5 border-bottom">
                    <div class="swiper-container" data-sw-show-items="5" data-sw-space-between="30" data-sw-autoplay="2500"
                        data-sw-loop="true">
                        <div class="swiper-wrapper align-items-center">
                          '.$itemsCarrusel.'  
                        </div>
                    </div>
                </div>
            </section>';

}

function form_bp_ser_shortcode( $atts = '') {

    $boton = '
    <form method="post" id="form-ser-contacts" class="wpcf7-form" >

    <p><input type="button" value="Enviar contacto" style="padding:10px 50px; width:auto !important; id=" enviar_datos_ser"="" class="wpcf7-form-control wpcf7-submit"></p>
    </form>
	<p id="txtMessage"></p>';

	return $boton;
}

?>