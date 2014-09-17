<?php
// Template Name: Tuesday Conference Page
get_header();
?>
<div class="row">

    <?php while (have_posts()) : the_post(); ?>

        <?php get_template_part('content', 'page_tconf'); ?>

    <?php endwhile; ?>

</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
