<?php
$page_meta = get_fields();
$banner_style = '';
if (!empty($page_meta['banner_image'])) {
  $banner_style = "background-image: url('".$page_meta['banner_image']['url'] ."')";
}
$args = array(
  'post_type' => 'osm-conf',
  'posts_per_page' => 1,
  'meta_query' => array(
      array(
        'key' => 'oc_set_as_current_conference',
        'value'    => '1',
      ),
    ),
  );
$post_arr = get_posts($args);
 ?>

<?php if (!empty($post_arr)): ?>

  <?php
    $current_post = $post_arr[0];
    $post_meta = get_fields($current_post->ID);

  ?>


        <div class="large-12 columns header-column">
          <div style="<?php echo $banner_style; ?>" class="full-page-header">
            <h1><?php the_title(); ?></h1>
            <hr>
          </div>
        </div>
        <div class="large-12 columns">
          <ul class="tabs events-tabs" data-tab>
            <li class="tab-title active"><a href="#panel2-1">Speakers &amp; Topics</a></li>
            <li class="tab-title"><a href="#panel2-2">Continuing Education Credit</a></li>
            <li class="tab-title"><a href="#panel2-3">Registration</a></li>
            <li class="tab-title"><a href="#panel2-4">Vendors</a></li>
          </ul>
          <div class="large-9 columns">
            <div class="tabs-content events-content">
              <div class="content active" id="panel2-1">
                <div class="event-title"><h1><?php echo $current_post->post_title; ?></h1>
                  <p class="biggerbold"><?php echo $post_meta['oc_subtitle']; ?></p>
                  <p class="event-date">
                  <?php echo date('F j Y', strtotime($post_meta['oc_date_from'])); ?> - <?php echo date('F j Y', strtotime($post_meta['oc_date_to'])); ?>
                  </p>
                </div>
                <hr>
                <h3>Speakers</h3>

                <?php if (!empty($post_meta['speaker']) && is_array($post_meta['speaker']) ): ?>

                 <?php foreach ($post_meta['speaker'] as $key => $speaker): ?>

                   <?php
                     $speaker_info = wen_get_speaker_info($speaker);
                     $link_open = '';
                     $link_close = '';
                     if (!empty($speaker_info['speaker_profile_url'])) {
                       $link_open = '<a href="' . esc_url( $speaker_info['speaker_profile_url'] ) . '">';
                       $link_close = '</a>';
                     }

                    ?>

                   <div class="large-3 columns conference-speaker">
                     <?php echo $link_open; ?>
                       <img src="<?php echo esc_url( $speaker_info['speaker_gravatar'] ); ?>">
                     <?php echo $link_close; ?>

                     <b>
                        <?php echo $link_open; ?>
                        <?php echo $speaker_info['speaker_full_name']; ?>
                       <?php echo $link_close; ?>
                      </b>
                     <?php if ( !empty($speaker_info['speaker_meta']) && isset($speaker_info['speaker_meta']['dr_specialty']) ): ?>
                       <?php echo ' '.$speaker_info['speaker_meta']['dr_specialty']; ?>
                     <?php endif ?>

                     <hr>
                     <?php echo strip_tags($speaker_info['speaker_description']); ?>
                  </div>

                 <?php endforeach ?>

                <?php endif ?>

                <br>
                <h3>Agenda</h3>
                <div class="large-6 columns agenda-items">
                  <?php echo $post_meta['oc_agenda']; ?>
                </div>
                <div class="large-6 columns agenda-items">
                  &nbsp;
                </div>
                <h3>Acknowledgement of Support</h3>
                <?php echo $post_meta['oc_support']; ?>
              </div>

              <div class="content" id="panel2-2">
                <?php $oc_education_credit = $post_meta['oc_education_credit']; ?>
                <?php if (!empty($oc_education_credit)): ?>
                  <?php echo apply_filters('the_content', $oc_education_credit ); ?>
                <?php endif ?>
              </div>

              <div class="content" id="panel2-3">
                <?php $oc_registration = $post_meta['oc_registration']; ?>
                <?php if (!empty($oc_registration)): ?>
                  <?php echo apply_filters('the_content', $oc_registration ); ?>
                <?php endif ?>
              </div>
              <div class="content" id="panel2-4">
                <?php $oc_vendors = $post_meta['oc_vendors']; ?>
                <?php if (!empty($oc_vendors)): ?>
                  <?php echo apply_filters('the_content', $oc_vendors ); ?>
                <?php endif ?>
              </div>
            </div>
          </div>
          <div class="large-3 columns paddingtwenty">
            <?php
                $register_url = tria_get_registration_url( $post_meta, 'register_url' );
             ?>
            <a class="button bigbtn" href="<?php echo $register_url; ?>" >Register online</a>
            <h4>LOCATION</h4>
                <?php $oc_location = $post_meta['oc_location']; ?>
                <?php if (!empty($oc_location)): ?>
                  <?php echo apply_filters('the_content', $oc_location ); ?>
                <?php endif ?>

            <?php $map_url  = $post_meta['map_url']; ?>
            <?php if (!empty($map_url)): ?>
                <?php echo $map_url; ?>
            <?php endif ?>


            <div class="conference-mailer">
              <h4>CONFERENCE MAILER</h4>
              Includes detailed speaker &amp; schedule information (PDF)
              <?php $oc_flyer  = $post_meta['oc_flyer']; ?>
              <?php $flyer_url = (!empty($oc_flyer)) ? esc_url($oc_flyer['url']) : 'javascript:void(0);';  ?>

              <a class="button" href="<?php echo $flyer_url; ?>">Download</a>
            </div>
          </div>
        </div>

<?php endif;?>
