<?php
$meta = get_fields();
 ?>
        <div class="large-10 columns contact-column">
          <div class="large-12 columns nopadding margintop">
            <div class="large-4 columns first-panel"><h3>Information/Map</h3>
              <p class="twentypx">
              <?php echo wen_get_option('contact_location_details'); ?>
              </p>
              <br>
              <?php $directions_page = (wen_get_option('cp_directions') ? get_post(wen_get_option('cp_directions')) : null); // get directions page ?>
              <?php if($directions_page) { ?>
              <a class="alt-button" href="<?php echo get_permalink($directions_page); ?>">
                  Get Directions
              </a>
              <?php } ?>
              </div>

              <div class="large-4 columns second-panel">
                <h3>Tell us what you think</h3>
                <p>Share your experience, provide feedback, positive or negative,
                on the service you received.</p>
                <br>
               <?php $feedback_hours_page = wen_get_option('cp_feedback'); ?>
                 <?php if (!empty($feedback_hours_page)): ?>
	                 <a class="alt-button" href="<?php echo esc_url(get_permalink($feedback_hours_page)); ?>">Feedback</a>
                 <?php endif ?>

              </div>
              <div class="large-4 columns third-panel"><h3>Schedule an appointment</h3>
                <p class="twentypx">
                To make an appointment, call <?php echo wen_get_option('contact_phone_number'); ?> Monday - Friday 8 A.M. - 5 P.M.
                </p>
                <br>
               <?php $schedule_appointment_page = wen_get_option('cp_schedule_appointment'); ?>
                 <?php if (!empty($schedule_appointment_page)): ?>
	                 <a class="alt-button" href="<?php echo esc_url(get_permalink($schedule_appointment_page)); ?>">Schedule</a>
                 <?php endif ?>

              </div>
              <div class="large-6 columns thirtypadfull">
                <h3><?php the_title(); ?></h3>

                <p>Phone: <?php echo wen_get_option('contact_phone_number'); ?><br>
                    Email: <?php echo wen_get_option('contact_email'); ?><br>
                    Primary Fax: <?php echo wen_get_option('contact_fax_number'); ?>
                </p>

                <?php the_content(); ?>

              </div>
              <div class="large-6 columns thirtypadfull">
                <h3 class="inner-page-welcome">Hours</h3>
                <?php
	                echo apply_filters('the_content',$meta['contact_hours']);
                 ?>
                 <?php $holiday_hours_page = wen_get_option('cp_holiday_hours'); ?>
                 <?php if (!empty($holiday_hours_page)): ?>
	                 <p><a class="alt-button-2" href="<?php echo esc_url(get_permalink($holiday_hours_page)); ?>">Holiday Hours 2014</a></p>
                 <?php endif ?>
              </div>
              <div class="clear"></div>
              <div class="large-12 container">
                <div class="map-container google-maps">

	                <?php echo wen_get_option('contact_google_map_code'); ?>

                </div>
                <div class="beneath-maps">
                  <div class="large-6 columns">
                    <h3>Tria Orthopaedic Center</h3>
                    <a class="button">See facility and services</a>
                  </div>
                  <div class="large-6 columns">
                    <h3>Tria Physical Therapy Education Center</h3>
                    <a class="button">See facility and services</a>
                  </div>
                </div>

                <?php echo wen_tile_row_generator(null, 4, 'small-columns', false); ?>


              </div>

            </div>
          </div>
        </div>

