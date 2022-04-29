<?php
get_header();
global $capital_allowed_tags;
$options = get_option('capital_options');
$pageSidebar = (isset($options['search_sidebar']))?$options['search_sidebar']:'';
if(!empty($pageSidebar)&&is_active_sidebar($pageSidebar)) {
$class = 9;  
}else{
$class = 12;  
}
$default_header = (isset($options['capital_default_banner']['url']))?$options['capital_default_banner']['url']:'';
if ( is_rtl() )	{$data_rtl = 'yes';} else {$data_rtl = 'no';}
$id = get_option('page_for_posts');
if($id==0||$id=='')
{
	$id = get_the_ID();
}
?>
<div class="hero-area">
    	<div class="page-banner page-banner-image parallax" style="background-image:url(<?php echo esc_url($default_header); ?>);">
        	<div class="container">
            	<div class="page-banner-text"><div><div>
        			<h1><?php printf( esc_html__( 'Search Results for: %s', 'capital' ), get_search_query() ); ?></h1>
                </div></div></div>
            </div>
        </div>
    </div>
  	<!-- Start Body Content -->
  	 <div id="main-container">
    	<div class="content">
        	<div class="container">
            	<div class="row">
                	<div class="col-md-<?php echo esc_attr($class); ?> content-block" id="content-col">
                    	<div class="blog-posts blog-page-posts">
                        <?php if(have_posts()) : ?>
						<?php while(have_posts()) : the_post();
							$meta_data_date = esc_html(get_the_date(get_option('date_format'), get_the_ID()));
                            
                            $post_media = '';
							if ( has_post_thumbnail() ) {
								$post_media = '<a href="'.get_the_permalink().'" class="media-box">'.get_the_post_thumbnail(get_the_ID(),'capital-600x400').'</a>';
							}	
							$post_meta = '<div class="blog-post-details">';
							$post_meta .= '<div class="post-date"><span><i class="mi mi-date-range"></i> '.$meta_data_date.' </span></div></div>';
							?>
							<article <?php post_class('post-list-item post'); ?>>
                        	<?php 
							echo '<div class="row">';
							if($post_media != ''){
								echo '<div class="col-md-4"><div class="post-media">';
									echo wp_kses($post_media, $capital_allowed_tags);
								echo '</div></div>';
							}
							if($post_media != ''){
								echo '<div class="col-md-8">';
							} else {
								echo '<div class="col-md-12">';	
							}
							
							echo '<h3 class="post-title"><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a></h3>';
							echo wp_kses($post_meta, $capital_allowed_tags);
							
							echo capital_excerpt('30');
							wp_link_pages( array(
							  	'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'capital' ) . '</span>',
							  	'after'       => '</div>',
							  	'link_before' => '<span>',
							  	'link_after'  => ' </span>',
								'separator'    => '/ ',
							) );
							echo '<a href="'.esc_url(get_permalink()).'" class="btn btn-primary btn-secondary">'.esc_html__('Read more','capital').'</a>';
							echo '</div></div></article>'; ?>
                                   
                       <?php endwhile; else: ?>
							<p class="alert alert-warning"><?php esc_html_e('No results found. Try searching again', 'capital'); ?></p>
						<?php endif; ?>
                        <!-- Pagination -->
                        <div class="page-pagination">
							<?php if(!function_exists('capital_pagination'))
                                {
                                next_posts_link( esc_html__('&laquo; Older Entries','capital'));
                                previous_posts_link( esc_html__('Newer Entries &raquo;','capital'));
                                }
                            else
                                {
                                echo capital_pagination();
                            } ?>
                        </div>
                        </div>
                   </div>
                   <?php if(is_active_sidebar($pageSidebar)) { ?>
                    <!-- Sidebar -->
                    <div class="sidebar col-md-3" id="sidebar-col">
                    	<?php dynamic_sidebar($pageSidebar); ?>
                    </div>
                    <?php } ?>
           		</div>
       		</div>
 		</div>
	</div>
    <!-- End Body Content -->
<?php get_footer(); ?>