<?php
get_header();
global $capital_allowed_tags;
$options = get_option('capital_options');
$page_title = (isset($options['page_404_title']))?$options['page_404_title']:'';
$page_content = (isset($options['page_404_content']))?$options['page_404_content']:'';
$page_404_banner = (isset($options['page_404_banner']['url']))?$options['page_404_banner']['url']:'';
if($page_404_banner != ''){
	$page_404_banner = $page_404_banner;
} else {
	$default_header = (isset($options['capital_default_banner']['url']))?$options['capital_default_banner']['url']:'';
}
?>
<div class="hero-area">
    	<div class="page-banner parallax" style="background-image:url(<?php echo esc_url($default_header); ?>);">
        	<div class="container">
            	<div class="page-banner-text"><div><div>
        			<h1><?php if($page_title != '') { echo esc_attr($page_title); } else { esc_html_e('404 Error!', 'capital'); } ?></h1>
                </div></div></div>
            </div>
        </div>
    </div>
    <!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
    		<div class="container">
            	<div class="row">
                	<!-- Posts List -->
                    <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
                    	<!-- Post -->
                        <article class="page-404">
                        	<?php if($page_content != ''){
								echo wp_kses($page_content, $capital_allowed_tags);
							} else { ?>
                          	<div class="text-align-center">
                          		<h2><?php if($page_title != '') { echo esc_attr($page_title); } else {esc_html_e('Sorry - Page Not Found!', 'capital');} ?></h2>
								<?php esc_html_e('The page you are looking for was moved, removed, renamed', 'capital'); ?><br><?php esc_html_e('or might never existed. You stumbled upon a broken link.', 'capital'); ?>
                      		</div>
                            <?php } ?>
                        </article>
                    </div>
                </div>
            </div>
        </div>
   	</div>
    <!-- End Body Content -->
<?php get_footer(); ?>