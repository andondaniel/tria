
<?php get_template_part( 'pagepart/footer', 'widgets' ); ?>


<div class="dark-foot">
  <footer class="row">
    <div class="large-12 columns footcolumn">
      <div class="row">
        <div class="large-2 columns">
          <?php
          $footer_logo = wen_get_option('footer_logo');
          if (!empty($footer_logo)) {
            echo '<img src="'.$footer_logo.'" />';
          }
           ?>
        </div>
        <div class="large-10 columns">
                  <div class="large-12 columns">
          <?php
             $args = array(
               'container' => false,
               'menu_class' => 'inline-list right',
               'theme_location' => 'footer',
               'fallback_cb' => false,
               );
             wp_nav_menu( $args );
           ?>
        </div>
	<div class="large-12 columns">
            <p><?php echo wen_get_option( 'copyright_text', '&copy 2014 Tria Orthopaedic Center - 952-831-8742 - Minneapolis, MN. All 		Rights Reserved.' ); ?></p>
          </div>

      </div>
    </div>
    </div>
  </footer>
</div>
<?php wp_footer(); ?>
<script>

  jQuery(document).foundation();
  jQuery(document).foundation('joyride', 'start');

</script>
<script src="<?php echo get_template_directory(); ?>/js/rem.js" type="text/javascript"></script>
</body>
</html>
