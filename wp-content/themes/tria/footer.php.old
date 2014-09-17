
<?php get_template_part( 'pagepart/footer', 'widgets' ); ?>


<div class="dark-foot">
  <footer class="row">
    <div class="large-12 columns footcolumn">
      <div class="row">
        <div class="large-2 columns">
          <?php
          $footer_logo = wen_get_option('footer_logo');
          if (!empty($footer_logo)) {
            echo '<a href="'.home_url('/').'"><img src="'.$footer_logo.'" /></a>';
          }
           ?>
        </div>
        <div class="large-10 columns">
          <div class="large-10 columns">
            <p><?php echo wen_get_option( 'copyright_text', '&copy 2014 Tria Orthopaedic' ); ?></p>
          </div>
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
</body>
</html>
