<?php
/**
 * @package Tria
 */
?>
<?php
	$post_meta = get_fields();
	// nspre($post_meta,'meta');
 ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('large-12 columns'); ?> >
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
		<br>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<p><strong>Posted Date: </strong><?php echo date('F jS, Y', strtotime($post_meta['job_date_posted'])); ?></p>
		<p><strong>Expire Date: </strong><?php echo date('F jS, Y', strtotime($post_meta['job_date_expired'])); ?></p>
		<p><strong>Department: </strong>
		<?php
		  $term_list = wp_get_post_terms(get_the_ID(), TAX_TYPE_CAREER_DEPARTMENT, array("fields" => "names"));
		  if (!empty($term_list)) {
		    foreach ($term_list as $key => $term) {
		      echo $term.' ';
		    }
		  }
		 ?>

		</p>
		<p><strong>Job Number: </strong><?php echo $post_meta['job_number']; ?></p>
		<p><strong>Status: </strong><?php echo $post_meta['job_status']; ?></p>
		<p><strong>Work Schedule: </strong><?php echo $post_meta['job_work_schedule']; ?></p>
		<p><strong>Site: </strong><?php echo $post_meta['job_site']; ?></p>
		<p><strong>Hours/Pay Period: </strong><?php echo $post_meta['job_hours_pay_period']; ?></p>
		<p><strong>City: </strong><?php echo $post_meta['job_city']; ?></p>
		<p><strong>Benefit Eligible: </strong><?php echo $post_meta['job_benefit_eligible']; ?></p>

		<p>&nbsp;</p>

		<p><strong>Job Description:</strong></p>
		<?php
			echo apply_filters('the_content', $post_meta['job_description'] );
		?>
		<p><strong>Additional Comments/Requirements:</strong></p>
		<?php
			echo apply_filters('the_content', $post_meta['job_additional_comments'] );
		?>

		<p>&nbsp;</p>

		<p><strong>Union Name: </strong><?php echo $post_meta['job_union_name']; ?></p>
		<p><strong>Job Code: </strong><?php echo $post_meta['job_code']; ?></p>
		<?php if (!empty($post_meta['job_url'])): ?>
			<p><strong>Job URL: </strong><a href="<?php echo esc_url($post_meta['job_url']); ?>" target="_blank"><?php echo $post_meta['job_url']; ?></a></p>
		<?php endif ?>

	</div><!-- .entry-content -->


</article><!-- #post-## -->
<div class="clear"></div>
