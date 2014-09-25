<?php
$post_meta = get_fields();
$dr_image_url = 'http://placehold.it/199x199&text=No+Image';
if ( !empty($post_meta['dr_image'])  ) {
  $dr_image_url = $post_meta['dr_image']['url'];
}
 ?>
<div class="large-12 columns">
  <div class="large-4 columns doctor-photo" >
    <a href="<?php the_permalink(); ?>">
      <img class="lazy" src="<?php echo $dr_image_url; ?>" alt="<?php the_title_attribute(); ?>" width="199" height="199" />
    </a>
  </div>
  <div class="large-8 columns doctor-description">
    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <p class="dr-title-inner"><?php echo $post_meta['dr_specialty']; ?></p>
    <?php
    $dr_description = $post_meta['dr_description'];
    echo '<p>'.wen_the_excerpt( $dr_description, 40, true ) . '</p>';
    ?>

  </div>
</div>
