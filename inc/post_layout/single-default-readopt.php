<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php global $post;?>
<?php wp_enqueue_script('rehubwaypoints' );wp_enqueue_script('rhreadingprogress' );?>
<!-- CONTENT -->

<div ng-app="domired" ng-controller="menu">
    <div class="stv-tabs row-wrap center-center ">
        <div class="s-flex comercio-tabs" ng-class="{'active-item': tab === 1  }" ng-click="tab = 1">
            <span class="mkdf-tour-nav-section-icon dripicons-document"></span>
            <span class="mkdf-tour-nav-section-title">
                <?php echo _x('Menu', 'nav menu single page comercio', 'roam-child');  ?> </span>
        </div>

        <div class="s-flex comercio-tabs" ng-class="{'active-item': tab === 2 }" ng-click="tab = 2">
            <span class="mkdf-tour-nav-section-icon dripicons-map"></span>
            <span class="mkdf-tour-nav-section-title">
            <?php echo _x('Historia', 'nav menu single page comercio', 'roam-child');  ?> </span>
        </div>
        
        <div class="s-flex comercio-tabs" ng-class="{'active-item': tab === 3 }" ng-click="tab = 3">
            <span class="mkdf-tour-nav-section-icon dripicons-location"></span>
            <span class="mkdf-tour-nav-section-title">
            <?php echo _x('Ubicación', 'nav menu single page comercio', 'roam-child');  ?> </span>
        </div>

        <div class="s-flex comercio-tabs" ng-class="{'active-item': tab === 4 }" ng-click="tab = 4">
            <span class="mkdf-tour-nav-section-icon dripicons-camera"></span>
            <span class="mkdf-tour-nav-section-title">
            <?php echo _x('Comentarios', 'nav menu single page comercio', 'roam-child');  ?> </span>
        </div>
    </div>
    <div class="rh-container"> 
        <div class="rh-content-wrap clearfix"  >
            <!-- Main Side -->
            <div class="main-side single post-readopt clearfix<?php if(get_post_meta($post->ID, 'post_size', true) == 'full_post' || rehub_option('disable_post_sidebar')) : ?> full_width<?php else:?> w_sidebar<?php endif; ?>">            
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <article ng-show="tab === 1" >
                    <div class="row-wrap stv-products-loop">
                     
                        <?php
                            $args = array(
                                'post_type' => 'product',
                                'posts_per_page' => 30
                                );
                            $loop = new WP_Query( $args );
                            if ( $loop->have_posts() ) {
                                while ( $loop->have_posts() ) : $loop->the_post(); 
                                ?>

                                    <div class="row stv-producto-item" data-profile="<?php echo $loop->post->ID; ?>">
                                       
                                        <div class="stv-producto-img-container">
                                         
                                            <img src="<?php  echo get_the_post_thumbnail_url($loop->post->ID); ?>" data-id="<?php echo $loop->post->ID; ?>">

                                        </div>

                                        <div class="stv-detalles-container">

                                            <p><?php the_title(); ?></p>
                                            <span class="price"><?php echo $product->get_price_html(); ?></span> 
                                        
                                        </div>                    

                                    </div>


                                    <?php
                                endwhile;
                            } else {
                                echo __( 'No products found' );
                            }
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
                    </article>
                   

                    <article ng-show="tab === 3" >
                        MAPA
                    </article>

                    <article ng-show="tab === 4" >
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