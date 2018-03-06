<?php 
/**
 * @package Theme Horse
 * @subpackage Clean_Retina
 * @since Clean Retina 3.0
 */
function cleanretina_textarea_register($wp_customize){
	class Cleanretina_Customize_cleanretina_upgrade extends WP_Customize_Control {
		public function render_content() { ?>
		<div class="theme-info"> 
			<a title="<?php esc_attr_e( 'Upgrade to Pro', 'cleanretina' ); ?>" href="<?php echo esc_url( 'http://themehorse.com/themes/clean-retina-pro' ); ?>" target="_blank">
			<?php _e( 'Upgrade to Pro', 'cleanretina' ); ?>
			</a>
			<a title="<?php esc_attr_e( 'Donate', 'cleanretina' ); ?>" href="<?php echo esc_url( 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=BRLCCUGP2ACYN' ); ?>" target="_blank">
			<?php _e( 'Donate', 'cleanretina' ); ?>
			</a>
			<a title="<?php esc_attr_e( 'Review Clean Retina', 'cleanretina' ); ?>" href="<?php echo esc_url( 'http://wordpress.org/support/view/theme-reviews/clean-retina' ); ?>" target="_blank">
			<?php _e( 'Rate Clean Retina', 'cleanretina' ); ?>
			</a>
			<a href="<?php echo esc_url( 'http://themehorse.com/theme-instruction/clean-retina/' ); ?>" title="<?php esc_attr_e( 'Clean Retina Theme Instructions', 'cleanretina' ); ?>" target="_blank">
			<?php _e( 'Theme Instructions', 'cleanretina' ); ?>
			</a>
			<a href="<?php echo esc_url( 'http://themehorse.com/support-forum/' ); ?>" title="<?php esc_attr_e( 'Support Forum', 'cleanretina' ); ?>" target="_blank">
			<?php _e( 'Support Forum', 'cleanretina' ); ?>
			</a>
			<a href="<?php echo esc_url( 'http://themehorse.com/preview/clean-retina/' ); ?>" title="<?php esc_attr_e( 'Clean Retina Demo', 'cleanretina' ); ?>" target="_blank">
			<?php _e( 'View Demo', 'cleanretina' ); ?>
			</a>
		</div>
		<?php
		}
	}
	class CleanRetina_Customize_CleanRetina_upgrade_to_pro extends WP_Customize_Control {
		public function render_content() { ?>
			<a href="<?php echo esc_url( 'http://themehorse.com/themes/clean-retina-pro/' ); ?>" title="<?php esc_attr_e( 'Upgrade to CleanRetina Pro', 'cleanretina' ); ?>" target="_blank">
			<?php _e( 'Upgrade to Clean Retina Pro', 'cleanretina' ); ?>
			</a><?php _e('to get more aditional features like (Advanced Slider, Color Options, Typography Options and many more.)','cleanretina');?>
		<?php
		}
	}
	class Cleanretina_Customize_Category_Control extends WP_Customize_Control {
		/**
		* The type of customize control being rendered.
		*/
		public $type = 'multiple-select';
		/**
		* Displays the multiple select on the customize screen.
		*/
		public function render_content() {
		global $options, $array_of_default_settings;
		$options = wp_parse_args(  get_option( 'cleanretina_theme_options', array() ),  cleanretina_get_option_defaults());
		$categories = get_categories(); ?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<select <?php $this->link(); ?> multiple="multiple" style="height: 100%;">
				<option value="0" <?php if ( empty( $options['front_page_category'] ) ) { selected( true, true ); } ?>><?php _e( '--Disabled--', 'cleanretina' ); ?></option>
				<?php
					foreach ( $categories as $category) :?>
						<option value="<?php echo $category->cat_ID; ?>" <?php if ( in_array( $category->cat_ID, $options['front_page_category']) ) { echo 'selected="selected"';}?>><?php echo $category->cat_name; ?></option>
					<?php endforeach; ?>
				?>
				</select>
			</label>
		<?php 
		}
	}
}

