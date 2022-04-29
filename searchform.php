<?php $unique_id = uniqid( 'search-form-' ); ?>
   
<form method="get" class="imi-searchform" action="<?php echo esc_url(home_url()); ?>/">
    <input type="text" name="s" id="<?php echo esc_attr($unique_id); ?>" value="" placeholder="<?php esc_html_e('Search','capital'); ?>">
	<button type ="submit" name ="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
</form>
