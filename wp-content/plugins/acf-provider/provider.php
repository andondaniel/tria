<?php

class acf_field_provider extends acf_field
{

	var $settings;


	function __construct()
	{
		// vars
		$this->name = 'provider';
		$this->label = __("Provider",'acf');
		$this->category = __("Relational",'acf');
		$this->defaults = array(
			'sort_by'    =>	'last_name',
			'sort_order' =>	'asc',
			'allow_null' =>	1,
		);

		// do not delete!
    	parent::__construct();


    	// settings
		$this->settings = array(
			'path' => apply_filters('acf/helpers/get_path', __FILE__),
			'dir' => apply_filters('acf/helpers/get_dir', __FILE__),
			'version' => '1.0.0'
		);

	}

	function create_options( $field )
		{
			// defaults?

			$field = array_merge($this->defaults, $field);


			// key is needed in the field names to correctly save the data
			$key = $field['name'];


			// Create Field Options HTML
			?>
	<tr class="field_option field_option_<?php echo $this->name; ?>">
		<td class="label">
			<label><?php _e("Sort By",'acf'); ?></label>
		</td>
		<td>
			<?php

			do_action('acf/create_field', array(
				'type'		=>	'radio',
				'name'		=>	'fields['.$key.'][sort_by]',
				'value'		=>	$field['sort_by'],
				'layout'	=>	'horizontal',
				'choices'	=>	array(
					'first_name' => __('First Name'),
					'last_name' => __('Last Name'),
				)
			));

			?>
		</td>
	</tr>
	<tr class="field_option field_option_<?php echo $this->name; ?>">
		<td class="label">
			<label><?php _e("Sort Order",'acf'); ?></label>
		</td>
		<td>
			<?php

			do_action('acf/create_field', array(
				'type'		=>	'radio',
				'name'		=>	'fields['.$key.'][sort_order]',
				'value'		=>	$field['sort_order'],
				'layout'	=>	'horizontal',
				'choices'	=>	array(
					'asc' => __('Ascending'),
					'desc' => __('Descending'),
				)
			));

			?>
		</td>
	</tr>
	<tr class="field_option field_option_<?php echo $this->name; ?>">
		<td class="label">
			<label><?php _e("Allow Null",'acf'); ?></label>
		</td>
		<td>
			<?php

			do_action('acf/create_field', array(
				'type'		=>	'radio',
				'name'		=>	'fields['.$key.'][allow_null]',
				'value'		=>	$field['allow_null'],
				'layout'	=>	'horizontal',
				'choices'	=>	array(
					1 => __('Yes'),
					0 => __('No'),
				)
			));

			?>
		</td>
	</tr>
			<?php

		}


		function create_field( $field )
		{
			// global
			global $post;
			// nspre($field,'f');

			// vars
			$args = array(
				'posts_per_page' => -1,
				'post_type' => 'doctor',
				'orderby' => 'meta_value',
				'post_status' => array('publish'),
				'suppress_filters' => false,
			);
			$args['order'] = $field['sort_order'];
			if ( 'first_name' == $field['sort_by'] ) {
				$args['meta_key'] = 'dr_first_name';
			}
			else if ( 'last_name' == $field['sort_by'] ) {
				$args['meta_key'] = 'dr_last_name';
			}

			// Change Field into a select
			$field['type'] = 'select';
			$field['choices'] = array();

			if ( 1 == $field['allow_null']) {
				// $field['choices']['null'] = __("Select",'acf');
			}

			$all_posts = get_posts($args);
			// nspre($args);
			if (!empty($all_posts)) {
				foreach ($all_posts as $key => $prv) {
					$field['choices'][$prv->ID] = esc_attr($prv->post_title);
				}
			}


			// create field
			do_action('acf/create_field', $field );



			// echo '<div class="acf-row">' . $field['label'] . '</div>';

		}

		function format_value_for_api( $value, $post_id, $field ){

			// no value?
			if( !$value )
			{
				return false;
			}


			// null?
			if( $value == 'null' )
			{
				return false;
			}

			$value = get_post($value);

			return $value;


		}


}

new acf_field_provider();
