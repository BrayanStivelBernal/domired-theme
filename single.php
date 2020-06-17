<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php get_header(); ?>
<?php global $post;?>
<?php $rh_post_layout_style = get_post_meta($post->ID, '_post_layout', true);?>
<?php if ($rh_post_layout_style == '') {
    if($post->post_type =='blog'){
        $rh_post_layout_style = rehub_option('blog_layout_style');
    }else{
        $rh_post_layout_style = rehub_option('post_layout_style'); 
    }
} ?>


<?php include(rh_locate_template('inc/post_layout/single-inimagefull.php')); ?>
                           

<!-- FOOTER -->
<?php get_footer(); ?>