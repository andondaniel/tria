<div class="large-10 columns">
  <?php
    $pargs = array(
      'orderby'      => 'name',
      'order'        => 'ASC',
      'hierarchical' => 0,
      );
    $all_providers = get_terms(TAX_TYPE_DOC_PROVIDER_TYPE, $pargs);
    // nspre($all_providers);
   ?>

   <?php if (!empty($all_providers)): ?>

    <?php foreach ($all_providers as $key => $ptype): ?>
      <?php
        $args = array(
          'post_type'      => POST_TYPE_DOCTOR,
          'posts_per_page' => -1,
          'order'          => 'ASC',
          'orderby'        => 'meta_value',
          'meta_key'       => 'dr_last_name',
          'tax_query' => array(
              array(
                'taxonomy' => TAX_TYPE_DOC_PROVIDER_TYPE,
                'field'    => 'id',
                'terms'    => array($ptype->term_id),
              ),
            ),
          );
       ?>
       <?php $providers_arr = get_posts( $args ); ?>

       <?php if (!empty($providers_arr)): ?>
         <div class="providers-wrap">
          <h3><?php echo $ptype->name; ?></h3>
           <ul class="provider-list">
             <?php foreach ($providers_arr as $key => $provider): ?>

               <li>
                <?php
                  $provider_name = $provider->post_title;
                  $dr_specialty = get_field('dr_specialty',$provider->ID);
                  if (!empty($dr_specialty)) {
                    $provider_name .= ', '.$dr_specialty;
                  }
                 ?>
                 <a href="<?php echo get_permalink($provider->ID ); ?>">
                   <?php echo $provider_name; ?>
                 </a>
               </li>

             <?php endforeach ?>
           </ul>
         </div><!-- .providers-wrap -->
       <?php endif ?>

    <?php endforeach ?>

   <?php endif ?>

</div>

