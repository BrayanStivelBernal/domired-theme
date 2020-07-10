<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php global $post;?>
<?php wp_enqueue_script('rehubwaypoints' );wp_enqueue_script('rhreadingprogress' );?>
<!-- CONTENT -->

<div ng-app="domired" ng-controller="menu" style="min-height:500px;">
    <div class="stv-tabs row-wrap center-center" ng-cloak>
        <div class="s-15 comercio-tabs" ng-repeat="categoria in categorias" ng-class="{'active-item': cat_select === categoria.term_id  }" ng-click="changeCat(categoria.term_id)">
            <span class="mkdf-tour-nav-section-icon dripicons-document"></span>
            <span class="mkdf-tour-nav-section-title">{{categoria.name}}</span>
        </div>
        
    </div>
    <div class="rh-container"  ng-cloak > 
        <div class="rh-content-wrap clearfix"  >
            <!-- Main Side -->
            <div class="main-side single post-readopt clearfix<?php if(get_post_meta($post->ID, 'post_size', true) == 'full_post' || rehub_option('disable_post_sidebar')) : ?> full_width<?php else:?> w_sidebar<?php endif; ?>">            
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <article ng-show="tab === 1" >
                    <div class="row-wrap stv-products-loop" >

                        <?php

                            $marca = get_post_meta($post->ID, 'relacion_con_marca')[0];
                            
                            $args = array(
                                'post_type' => 'product',
                                'posts_per_page' => -1,
                                'tax_query'      => array(array(
                                        'taxonomy' => 'store',
                                        'field'    => 'ID',
                                        'terms'    => array ($marca))
                                    )
                                );

                            $categorias = [];

                            $loop = new WP_Query( $args );
                            if ( $loop->have_posts() ) {
                                while ( $loop->have_posts() ) : $loop->the_post(); 
                                
                                $terms = get_the_terms( $loop->post->ID, 'product_cat' );
                                $cats_item_ids = [];
                                for($i = 0; $i < count($terms); $i++){
                                    $categorias[$terms[$i]->name] = $terms[$i];
                                    $cats_item_ids[$i] = $terms[$i]->term_id;
                                }
                                if(empty($cat_items_ids)){
                                    $cat_items_ids = [0];
                                }
                                

                                ?>
                                
                                    <div ng-hide="-1 === <?php echo json_encode($cats_item_ids, true); ?>.indexOf(cat_select)" class="row stv-producto-item mobile-not" data-profile="<?php echo $loop->post->ID; ?>">
                                      
                                        <div class="stv-producto-img-container">
                                            
                                            
                                         
                                            <img src="<?php $foto = get_the_post_thumbnail_url($loop->post->ID); echo $foto; ?>" data-id="<?php echo $loop->post->ID; ?>">

                                        </div>

                                        <div class="stv-detalles-container">
                                            <div class="row-wrap space-around-center ">
                                                <h4 class="titulo"><?php the_title(); ?></h4>
                                                <span class="price"><?php echo $product->get_price_html(); ?></span> 
                                            </div>
                                             
                                            
                                            <div class="row-wrap center-center descripcion">
                                                    <p><?php $descrip = $product->get_description();
                                                     if(strlen($descrip) > 100){
                                                        echo substr($descrip ,0, 97).'...';
                                                     }else{
                                                        echo $descrip;
                                                     }  ?></p>
                                            </div>

                                            <div class="row  space-around-center">


                                                <div class="column s-30">
                                                  
                                                   <?php 
                                                        $product = wc_get_product(  $loop->post->ID );

                                                        if ( $product->get_type() === 'simple'){

                                                            
                                                           ?>
                                                    <div class="quantity">
                                                        <input type="number" id="quantity_5eee9f3a63b6f" ng-model="producto.id<?php echo $loop->post->ID; ?>" class="input-text qty text" step="1" min="1" max="60" name="quantity" value="1" title="Cantidad" size="4" placeholder="1" inputmode="numeric">
                                                    </div>  
                                                </div>
                                               
                                                <div class="column ">
                                                         
                                                    <a href="?add-to-cart=<?php echo $loop->post->ID; ?>" 
                                                        rel="nofollow" data-quantity="{{ producto.id<?php echo $loop->post->ID; ?>}}" data-product_id="<?php echo $loop->post->ID; ?>" 
                                                        class="re_track_btn rh-deal-compact-btn btn_offer_block add_to_cart_button ajax_add_to_cart product_type_simple ">
                                                        Añadir al pedido
                                                    </a>
                                                </div>



                                                        <?php

                                                        }else{
                                                           
                                                            $ids_product = json_encode($product->get_children(), true);
                                                        ?>
                                                </div>
                                                <div class="column ">
                                                         
                                                    <a ng-click="producto_compuesto($event, <?php echo $loop->post->ID; ?>,'<?php the_title(); ?>','<?php echo $foto; ?>') " 
                                                        rel="nofollow" class="re_track_btn rh-deal-compact-btn btn_offer_block add_to_cart_button product_type_simple ">
                                                        Elige como la quieres
                                                    </a>
                                                </div>



                                                        <?php

                                                        }
                                                       
                                                   ?>
                                                    
                                                
                                            </div>
                                        </div>    
                                              

                                    </div>

                                    <div ng-hide="-1 === <?php echo json_encode($cats_item_ids, true); ?>.indexOf(cat_select)" class="stv-producto-item mobile" data-profile="<?php echo $loop->post->ID; ?>">
                                       
                                        <div class="row-wrap space-between-center">
                                            <h4 class="titulo"><?php the_title(); ?></h4>
                                            <span class="price"><?php echo $product->get_price_html(); ?></span> 
                                        </div>
                                       
                                        <div class="row">
                      
                                        <div class="stv-producto-img-container">

                                                <img src="<?php  echo get_the_post_thumbnail_url($loop->post->ID); ?>" data-id="<?php echo $loop->post->ID; ?>">

                                            </div>

                                            <div class="stv-detalles-container">                                            
                                                
                                                <div class="row-wrap center-start descripcion">
                                                        <p><?php $descrip = $product->get_description();
                                                        if(strlen($descrip) > 50){
                                                            echo substr($descrip ,0, 47).'...';
                                                        }else{
                                                            echo $descrip;
                                                        }  ?></p>
                                                </div>

                                                <div class="row q-add space-around-center">


                                                    <div class="column s-30">
                                                    
                                                    <?php 
                                                            $product = wc_get_product(  $loop->post->ID );

                                                            if ( $product->get_type() === 'simple'){
    
                                                    ?>
                                                        <div class="quantity">
                                                            <input type="number" id="quantity_5eee9f3a63b6f" ng-model="producto.id<?php echo $loop->post->ID; ?>" class="input-text qty text" step="1" min="1" max="60" name="quantity" value="1" title="Cantidad" size="4" placeholder="1" inputmode="numeric">
                                                        </div>  
                                                    </div>
                                                
                                                    <div class="column ">
                                                            
                                                        <a href="?add-to-cart=<?php echo $loop->post->ID; ?>" 
                                                            rel="nofollow" data-quantity="{{ producto.id<?php echo $loop->post->ID; ?>}}" data-product_id="<?php echo $loop->post->ID; ?>" 
                                                            class="re_track_btn rh-deal-compact-btn btn_offer_block add_to_cart_button ajax_add_to_cart product_type_simple ">
                                                            AÑADIR 
                                                        </a>
                                                    </div>
                                                    <?php

                                                    }else{
                                                        
                                                        
                                                    ?>
                                                     </div>
                                                
                                                    <div class="column ">
                                                            
                                                        <a ng-click="producto_compuesto($event, <?php echo $loop->post->ID; ?>,'<?php the_title(); ?>','<?php echo $foto; ?>') " 
                                                            rel="nofollow" data-quantity="{{ producto.id<?php echo $loop->post->ID; ?>}}" data-product_id="<?php echo $loop->post->ID; ?>" 
                                                            class="re_track_btn rh-deal-compact-btn btn_offer_block add_to_cart_button  product_type_simple ">
                                                            ELIGE 
                                                        </a>
                                                    </div>

                                                    <?php  } ?>
                                                </div>
                                            </div>    
                                        </div>
                                     
                                              

                                    </div>
                                


                                    <?php
                                endwhile;
                            } else {
                                echo __( 'No se encontraron productos de este negocio' );
                            }

                            echo '<script> var categorias_productos = '.json_encode($categorias, true).'</script>';
                            wp_reset_postdata();
                        ?>
                    
                    </div>
                  
                    </article>
                    <article ng-show="tab === 2" <?php post_class('post pt0 pb0 pr0 pl0'); ?> id="post-<?php the_ID(); ?>"> show
                        <?php $nohead = (isset($nohead)) ? $nohead : '';?> 
                        <?php if(!$nohead):?>       
                            <!-- Title area -->
                            <div class="rh_post_layout_metabig mt10">
                                <div class="title_single_area">
                                    <?php 
                                        $crumb = '';
                                        if( function_exists( 'yoast_breadcrumb' ) ) {
                                            $crumb = yoast_breadcrumb('<div class="breadcrumb">','</div>', false);
                                        }
                                        if( ! is_string( $crumb ) || $crumb === '' ) {
                                            if(rehub_option('rehub_disable_breadcrumbs') == '1' || vp_metabox('rehub_post_side.disable_parts') == '1') {echo '';}
                                            elseif (function_exists('dimox_breadcrumbs')) {
                                                dimox_breadcrumbs(); 
                                            }
                                        }
                                        echo ''.$crumb;  
                                    ?> 
                                    <?php echo re_badge_create('labelsmall'); ?>                 
                                    <h1><?php the_title(); ?></h1> 
                                    <div class="meta post-meta">
                                        <?php rh_post_header_meta(false, false, true, true, true);?> 
                                    </div>                        
                                </div>
                            </div>
                            <?php if(rehub_option('rehub_single_after_title')) : ?><div class="mediad mediad_top"><?php echo do_shortcode(rehub_option('rehub_single_after_title')); ?></div><div class="clearfix"></div><?php endif; ?>                         
                            <div class="feature-post-section mb35">
                                <?php include(rh_locate_template('inc/parts/top_image.php')); ?>  
                            </div> 
                            <div class="clearfix mb5"></div>  
                        <?php endif;?>                                                         
                        <?php if(rehub_option('rehub_single_before_post') && vp_metabox('rehub_post_side.show_banner_ads') != '1') : ?><div class="mediad mediad_before_content"><?php echo do_shortcode(rehub_option('rehub_single_before_post')); ?></div><?php endif; ?>
                        <div class="post-inner clearbox">
                            <div class="mobileblockdisplay rh-flex-columns">
                            <div class="post-meta-left hideonsmalltablet text-center">
                                <?php if(rehub_option('exclude_author_meta') != 1):?>                              
                                    <?php $author_id=$post->post_author; ?>
                                    <a href="<?php echo get_author_posts_url( $author_id ) ?>" class="redopt-aut-picture mb10 blockstyle">
                                        <?php echo get_avatar( $author_id, '70', '', '', array('class'=>'roundborder') ); ?>                   
                                    </a>
                                    <a href="<?php echo get_author_posts_url( $author_id ) ?>" class="redopt-aut-link lineheight15 blockstyle font80 greycolor">             
                                        <?php the_author_meta( 'display_name', $author_id ); ?>         
                                    </a>
                                <?php endif;?>
                                <?php if(rehub_option('exclude_date_meta') != 1):?>
                                    <div class="date_time_post font60 border-bottom pb10 mb15"><?php the_time(get_option( 'date_format' )); ?></div>
                                <?php endif;?>
                                <?php if(rehub_option('rehub_disable_share_top') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                                <?php else :?>                               
                                    <?php if(function_exists('rehub_social_share')):?>
                                        <div id="rh-share-sticky">
                                        <?php echo rehub_social_share('square', 1);?>
                                        </div>
                                    <?php endif;?>             
                                <?php endif; ?>                                     
                            </div> 
                            <div class="<?php if(rehub_option('rehub_disable_share_top') =='1' && rehub_option('exclude_author_meta') == '1' &&  rehub_option('exclude_date_meta') == '1'){echo '';}else{echo 'leftbarcalc';}?>">
                                <?php the_content(); ?>
                                <?php if(rehub_option('rehub_single_code') && vp_metabox('rehub_post_side.show_banner_ads') != '1') : ?><div class="single_custom_bottom"><?php echo do_shortcode (rehub_option('rehub_single_code')); ?></div><div class="clearfix"></div><?php endif; ?>

                                <?php if(rehub_option('rehub_disable_share') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                                <?php else :?>
                                    <?php include(rh_locate_template('inc/parts/post_share.php')); ?>  
                                <?php endif; ?>

                                <?php if(rehub_option('rehub_disable_prev') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                                <?php else :?>
                                    <?php include(rh_locate_template('inc/parts/prevnext.php')); ?>                    
                                <?php endif; ?>                 

                                <?php if(rehub_option('rehub_disable_tags') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                                <?php else :?>
                                    <div class="tags">
                                        <p><?php the_tags('<span class="tags-title-post">'.__('Tags: ', 'rehub-theme').'</span>',""); ?></p>
                                    </div>
                                <?php endif; ?>

                                <?php if(rehub_option('rehub_disable_author') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                                <?php else :?>
                                    <?php rh_author_detail_box();?>
                                <?php endif; ?>                
                            </div>
                            </div>
                        </div>
                        
                        <?php comments_template(); ?> 
                    </article>
                   
                    <div class="clearfix"></div>                    
                <?php endwhile; endif; ?>
                <?php if(rehub_option('rehub_disable_relative') =='1' || vp_metabox('rehub_post_side.disable_parts') == '1')  : ?>
                <?php else :?>
                    <div class="pt20 pb20">
                    <?php include(rh_locate_template('inc/parts/related_posts.php')); ?>
                    </div>
                <?php endif; ?> 
                
            </div>  
            <!-- /Main Side --> 
            <!-- Sidebar -->
            <?php if(get_post_meta($post->ID, 'post_size', true) == 'full_post' || rehub_option('disable_post_sidebar')) : ?><?php else : ?><?php get_sidebar(); ?><?php endif; ?>
            <!-- /Sidebar --> 
        </div>
    </div>
</div>
<!-- /CONTENT -->     