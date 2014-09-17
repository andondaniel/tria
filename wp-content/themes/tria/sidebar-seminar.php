<?php

//  Current Seminar
$current_seminar = wen_get_current_event();

?>
<?php $map_url  = get_field( 'map_url', $current_seminar->ID ); ?>
<?php if (!empty($map_url)): ?>
    <div style="margin-bottom:10px;"><?php echo $map_url; ?></div>
<?php endif ?>

<?php
//  Print the Current Seminar Block
wen_print_current_event($current_seminar);


//  Get Upcoming Seminars
$upcoming_seminars = wen_get_upcoming_events($current_seminar);

//  Print the Upcoming Seminars Block
wen_print_upcoming_events($upcoming_seminars);

//  Get Past Seminars
$past_seminars = wen_get_past_events($current_seminar);

//  Print the Past Seminars Block
wen_print_past_events($past_seminars);

//  Display Newsletter Form
wen_newsletter_form();
