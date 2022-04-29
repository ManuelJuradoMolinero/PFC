<?php 
global $capital_allowed_tags;
$options = get_option('capital_options');
if(is_home()){
	$id = get_option('page_for_posts');
} else {
	$id = get_the_ID();
}
$post_type = get_post_type($id);
$default_project_banner = (isset($options['default_project_banner']))?$options['default_project_banner']['url']:'';
$default_post_banner = (isset($options['default_post_banner']))?$options['default_post_banner']['url']:'';
$default_service_banner = (isset($options['default_service_banner']))?$options['default_service_banner']['url']:'';
$default_team_banner = (isset($options['default_team_banner']))?$options['default_team_banner']['url']:'';
$default_product_banner = (isset($options['default_product_banner']))?$options['default_product_banner']['url']:'';

if($post_type=='imi_projects' && $default_project_banner != '')
{
	$image_default = $default_project_banner;
}
elseif($post_type=='post' && $default_post_banner != '')
{
	$image_default = $default_post_banner;
}
elseif($post_type=='imi_services' && $default_service_banner != '')
{
	$image_default = $default_service_banner;
}
elseif($post_type=='imi_team' && $default_team_banner != '')
{
	$image_default = $default_team_banner;
}
elseif($post_type=='product' && $default_product_banner != '')
{
	$image_default = $default_product_banner;
}
else{
	$image_default = (isset($options['capital_default_banner']))?$options['capital_default_banner']['url']:'';
}

$image = $banner_type = '';
$fimagebanner = get_post_meta($id,'capital_featured_image_banner',true);
$height = get_post_meta($id,'capital_pages_slider_height',true);
$PageBannerMinHeight = (isset($options['inner_page_header_min_height']))?$options['inner_page_header_min_height']:'';
$color = get_post_meta($id,'capital_pages_banner_color',true);
$sub_title = get_post_meta($id,'capital_header_sub_title',true);
$color = ($color!='' && $color!='#')?$color:'';
$post_image = get_post_meta($id,'capital_header_image',true);
$image_src = wp_get_attachment_image_src( $post_image, 'full', '', array() );
$post_thumbnail_id = get_post_thumbnail_id( $id );
$post_thumbnail_url = wp_get_attachment_image_src($post_thumbnail_id,'full', true);
if(is_tax() || is_category()){
	$term_id = get_queried_object()->term_id;
	$term_banner = get_term_meta( $term_id, 'capital_term_banner_image', true );
	$term_banner_image = RWMB_Image_Field::file_info( $term_banner, array( 'size' => 'full' ) );
} else {
	$term_banner_image['url'] = '';
}


if(has_post_thumbnail($id) && $fimagebanner == 1){$image = $post_thumbnail_url[0];}elseif(is_array($image_src)) { $image = $image_src[0]; }elseif($term_banner_image['url'] != ''){ $image = $term_banner_image['url']; } else { $image = $image_default; }
$project_archive_title = (isset($options['project_archive_title']))?$options['project_archive_title']:esc_html__('Projects', 'capital');
$blog_archive_title = (isset($options['blog_archive_title']))?$options['blog_archive_title']:esc_html__('Blog', 'capital');
$service_archive_title = (isset($options['service_archive_title']))?$options['service_archive_title']:esc_html__('Services', 'capital');
$team_archive_title = (isset($options['team_archive_title']))?$options['team_archive_title']:esc_html__('Team', 'capital');
$shop_archive_title = (isset($options['shop_archive_title']))?$options['shop_archive_title']:esc_html__('Shop', 'capital');
$breadcrumb_header_display = (isset($options['breadcrumb_header_display']))?$options['breadcrumb_header_display']:1;

if($post_type=='imi_projects')
{
	if(is_single()){
		$blog_title = get_the_title(get_the_ID());
	}
	elseif (is_tax('imi_projects_category')){
		$blog_title = single_term_title("", false);
	}
	else {
		$blog_title = $project_archive_title;
	}
	$banner_title = $blog_title;
}
elseif($post_type=='post')
{
	if(is_single()){
		$blog_title = get_the_title(get_the_ID());
	}
	elseif (is_category() || is_tag()){
		$blog_title = single_term_title("", false);
	}
	elseif (is_author()){
		global $author;
        $userdata = get_userdata($author);
		$blog_title = $userdata->display_name;
	} else {
		$blog_title = $blog_archive_title;
	}
	$banner_title = $blog_title;
}
elseif($post_type=='imi_services')
{
	if(is_single()){
		$blog_title = get_the_title(get_the_ID());
	}
	elseif (is_tax('imi_services_category')){
		$blog_title = single_term_title("", false);
	}
	else {
		$blog_title = $service_archive_title;
	}
	$banner_title = $blog_title;
}
elseif($post_type=='imi_team')
{
	if(is_single()){
		$blog_title = get_the_title(get_the_ID());
	}
	elseif (is_tax('imi_team_category')){
		$blog_title = single_term_title("", false);
	}
	else {
		$blog_title = $team_archive_title;
	}
	$banner_title = $blog_title;
}
elseif($post_type=='product')
{
	if(is_single()){
		$blog_title = get_the_title(get_the_ID());
	}
	elseif (is_tax('product_cat')){
		$blog_title = single_term_title("", false);
	}
	else {
		$blog_title = $shop_archive_title;
	}
	$banner_title = $blog_title;
}
else
{
	$banner_title = get_the_title($id);
}
if($height != ''){$rheight = $height;} elseif($PageBannerMinHeight != ''){$rheight = $PageBannerMinHeight;} else {$rheight = '';}
?>
 <div class="hero-area">
 <?php if($image!='')
 {
	 echo '<div class="page-banner page-banner-image parallax" style="background-image:url('.esc_url($image).'); background-color:'.esc_attr($color).'; height:'.esc_attr($rheight).'px'.';">
	 <div class="container">
            	<div class="page-banner-text"><div style="height:'. esc_attr($rheight).'px;"><div>';
 }
 else
 {
	 echo '<div class="page-banner" style="background-color:'.esc_attr($color).'; height:'.esc_attr($rheight).'px'.';">
	 <div class="container">
            	<div class="page-banner-text"><div style="height:'. esc_attr($rheight).'px;"><div>';
 }
 ?>
        			<h1><?php echo wp_kses($banner_title, $capital_allowed_tags); ?></h1>
                    <?php if($sub_title != ''){ ?>
                    	<p><?php echo esc_attr($sub_title); ?></p>
                    <?php } ?>
                </div></div></div>
            </div>
        </div>
    </div>
    <?php if($breadcrumb_header_display != '' && $breadcrumb_header_display != 1){ ?>
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


 <audio id="musica" src="http://localhost/Desarrollo_wordpress/wp-content/uploads/2022/03/musica.mp3" loop controls></audio>
