<?php
// $meta = get_fields();

 ?>
        <div class="large-10 columns">
          <div class="large-12 columns nopadding margintop">

              <div class="large-12 container">
               <h2>OSM Conference Registration</h2>

               <?php
               $osmar = get_query_var('osmr');
               $iframe_url_encoded = substr($osmr, 4);
               $iframe_url = base64_decode($iframe_url_encoded);

               // nspre($iframe_url_encoded,'iframe_url_encoded');
               // nspre($iframe_url,'iframe_url');
               // nspre($_REQUEST,'request');
                ?>

                <?php if (!empty($iframe_url)): ?>
                  <iframe src="<?php echo esc_url($iframe_url); ?>" frameborder="1" width="800" height="600"></iframe>
                <?php endif ?>


              </div>
              <div class="clear"></div>

            </div>
          </div>
        </div>