function cleanretina_customize_register($wp_customize){
	$wp_customize->add_panel( 'cleanretina_design_options_panel', array(
	'priority'       => 200,
	'capability'     => 'edit_theme_options',
	'title'          => __('Design Options', 'cleanretina')
	));

	$wp_customize->add_panel( 'cleanretina_advanced_options_panel', array(
	'priority'       => 300,
	'capability'     => 'edit_theme_options',
	'title'          => __('Advanced Options', 'cleanretina')
	));

	$wp_customize->add_panel( 'cleanretina_featured_post_page_panel', array(
	'priority'       => 400,
	'capability'     => 'edit_theme_options',
	'title'          => __('Featured Post/ Page Slider', 'cleanretina')
	));
	global $options, $array_of_default_settings;
	$options = wp_parse_args(  get_option( 'cleanretina_theme_options', array() ), cleanretina_get_option_defaults());
/********************Clean Retina Upgrade ******************************************/
	$wp_customize->add_section('cleanretina_upgrade_to_pro', array(
		'title'					=> __('What is new on Clean Retina Pro?', 'cleanretina'),
		'priority'				=> 0.5,
	));
	$wp_customize->add_setting( 'cleanretina_theme_settings[cleanretina_upgrade_to_pro]', array(
		'default'				=> false,
		'capability'			=> 'edit_theme_options',
		'sanitize_callback'	=> 'wp_filter_nohtml_kses',
	));
	$wp_customize->add_control(
		new CleanRetina_Customize_CleanRetina_upgrade_to_pro(
		$wp_customize,
		'cleanretina_upgrade_to_pro',
			array(
				'label'					=> __('Clean Retina Upgrade','cleanretina'),
				'section'				=> 'cleanretina_upgrade_to_pro',
				'settings'				=> 'cleanretina_theme_settings[cleanretina_upgrade_to_pro]',
			)
		)
	);
	$wp_customize->add_section('cleanretina_upgrade', array(
		'title'					=> __('Clean Retina Support', 'cleanretina'),
		'description'			=> __('Hey! Buy us a beer and we shall come with new features and update. ','cleanretina'),
		'priority'				=> 1,
	));
	$wp_customize->add_setting( 'cleanretina_theme_options[cleanretina_upgrade]', array(
		'default'				=> false,
		'capability'			=> 'edit_theme_options',
		'sanitize_callback'	=> 'wp_filter_nohtml_kses',
	));
	$wp_customize->add_control(
		new Cleanretina_Customize_cleanretina_upgrade(
		$wp_customize,
		'cleanretina_upgrade',
			array(
				'label'					=> __('Clean Retina Upgrade','cleanretina'),
				'section'				=> 'cleanretina_upgrade',
				'settings'				=> 'cleanretina_theme_options[cleanretina_upgrade]',
			)
		)
	);
/******************** Design Options ******************************************/
/******************** Custom Header ******************************************/
	$wp_customize->add_section('custom_header_setting', array(
		'title'					=> __('Custom Header', 'cleanretina'),
		'priority'				=> 200,
		'panel'					=>'cleanretina_design_options_panel'
	));
	$wp_customize->add_setting( 'cleanretina_theme_options[hide_header_searchform]', array(
		'default'				=> 0,
		'sanitize_callback'	=> 'prefix_sanitize_integer',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control( 'custom_header_setting', array(
		'label'					=> __('Hide Searchform from Header', 'cleanretina'),
		'section'				=> 'custom_header_setting',
		'settings'				=> 'cleanretina_theme_options[hide_header_searchform]',
		'type'					=> 'checkbox',
	));
	/********************Fav Icon ******************************************/
	$wp_customize->add_section('fav_icon_setting', array(
		'title'					=> __('Fav Icon Options', 'cleanretina'),
		'priority'				=> 210,
		'panel'					=>'cleanretina_design_options_panel',
	));
	$wp_customize->add_setting( 'cleanretina_theme_options[disable_favicon]', array(
		'default'				=> 1,
		'sanitize_callback'	=> 'prefix_sanitize_integer',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
		$wp_customize->add_control( 'fav_icon_setting', array(
		'label'					=> __('Disable Favicon', 'cleanretina'),
		'section'				=> 'fav_icon_setting',
		'settings'				=> 'cleanretina_theme_options[disable_favicon]',
		'type'					=> 'checkbox',
	));
	$wp_customize->add_setting( 'cleanretina_theme_options[favicon]',array(
		'sanitize_callback'	=> 'esc_url_raw',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
		$wp_customize,
		'favicon',
			array(
				'section'			=> 'fav_icon_setting',
				'settings'			=> 'cleanretina_theme_options[favicon]',
			)
		)
	);
	/********************Web Icon ******************************************/
	$wp_customize->add_section('webclip_icon_setting', array(
		'title'					=> __('Web Clip Icon Options', 'cleanretina'),
		'priority'				=> 220,
		'panel'					=>'cleanretina_design_options_panel'
	));
	$wp_customize->add_setting( 'cleanretina_theme_options[disable_webpageicon]', array(
		'default'				=> 1,
		'sanitize_callback'	=> 'prefix_sanitize_integer',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control( 'webclip_icon_setting', array(
		'label'					=> __('Disable Web Clip Icon', 'cleanretina'),
		'section'				=> 'webclip_icon_setting',
		'settings'				=> 'cleanretina_theme_options[disable_webpageicon]',
		'type'					=> 'checkbox',
	));
	$wp_customize->add_setting( 'cleanretina_theme_options[webpageicon]',array(
		'sanitize_callback'=> 'esc_url_raw',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
		$wp_customize,
		'webpageicon',
			array(
				'section'			=> 'webclip_icon_setting',
				'settings'			=> 'cleanretina_theme_options[webpageicon]'
			)
		)
	);
	/********************Default Layout options ******************************************/
	$wp_customize->add_section('cleanretina_default_layout', array(
		'title'					=> __('Default Layout Options', 'cleanretina'),
		'priority'				=> 230,
		'panel'					=>'cleanretina_design_options_panel'
	));
	$wp_customize->add_setting('cleanretina_theme_options[default_layout]', array(
		'default'				=> 'right-sidebar',
		'sanitize_callback'	=> 'prefix_sanitize_integer',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control('cleanretina_default_layout', array(
		'section'				=> 'cleanretina_default_layout',
		'settings'				=> 'cleanretina_theme_options[default_layout]',
		'type'					=> 'radio',
		'checked'				=> 'checked',
		'choices'				=> array(
			'no-sidebar'				=> __('No Sidebar','cleanretina'),
			'no-sidebar-full-width'	=> __('No Sidebar, Full Width','cleanretina'),
			'no-sidebar-one-column'	=> __('No Sidebar, One Column','cleanretina'),
			'left-sidebar'				=> __('Left Sidebar','cleanretina'),
			'right-sidebar'			=> __('Right Sidebar','cleanretina'),
		),
	));
	/********************Home Page Layout Options******************************************/
	$wp_customize->add_section('cleanretina_homepage_layout', array(
		'title'					=> __('Home Page Layout Options', 'cleanretina'),
		'priority'				=> 240,
		'panel'					=>'cleanretina_design_options_panel'
	));
	$wp_customize->add_setting('cleanretina_theme_options[home_page_layout]', array(
		'default'				=> 'right-sidebar',
		'sanitize_callback'	=> 'prefix_sanitize_integer',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control('cleanretina_homepage_layout', array(
		'label'					=> __('Layout Display Type on Home Page','CleanRetina'),
		'description'					=>__('To select one of these layouts, Latest Posts should be checked in Reading sub-menu of Settings menu. Go to Settings->Reading->Check on Your Latest Posts','cleanretina') .'<br><br>' . __('If you chose the corporate layout then you will have to add corporate layout content from Home Corporate Layout option under Advanced Options Tab.' ,'cleanretina'),
		'priority'				=>10,
		'section'				=> 'cleanretina_homepage_layout',
		'settings'				=> 'cleanretina_theme_options[home_page_layout]',
		'type'					=> 'radio',
		'checked'				=> 'checked',
		'choices'				=> array(
			'no-sidebar'				=> __('No Sidebar','cleanretina'),
			'no-sidebar-full-width'	=> __('No Sidebar, Full Width','cleanretina'),
			'no-sidebar-one-column'	=> __('No Sidebar, One Column','cleanretina'),
			'left-sidebar'				=> __('Left Sidebar','cleanretina'),
			'right-sidebar'			=> __('Right Sidebar','cleanretina'),
			'corporate-layout'		=> __('Corporate Layout','cleanretina'),
		),
	));

	$wp_customize->add_setting('cleanretina_theme_options[blog_display_type]', array(
		'default'				=> 'excerpt_display_one',
		'sanitize_callback'	=> 'prefix_sanitize_integer',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control('cleanretina_blogdisplay_layout', array(
		'label'					=>__('Blog Display Type on Home Page','cleanretina'),
		'priority'				=>20,
		'section'				=> 'cleanretina_homepage_layout',
		'settings'				=> 'cleanretina_theme_options[blog_display_type]',
		'type'					=> 'radio',
		'checked'				=> 'checked',
		'choices'				=> array(
			'excerpt_display_one'				=> __('Blog Image Large','cleanretina'),
			'excerpt_display_two'	=> __('Blog Image Medium','cleanretina'),
			'content_display'	=> __('Blog Full Content','cleanretina'),
		),
	));
	/********************Custom Css ******************************************/
	$wp_customize->add_section( 'cleanretina_custom_css', array(
		'title'					=> __('Custom CSS', 'cleanretina'),
		'description'			=> __('This CSS will overwrite the CSS of style.css file.','cleanretina'),
		'priority'				=> 250,
		'panel'					=>'cleanretina_design_options_panel'
	));
	$wp_customize->add_setting( 'cleanretina_theme_options[custom_css]', array(
		'default'				=> '',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options',
		'sanitize_callback'	=> 'wp_filter_nohtml_kses'
	));
	$wp_customize->add_control( 'custom_css', array(
		'section'				=> 'cleanretina_custom_css',
				'settings'				=> 'cleanretina_theme_options[custom_css]',
				'type'					=> 'textarea'
	));
	/******************** Advanced Options ******************************************/
	/******************** Home Slogan Options ******************************************/
	$wp_customize->add_section('home_slogan_options', array(
		'title'					=> __('Home Slogan Options', 'cleanretina'),
		'priority'				=> 300,
		'panel'					=>'cleanretina_advanced_options_panel'
	));
	$wp_customize->add_setting( 'cleanretina_theme_options[disable_slogan]', array(
		'default'				=> 0,
		'sanitize_callback'	=> 'prefix_sanitize_integer',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control( 'home_slogan_options', array(
		'label'					=> __('Disable Slogan Part', 'cleanretina'),
		'section'				=> 'home_slogan_options',
		'settings'				=> 'cleanretina_theme_options[disable_slogan]',
		'type'					=> 'checkbox',
	));
	$wp_customize->add_setting('cleanretina_theme_options[slogan_position]', array(
		'default'				=> 'above-slider',
		'sanitize_callback'	=> 'prefix_sanitize_integer',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control('cleanretina_design_layout', array(
		'label'					=> __('Slogan Position', 'cleanretina'),
		'section'				=> 'home_slogan_options',
		'settings'				=> 'cleanretina_theme_options[slogan_position]',
		'type'					=> 'radio',
		'checked'				=> 'checked',
		'choices'				=> array(
			'above-slider'					=> __('Above Slider','cleanretina'),
			'below-slider'					=> __('Below Slider','cleanretina'),
		),
	));
	$wp_customize->add_setting( 'cleanretina_theme_options[home_slogan1]', array(
		'default'				=> '',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options',
		'sanitize_callback'	=> 'esc_textarea'
	));
	$wp_customize->add_control( 'home_slogan1', array(
		'label'					=> __('Home Page Slogan1', 'cleanretina'),
		'description'			=> __('The appropriate length of the slogan is around 10 words.','cleanretina'),
		'section'				=> 'home_slogan_options',
		'settings'				=> 'cleanretina_theme_options[home_slogan1]',
		'type'					=> 'textarea'
	));
	$wp_customize->add_setting( 'cleanretina_theme_options[home_slogan2]', array(
		'default'				=> '',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options',
		'sanitize_callback'	=> 'esc_textarea'
	));
	$wp_customize->add_control( 'home_slogan2', array(
		'label'					=> __('Home Page Slogan2', 'cleanretina'),
		'description'			=> __('The appropriate length of the slogan is around 10 words.','cleanretina'),
		'section'				=> 'home_slogan_options',
		'settings'				=> 'cleanretina_theme_options[home_slogan2]',
		'type'					=> 'textarea'
	));
	/******************** Home's Corporate Type Layout Options *********************/
	$wp_customize->add_section('home_corporate_layout_options', array(
		'title'					=> __('Homes Corporate Type Layout Options', 'cleanretina'),
		'priority'				=> 310,
		'panel'					=>'cleanretina_advanced_options_panel'
	));
	$wp_customize->add_setting( 'cleanretina_theme_options[corporate_content_title]', array(
		'default'				=> '',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control( 'corporate_content_title', array(
		'priority'				=>10,
		'label'					=> __('Corporate Content Title', 'cleanretina'),
		'section'				=> 'home_corporate_layout_options',
		'settings'				=> 'cleanretina_theme_options[corporate_content_title]',
		'type'					=> 'text'
	));
	// Featured Box
		for ( $i=1; $i <= 3; $i++ ) {
			$wp_customize->add_setting('cleanretina_theme_options[featured_home_box_image]['. $i.']', array(
				'default'					=>'',
				'sanitize_callback'		=>'esc_url_raw',
				'type' 						=> 'option',
				'capability' 				=> 'manage_options'
			));
			$wp_customize->add_control(
				new WP_Customize_Image_Control(
				$wp_customize,
					'featured_home_box_image'. $i,
					array(
					'priority'					=> 1 . $i,
					'label'				=> __('Featured Box #','cleanretina') . $i,
					'description'		=> __('Upload Icon Image','cleanretina'),
					'section'			=> 'home_corporate_layout_options',
					'settings'			=> 'cleanretina_theme_options[featured_home_box_image]'.'['. $i .']',
					)
				)
			);
			$wp_customize->add_setting('cleanretina_theme_options[featured_home_box_link]'.'['. $i .']', array(
				'default'					=>'',
				'sanitize_callback'		=>'esc_url_raw',
				'type' 						=> 'option',
				'capability' 				=> 'manage_options'
			));
			$wp_customize->add_control( 'featured_home_box_link'. $i .'', array(
				'priority'					=> 1 . $i,
				'description'						=> __('Redirect Link', 'cleanretina'),
				'section'					=> 'home_corporate_layout_options',
				'settings'					=> 'cleanretina_theme_options[featured_home_box_link]'.'['. $i .']',
				'type'						=> 'text',
			));
			$wp_customize->add_setting('cleanretina_theme_options[featured_home_box_title]'.'['. $i .']', array(
				'default'					=>'',
				'sanitize_callback'		=>'sanitize_text_field',
				'type' 						=> 'option',
				'capability' 				=> 'manage_options'
			));
			$wp_customize->add_control( 'featured_home_box_title'. $i .'', array(
				'priority'					=> 1 . $i,
				'description'						=> __('Title', 'cleanretina'),
				'section'					=> 'home_corporate_layout_options',
				'settings'					=> 'cleanretina_theme_options[featured_home_box_title]'.'['. $i .']',
				'type'						=> 'text',
			));
			$wp_customize->add_setting('cleanretina_theme_options[featured_home_box_description]'.'['. $i .']', array(
				'default'					=>'',
				'sanitize_callback'		=>'esc_textarea',
				'type' 						=> 'option',
				'capability' 				=> 'manage_options'
			));
			$wp_customize->add_control( 'featured_home_box_description'. $i .'', array(
				'priority'					=> 1 . $i,
				'description'						=> __('Description', 'cleanretina'),
				'section'					=> 'home_corporate_layout_options',
				'settings'					=> 'cleanretina_theme_options[featured_home_box_description]'.'['. $i .']',
				'type'						=> 'textarea',
			));
		}
	/******************** Corporate Page Template Options *********************/
	$wp_customize->add_section('corporate_page_template_options', array(
		'title'					=> __('Corporate Page Template Options', 'cleanretina'),
		'description'			=> '<i>' . __('Settings used on pages that use the "Corporate Template" page template. This template must be assigned to a page before its settings take effect.','cleanretina'). '</i>',
		'priority'				=> 320,
		'panel'					=>'cleanretina_advanced_options_panel'
	));
		// Featured Box
		for ( $i=1; $i <= 3; $i++ ) {
			$wp_customize->add_setting('cleanretina_theme_options[corporate_template_pages]'.'['. $i .']', array(
					'default'					=>'',
					'sanitize_callback'		=>'cleanretina_sanitize_dropdown_pages',
					'type' 						=> 'option',
					'capability' 				=> 'manage_options'
			));
			$wp_customize->add_control( 'cleanretina_theme_options[corporate_template_pages]'.'['. $i .']', array(
				'priority'					=> 1 . $i,
				'label'						=> __('Page #', 'cleanretina') . $i,
				'section'					=> 'corporate_page_template_options',
				'settings'					=> 'cleanretina_theme_options[corporate_template_pages]'.'['. $i .']',
				'type'						=> 'dropdown-pages',
			));
		}
	/******************** Excerpt Options *********************************************/
	$wp_customize->add_section( 'cleanretina_excerpt_section', array(
		'title' 						=> __('Excerpt Options','cleanretina'),
		'priority'					=> 330,
		'panel'						=>'cleanretina_advanced_options_panel'
	));
	$wp_customize->add_setting('cleanretina_theme_options[excerpt_length]', array(
		'default'					=> '30',
		'sanitize_callback'		=> 'cleanretina_sanatize_excerpt_length',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('excerpt_length', array(
		'label'						=> __('Excerpt Length', 'cleanretina'),
		'description'				=> __('Default value for excerpt length is 30 words.','cleanretina'),
		'section'					=> 'cleanretina_excerpt_section',
		'type'						=> 'text',
		'settings'					=> 'cleanretina_theme_options[excerpt_length]'
	) );
	/******************** Feed Redirect *********************************************/
	$wp_customize->add_section( 'cleanretina_feed_redirect_section', array(
		'title' 						=> __('Feed Redirect','cleanretina'),
		'priority'					=> 340,
		'panel'						=>'cleanretina_advanced_options_panel'
	));
	$wp_customize->add_setting('cleanretina_theme_options[feed_url]', array(
		'default'					=> '',
		'sanitize_callback'		=> 'esc_url_raw',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('feed_url', array(
		'label'						=> __('Feed Redirect URL', 'cleanretina'),
		'section'					=> 'cleanretina_feed_redirect_section',
		'type'						=> 'text',
		'settings'					=> 'cleanretina_theme_options[feed_url]'
	) );
	/******************** Homepage / Frontpage Category Setting *********************/
	$wp_customize->add_section(
		'cleanretina_category_section', array(
		'title' 						=> __('Homepage / Frontpage Category Setting','cleanretina'),
		'description'				=> __('Only posts that belong to the categories selected here will be displayed on the front page. ( You may select multiple categories by holding down the CTRL key. ) ','cleanretina'),
		'priority'					=> 350,
		'panel'					=>'cleanretina_advanced_options_panel'
	));
	$wp_customize->add_setting( 'cleanretina_theme_options[front_page_category]', array(
		'default'					=>array(),
		'sanitize_callback'		=> 'prefix_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control(
		new Cleanretina_Customize_Category_Control(
		$wp_customize,
			'cleanretina_theme_options[front_page_category]',
			array(
			'label'					=> __('Front page posts categories','cleanretina'),
			'section'				=> 'cleanretina_category_section',
			'settings'				=> 'cleanretina_theme_options[front_page_category]',
			'type'					=> 'multiple-select',
			)
		)
	);

	/******************** Slider Options ******************************************************/
	/********************Featured Post/ Page Slider******************************************/
	$wp_customize->add_section( 'cleanretina_featured_content_setting', array(
		'title'					=> __('Featured Post/ Page Slider', 'cleanretina'),
		'priority'				=> 400,
		'panel'					=>'cleanretina_featured_post_page_panel'
	));
	$wp_customize->add_setting( 'cleanretina_theme_options[disable_slider]', array(
		'default'					=> 0,
		'sanitize_callback'		=> 'prefix_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'cleanretina_disable_slider', array(
		'priority'					=>410,
		'label'						=> __('Disable Slider', 'cleanretina'),
		'section'					=> 'cleanretina_featured_content_setting',
		'settings'					=> 'cleanretina_theme_options[disable_slider]',
		'type'						=> 'checkbox',
	));
	$wp_customize->add_setting('cleanretina_theme_options[slider_quantity]', array(
		'default'					=> '4',
		'sanitize_callback'		=> 'cleanretina_sanitize_delay_transition',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('slider_quantity', array(
		'priority'					=>420,
		'label'						=> __('Number of Slides', 'cleanretina'),
		'description'				=> __('Please refresh the page to display effect on Slider Quantity','cleanretina'),
		'section'					=> 'cleanretina_featured_content_setting',
		'settings'					=> 'cleanretina_theme_options[slider_quantity]',
		'type'						=> 'text',
	) );
	$wp_customize->add_setting('cleanretina_theme_options[transition_effect]', array(
		'default'					=> 'fade',
		'sanitize_callback'		=> 'cleanretina_sanitize_effect',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('transition_effect', array(
		'priority'					=>430,
		'label'						=> __('Transition Effect', 'cleanretina'),
		'section'					=> 'cleanretina_featured_content_setting',
		'settings'					=> 'cleanretina_theme_options[transition_effect]',
		'type'						=> 'select',
		'choices'					=> array(
			'fade'					=> __('Fade','cleanretina'),
			'wipe'					=> __('Wipe','cleanretina'),
			'scrollUp'				=> __('Scroll Up','cleanretina' ),
			'scrollDown'			=> __('Scroll Down','cleanretina' ),
			'scrollLeft'			=> __('Scroll Left','cleanretina' ),
			'scrollRight'			=> __('Scroll Right','cleanretina' ),
			'blindX'					=> __('Blind X','cleanretina' ),
			'blindY'					=> __('Blind Y','cleanretina' ),
			'blindZ'					=> __('Blind Z','cleanretina' ),
			'cover'					=> __('Cover','cleanretina' ),
			'shuffle'				=> __('Shuffle','cleanretina' ),
		),
	));
	$wp_customize->add_setting('cleanretina_theme_options[transition_delay]', array(
		'default'					=> '4',
		'sanitize_callback'		=> 'cleanretina_sanitize_delay_transition',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('transition_delay', array(
		'priority'					=>440,
		'label'						=> __('Transition Delay', 'cleanretina'),
		'section'					=> 'cleanretina_featured_content_setting',
		'settings'					=> 'cleanretina_theme_options[transition_delay]',
		'type'						=> 'text',
	) );
	$wp_customize->add_setting('cleanretina_theme_options[transition_duration]', array(
		'default'					=> '1',
		'sanitize_callback'		=> 'cleanretina_sanitize_delay_transition',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('transition_duration', array(
		'priority'					=>450,
		'label'						=> __('Transition Length', 'cleanretina'),
		'section'					=> 'cleanretina_featured_content_setting',
		'settings'					=> 'cleanretina_theme_options[transition_duration]',
		'type'						=> 'text',
	) );
	/******************** Featured Post/ Page Slider Options  ************/
		$wp_customize->add_section( 'cleanretina_page_post_options', array(
			'title' 						=> __('Featured Post/ Page Slider Options','cleanretina'),
			'priority'					=> 460,
			'panel'					=>'cleanretina_featured_post_page_panel'
		));
		$wp_customize->add_setting('cleanretina_theme_options[exclude_slider_post]', array(
			'default'					=>0,
			'sanitize_callback'		=>'prefix_sanitize_integer',
			'type' 						=> 'option',
			'capability' 				=> 'manage_options'
		));
		$wp_customize->add_control( 'exclude_slider_post', array(
			'priority'					=>470,
			'label'						=> __('Exclude Slider post from Homepage posts?', 'cleanretina'),
			'section'					=> 'cleanretina_page_post_options',
			'settings'					=> 'cleanretina_theme_options[exclude_slider_post]',
			'type'						=> 'checkbox',
		));
		// featured post/page
		for ( $i=1; $i <= $options['slider_quantity'] ; $i++ ) {
			$wp_customize->add_setting('cleanretina_theme_options[featured_post_slider]['. $i.']', array(
				'default'					=>'',
				'sanitize_callback'		=>'prefix_sanitize_integer',
				'type' 						=> 'option',
				'capability' 				=> 'manage_options'
			));
			$wp_customize->add_control( 'featured_post_slider]['. $i .']', array(
				'priority'					=> 480 . $i,
				'label'						=> __(' Featured Slider Post/Page #', 'cleanretina') . ' ' . $i ,
				'section'					=> 'cleanretina_page_post_options',
				'settings'					=> 'cleanretina_theme_options[featured_post_slider]['. $i .']',
				'type'						=> 'text',
			));
		}
	/******************** Social Links *****************************************/
	$wp_customize->add_section(
		'cleanretina_sociallinks_section', array(
		'title' 						=> __('Social Links','cleanretina'),
		'priority'					=> 500,
	));
	$social_links = array(); 
		$social_links_name = array();
		$social_links_name = array( __( 'Facebook', 'cleanretina' ),
									__( 'Twitter', 'cleanretina' ),
									__( 'Google Plus', 'cleanretina' ),
									__( 'Pinterest', 'cleanretina' ),
									__( 'Youtube', 'cleanretina' ),
									__( 'Vimeo', 'cleanretina' ),
									__( 'LinkedIn', 'cleanretina' ),
									__( 'Flickr', 'cleanretina' ),
									__( 'Tumblr', 'cleanretina' ),
									__( 'Myspace', 'cleanretina' ),
									__( 'RSS', 'cleanretina' )
									);
		$social_links = array( 	'Facebook' 		=> 'social_facebook',
										'Twitter' 		=> 'social_twitter',
										'Google-Plus'	=> 'social_googleplus',
										'Pinterest' 	=> 'social_pinterest',
										'You-tube'		=> 'social_youtube',
										'Vimeo'			=> 'social_vimeo',
										'Linked'			=> 'social_linkedin',
										'Flickr'			=> 'social_flickr',
										'Tumblr'			=> 'social_tumblr',
										'My-Space'		=> 'social_myspace',
										'RSS'				=> 'social_rss' 
									);
		$i = 0;
		foreach( $social_links as $key => $value ) {
			$wp_customize->add_setting( 'cleanretina_theme_options['. $value. ']', array(
				'default'					=>'',
				'sanitize_callback'		=> 'esc_url',
				'type' 						=> 'option',
				'capability' 				=> 'manage_options'
			));
			$wp_customize->add_control( $value, array(
					'label'					=> $social_links_name[ $i ],
					'section'				=> 'cleanretina_sociallinks_section',
					'settings'				=> 'cleanretina_theme_options['. $value. ']',
					'type'					=> 'text',
					)
			);
			$i++;
		}
	/********************************************************************************/
	/******************** Webmaster Tools ******************************************/
	$wp_customize->add_section('webmaster_analytics_tools', array(
		'title'					=> __('Webmaster Tools', 'cleanretina'),
		'priority'				=> 600,
	));
	$wp_customize->add_setting( 'cleanretina_theme_options[analytic_header]', array(
		'default'				=> '',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options',
		'sanitize_callback'	=> 'wp_kses_stripslashes'
	));
	$wp_customize->add_control( 'analytic_header', array(
		'label'					=> __('Code to display on Header','cleanretina'),
		'description'			=> __('Note: Enter your custom header script.','cleanretina'),
		'section'				=> 'webmaster_analytics_tools',
		'settings'				=> 'cleanretina_theme_options[analytic_header]',
		'type'					=> 'textarea'
	));
	$wp_customize->add_setting( 'cleanretina_theme_options[analytic_footer]', array(
		'default'				=> '',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options',
		'sanitize_callback'	=> 'wp_kses_stripslashes'
	));
	$wp_customize->add_control( 'analytic_footer', array(
		'label'					=> __('Code to display on Footer','cleanretina'),
		'description'			=> __('Note: Enter your custom footer script.','cleanretina'),
		'section'				=> 'webmaster_analytics_tools',
		'settings'				=> 'cleanretina_theme_options[analytic_footer]',
		'type'					=> 'textarea'
	));

}
/********************Sanitize the values ******************************************/
function cleanretina_sanitize_dropdown_pages( $page_id, $setting ) {
	// Ensure $input is an absolute integer.
	$page_id = absint( $page_id );
	
	// If $page_id is an ID of a published page, return it; otherwise, return the default.
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}
function cleanretina_sanatize_excerpt_length( $input ) {
	if(is_numeric($input)){
	return $input;
	}
}
function prefix_sanitize_integer( $input ) {
	return $input;
}
function cleanretina_sanitize_effect( $input ) {
	if ( ! in_array( $input, array( 'fade', 'wipe', 'scrollUp', 'scrollDown', 'scrollLeft', 'scrollRight', 'blindX', 'blindY', 'blindZ', 'cover', 'shuffle' ) ) ) {
		$input = 'fade';
	}
	return $input;
}
function cleanretina_sanitize_delay_transition( $input ) {
	if(is_numeric($input)){
	return $input;
	}
}

function customize_styles_cleanretina_upgrade( $input ) { ?>
	<style type="text/css">
		#customize-theme-controls #accordion-section-cleanretina_upgrade_to_pro .accordion-section-title:after {
			color: #fff;
		}
		#customize-theme-controls #accordion-section-cleanretina_upgrade_to_pro .accordion-section-title {
			background-color: rgba(150, 81, 204, 0.9);
			color: #fff;
			border: 0 none;
		}
		#customize-theme-controls #accordion-section-cleanretina_upgrade_to_pro .accordion-section-title:hover {
			background-color: rgba(150, 81, 204, 1);
		}
		#customize-theme-controls #accordion-section-cleanretina_upgrade a {
			padding: 5px 0;
			display: block;
		}
		#customize-theme-controls #accordion-section-cleanretina_upgrade_to_pro a {
			color: rgba(150, 81, 204, 1);
		}
		#customize-theme-controls #accordion-section-cleanretina_upgrade_to_pro a:hover {
			text-decoration: underline;
		}
	</style>
<?php }
function cleanretina_upgrade_notice() {
	// Enqueue the script
	wp_enqueue_script(
		'cleanretina-upgrade-pro',
		get_template_directory_uri() . '/library/js/cleanretina_customizer.js',
		array(), '3.0',
		true
	);
	// Localize the script
	wp_localize_script(
		'cleanretina-upgrade-pro',
		'cleanretinaproupgrade',
		array(
			'cleanretinaprourl'		=> esc_url( 'http://themehorse.com/themes/clean-retina-pro/' ),
			'cleanretinaprolabel'	=> __( 'Upgrade to Clean Retina Pro', 'cleanretina' ),
		)
	);
}
add_action( 'customize_controls_enqueue_scripts', 'cleanretina_upgrade_notice' );
add_action('customize_register', 'cleanretina_textarea_register');
add_action('customize_register', 'cleanretina_customize_register');
add_action( 'customize_controls_print_styles', 'customize_styles_cleanretina_upgrade');
?>