<?php
$banner_style = '';
$page_banner = get_field( 'banner_image' );
if (!empty( $page_banner )) {
  $banner_style = "background-image: url('".$page_banner['url'] ."')";
}
 ?>
        <div class="large-10 columns header-column">
          <div style="<?php echo $banner_style; ?>" class="inner-page-header">
            <h1><?php the_title(); ?></h1>
            <hr>
          </div>
        </div>
