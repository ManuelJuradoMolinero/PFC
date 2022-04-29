<?php
/*
Template Name: One Page
*/
get_header();
global $capital_allowed_tags;
$options = get_option('capital_options');
$pageSidebarGet = get_post_meta(get_the_ID(),'capital_select_sidebar_from_list', true);
$pageSidebarStrictNo = get_post_meta(get_the_ID(),'capital_strict_no_sidebar', true);
$pageSidebarOpt = (isset($options['page_sidebar']))?$options['page_sidebar']:'';
if($pageSidebarGet != ''){
	$pageSidebar = $pageSidebarGet;
}elseif($pageSidebarOpt != ''){
	$pageSidebar = $pageSidebarOpt;
}else{
	$pageSidebar = '';
}
if($pageSidebarStrictNo == 1){
	$pageSidebar = '';
}
$sidebar_column = get_post_meta(get_the_ID(),'capital_sidebar_columns_layout',true);
$sidebar_column = ($sidebar_column=='')?4:$sidebar_column;
if(!empty($pageSidebar)&&is_active_sidebar($pageSidebar)) {
$left_col = 12 - intval($sidebar_column);
$class = $left_col;  
}else{
$class = 12;  
}
$page_header = get_post_meta(get_the_ID(),'capital_pages_Choose_slider_display',true);
if($page_header==4) {
	get_template_part( 'pages', 'flex' );
}
elseif($page_header==5) {
	get_template_part( 'pages', 'revolution' );
} else{
	get_template_part( 'pages', 'banner' );
}
?>
<!-- Start Body Content -->
<div id="main-container">
  	<div class="content">
   		<div class="container">
       		<div class="row">
            	<div class="col-md-<?php echo esc_attr($class); ?>" id="content-col">
            		<?php $onepage_menu_id = get_post_meta(get_the_ID(),'capital_select_menu_from_list',true);
					if($onepage_menu_id != ''){
						$menu_items = wp_get_nav_menu_items($onepage_menu_id);
						$theidlist = array();
							foreach ( (array) $menu_items as $key => $menu_item ) {
								$theidlist[] = $menu_item->object_id;
							}
					}
					remove_all_actions( 'pre_get_posts' );
					$the_query = new WP_Query( array( 'post_type' => 'page', 'order' => 'ASC', 'orderby' => 'post__in', 'posts_per_page' => '-1', 'post__in' => $theidlist, 'suppress_filters' => true ) );
    				while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
    				<style type="text/css" scoped>
						<?php echo get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true ); ?>
					</style>
    				<div id="scroll-<?php echo get_the_ID(); ?>" class="page-section">
    					<div class="post-content">
   							<?php the_content(); ?>
						</div>
      				</div>
    				<?php endwhile; 
						wp_reset_postdata();
					?>
                </div>
                <?php if(is_active_sidebar($pageSidebar)) { ?>
                    <!-- Sidebar -->
                    <div class="col-md-<?php echo esc_attr($sidebar_column); ?>" id="sidebar-col">
                    	<?php dynamic_sidebar($pageSidebar); ?>
                    </div>
                    <?php } ?>
            	</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>