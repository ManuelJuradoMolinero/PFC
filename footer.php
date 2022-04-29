<?php
global $capital_allowed_tags;
$menu_locations = get_nav_menu_locations();
$options = get_option('capital_options');
$enable_footer_widgets = (isset($options['enable_footer_widgets']))?$options['enable_footer_widgets']:0;
$footer_bottom_enable = (isset($options['footer_bottom_enable']))?$options['footer_bottom_enable']:1;
$footer_layout = (isset($options['footer_layout']))?$options['footer_layout']:4;
$fbottomcont = (isset($options['footer_bottom_cont_type']))?$options['footer_bottom_cont_type']:'';
$footer_top_skin = (isset($options['footer_top_skin']))?$options['footer_top_skin']:'footer-dark-skin';
$footer_bottom_skin = (isset($options['footer_bottom_skin']))?$options['footer_bottom_skin']:'footer-dark-skin';
$enable_footer_custom_sidebar = (isset($options['enable_footer_custom_sidebar']))?$options['enable_footer_custom_sidebar']:0;
$footer_custom_sidebar = (isset($options['footer_custom_sidebar']))?$options['footer_custom_sidebar']:'';
 ?>


    <!-- Site Footer -->
    <?php if($enable_footer_custom_sidebar == 1){
		if ( !empty( $footer_custom_sidebar ) || $footer_custom_sidebar != '' ) {
		$post_sidebar = get_post( $footer_custom_sidebar );
		?>
		<div class="footer-custom-sidebar">
			<div class="container"> 
				<style type="text/css" scoped>
					<?php echo get_post_meta( $footer_custom_sidebar, '_wpb_shortcodes_custom_css', true ); ?>
				</style>
				<?php echo apply_filters( 'the_content', $post_sidebar->post_content ); ?>
			</div>
		</div>
	<?php } } ?>
    <?php if($enable_footer_widgets == 1) { ?>
		<div class="site-footer site-footer-top <?php echo esc_attr($footer_top_skin); ?>">
			<div class="container">
				<div class="row">
					<?php
						$col = 12 / $footer_layout;
						for ( $count = 1; $count <= $footer_layout; $count ++ ): ?>
							<div class="col-md-<?php echo esc_attr( $col ); ?> col-sm-6 col-xs-12">
								<?php dynamic_sidebar( 'capital-footer-' . $count ); ?>
							</div>
					<?php endfor; ?>
				</div>
			</div>
		</div>
    <?php } ?>
    <?php if($footer_bottom_enable == 1) { ?>
    <div class="site-footer-bottom <?php echo esc_attr($footer_bottom_skin); ?>">
    	<div class="container">
        	<div class="row">
            	<?php if($fbottomcont == 2 ) { ?>
            		<div class="col-md-12 col-sm-12">
                <?php } else { ?>
            		<div class="col-md-6 col-sm-6">
                <?php } ?>
				<?php if (!empty($options['footer_copyright_text'])) { ?>
                	<div class="copyrights-col-left">
                   		<p><?php echo wp_kses($options['footer_copyright_text'], $capital_allowed_tags); ?></p>
                  	</div>
             	<?php } else { ?>
               		<div class="copyrights-col-left">
                		<p><?php echo esc_attr('&copy; ','capital'). date('Y'); ?> <?php echo esc_attr(bloginfo('name')); ?></p>
					</div>
                <?php } ?>
                </div>
				<?php if($fbottomcont != 2 ) { ?>
            	<div class="col-md-6 col-sm-6">
					<?php if($fbottomcont == 0 ) { ?>
                        <?php if (!empty($menu_locations['footer-menu'])) { ?>
                            <div class="copyrights-col-right">
                            <?php
                                  wp_nav_menu(array('theme_location' => 'footer-menu', 'depth' => 1, 'container' => '','items_wrap' => '<ul id="%1$s" class="footer-menu">%3$s</ul>'));
                           	?>
                            </div>
				
                        <?php } ?>
                    <?php } elseif($fbottomcont == 1 ) { ?>
                	<div class="copyrights-col-right">
                        <?php
							$footer_social_shape = (isset($options['footer_social_shape']))?$options['footer_social_shape']:'';
							$footer_social_size = (isset($options['footer_social_size']))?$options['footer_social_size']:'';
							$footer_social_style = (isset($options['footer_social_style']))?$options['footer_social_style']:'';
							$footer_social_hover_style = (isset($options['footer_social_hover_style']))?$options['footer_social_hover_style']:'';
                            $socialSites = $options['footer_social_links']; ?>
                            
                    		<ul class="footer-social imi-social-icons <?php echo esc_attr($footer_social_shape); ?> <?php echo esc_attr($footer_social_size); ?> <?php echo esc_attr($footer_social_style); ?> <?php echo esc_attr($footer_social_hover_style); ?>">
                           <?php
                            foreach ($socialSites as $key => $value) {
                                $string = substr($key, 3);
                                if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                    echo '<li class="'.esc_attr($string).'"><a href="mailto:' . esc_attr($value) . '"><i class="fa ' . esc_attr($key) . '"></i></a></li>';
                                }
                                if (filter_var($value, FILTER_VALIDATE_URL)) {
                                    echo '<li class="'.esc_attr($string).'"><a href="' . esc_url($value) . '" target="_blank"><i class="fa ' . esc_attr($key) . '"></i></a></li>';
                                }
                                elseif($key == 'fa-skype' && $value != '' && $value != 'Enter Skype ID') {
                                    echo '<li class="'.esc_attr($string).'"><a href="skype:' . esc_attr($value) . '?call"><i class="fa ' . esc_attr($key) . '"></i></a></li>';
                                }
                            }
                        ?>
                    	</ul>
					

                   	</div>
                	<?php } ?>
           		</div>
               	<?php } ?>
      		</div>
  		</div>
	</div>
    <?php } ?>
    <?php if (isset($options['enable_backtotop'])&&$options['enable_backtotop'] == 1) { 
		echo'<a id="back-to-top"><i class="fa fa-angle-up"></i></a> ';
 	} ?>
</div>
<!-- End Boxed Body -->
 <?php $SpaceBeforeBody = (isset($options['space-before-body']))?$options['space-before-body']:'';
    echo esc_html($SpaceBeforeBody);
wp_footer(); ?>


		

</body>
</html>



