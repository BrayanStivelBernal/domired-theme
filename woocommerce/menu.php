<div class="s-50  profiler<?php echo the_title(); ?>" data-profile="<?php echo $loop->post->ID; ?>">

    <img src="<?php  get_the_post_thumbnail($loop->post->ID); ?>" data-id="<?php echo $loop->post->ID; ?>">

    <p><?php the_title(); ?></p>

    <span class="price"><?php echo $product->get_price_html(); ?></span>                    

</div>