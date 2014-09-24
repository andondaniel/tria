<?php
// Template Name: Home
get_header();
?>

<?php get_template_part('pagepart/slider', 'home'); ?>


<div class="full-width-row row">
    <div class="large-12 columns pull-slight nopad">
        <ul class="tabs" data-tab>
            <li class="tab-title active"><a href="#panel2-1">Make an Appointment</a></li>
            <li class="tab-title"><a href="#panel2-2">Our Services</a>
            </li>
        </ul>
        <div class="tabs-content">
            <div class="content active pull-up" id="panel2-1">
                <div class="large-3 columns contact-panel">
                    <?php $contact_page = (wen_get_option('cp_contact') ? get_post(wen_get_option('cp_contact')) : null); // get contact page ?>
                    <?php $directions_page = (wen_get_option('cp_directions') ? get_post(wen_get_option('cp_directions')) : null); // get directions page ?>
                    <h3><?php echo ($contact_page ? $contact_page->post_title : 'Contact'); ?></h3>
                    <p class="contact-number">
                        <?php echo wen_get_option('contact_phone_number'); ?>
                    </p>
                    <p class="twentypx">
                        <?php echo wen_get_option('contact_phone_number'); ?>
                        <?php echo wen_get_option('contact_location_details'); ?>
                    </p>
                    <br>
                    <?php if($contact_page) { ?>
                    <a href="<?php echo get_permalink($contact_page); ?>" class="button small">Hours</a>
                    <?php } ?>
                    <?php if($directions_page) { ?>
                    <a href="<?php echo get_permalink($directions_page); ?>" class="alt-button">Directions</a>
                    <?php } ?>
                </div>
                <div class="large-9 columns find-a-doctor-panel">
                    <?php $finddoctor_page = (wen_get_option('cp_find_a_doctor') ? get_post(wen_get_option('cp_find_a_doctor')) : null); // get find a doctor page ?>
                    <?php $fa_tagline = ($finddoctor_page ? get_field('tag_line', $finddoctor_page->ID) : null); ?>
                    <div class="large-4 findadrsmall displayinline">
                        <h3><?php echo ($finddoctor_page ? $finddoctor_page->post_title : 'Find a Doctor'); ?></h3>
                        <?php if($fa_tagline) { ?>
                        <p><?php echo $fa_tagline; ?></p>
                        <a href="<?php echo get_permalink($finddoctor_page); ?>" class="alt-button">Find a Doctor</a>
                        <?php } ?>
                    </div>
                    <div class="large-7 displayinline drslidewrap">
                        <?php

                        //  Get Featured Doctors
                        $fDoctors = get_posts(array(
                            'post_type' => POST_TYPE_DOCTOR,
                            'meta_key' => 'feature_doctor_on_homepage',
                            'meta_value' => '1',
                            'nopaging' => true
                        ));

                        //  Check
                        if(sizeof($fDoctors) > 0) {

                            //  Get Global
                            global $post;
                        ?>
                        <div class="slider2 multiple-items">
                            <?php foreach($fDoctors as $fDoctor) { $post = $fDoctor; setup_postdata($fDoctor); ?>
                            <div class="slidestyle2 slide2-1">
                                <a class="dr-hover" href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail(); ?>
                                    <span class="view-profile">View Profile</span></a>
                                <span class="dr-name"><?php the_title(); ?></span>
                                <span class="dr-title"><?php echo get_field('dr_specialty'); ?></span>
                            </div>
                            <?php } ?>
                        </div>
                        <?php }

                            //  Reset Postdata
                            wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
            <div class="content pull-up" id="panel2-2">
                <div class="large-4 columns services-panel">
                    <h3>Services</h3>
                    <hr>
                    <?php
                      $custom_query_args = array(
                        'post_type' => 'service',
                        'posts_per_page' => 6,
                        'tax_query' => array(
                            array(
                              'taxonomy' => 'service_type',
                              'field'    => 'slug',
                              'terms'    => 'tria-service',
                            ),
                          ),
                        );

                      $custom_query = new WP_Query( $custom_query_args );
                     ?>
                     <?php if ( $custom_query->have_posts() ) : ?>

                        <ul>

                       <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

                         <li>
                             <a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a>
                         </li>


                       <?php endwhile; ?>
                       </ul>

                     <?php endif; ?>

                     <?php
                     // Reset postdata
                     wp_reset_postdata();
                     ?>

                </div>
                <div class="large-4 columns services-panel"> <h3>Unique Programs at Tria</h3>
                    <hr>
                    <?php
                      $custom_query_args = array(
                        'post_type' => 'service',
                        'posts_per_page' => 6,
                        'tax_query' => array(
                            array(
                              'taxonomy' => 'service_type',
                              'field'    => 'slug',
                              'terms'    => 'tria-unique-program',
                            ),
                          ),
                        );

                      $custom_query = new WP_Query( $custom_query_args );
                     ?>
                     <?php if ( $custom_query->have_posts() ) : ?>

                        <ul>

                       <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

                         <li>
                             <a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a>
                         </li>


                       <?php endwhile; ?>
                       </ul>

                     <?php endif; ?>

                     <?php
                     // Reset postdata
                     wp_reset_postdata();
                     ?>

                    </div>
                <div class="large-4 columns services-panel">
                  <?php $acute_injury_clinic_page = wen_get_option('cp_acute_injury_clinic'); ?>


                  <?php if (!empty($acute_injury_clinic_page)): ?>

                    <?php
                      $clinic_post = get_post($acute_injury_clinic_page);
                      $clinic_thumbnail = get_the_post_thumbnail($acute_injury_clinic_page, 'full');
                     ?>
                    <h3>Visit Clinic</h3>
                    <hr>
                    <?php echo $clinic_thumbnail; ?>
                    <a class="button fullwidthbutton" href="<?php echo get_permalink($acute_injury_clinic_page); ?>" >Acute Injury Clinic</a>

                  <?php endif ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php echo wen_tile_row_generator(); ?>

<?php get_footer(); ?>
