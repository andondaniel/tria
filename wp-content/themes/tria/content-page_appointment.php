<?php
$meta = get_fields();
 ?>
<?php
$drid = get_query_var('drid');
$args = array(
  'post_type' => 'doctor',
  'orderby'   => 'title',
  'order'     => 'ASC',
  );

$all_doctors = get_posts($args);
// nspre($all_doctors,'d');
$options_html = '';
if (!empty($all_doctors)) {
  foreach ($all_doctors as $key => $doc) {
    $options_html .= '<option value="'.esc_attr( $doc->post_title ).'"';
    if ($doc->ID == $drid) {
      $options_html .= ' selected="selected" ';
    }
    $options_html .= '>'.esc_attr($doc->post_title).'</option>';
  }
  ?>
  <script>
  var options_html = '<?php echo $options_html; ?>';
  </script>
  <?php
}

 ?>
<?php

if (!empty($drid) && intval($drid) > 0) {
  // nspre($drid,'drid');
  $dr_post = get_post($drid);
  // nspre($dr_post);
  $doctor_name = $dr_post->post_title;
}

?>
<script>
  jQuery(document).ready(function($){

    jQuery('select[name=doctor-name]').append(options_html);

    // alert('<?php echo $drid; ?>');

  });
  </script>
<div class="large-10 columns">
  <?php the_content(); ?>
</div>

