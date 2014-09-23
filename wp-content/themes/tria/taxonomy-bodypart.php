<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tria
 */
get_header();
?>

<?php

$current_taxonomy_object = get_queried_object();
$tax_meta = get_fields($current_taxonomy_object);
$related_interest = $tax_meta['related_interest'];
// nspre($tax_meta);

$banner_style = '';
$page_banner = get_field( 'banner_image', $parent_page_id);
if (!empty( $tax_meta['part_full_image'] )) {
  $banner_style = "background-image: url('".$tax_meta['part_full_image']['url'] ."')";
}

?>

<div class="row">

    <div class="large-12 columns">
        <?php get_sidebar(); ?>
        <br>

        <div class="large-10 columns header-column">
        	<div id="primary" class="content-area">
        		<main id="main" class="site-main" role="main">

                    <div class="large-12 columns header-column">
                      <div style="<?php echo $banner_style; ?>" class="inner-page-header">
                        <h1><?php echo apply_filters('the_title', $current_taxonomy_object->name ); ?></h1>
                        <hr>
                      </div>
                    </div>

                    <div class="row">

                        <div class="large-8 columns">

                            <?php echo apply_filters('the_content', $tax_meta['bodypart_details'] ); ?>

                            <?php
                            // find provider pool
                            $args = array(
                                'post_type' => POST_TYPE_DOCTOR,
                                'posts_per_page' => 6,
                                'tax_query' => array(
                                        array(
                                            'taxonomy' => TAX_TYPE_DOC_INTEREST,
                                            'field'    => 'id',
                                            'terms'    => array($related_interest),
                                        ),
                                    ),
                                );
                            $pools = get_posts($args);

                             ?>
                             <?php if (!empty($pools)): ?>

                                <ul>
                                <?php foreach ($pools as $key => $provider): ?>
                                    <?php
                                        $provider_meta = get_fields($provider->ID);
                                    ?>
                                    <li>
                                        <a href="<?php echo get_permalink($provider->ID ); ?>">
                                        <?php if (!empty($provider_meta['dr_image'])): ?>
                                            <img src="<?php echo $provider_meta['dr_image']['url']; ?>" alt="<?php echo esc_attr($provider->post_title); ?>" />
                                        <?php endif ?>
                                            <?php echo $provider->post_title; ?>
                                            <?php if (!empty($provider_meta['dr_specialty'])): ?>
                                                <?php echo ', '.$provider_meta['dr_specialty'] ?>

                                            <?php endif ?>
                                        </a>
                                    </li>
                                <?php endforeach ?>
                                </ul>
                                <?php
                                    $find_a_doctor_page = wen_get_option('cp_find_a_doctor');
                                 ?>
                                 <?php if (!empty($find_a_doctor_page)): ?>
                                    <p><a href="<?php echo get_permalink($find_a_doctor_page); ?>">More Experts</a></p>

                                 <?php endif ?>


                             <?php endif ?>



                        </div><!-- .large-8 -->

                        <div class="large-4 columns">
                        <?php
                            $related_conditions = $tax_meta['related_conditions'];
                         ?>

                         <?php if (!empty($related_conditions)): ?>

                            <h4>Related Services and Conditions</h4>

                            <ul>
                            <?php foreach ($related_conditions as $key => $cond): ?>
                                <li>
                                    <a href="<?php echo get_permalink($cond['condition_item']->ID );?>">
                                    <?php echo esc_attr($cond['condition_item']->post_title ); ?>
                                    </a>
                                </li>
                            <?php endforeach ?>
                            </ul>

                         <?php endif ?>


                        </div><!-- .large-4 -->
                    </div><!-- .row -->


        		</main><!-- #main -->
        	</div><!-- #primary -->
    	</div>
	</div>

</div>


<?php get_sidebar(); ?>
<?php get_footer(); ?>
