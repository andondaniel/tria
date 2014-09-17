<?php /* start WPide restore code */
                                    if ($_POST["restorewpnonce"] === "3c0115f1dca89705a0fd09005f29c36a11bf4b235f"){
                                        if ( file_put_contents ( "/home/bpdcom/public_html/wp/tria/wp-content/themes/tria/page.php" ,  preg_replace("#<\?php /\* start WPide(.*)end WPide restore code \*/ \?>#s", "", file_get_contents("/home/bpdcom/public_html/wp/tria/wp-content/plugins/wpide/backups/themes/tria/page_2014-08-13-04.php") )  ) ){
                                            echo "Your file has been restored, overwritting the recently edited file! \n\n The active editor still contains the broken or unwanted code. If you no longer need that content then close the tab and start fresh with the restored file.";
                                        }
                                    }else{
                                        echo "-1";
                                    }
                                    die();
                            /* end WPide restore code */ ?><?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Tria
 */

get_header(); ?>

  <div class="row">
    <div class="large-12 columns">

      <?php get_sidebar(); ?>


      <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'content', 'page' ); ?>

      <?php endwhile; // end of the loop. ?>



    </div>
  </div> <!-- .row -->


<?php get_footer(); ?>
