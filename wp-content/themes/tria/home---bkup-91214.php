<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tria
 */

get_header();
// global $wp_query;
// nspre($wp_query->query_vars,'q');
?>
<style>
  .btn-selected{
    background-color: #EEEEEE;
  }
  .grid-view-wrap .post{
    width:30%;
  }

  #blog-search-form-wrap{
    display: none;
  }


</style>

<script>
  jQuery(document).ready(function($){
    $('#btn-blog-search-button').on('click',function(e){
      e.preventDefault();
      $('#blog-search-form-wrap').fadeToggle('slow');

    });
  });
</script>
<div class="row">

    <div class="large-12 columns">
        <?php get_sidebar(); ?>
        <br>

        <?php
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'meta_key'       => '_is_ns_featured_post',
                'meta_value'     => 'yes',
                'order'          => 'asc',
                'orderby'        => 'menu_order',
                );
            $featured_posts = get_posts( $args );
            // nspre($featured_posts,'f');
         ?>
         <?php if (!empty($featured_posts)): ?>
        <div class="large-6 columns header-column">


                <?php
                    $feat_image = wp_get_attachment_image_src( get_post_thumbnail_id($featured_posts[0]->ID) ,'full' );
                    // nspre($feat_image);
                    $image_url = '';
                    $style_text = '';
                    if (!empty($feat_image)) {
                        $image_url = $feat_image[0];
                        $style_text = "background-image:url('".$image_url."')";
                    }
                    $post_title = $featured_posts[0]->post_title;
                    $post_url = get_permalink( $featured_posts[0]->ID );
                ?>


          <div style="<?php echo $style_text; ?>" class="blogtop1">
            <div class="blogoverlay">
              <h1><a href="<?php echo esc_url($post_url); ?>" title="<?php echo esc_attr($post_title); ?>"><?php echo wen_the_content( $post_title, 2, true ); ?></a></h1>
            </div>
          </div>
        </div>

        <div class="large-4 columns header-column">
            <?php if (count($featured_posts) > 1): ?>
                <?php
                $remaining_posts = $featured_posts;
                array_shift($remaining_posts);
                 ?>

                 <?php $cnt = 2; ?>
                 <?php foreach ($remaining_posts  as $key => $rem): ?>


                    <?php
                        $feat_image = wp_get_attachment_image_src( get_post_thumbnail_id( $rem->ID ) ,'full' );
                        $image_url = '';
                        $style_text = '';
                        if (!empty($feat_image)) {
                            $image_url = $feat_image[0];
                            $style_text = "background-image:url('".$image_url."')";
                        }
                        $post_title = $rem->post_title;
                        $post_url = get_permalink( $rem->ID );
                    ?>


                  <div style="<?php echo $style_text; ?>" class="blogtop<?php echo $cnt; ?>">
                    <div class="blogoverlay">
                      <h1><a href="<?php echo esc_url($post_url); ?>" title="<?php echo esc_attr($post_title); ?>"><?php echo wen_the_content( $post_title, 2, true ); ?></a></h1>
                    </div>
                  </div>

                  <?php $cnt++; ?>

                 <?php endforeach ?>


            <?php endif ?>
        </div>
        <?php endif; ?>

        <div class="large-10 columns">
          <nav class="post-nav">
            <ul class="">
              <li>
                <b>Sort by</b>



              </li>
              <li>
              <?php
              $qargs = array(
                'blog_order'=>'date',
                );
              $blog_dir = get_query_var('blog_dir');
              if (empty($blog_dir)) {
                $qargs['blog_dir'] = 'asc';
              }
              else{
                 $qargs['blog_dir'] = ( 'asc' == $blog_dir ) ? 'desc' : 'asc' ;
              }
               ?>
                <a href="<?php echo add_query_arg( $qargs ); ?>">Date</a>
              </li>
              <li><a href="javascript:void(0)" id="btn-blog-search-button">Search</a>
                <div id="blog-search-form-wrap">
                  <?php get_search_form( true ); ?>
                </div><!-- .blog-search-form-wrap -->
              </li>
            </ul>
            <div class="layout-buttons-wrap">
              <a href="#" class="btn-view-change btn-list" data-view="list-view">List View</a>
              <a href="#" class="btn-view-change btn-grid" data-view="grid-view">Grid View</a>
            </div>

          </nav>
        </div>



        <div class="large-10 columns header-column">
        	<div id="primary" class="content-area">
        		<main id="main" class="site-main" role="main">

            <div id="blog-content-wrap">

          		<?php if ( have_posts() ) : ?>

          			<?php /* Start the Loop */ ?>
          			<?php while ( have_posts() ) : the_post(); ?>

          				<?php
          					/* Include the Post-Format-specific template for the content.
          					 * If you want to override this in a child theme, then include a file
          					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
          					 */
          					get_template_part( 'content', 'post' );
          				?>

          			<?php endwhile; ?>

          			<div class="clear" style="text-align:center; height:70px; overflow:hidden; padding-top:20px;">
                  <?php if (function_exists('wp_pagenavi')): ?>
                    <?php wp_pagenavi(); ?>
                  <?php else: ?>
                    <?php tria_paging_nav(); ?>
                  <?php endif ?>
                </div>
                <div class="clear"></div><!-- .clear -->

          		<?php else : ?>

          			<?php get_template_part( 'content', 'none' ); ?>

          		<?php endif; ?>

            </div><!-- .blog-content-wrap -->


        		</main><!-- #main -->
        	</div><!-- #primary -->
    	</div>
	</div>

</div>


<?php get_sidebar(); ?>
<?php get_footer(); ?>
