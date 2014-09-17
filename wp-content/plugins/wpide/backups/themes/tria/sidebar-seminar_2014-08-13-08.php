<?php /* start WPide restore code */
                                    if ($_POST["restorewpnonce"] === "3c0115f1dca89705a0fd09005f29c36a11bf4b235f"){
                                        if ( file_put_contents ( "/home/bpdcom/public_html/wp/tria/wp-content/themes/tria/sidebar-seminar.php" ,  preg_replace("#<\?php /\* start WPide(.*)end WPide restore code \*/ \?>#s", "", file_get_contents("/home/bpdcom/public_html/wp/tria/wp-content/plugins/wpide/backups/themes/tria/sidebar-seminar_2014-08-13-08.php") )  ) ){
                                            echo "Your file has been restored, overwritting the recently edited file! \n\n The active editor still contains the broken or unwanted code. If you no longer need that content then close the tab and start fresh with the restored file.";
                                        }
                                    }else{
                                        echo "-1";
                                    }
                                    die();
                            /* end WPide restore code */ ?><?php

//  Get Current Seminar
global $current_seminar, $current_seminar_metas;

//  Check
if($current_seminar) { ?>

<div class="current-seminar-block">
    <a class="panel-link" href="#">
        <img src="<?php echo get_template_directory_uri();?>/img/smartbody-sidebar.jpg"/>
    </a>
    <div class="overlay">
        <h6>Up Next</h6>
        <p>
            <b><?php echo apply_filters('the_title', $current_seminar->post_title); ?></b><br/>
            <?php echo date('l, F jS, Y, h:i A', strtotime($current_seminar_metas['seminar_date'] . ' ' . $current_seminar_metas['time_from'])); ?>
        </p>
        <a class="featured-button button">Upcoming Seminars </a>
    </div>
</div>

<?php } ?>

<?php

//  Get Upcoming Seminars
$upcoming_seminars = get_upcoming_seminars($current_seminar);

//  Check for Upcoming Seminars
if(sizeof($upcoming_seminars) > 0) { ?>

<div class="upcoming-seminars">
    <?php foreach($upcoming_seminars as $upcoming_seminar) { ?>
    <div class="upcoming-seminar">
        <p>
            <b><?php echo apply_filters('the_title', $upcoming_seminar->post_title); ?></b>
            <?php echo date('l, F jS, Y, h:i A', strtotime(get_field('seminar_date', $upcoming_seminar->ID) . ' ' . get_field('time_from', $upcoming_seminar->ID))); ?>
        </p>
    </div>
    <?php } ?>
</div>

<?php } ?>

<a class="button fullwidthbutton pastseminars">Past Seminars</a>
<dl class="accordion" data-accordion>
  <dd class="accordion-navigation">
  <a class="grey-button" href="#panel1">2011</a>
  <div id="panel1" class="content active">
    <p><b>Core 101: A Look at Pilates and Yoga for Beginners</b>
    Tuesday, October 11, 2011, 7 P.M.</p>
    <p><b>Joint Replacement: What's New? Is it Right for Me?</b>
    Wednesday, September 14th, 2011, 7 P.M.</p>
    <p><b>Hilton Recovery Program: A Hospital Alternative</b>
    Tuesday, April 19th, 2011, 7 P.M.</p>
    <p><b>Nutritional Needs of the Athlete: Myths and Truths</b>
    Tuesday, January 27th, 2011, 7 P.M.</p>
  </div>
  </dd>
  <dd class="accordion-navigation">
  <a class="light-grey-button" href="#panel2">2012</a>
  <div id="panel2" class="content">
    <p><b>Core 101: A Look at Pilates and Yoga for Beginners</b>
    Tuesday, October 11, 2011, 7 P.M.</p>
    <p><b>Joint Replacement: What's New? Is it Right for Me?</b>
    Wednesday, September 14th, 2011, 7 P.M.</p>
    <p><b>Hilton Recovery Program: A Hospital Alternative</b>
    Tuesday, April 19th, 2011, 7 P.M.</p>
    <p><b>Nutritional Needs of the Athlete: Myths and Truths</b>
    Tuesday, January 27th, 2011, 7 P.M.</p>
  </div>
  </dd>
  <dd class="accordion-navigation">
  <a class="light-grey-button" href="#panel3">2013</a>
  <div id="panel3" class="content">
    <p><b>Core 101: A Look at Pilates and Yoga for Beginners</b>
    Tuesday, October 11, 2011, 7 P.M.</p>
    <p><b>Joint Replacement: What's New? Is it Right for Me?</b>
    Wednesday, September 14th, 2011, 7 P.M.</p>
    <p><b>Hilton Recovery Program: A Hospital Alternative</b>
    Tuesday, April 19th, 2011, 7 P.M.</p>
    <p><b>Nutritional Needs of the Athlete: Myths and Truths</b>
    Tuesday, January 27th, 2011, 7 P.M.</p>
  </div>
  </dd>
  <dd class="accordion-navigation">
  <a class="light-grey-button" href="#panel4">2014</a>
  <div id="panel4" class="content">
    <p><b>Core 101: A Look at Pilates and Yoga for Beginners</b>
    Tuesday, October 11, 2011, 7 P.M.</p>
    <p><b>Joint Replacement: What's New? Is it Right for Me?</b>
    Wednesday, September 14th, 2011, 7 P.M.</p>
    <p><b>Hilton Recovery Program: A Hospital Alternative</b>
    Tuesday, April 19th, 2011, 7 P.M.</p>
    <p><b>Nutritional Needs of the Athlete: Myths and Truths</b>
    Tuesday, January 27th, 2011, 7 P.M.</p>
  </div>
  </dd>
</dl>
<div class="mailing-subscribe">
  <h4>Mailing List</h4>
  <p>If you are interested in receiving notices regarding upcoming seminars, sign up for our mailing list:</p>
  <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Email" style="background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==); background-attachment: scroll; cursor: auto; background-position: 100% 50%; background-repeat: no-repeat no-repeat;">
  <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
</div>
