<style>
  .hide-me{
    display: none;
  }
</style>
  <?php
  $meta = get_fields();
  // nspre($meta);
  $seletion_tools = get_post_meta(get_the_ID(),'_selection_tools', true);
  // nspre($seletion_tools);
  $enabled_filters = array();
  if (!empty($seletion_tools)) {
    foreach ($seletion_tools['enabled'] as $key => $tool) {

      if ( 'Y' == $seletion_tools['enabled'][$key] ) {
        $enabled_filters[$seletion_tools['slug'][$key]]['label'] = $seletion_tools['label'][$key];
        $enabled_filters[$seletion_tools['slug'][$key]]['slug'] = $seletion_tools['slug'][$key];
      }

    }
  }
  // nspre($enabled_filters,'enabled_filters');

  $banner_style = '';
  if (!empty($meta['banner_image'])) {
    $banner_style = "background-image: url('".$meta['banner_image']['url'] ."')";
  }
   ?>
  <div class="large-10 columns header-column">
          <div style="<?php echo $banner_style; ?>" class="inner-page-header">
            <h1><?php the_title(); ?></h1>
            <hr>
          </div>
          <div class="large-12 columns">
            <div class="large-7 columns">
              <div class="finddr-block">
              <?php
              $find_a_doctor_page = wen_get_option('cp_find_a_doctor');
               ?>
                <form action="<?php echo get_permalink($find_a_doctor_page ); ?>" method="GET">

                <?php if ( array_key_exists( 'name', $enabled_filters ) ): ?>
                  <label for="name">Name:</label>
                  <input type="text" id="pname" name="pname" value="<?php echo (isset($_REQUEST['pname'])) ? urldecode($_REQUEST['pname']) : '' ; ?>" /> <br>
                <?php endif ?>

                <?php if ( array_key_exists( 'interest', $enabled_filters ) ): ?>
                  <label for="interest">Interest:</label>
                  <div class="styled-select">
                    <?php
                      $args = array(
                        'taxonomy'        => 'doc_interest',
                        'id'              => 'interest',
                        'hide_empty'      => 0,
                        'depth'           => 1,
                        'name'            => 'interest',
                        'show_option_all' => 'All',
                        'hierarchical'    => 1,
                        );
                      if (isset($_REQUEST['interest']) && intval($_REQUEST['interest']) > 0) {
                        $args['selected'] = intval($_REQUEST['interest']);
                      }

                      wp_dropdown_categories($args);
                     ?>
                  </div>
                <?php endif ?>

                <?php if ( array_key_exists( 'provider_type', $enabled_filters ) ): ?>
                  <label for="name">Provider Type:</label>
                  <div class="styled-select">
                    <?php
                      $args = array(
                        'taxonomy'        => 'doc_ptype',
                        'id'              => 'provider_type',
                        'hide_empty'      => 0,
                        'depth'           => 1,
                        'name'            => 'provider',
                        'show_option_all' => 'All',
                        'hierarchical'    => 1,
                        );
                      if (isset($_REQUEST['provider']) && intval($_REQUEST['provider']) > 0) {
                        $args['selected'] = intval($_REQUEST['provider']);
                      }
                      wp_dropdown_categories($args);
                     ?>
                  </div>
                <?php endif ?>
                <?php if ( array_key_exists( 'location', $enabled_filters ) ): ?>
                  <label for="name">Location:</label>
                  <div class="styled-select">
                    <?php
                      $args = array(
                        'taxonomy'   => 'doc_location',
                        'id'         => 'provider_type',
                        'hide_empty' => 0,
                        'depth'      => 1,

                        );

                      wp_dropdown_categories($args);
                     ?>
                  </div>
                <?php endif ?>

                <?php foreach ($enabled_filters as $key => $filter): ?>

                  <?php
                  $def_array = array(
                      'name',
                      'interest',
                      'provider_type',
                      'location',
                  );
                  if (in_array($key,$def_array)) {
                    continue;
                  }
                   ?>
                   <label for="name"><?php echo $filter['label'] ?>:</label>
                   <div class="styled-select">
                     <?php
                       $args = array(
                         'taxonomy'        => 'df_'.$key,
                         'id'              => '',
                         'hide_empty'      => 0,
                         'depth'           => 1,
                         'name'            => 'filter_'.$key,
                         'show_option_all' => 'All',
                         'hierarchical'    => 1,
                         );
                       if (isset($_REQUEST['filter_'.$key]) && intval($_REQUEST['filter_'.$key]) > 0) {
                         $args['selected'] = intval($_REQUEST['filter_'.$key]);
                       }
                       wp_dropdown_categories($args);
                      ?>
                   </div>



                <?php endforeach ?>

                <br>
                <input type="submit" value="Search" class="right">

                </form>

              </div> <!-- .finddr-block -->

              <?php
              $cp_all_providers = wen_get_option('cp_all_providers');
               ?>
               <?php if (!empty($cp_all_providers)): ?>

                <p>
                  <a href="<?php echo esc_url(get_permalink($cp_all_providers)); ?>">View All Providers</a>
                </p>
               <?php endif ?>

            </div> <!-- .large-7 columns -->

            <div class="large-5 columns thirtypadfull">
              <h2 class="inner-page-welcome">Meet our dedicated staff</h2>
                <?php the_content(); ?>
            </div> <!-- large-5 columns thirtypadfull -->

          </div> <!-- large-12 columns -->



        <?php
          $custom_query_args = array(
            'post_type'      => POST_TYPE_DOCTOR,
            'posts_per_page' => wen_get_option('provider_per_page',2),
            'orderby'        => 'meta_value title',
            'order'          => 'asc',
            'meta_key'       => 'dr_last_name',

            );
          // $custom_query_args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
          // nspre($_REQUEST['dr_name'],'name');
          if (isset($_REQUEST['pname']) && !empty($_REQUEST['pname'])) {
            $custom_query_args['s'] = urldecode($_REQUEST['pname']);
          }

          $custom_filters_params = array();

          foreach ($_REQUEST as $rkey => $req) {
            // nspre($rkey);
            $ps = strpos( $rkey, 'filter_');
            if ( false !== $ps ) {
              $fkey = str_replace('filter_', '', $rkey);
              if ($req > 0) {
                $custom_filters_params[$fkey]= $req;
              }
            }
          }

          // nspre($custom_filters_params);


          if (
              ( isset($_REQUEST['interest']) && intval($_REQUEST['interest']) > 0 ) ||
              ( isset($_REQUEST['provider']) && intval($_REQUEST['provider']) > 0 ) ||
              ( !empty($custom_filters_params) )
            ) {

              // $custom_query_args['tax_query'][] = array(
              //     'relation' => 'AND',
              //   );
              if ( intval($_REQUEST['provider']) > 0 ) {
                $custom_query_args['tax_query'][] = array(
                  'taxonomy' => 'doc_ptype',
                  'field'    => 'id',
                  'terms'    => array( intval($_REQUEST['provider']) ),
                  'operator' => 'IN',
                  );
              }
              if ( intval($_REQUEST['interest']) > 0 ) {
                $custom_query_args['tax_query'][] = array(
                  'taxonomy' => 'doc_interest',
                  'field'    => 'id',
                  'terms'    => array( intval($_REQUEST['interest']) ),
                  'operator' => 'IN',
                  );
              }
              foreach ($custom_filters_params as $cfp_key => $cfp_value) {
                $custom_query_args['tax_query'][] = array(
                  'taxonomy' => 'df_'.$cfp_key,
                  'field'    => 'id',
                  'terms'    => array( intval( $cfp_value ) ),
                  'operator' => 'IN',
                  );
              }
          }

          // nspre($custom_query_args,'args');

          $custom_query = new WP_Query( $custom_query_args );
          // nspre($custom_query,'cq');
         ?>
         <?php
         // Pagination fix
         global $wp_query;
         $temp_query = $wp_query;
         $wp_query   = NULL;
         $wp_query   = $custom_query;
         ?>
         <?php if ( $custom_query->have_posts() ) : ?>

         <div id="container-providers" style="border:1px #FFFFFF solid; display:block; height:auto; overflow:hidden;">
           <!-- the loop -->
           <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

            <?php
            // $post_meta = get_fields();
             ?>

           <?php get_template_part('pagepart/fap','item'); ?>


           <?php endwhile; ?>
           <!-- end of the loop -->



           </div><!-- #container-providers -->


         <?php else: ?>
          <p><strong>Not found</strong></p>

         <?php endif; ?>


         <?php
          $data_text = '';
          $data_arr = array();
          $data_arr['data-next_page'] = 2;
          if (!empty($_GET)) {
            foreach ($_GET as $k => $g) {
              $data_arr['data-'.$k] = esc_attr($g);
            }
          }
          if (!empty($data_arr)) {
            foreach ($data_arr as $key => $d) {
              $data_text .= ' '. $key.'="'.$d.'" ';
            }
          }
          ?>
         <?php if ( $custom_query->max_num_pages > 1 ): ?>
          <p style="margin:20px;">
            <a href="#" id="btn-load-more-provider" <?php echo $data_text; ?> style="outline:none;" class="button">
              View more
            </a>
            <span id="loading-provider" style="display:none; margin-left:10px;"><img src="<?php echo get_template_directory_uri();?>/img/loading.gif" alt="Loading..." /></span>
          </p>
         <?php endif ?>

         <?php
         // Reset postdata
         wp_reset_postdata();
         ?>

         <?php
         // Reset main query object
         $wp_query = NULL;
         $wp_query = $temp_query;
         ?>

</div> <!-- large-10 columns header-column -->
