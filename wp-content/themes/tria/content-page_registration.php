<div class="large-10 columns" style="margin-top:20px;">

    <?php
    $formid = get_query_var('formid');
    if (!empty($formid) && intval($formid) > 0) {
    // nspre($formid,'id');
      $shortcode_text = '[contact-form-7 id="'.$formid.'"]';
      echo do_shortcode( $shortcode_text );
    }
    ?>


</div>
