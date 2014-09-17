<style>
  .sitemap-left .widget-title, .sitemap-right .widget-title{
    font-size: 1.15em;
    color: #FFF;
    font-family: "Open Sans", Arial;
    margin-left: 17px;
  }

</style>
<div class="light-foot show-for-large-up">

   <div class="row">
    <div class="large-12 columns">
       <div class="large-6 columns footcolumn">
        <h4>Sitemap</h4>
       </div>
        <div class="large-3 columns grey-border-left footcolumn">
          <h4>Connect</h4>
        </div>
         <div class="large-3 columns grey-border-left footcolumn">
          <h4>Find Us</h4>
        </div>
      </div>
  </div>
</div>


<div class="mid-foot">
  <div class="row">
    <div class="large-12 columns">
          <div class="large-3 columns footcolumn sitemap">

            <h4 class="show-for-small">Sitemap</h4>

            <h4 class="">Sitemap Links</h4>

            <div class="sitemap-left">
              <?php
                dynamic_sidebar('sidebar-sitemap-left');
               ?>
            </div>

          </div>


          <div class="large-3 columns footcolumn sitemap">
          <div class="sitemap-right">
            <?php
              dynamic_sidebar('sidebar-sitemap-right');
             ?>
           </div>

          </div>
          <div class="large-3 columns grey-border-left footcolumn mid-foot-column">

            <h4 class="show-for-small">Connect With Us</h4>
                <div class="schedule-foot">
                  Schedule an appointment:
                </div>
                <div class="phone-foot">
                  <?php echo wen_get_option('contact_phone_number'); ?>
                  <br />
                  Email: <a href="mailto:<?php echo wen_get_option('contact_email'); ?>"><?php echo wen_get_option('contact_email'); ?></a>
                </div>

                <?php
                    //  Social Links
                    $social_links = wen_get_option('social_links')
                ?>
                <hr>
                <ul class="footer-social">
                <?php foreach($social_links as $social_link) { ?>
                    <a href="<?php echo $social_link['social_link']; ?>">
                        <li class="<?php echo $social_link['social_class'] . (strpos($social_link['social_class'], 'social') > -1 ? '' : ' icons'); ?>">
                            <?php echo $social_link['title']; ?>
                        </li>
                    </a>
                <?php } ?>
                </ul>
          </div>
          <div class="large-3 columns grey-border-left mid-foot-column">
              <h4 class="show-for-small">Find Us</h4>
              <p class="address"><?php echo wen_get_option('contact_location_details'); ?></p>
              <?php if(($map_url = wen_get_option('contact_location_map')) != '') { ?>
              <img class="footer-map" src="<?php echo $map_url; ?>" />
              <?php } ?>
              <?php $directions_page = (wen_get_option('cp_directions') ? get_post(wen_get_option('cp_directions')) : null); // get directions page ?>
              <?php if($directions_page) { ?>
              <a class="large button expand" href="<?php echo get_permalink($directions_page); ?>">
                  Get Directions
              </a>
              <?php } ?>
          </div>
    </div>
  </div>
</div>
