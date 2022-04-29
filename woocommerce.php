<?php 
get_header();
$options = get_option('capital_options');
$pageSidebarGet = get_post_meta(get_the_ID(),'capital_select_sidebar_from_list', true);
$pageSidebarStrictNo = get_post_meta(get_the_ID(),'capital_strict_no_sidebar', true);
$breadcrumb_header_display = (isset($options['breadcrumb_header_display']))?$options['breadcrumb_header_display']:1;
$PageBannerMinHeight = (isset($options['inner_page_header_min_height']))?$options['inner_page_header_min_height']:'';
$pageSidebarOpt = $options['product_sidebar'];
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
$sidebar_column = ($sidebar_column=='')?3:$sidebar_column;
if(!empty($pageSidebar)&&is_active_sidebar($pageSidebar)) {
$left_col = 12-$sidebar_column;
$class = $left_col;  
}else{
$class = 12;  
}
$product_banner = (isset($options['default_product_banner']))?$options['default_product_banner']['url']:'';
$default_banner = (isset($options['capital_default_banner']))?$options['capital_default_banner']['url']:'';
if(is_product_category()){
	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	$term_banner_image = get_option($term->taxonomy . $term->term_id . "_term_banner");
	if($term_banner_image != ''){
		$image_default = $term_banner_image;
	}
	if($product_banner != ''){
		$image_default = $product_banner;
	} else {
		$image_default = $product_banner;
	}
	$shop_archive_title = (isset($options['shop_archive_title']))?$options['shop_archive_title']:esc_html__('Shop', 'capital');
?>
    <div class="hero-area">
    	<?php if($image_default != ''){ ?>
    		<div class="page-banner page-banner-image parallax" style="background-image:url(<?php echo esc_url($image_default); ?>); height:<?php echo esc_attr($PageBannerMinHeight); ?>px;">
       	<?php } else { ?>
    		<div class="page-banner parallax" style="height:<?php echo esc_attr($PageBannerMinHeight); ?>px;">
        <?php } ?>
        	<div class="container">
            	<div class="page-banner-text"><div style="height:<?php echo esc_attr($PageBannerMinHeight); ?>px;"><div>
        			<h1><?php echo esc_attr($shop_archive_title); ?></h1>
                </div></div></div>
            </div>
        </div>
    </div>
    <?php if($breadcrumb_header_display != '' || $breadcrumb_header_display == 1){ ?>
    <div class="breadcrumb-wrapper">
    	<div class="container">
			<?php if(function_exists('bcn_display')){ ?>
				<ol class="breadcrumb">
					<?php bcn_display(); ?>
				</ol>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
<?php } else {
$page_header = get_post_meta(get_the_ID(),'capital_pages_Choose_slider_display',true);
if($page_header==4) {
	get_template_part( 'pages', 'flex' );
}
elseif($page_header==5) {
	get_template_part( 'pages', 'revolution' );
}
else {
	get_template_part( 'pages', 'banner' );
}
}
?>
<!-- Start Body Content -->
<div id="main-container">
  	<div class="content">
   		<div class="container">
       		<div class="row">
            	<div class="col-md-<?php echo esc_attr($class); ?>" id="content-col">
            		<?php if ( have_posts() ) :
						woocommerce_content(); echo capital_pagination();
						endif; ?>
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