<?php

	global $post;
	$parent_page_id = get_parent_page_for_post_type();

	$parent_page_obj = get_post($parent_page_id);

	$banner_style = '';
	$page_banner = get_field( 'banner_image', $parent_page_id);
	if (!empty( $page_banner )) {
	  $banner_style = "background-image: url('".$page_banner['url'] ."')";
	}
 ?>
  <div class="large-10 columns header-column">
    <div style="<?php echo $banner_style; ?>" class="inner-page-header">
      <h1><?php echo $parent_page_obj->post_title; ?></h1>
      <hr>
    </div>
  </div>
