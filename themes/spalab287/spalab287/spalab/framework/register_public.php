<?php
function dttheme_blog_title() {
	$the_content = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', get_option('blogname'));
	return $the_content;
}

function filter_ptags_on_images($content) {
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'filter_ptags_on_images');

remove_action('wp_head', 'rel_canonical');

add_action('wp_head', 'dttheme_render_ie_pie', 8);
function dttheme_render_ie_pie() {
	echo ' <!--[if IE]>
    <style type="text/css" media="screen">
			.team .social-icons li {
				behavior: url('.get_template_directory_uri().'/PIE.php);
               }
     </style>
     <![endif]-->';
	echo "\n";
}

#Remove rel attribute from the category list ( Validation purpose)
function remove_category_list_rel($output) {
	return str_replace(' rel="category tag"', '', $output);
}
add_filter('wp_list_categories', 'remove_category_list_rel');
add_filter('the_category', 'remove_category_list_rel');
#To remove rel attribute from the category list

add_filter('widget_text', 'do_shortcode');

#FILTER TO MODIFY THE DEFAULT CATEGORY WIDGET
add_filter('wp_list_categories', 'my_wp_list_categories');
if (!function_exists('my_wp_list_categories')) {
 function my_wp_list_categories($output) {
	if (strpos($output, "</span>") <= 0) {
		$output = str_replace('</a> (', '<span> ', $output);
		$output = str_replace(')', '</span></a> ', $output);
	}
	return $output;
 }
}

add_filter('get_archives_link', 'my_wp_list_archive');
if (!function_exists('my_wp_list_archive')) {
 function my_wp_list_archive($output) {
	$output = str_replace('</a>&nbsp;(', '<span> ', $output);
	$output = str_replace(')', '</span></a> ', $output);
	return $output;
 }
}

#Remove Widget Default Title
add_filter('widget_title', 'my_wp_remove_custom_widget_title');
function my_wp_remove_custom_widget_title($title) {
	$title = $title;
	return $title;
}

/** dttheme_default_navigation()
 * Objective:
 *		To setup default navigation  when no menu is selected
 **/
function dttheme_default_navigation() {
	echo '<ul class="menu">';
	$args = array('depth' => 1, 'title_li' => '', 'echo' => 0, 'post_type' => 'page', 'post_status' => 'publish');
	$pages = wp_list_pages($args);
	if ($pages)
		echo ( $pages );
	echo '</ul>';
}
### --- ****  dttheme_default_navigation() *** --- ###

add_action('wp_enqueue_scripts', 'plugin_head_styles_scripts');
function plugin_head_styles_scripts() {

	#Theme urls for Style Picker
	$scroll = dttheme_option('general', 'disable-custom-scroll') ? "disable" : "enable";
	$stickynav = ( dttheme_option("general","enable-sticky-nav") ) ? "enable" : "disable";
	$loadingbar = ( dttheme_option("general","loading-bar") ) ? "disable" : "enable";
	

	echo "\n <script type='text/javascript'>\n\t";
	echo "var mytheme_urls = {\n";
	echo "\t\t theme_base_url:'".IAMD_BASE_URL."'";
	echo "\n \t\t,framework_base_url:'".IAMD_FW_URL."'";
	echo "\n \t\t,ajaxurl:'".admin_url('admin-ajax.php')."'";
	echo "\n \t\t,url:'".get_site_url()."'";
	echo "\n \t\t,scroll:'".$scroll."'";
	echo "\n \t\t,stickynav:'".$stickynav."'";
	echo "\n \t\t,loadingbar:'".$loadingbar."'";
	echo "\n \t\t,is_admin:'".current_user_can('level_10') ."'";
	echo "\n \t\t,skin:'".dttheme_option('appearance','skin')."'";
	echo "\n \t\t,layout:'".dttheme_option('appearance','layout')."'";
	echo "\n \t\t,layout_pattern:'".dttheme_option('appearance','boxed-layout-pattern')."'";
	echo "\n\t};\n";
	echo " </script>\n";
	
	#Theme urls for Style Picker End
	wp_enqueue_script('modernizr-script', IAMD_FW_URL.'js/public/modernizr-2.6.2.min.js');
	
	wp_enqueue_script('jquery');
	wp_enqueue_script('retina-script', IAMD_FW_URL.'js/public/retina.js',array(),false,true);
	wp_enqueue_script('ui-totop-script', IAMD_FW_URL.'js/public/jquery.ui.totop.min.js',array(),false,true);
	
	wp_enqueue_script('easing-script', IAMD_FW_URL.'js/public/easing.js',array(),false,true);
	wp_enqueue_script('smartresize-script', IAMD_FW_URL.'js/public/jquery.smartresize.js',array(),false,true);
	
	wp_enqueue_script('nicescroll-script', IAMD_FW_URL.'js/public/jquery.nicescroll.min.js',array(),false,true);
	
	/* Catalog */
	wp_enqueue_script('jq.smooth', IAMD_FW_URL.'js/public/jquery-smoothscroll.js',array(),false,true);
	
	wp_enqueue_script('sticky-nav', IAMD_FW_URL.'js/public/jquery.sticky.js',array(),false,true);
	
	wp_enqueue_script('isotope-script', IAMD_FW_URL.'js/public/jquery.isotope.min.js',array(),false,true);
	
	wp_enqueue_script('fitvids-script', IAMD_FW_URL.'js/public/jquery.fitvids.js',array(),false,true);
	wp_enqueue_script('bx-script', IAMD_FW_URL.'js/public/jquery.bxslider.js',array(),false,true);
	
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_style('jquery-ui-datepicker','http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css' );
		wp_enqueue_script( 'mgs-reservation',  IAMD_FW_URL.'js/public/reservation.js', array( 'jquery' ), '2014-03-18', true );

	
	#Theme Picker 		
	if( dttheme_option("general","disable-picker") === NULL  && !is_user_logged_in() ):
		wp_enqueue_script('theme-cookies', IAMD_FW_URL.'js/public/jquery.cookie.js',array(),false,true);
		wp_enqueue_script('theme-picker', IAMD_FW_URL.'js/public/picker.js',array(),false,true);
	endif;
	
	wp_enqueue_script('custom-script', IAMD_FW_URL.'js/public/custom.js',array(),false,false);
	
	wp_enqueue_script('stickymojo-script', IAMD_FW_URL.'js/public/stickyMojo.js',array(),false,true);
	
	wp_enqueue_script('stickyfloat', IAMD_FW_URL.'js/public/stickyfloat.js',array(),false,false);
}

add_action('wp_head', 'dttheme_appearance_load_fonts', 7);
/** dttheme_appearance_load_fonts()
 * Objective:
 *		To load google fonts based on appearance settings in admin panel.
 **/
function dttheme_appearance_load_fonts() {
	$custom_fonts = array();
	$output = "";
	$font = "";

	$subset = dttheme_option('general', 'google-font-subset');
	if ($subset) {
		$subset = strtolower(str_replace(' ', '', $subset));
	}

	#Menu Section
	$disable_menu = dttheme_option("appearance", "disable-menu-settings");
	if (empty($disable_menu)) :
		$font = dttheme_option("appearance", "menu-font");
		if (!empty($font)) :
			$font = str_replace(" ", "+", $font);
			array_push($custom_fonts, $font);
		endif;
	endif; #Menu Secion End

	#Body Section
	$disable_boddy_settings = dttheme_option("appearance", "disable-boddy-settings");

	if (empty($disable_boddy_settings)) :
		$font = dttheme_option("appearance", "body-font");
		$font = str_replace(" ", "+", $font);
		if (!empty($font)) :
			array_push($custom_fonts, $font);
		endif;
	endif;

	#Footer Section
	$disable_footer = dttheme_option("appearance", "disable-footer-settings");
	if (empty($disable_footer)) :
		$footer_title_font = dttheme_option("appearance", "footer-title-font");
		$footer_title_font = !empty($footer_title_font) ? str_replace(" ", "+", $footer_title_font) : NULL;
		if (!empty($footer_title_font)) :
			array_push($custom_fonts, $footer_title_font);
		endif;

		$footer_content_font = dttheme_option("appearance", "footer-content-font");
		$footer_content_font = !empty($footer_content_font) ? str_replace(" ", "+", $footer_content_font) : NULL;
		if (!empty($footer_content_font)) :
			array_push($custom_fonts, $footer_content_font);
		endif;

	endif; #Footer Section End

	#Typography Section
	$disable_typo = dttheme_option("appearance", "disable-typography-settings");
	if (empty($disable_typo)) :
		for ($i = 1; $i <= 6; $i++) :
			$font = dttheme_option("appearance", "H{$i}-font");
			if (!empty($font)) :
				$font = str_replace(" ", "+", $font);
				array_push($custom_fonts, $font);
			endif;
		endfor;
	endif; #Typography Section End

	#404 Section
	$disable_404_settings = dttheme_option("specialty", "disable-404-font-settings");
	if (empty($disable_404_settings)) :
		$font = dttheme_option("specialty", "message-font");
		if (!empty($font)) :
			$font = str_replace(" ", "+", $font);
			array_push($custom_fonts, $font);
		endif;
	endif;


	if (!empty($custom_fonts)) :
		$custom_fonts = array_unique($custom_fonts);
		$font = implode(":300,400,400italic,700 %7C", $custom_fonts);
		$font .= ":300,400,400italic,700 %7C";
	endif;
	
		$font .= "Lato:300,400,700%7CRaleway:400,500,300,600%7CTangerine:400,700%7CRoboto";
		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array('family' => $font, 'subset' => $subset);
		wp_enqueue_style('mytheme-google-fonts', add_query_arg($query_args, "$protocol://fonts.googleapis.com/css" ), array(), null);

}
### --- ****  dttheme_appearance_load_fonts() *** --- ###

add_action('wp_head', 'dttheme_appearance_css', 9);
/** dttheme_appearance_css()
 * Objective:
 *		To generate in-line style based on appearance settings in admin panel.
 **/
function dttheme_appearance_css() {
	$output = NULL;
	
	#Layout Section
	if(dttheme_option("appearance","layout") == "boxed"):
		if(dttheme_option("appearance","bg-type") == "bg-patterns"):
			$pattern = dttheme_option("appearance","boxed-layout-pattern");
			$pattern_repeat = dttheme_option("appearance","boxed-layout-pattern-repeat");
			$pattern_opacity = dttheme_option("appearance","boxed-layout-pattern-opacity");
			$disable_color = dttheme_option("appearance","disable-boxed-layout-pattern-color");
			$pattern_color =  dttheme_option("appearance","boxed-layout-pattern-color");
			$output .= "body { ";
				if(!empty($pattern))
					$output .= "background-image:url('".IAMD_FW_URL."theme_options/images/patterns/{$pattern}');"; 
						
				$output .= "background-repeat:$pattern_repeat;";
				if(empty($disable_color)){
					if(!empty($pattern_opacity)){
						$color = hex2rgb($pattern_color);
						$output .= "background-color:rgba($color[0],$color[1],$color[2],$pattern_opacity); ";
					}else{
						$output .= "background-color:$pattern_color;";
					}
				}
			$output .= "}\r\t";
		
		elseif(dttheme_option("appearance","bg-type") == "bg-custom"):
			$bg = dttheme_option("appearance","boxed-layout-bg");
			$bg_repeat = dttheme_option("appearance","boxed-layout-bg-repeat");
			$bg_opacity = dttheme_option("appearance","boxed-layout-bg-opacity");
			$bg_color =  dttheme_option("appearance","boxed-layout-bg-color");
			$disable_color = dttheme_option("appearance","disable-boxed-layout-bg-color");
			$bg_position =  dttheme_option("appearance","boxed-layout-bg-position");
			$output .= "body { ";
			if(!empty($bg)) {
				$output .= "background-image:url($bg);";
				$output .= "background-repeat:$bg_repeat;";
				$output .= "background-position:$bg_position;";
			}
			
			if(empty($disable_color)){
				if(!empty($bg_opacity)){	
					$color = hex2rgb($bg_color);
					$output .= "background-color:rgba($color[0],$color[1],$color[2],$bg_opacity);";
				}else{
					$output .= "background-color:$bg_color;";
				}
			}
			$output .= "}\r\t";
		endif;
	endif;
	#Layout Section

	#Menu Section
	$disable_menu = dttheme_option("appearance", "disable-menu-settings");
	if (empty($disable_menu)) :
		$font_type = dttheme_option("appearance", "menu-font-type");
		$style = dttheme_option("appearance","menu-standard-font-style");
		
		if( !empty($font_type) ){
		#Menu Font: Standard
			$font = dttheme_option("appearance","menu-standard-font");
		} else {
		#Menu Font: Google
			$font = dttheme_option("appearance", "menu-font");
		}

		$size = dttheme_option("appearance", "menu-font-size");
		$primary_color = dttheme_option("appearance", "menu-primary-color");
		$secondary_color = dttheme_option("appearance", "menu-secondary-color");
		
		if (!empty($font) || (!empty($primary_color) and $primary_color != "#") || !empty($size)) :
		
			$output .= "#main-menu ul.menu li a, .mean-container .mean-nav ul li a, #main-menu ul li.menu-item-simple-parent ul.sub-menu li a, .megamenu-child-container > ul.sub-menu > li > a, .megamenu-child-container > ul.sub-menu > li > .nolink-menu  { ";
				if (!empty($font)) {	$output .= "font-family:{$font},sans-serif; ";	}
				
				if (!empty($primary_color) && ($primary_color != '#')) {	$output .= "color:{$primary_color}; ";  }
				
				if (!empty($size) and ($size > 0)) {	$output .= "font-size:{$size}px; ";	}
				
				if( !empty( $style ) ){		$output .= "font-style: {$style}";	}
			$output .= "}\r\t";
		endif;

		if (!empty($secondary_color) and $secondary_color != "#") :
		  $output .= "#main-menu ul > li:hover > a, #main-menu ul ul li.current_page_item a, #main-menu ul ul li.current_page_item ul li.current_page_item a, #main-menu ul ul li.current_page_item ul li a:hover, #main-menu ul li.menu-item-simple-parent ul.sub-menu li a:hover, .megamenu-child-container > ul.sub-menu > li > a:hover { ";
	  	  $output .= "color:{$secondary_color}; ";
		  $output .= "}\r\t";
	endif;
	endif; #Menu Section End

	#Body Section
	$disable_boddy_settings = dttheme_option("appearance", "disable-boddy-settings");
	if (empty($disable_boddy_settings)) :
		$font_type = dttheme_option("appearance", "body-font-type");
		$style = dttheme_option("appearance","body-standard-font-style");

		if( !empty($font_type) ){
		#Body Font: Standard
			$body_font = dttheme_option("appearance","body-standard-font");
			
		} else {
		#Body Font: Google
			$body_font = dttheme_option("appearance", "body-font");
		}

		$body_font_size = dttheme_option("appearance", "body-font-size");
		$body_font_color = dttheme_option("appearance", "body-font-color");

		$body_primary_color = dttheme_option("appearance", "body-primary-color");
		$body_secondary_color = dttheme_option("appearance", "body-secondary-color");


		if (!empty($body_font) || (!empty($body_font_color) and $body_font_color != "#") || !empty($body_font_size)) :
			$output .= "body {";
			if (!empty($body_font)) {	$output .= "font-family:{$body_font} , sans-serif; ";  }

			if (!empty($body_font_color) && ($body_font_color != '#')) { $output .= "color:{$body_font_color}; "; }

			if (!empty($body_font_size)) {	$output .= "font-size:{$body_font_size}px; "; }
			
			if( !empty( $style ) ){ $output .= "font-style: {$style}";	}
			$output .= "}\r\t";
		endif;

		if ((!empty($body_primary_color) and $body_primary_color != "#") || (!empty($body_secondary_color) and $body_secondary_color != "#")) :
			if (!empty($body_primary_color) && ($body_primary_color != '#')) { 	$output .= "a { color:{$body_primary_color}; }"; }

			if (!empty($body_secondary_color) && ($body_secondary_color != '#')) {	$output .= "a:hover { color:{$body_secondary_color}; }";	}
		endif;
	endif; #Body Section End

	#Footer Section
	$disable_footer = dttheme_option("appearance", "disable-footer-settings");
	if (empty($disable_footer)) :

		#Footer Title
		$font_type = dttheme_option("appearance", "footer-title-font-type");
		$style = dttheme_option("appearance","footer-title-standard-font-style");
		
		if( !empty($font_type) ){
			#Footer Title Font : Standard Font
			$footer_title_font = dttheme_option("appearance","footer-title-standard-font");
		} else {
			#Footer Title Font : Google Font	
			$footer_title_font = dttheme_option("appearance", "footer-title-font");		
		}
		
		$footer_title_font_color = dttheme_option("appearance", "footer-title-font-color");
		$footer_title_font_size = dttheme_option("appearance", "footer-font-size");
		$footer_primary_color = dttheme_option("appearance", "footer-primary-color");
		$footer_secondary_color = dttheme_option("appearance", "footer-secondary-color");
		$footer_bg_color = dttheme_option("appearance", "footer-bg-color");
		$copyright_bg_color = dttheme_option("appearance", "copyright-bg-color");

		if (!empty($footer_title_font) || (!empty($footer_title_font_color) and $footer_title_font_color != "#") || !empty($footer_title_font_size)) :
			$output .= "#footer h1, #footer h2, #footer h3, #footer .widget h3.widgettitle, #footer h4, #footer h5, #footer h6, #footer h1 a, #footer h2 a, #footer h3 a, #footer h4 a, #footer h5 a, #footer h6 a {";
			if (!empty($footer_title_font)) {	$output .= "font-family:{$footer_title_font}; ";	}

			if (!empty($footer_title_font_color) && ($footer_title_font_color != '#')) {	$output .= "color:{$footer_title_font_color}; ";	}

			if (!empty($footer_title_font_size)) {	$output .= "font-size:{$footer_title_font_size}px; ";	}
			
			if( !empty( $style ) ){ $output .= "font-style: {$style}";	}
			$output .= "}\r\t";
		endif;

		if ((!empty($footer_primary_color) and $footer_primary_color != "#") || (!empty($footer_secondary_color) and $footer_secondary_color != "#")) :
			if (!empty($footer_primary_color) && ($footer_primary_color != '#')) {
				$output .= "#footer a, #footer ul li a, #footer .widget_categories ul li a, #footer .widget.widget_recent_entries .entry-metadata .tags a, #footer .categories a, .copyright a { color:{$footer_primary_color}; }";
			}

			if (!empty($footer_secondary_color) && ($footer_secondary_color != '#')) {
				$output .= "#footer a:hover, #footer h1 a:hover, #footer h2 a:hover, #footer h3 a:hover, #footer h4 a:hover, #footer h5 a:hover, #footer h6 a:hover, #footer ul li a:hover, #footer .widget.widget_recent_entries .entry-metadata .tags a:hover, #footer .categories a:hover, .copyright a:hover { color:{$footer_secondary_color}; }";
			}
		endif;
		
		#Footer Content
		$font_type = dttheme_option("appearance","footer-content-font-type");
		$style = dttheme_option("appearance","footer-content-standard-font-style");
		if( !empty($font_type) ){
			#Footer Title Font : Standard Font
			$footer_title_font = dttheme_option("appearance","footer-content-standard-font");
		} else {
			#Footer Title Font : Google Font	
			$footer_title_font = dttheme_option("appearance", "footer-content-font");		
		}
		
		$footer_content_font_color = dttheme_option("appearance", "footer-content-font-color");
		$footer_content_font_size = dttheme_option("appearance", "footer-content-font-size");
		
		if (!empty($footer_content_font) || (!empty($footer_content_font_color) and $footer_content_font_color != "#") || !empty($footer_content_font_size)) :
			$output .= "#footer, #footer p, #footer span, #footer .widget.widget_recent_entries .entry-metadata .author, #footer .widget.widget_recent_entries .entry-meta .date, #footer label, #footer .widget ul li, #footer .widget ul li:hover, .copyright, #footer .widget.widget_recent_entries .entry-metadata .tags, #footer .categories {";
			
			if (!empty($footer_content_font)) {	$output .= "font-family:{$footer_content_font} !important; ";	}

			if (!empty($footer_content_font_color) && ($footer_content_font_color != '#')) {	$output .= "color:{$footer_content_font_color} !important; ";	}

			if (!empty($footer_content_font_size)) {	$output .= "font-size:{$footer_content_font_size}px !important; ";	}
			
			if( !empty( $style ) ){ $output .= "font-style: {$style}";	}

			$output .= "}\r\t";
		
		endif;
		
		if (!empty($footer_bg_color) and $footer_bg_color != "#") {		$output .= "#footer { background-color: $footer_bg_color; }";	}

		if (!empty($copyright_bg_color) and $copyright_bg_color != "#") {	$output .= ".copyright { background-color: $copyright_bg_color; }"; }
	
	endif; #Footer Section End

	#Typography Settings
	$disable_typo = dttheme_option("appearance", "disable-typography-settings");
	if (empty($disable_typo)) :
		for ($i = 1; $i <= 6; $i++) :
			$font_type = dttheme_option("appearance", "H{$i}-font-type");
			$style = dttheme_option("appearance","H{$i}-standard-font-style");
			
			if( !empty($font_type) ){
			#Menu Font: Standard
				$font = dttheme_option("appearance","H{$i}-standard-font");
			} else {
			#Menu Font: Google
				$font = dttheme_option("appearance", "H{$i}-font");
			}
			
			$color = dttheme_option("appearance", "H{$i}-font-color");
			$size = dttheme_option("appearance", "H{$i}-size");

			if (!empty($font) || (!empty($color) and $color != "#") || !empty($size)) :
				$output .= " .border-title H$i, H$i {";
				if (!empty($font)) {	$output .= "font-family:{$font}; ";	}

				if (!empty($color) && ($color != '#')) {	$output .= "color:{$color}; ";	}
				
				if (!empty($size)) { $output .= "font-size:{$size}px; "; }

				$output .= "}\r\t";
			endif;
		endfor;
	endif; #Typography Settings end
	
	#Color Options Settings
	$disable_color_options_settings = dttheme_option("color-options", "disable-color-options-settings");
	if (empty($disable_color_options_settings)) :
	
	# TOP BAR STARTS 
		#Top Bar Color
		$color = dttheme_option("color-options", "topbar-bg-color");
		if (!empty($color) and $color != "#")  :
			$output .= "#bbar-wrapper { ";
				$output .= "background:{$color} !important; ";
			$output .= "}\r\t";
		endif;
		
		#Top Bar Left Menu
		$color = dttheme_option("color-options", "topbar-left-menu-color");
		if (!empty($color) and $color != "#")  :
			$output .= "#bbar-wrapper ul.top-menu li a { ";
				$output .= "color:{$color} !important; ";
			$output .= "}\r\t";
		endif;
		
		#Top Bar Right
		
		#Top Bar Phone-No
		$color = dttheme_option("color-options", "topbar-phno-color");
		if (!empty($color) and $color != "#")  :
			$output .= "#bbar-wrapper, #bbar-wrapper.type1, #bbar-wrapper.type1 i, #bbar-wrapper.type1 a, #bbar-wrapper.type4, #bbar-wrapper.type4 i, #bbar-wrapper.type4 a, #bbar-wrapper.type5, #bbar-wrapper.type5 i, #bbar-wrapper.type5 a { ";
				$output .= "color:{$color}; ";
			$output .= "}\r\t";
		endif;
		
		#Top Bar Email
		$color = dttheme_option("color-options", "topbar-email-color");
		if (!empty($color) and $color != "#")  :
			$output .= "#bbar-wrapper .column.dt-sc-one-half.alignright a, #bbar-wrapper a, #bbar-wrapper.type1 a, #bbar-wrapper.type4 a, #bbar-wrapper.type5 a { ";
				$output .= "color:{$color}; ";
			$output .= "}\r\t";
		endif;
		
		#Top Bar Hover Color
		$color = dttheme_option("color-options", "topbar-hover-color");
		if (!empty($color) and $color != "#")  :
			$output .= "#bbar-wrapper ul.top-menu li a:hover, #bbar-wrapper .column.dt-sc-one-half.alignright a:hover, #bbar-wrapper .column.dt-sc-one-half.alignright a:hover, #bbar-wrapper a:hover, #bbar-wrapper.type1 a:hover, #bbar-wrapper.type4 a:hover, #bbar-wrapper.type5 a:hover { ";
				$output .= "color:{$color}; ";
			$output .= "}\r\t";
		else :
			$output .= "#bbar-wrapper ul.top-menu li a:hover, #bbar-wrapper .column.dt-sc-one-half.alignright a:hover, #bbar-wrapper .column.dt-sc-one-half.alignright a:hover, #bbar-wrapper a:hover, #bbar-wrapper.type1 a:hover, #bbar-wrapper.type4 a:hover, #bbar-wrapper.type5 a:hover { ";
				$output .= "color:#2d2d29; ";
			$output .= "}\r\t";		 
		endif;
	# TOP BAR ENDS 
	
	# MENU SECTION STARTS
		#Main Menu Hover
		$color = dttheme_option("color-options", "main-menu-hover-color");
		if (!empty($color) and $color != "#")  :
			$output .= "#main-menu > ul > li > a:hover,  #main-menu > ul > li:hover > a, #header.header4 #main-menu > ul.menu > li > a:hover, #header.header5 #main-menu > ul.menu > li > a:hover { ";
				$output .= "border-color:{$color}; ";
			$output .= "}\r\t";
		endif;
		
		#Active Menu Color
		$color = dttheme_option("color-options", "active-main-menu-color");
		if (!empty($color) and $color != "#")  : 
			$output .= "#main-menu > ul > li.current_page_item > a, #main-menu > ul > li.current-menu-item > a, .megamenu-child-container ul.sub-menu > li > ul li.current_page_item a, .megamenu-child-container ul.sub-menu > li > ul li.current_page_ancestor a, .megamenu-child-container ul.sub-menu > li > ul li.current-menu-item a, .megamenu-child-container ul.sub-menu > li > ul li.current-menu-ancestor a, #main-menu ul li.menu-item-simple-parent ul li.current_page_item > a, #main-menu ul li.menu-item-simple-parent ul li.current_page_ancestor > a, #main-menu ul li.menu-item-simple-parent ul li.current-menu-item > a, #main-menu ul li.menu-item-simple-parent ul li.current-menu-ancestor > a { ";
				$output .= "border-color:{$color}; ";
			$output .= "}\r\t";
		endif;
		
		
	# MENU SECTION ENDS
		
		#Breadcrumb Border Color 
		$color = dttheme_option("color-options", "breadcrumb-border-color");
		if (!empty($color) and $color != "#")  :
			$output .= ".breadcrumb h6, .breadcrumb-section.type2 .breadcrumb h6 { ";
				$output .= "color:{$color}; ";
			$output .= "}\r\t";
		endif;

		#Active page in Breadcrumb Section Color 
		$color = dttheme_option("color-options", "active-pg-bsection-color");
		if (!empty($color) and $color != "#")  :
			$output .= ".breadcrumb h6 { ";
				$output .= "background:{$color}; ";
			$output .= "}\r\t";
		endif;
	endif; 
	
	#Color Options Settings end

	#404 Settings
	$disable_404_settings = dttheme_option("specialty", "disable-404-font-settings");
	if (empty($disable_404_settings)) :
		$font = dttheme_option("specialty", "message-font");
		$color = dttheme_option("specialty", "message-font-color");
		$size = dttheme_option("specialty", "message-font-size");

		if (!empty($font) || (!empty($color) and $color != "#") || !empty($size)) :
			$output .= "div.error-info { ";
			if (!empty($font)) {
				$output .= "font-family:{$font}; ";
			}

			if (!empty($color) && ($color != '#')) {
				$output .= "color:{$color}; ";
			}

			if (!empty($size)) {
				$output .= "font-size:{$size}px; ";
			}
			$output .= "}\r\t";

			$output .= "div.error-info h1, div.error-info h2, div.error-info h3,div.error-info h4,div.error-info h5,div.error-info h6 { ";
			if (!empty($font)) {
				$output .= "font-family:{$font}; ";
			}

			if (!empty($color) && ($color != '#')) {
				$output .= "color:{$color}; ";
			}
			$output .= "}\r\t";

		endif;
	endif; #404 Settings end


	#custom CSS
	if (dttheme_option('integration', 'enable-custom-css')) :
		$css = dttheme_option('integration', 'custom-css');
		$output .= stripcslashes($css);
	endif; #custom CSS eND

	if (!empty($output)) :
		$output = "\r".'<style type="text/css">'."\r\t".$output."\r".'</style>'."\r";
		echo ( $output );
	endif;

}

function dttheme_slider_section($post_id) {
	$tpl_default_settings = get_post_meta($post_id, '_tpl_default_settings', TRUE);
	$tpl_default_settings = is_array($tpl_default_settings) ? $tpl_default_settings : array();

	if (array_key_exists('show_slider', $tpl_default_settings) && array_key_exists('slider_type', $tpl_default_settings)) :

		echo '<!-- **Slider Section** -->';
		echo '<section id="slider">';
		if ($tpl_default_settings['slider_type'] === "layerslider") :
			$id = isset( $tpl_default_settings['layerslider_id'])? $tpl_default_settings['layerslider_id'] : "";
			$slider = !empty($id) ? do_shortcode("[layerslider id='{$id}']") : "";
			echo ( $slider );
			
		elseif ($tpl_default_settings['slider_type'] === "revolutionslider") :
			$id = isset($tpl_default_settings['revolutionslider_id']) ? $tpl_default_settings['revolutionslider_id'] : "";
			$slider = !empty($id) ? do_shortcode("[rev_slider $id]") : "";
			echo ( $slider );
		
		elseif( $tpl_default_settings['slider_type'] === "imageonly" ):
			
			$img = isset($tpl_default_settings['slider-image']) ? "<div class='slider-image-only'><img src='{$tpl_default_settings['slider-image']}' alt=''/></div>" : "";
			echo ( $img );
			
		endif;
		
		$slider_shortcode = '';
		if(isset($tpl_default_settings['slider-shortcode'])) {
			$slider_shortcode = do_shortcode($tpl_default_settings['slider-shortcode']);
		}
		echo ( $slider_shortcode );

		echo '</section><!-- **Slider Section - End** -->';
	endif;
}

//new breadcrumb
if (!function_exists('dttheme_subtitle_section')) {
 function dttheme_subtitle_section($id=0,$type,$settings = array() ){
	
	//var_dump($id);
	
	if( $id > 0 ){

		$title = get_the_title($id);
		
		// breadcrumb titlt
		$breadcrumb_title = get_post_meta( $id, '_tpl_default_settings', TRUE );
		$breadcrumb_sub_title = isset( $breadcrumb_title['breadcrumb-sub-title'] ) ? $breadcrumb_title['breadcrumb-sub-title']  : '';
		$title = !empty($breadcrumb_sub_title) ? $breadcrumb_sub_title : $title;
		//

		if( $type === "post" )
			$settings = '_dt_post_settings';
		elseif( $type === "page")
			$settings = '_tpl_default_settings';
		elseif( $type === "dt_portfolios" )
			$settings = '_portfolio_settings';

		$settings = get_post_meta( $id, $settings, TRUE );
		$settings = is_array($settings) ? $settings : array();
	}

	$disable_breadcrumb = dttheme_option('general','disable-breadcrumb');
	$breadcrumb_type = dttheme_option('general','breadcrumb-type');
		
	if ( !array_key_exists('disable_breadcrumb_section', $settings) ) :		
		
		$default_breadcrumb_image_url = dttheme_option('general', 'breadcrumb-image-url');
        $default_breadcrumb_image_url = !empty( $default_breadcrumb_image_url ) ? $default_breadcrumb_image_url : IAMD_BASE_URL.'images/breadcrumb-default-bg.jpg'; 
							
		$bg = array_key_exists('breadcrumb-bg', $settings) ? $settings['breadcrumb-bg'] : $default_breadcrumb_image_url;
		$position = array_key_exists('breadcrumb-bg-position', $settings) ? $settings['breadcrumb-bg-position'] :'center center';
		$repeat = array_key_exists('breadcrumb-bg-repeat', $settings) ? $settings['breadcrumb-bg-repeat'] :'repeat';
		
		$style = $class = '';
		if($bg != '')
			$style .= " background:url($bg) $position $repeat;";
		
		if($bg != '')	
			$class .= array_key_exists('breadcrumb-darkbg', $settings) ? "dark-bg" : "";	
	
		if($breadcrumb_type == "type1"){
			echo '<!-- **Breadcrumb** -->';
			echo '<section class="breadcrumb-section">';
			echo '	<div class="container">';
			new dttheme_breadcrumb;
			get_search_form();
			echo '	</div>';
			echo '</section><!-- **Breadcrumb** -->';
		}else{
			echo '<!-- ** Breadcrumb Section ** -->';
			echo '<section class="breadcrumb-section type2 '.$class.'"  style="'.$style.'">';
			echo '  <div class="container">';
			echo '     <div class="main-title-section">';
							if ( is_front_page() && is_home() ) {
			echo "				<h1>".get_bloginfo('description')."</h1>";
							} else {
			echo "				<h1>{$title}</h1>";
							}
			echo '     </div>';
					   get_search_form();
			echo '  </div>';
			if(!isset($disable_breadcrumb)) { new dttheme_breadcrumb; }
			echo '</section>';
		}
	
	endif;	
 }
}


if (!function_exists('dttheme_breadcrumb_custom_subtitle_section')) {
  function dttheme_breadcrumb_custom_subtitle_section( $title, $class){
		$disable_breadcrumb = dttheme_option('general','disable-breadcrumb');
	
		$breadcrumb_type = dttheme_option('general','breadcrumb-type');
		
		$default_breadcrumb_image_url = dttheme_option('general', 'breadcrumb-image-url');
        $default_breadcrumb_image_url = !empty( $default_breadcrumb_image_url ) ? $default_breadcrumb_image_url : IAMD_BASE_URL.'images/breadcrumb-default-bg.jpg'; 
							
		$style = '';
		if($default_breadcrumb_image_url != '')
			$style .= " background:url($default_breadcrumb_image_url) center center repeat;";
		
		if($breadcrumb_type == "type1"){
			echo '<!-- **Breadcrumb** -->';
			echo '<section class="breadcrumb-section">';
			echo '	<div class="container">';
			new dttheme_breadcrumb;
			get_search_form();
			echo '	</div>';
			echo '</section><!-- **Breadcrumb** -->';
		}else{
			echo '<!-- ** Breadcrumb Section ** -->';
			echo '<section class="breadcrumb-section type2" style="'.$style.'">';
			echo '  <div class="container">';
			echo '     <div class="main-title-section">';
							if ( is_front_page() && is_home() ) {
			echo "				<h1>".get_bloginfo('description')."</h1>";
							} else {
			echo "				<h1>{$title}</h1>";
							}
			echo '     </div>';
					   get_search_form();
			echo '  </div>';
			if(!isset($disable_breadcrumb)) { new dttheme_breadcrumb; }
			echo '</section>';
		}
  }
}
//new breadcrumb

if (!function_exists('dttheme_title_section')) {
  function dttheme_title_section($id=0,$type,$settings = array() ){
	
	if( $id > 0 ){

		$title = get_the_title($id);

		if( $type === "post" )
			$settings = '_dt_post_settings';
		elseif( $type === "page" )
			$settings = '_tpl_default_settings';
		elseif( $type === "dt_portfolios" )
			$settings = '_portfolio_settings';

		$settings = get_post_meta( $id, $settings, TRUE );
		$settings = is_array($settings) ? $settings : array();
	}

	if ( !array_key_exists('show_slider', $settings) ) :		
	
		echo "<div class='container'>";
		echo '	<h1 class="hr-title dt-page-title">';
		echo '		<span>';
		echo "			{$title}";
		echo '		</span>';					
		echo '	</h1>';
		echo '</div>';
	endif;	
  }
}

function dttheme_custom_subtitle_section( $title ){
		echo "<div class='container'>";
		echo '	<h1 class="hr-title dt-page-title">';
		echo '		<span>';
		echo "			{$title}";
		echo '		</span>';					
		echo '	</h1>';
		echo '</div>';
}



/** dttheme_excerpt()
 * Objective:
 *		To produce the excerpt for the posts.
 **/
if (!function_exists('dttheme_excerpt')) {
 function dttheme_excerpt($limit = NULL) {
	$limit = !empty($limit) ? $limit : 10;
	
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	$excerpt = array_filter($excerpt);
	
	if (!empty($excerpt)) {
		if (count($excerpt) >= $limit) {
			array_pop($excerpt);
			$excerpt = implode(" ", $excerpt).'...';
		} else {
			$excerpt = implode(" ", $excerpt);
		}
		$excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
		return "<p>{$excerpt}</p>";
	}
 }
}
### --- ****  dttheme_excerpt() *** --- ###

/** dttheme_custom_comments()
 * Objective:
 *		To customize the post/page comments view.
 **/
if (!function_exists('dttheme_custom_comments')) {
 function dttheme_custom_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	switch ($comment->comment_type ) :
	case 'pingback':
	case 'trackback':
		echo '<li class="post pingback">';
		echo "<p>";
		_e('Pingback:', 'spalab');
		comment_author_link();
		edit_comment_link(__('Edit', 'spalab'), ' ', '');
		echo "</p>";
		break;

	default:
	case '':
		echo "<li ";
		comment_class();
		echo ' id="li-comment-';
		comment_ID();
		echo '">';
		echo '<article class="comment" id="comment-';
		comment_ID();
		echo '">';

		echo '<header class="comment-author">'.get_avatar($comment, 81).'</header>';

		echo '<section class="comment-details">';
		echo '	<div class="author-name"><span class="fa fa-user"></span>'.ucfirst(get_comment_author_link()).'</div>';
		echo '	<div class="commentmetadata">'.get_comment_date('d M Y').'</div>';
		echo '  <div class="comment-body">';
		echo '		<div class="comment-content">';
		comment_text();
		if ($comment->comment_approved == '0') :
			_e('Your comment is awaiting moderation.', 'spalab');
		endif;
		edit_comment_link(__('Edit', 'spalab'));
		echo '		</div>';
		echo '	</div>';
		echo '	<div class="reply">';
		echo comment_reply_link(array_merge($args, array('reply_text' => __('Reply', 'spalab'),
			'depth' => $depth, 'max_depth' => $args['max_depth'])));

		echo '	</div>';
		echo '</section>';
		echo '</article><!-- .comment-ID -->';
		break;
	endswitch;
 }
}
### --- ****  dttheme_custom_comments() *** --- ###

#BREADCRUMB
class dttheme_breadcrumb {
	var $options;

	function __construct(){
		
		$delimiter =  'fa '.dttheme_option('general', 'breadcrumb-delimiter');
		$this->options = array( 'before' => "<span class='${delimiter}' > ",'after' => ' </span>');
		$markup = $this->options['before'].$this->options['after'];
		
		$breadcrumb_type = dttheme_option('general','breadcrumb-type');
		
		global $post;
		
		echo '<div class="breadcrumb"> <div class="container">';
			if($breadcrumb_type == "type2"){
				echo '
						<span class="simpletext">'.__("You are here:","spalab").'</span>';
			}
				echo '	<a href="'.home_url().'">'.__('Home','spalab').'</a>';
				
			if( !is_front_page() && !is_home()) {
				echo ( $markup );
			}
			
			$output = $this->simple_breadcrumb_case($post);

		if ( is_page() || is_single() ) {
			echo "<h6>";
					the_title();
			echo "</h6>";
			
		}elseif( $output !== NULL ){
			echo "<h6>".$output."</h6>";
		}else {
			$title =  (get_option( 'page_for_posts' ) > 0) ? get_the_title( get_option( 'page_for_posts' ))  :NULL;
			echo ( $markup );
			echo "<h6>".$title."</h6>";
			
		}
		//if($breadcrumb_type == "type2"){ echo " </div>"; }
		echo "</div> </div><!-- ** breadcrumb - End -->";
	}
	
	function simple_breadcrumb_case($der_post){
		$markup = $this->options['before'].$this->options['after'];
		if (is_page()){
			 if($der_post->post_parent) {
				 $my_query = get_post($der_post->post_parent);			 
				 $this->simple_breadcrumb_case($my_query);
				 $link = '<a href="'.get_permalink($my_query->ID).'">';
				 $link .= ''. get_the_title($my_query->ID) . '</a>'. $markup;
				 echo ( $link );
			 }
		return;	 	
		} 

		if(is_single()){
			$category = get_the_category();
			if (is_attachment()){
				$my_query = get_post($der_post->post_parent);			 
				$category = get_the_category($my_query->ID);
				if( isset($category[0])) {
					$ID = $category[0]->cat_ID;
					echo get_category_parents($ID, TRUE, $markup, FALSE );
					previous_post_link("%link $markup");
				}
				
				
			}else{
				$postType = get_post_type();

				if($postType == 'post')	{
					if(isset($category[0]->cat_ID)) {
						$ID = $category[0]->cat_ID;
						echo get_category_parents($ID, TRUE,$markup, FALSE );
					} 
					
				} else if($postType == 'dt_portfolios') {
					global $post;
					$terms = get_the_term_list( $post->ID, 'portfolio_entries', '', '$$$', '' );
					$terms =  array_filter(explode('$$$',$terms));
					if( !empty($terms)):
						echo ( $terms[0].$markup );
				    endif;
					
				} else if($postType == 'product') {
					global $post;
					$terms = get_the_term_list( $post->ID, 'product_cat', '', '$$$', '' );
					$terms =  array_filter(explode('$$$',$terms));
					if( !empty($terms)):
						echo ( $terms[0].$markup );
				    endif;
				} 
			}
		return;
		}

		if(is_tax()){
			  $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			  $parent = get_term($term->parent, get_query_var('taxonomy') );
			  
			  if(isset($parent->name)){
				  $result = $parent->name.$markup.$term->name;
			  }else{
				  $result = $term->name;
			  }
			  
  			  return __("Archive for Tax: ",'spalab').$result;
		}

		if(is_category()){
			$category = get_the_category(); 
			$i = $category[0]->cat_ID;
			$parent = $category[0]-> category_parent;
			if($parent > 0 && $category[0]->cat_name == single_cat_title("", false)){
				echo get_category_parents($parent, TRUE, $markup, FALSE);
			}
		return __("Archive for Category: ",'spalab').single_cat_title('',FALSE);
		}

		if(is_author()){
			$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
			return __("Archive for Author: ",'spalab').$curauth->nickname;
		}

		if(is_tag()){ return __("Archive for Tag: ",'spalab').single_tag_title('',FALSE); }

		if(is_404()){ return __("LOST",'spalab'); }

		if(is_search()){ return __("Search",'spalab'); }	

		if(is_year()){ return get_the_time('Y'); }

		if(is_month()){
			$k_year = get_the_time('Y');
			echo "<a href='".get_year_link($k_year)."'>".$k_year."</a>".$markup;
			return get_the_time('F'); 
		}

		if(is_day() || is_time()){ 
			$k_year = get_the_time('Y');
			$k_month = get_the_time('m');
			$k_month_display = get_the_time('F');
			echo "<a href='".get_year_link($k_year)."'>".$k_year."</a>".$markup;
			echo "<a href='".get_month_link($k_year, $k_month)."'>".$k_month_display."</a>".$markup;
		return get_the_time('jS (l)'); 
		}
		
		if(is_post_type_archive('product')){
			return 'Products';
		}
		
	}
}


#END OF BREADCRUMB
####################################

#MyTheme Color Picker
if (!function_exists('dttheme_color_picker')) {
  function dttheme_color_picker(){

	$patterns_url = IAMD_FW_URL."theme_options/images/pattern/";
	$skins_url = IAMD_BASE_URL."images/style-picker/";
	
	$patterns = "";
	$patterns_array =  dttheme_listImage(TEMPLATEPATH."/images/style-picker/patterns/");
	
	foreach($patterns_array as $k => $v){
		$img = 	IAMD_BASE_URL."images/style-picker/patterns/".$k;
		$patterns .= '<li>';
		$patterns .= "<a data-image='{$k}' href='' title=''>";
		$patterns .= "<img src='$img' alt='$v' title='$v' width='30' height='30' />";
		$patterns .= '</a>';
		$patterns .= '</li>'; 
	}
	
	$colors = "";
	foreach(getFolders(get_template_directory()."/skins") as $skin ):
		$img = 	$skins_url.$skin.".jpg";
		$colors .= '<li>';
		$colors .= '<a id="'.$skin.'" href="" title="">';
		$colors .= '<img src="'.$img.'" alt="color-'.$skin.'" title="color-'.$skin.'"/>';
		$colors .= '</a>';
		$colors .= '</li>';
	endforeach;
	
	$str = '<!-- **Delicate Style Picker Wrapper** -->';
	$str .= '<div class="delicate-style-picker-wrapper">';
	$str .= '	<a href="" title="" class="style-picker-ico"> <img src="'.IAMD_BASE_URL.'images/style-picker/picker-icon.png" alt="" title="" class="rotating" /> </a>';
	$str .= '	<div id="delicate-style-picker">';
	$str .= '   	<h2>'.__('Select Your Style','spalab').'</h2>';
	
	$str .= '       <h3>'.__('Choose your layout','spalab').'</h3>';
	$str .= '		<ul class="layout-picker">';
	$str .= '       	<li> <a id="fullwidth" href="" title="" class="selected"> <img src="'.IAMD_BASE_URL.'images/style-picker/fullwidth.jpg" alt="" title="" /> </a> </li>';
	$str .= '       	<li> <a id="boxed" href="" title=""> <img src="'.IAMD_BASE_URL.'images/style-picker/boxed.jpg" alt="" title="" /> </a> </li>';
	$str .= '		</ul>';
	$str .= '		<div class="hr"> </div>';
	$str .= '		<div id="pattern-holder" style="display:none;">';
	$str .='			<h3>'.__('Patterns for Boxed Layout','spalab').'</h3>';
	$str .= '			<ul class="pattern-picker">';
	$str .= 				$patterns;
	$str .= '			</ul>';
	$str .= '			<div class="hr"> </div>';
	$str .= '		</div>';
	
	$str .= '		<h3>'.__('Color scheme','spalab').'</h3>';
	$str .= '		<ul class="color-picker">';
	$str .= 		$colors;
	$str .= '		</ul>';
	
	$str .= '	</div>';
	$str .= '</div><!-- **Delicate Style Picker Wrapper - End** -->';
	
echo ( $str );
  }
}

# Data Validation
global $dt_allowed_html_tags;
$dt_allowed_html_tags = array(
	'a' => array('class' => array(), 'href' => array(), 'title' => array(), 'target' => array()),
	'abbr' => array('title' => array()),
	'address' => array(),
	'area' => array('shape' => array(), 'coords' => array(), 'href' => array(), 'alt' => array()),
	'article' => array(),
	'aside' => array(),
	'audio' => array('autoplay' => array(), 'controls' => array(), 'loop' => array(), 'muted' => array(), 'preload' => array(), 'src' => array()),
	'b' => array(),
	'base' => array('href' => array(), 'target' => array()),
	'bdi' => array(),
	'bdo' => array('dir' => array()), 
	'blockquote' => array('cite' => array()), 
	'br' => array(),
	'button' => array('autofocus' => array(), 'disabled' => array(), 'form' => array(), 'formaction' => array(), 'formenctype' => array(), 'formmethod' => array(), 'formnovalidate' => array(), 'formtarget' => array(), 'name' => array(), 'type' => array(), 'value' => array()),
	'canvas' => array('height' => array(), 'width' => array()),
	'caption' => array('align' => array()),
	'cite' => array(),
	'code' => array(),
	'col' => array(),
	'colgroup' => array(),
	'datalist' => array('id' => array()),
	'dd' => array(),
	'del' => array('cite' => array(), 'datetime' => array()),
	'details' => array('open' => array()),
	'dfn' => array(),
	'dialog' => array('open' => array()),
	'div' => array('class' => array(), 'id' => array(), 'align' => array()),
	'dl' => array(),
	'dt' => array(),
	'em' => array(),
	'embed' => array('height' => array(), 'src' => array(), 'type' => array(), 'width' => array()),
	'fieldset' => array('disabled' => array(), 'form' => array(), 'name' => array()),
	'figcaption' => array(),
	'figure' => array(),
	'form' => array('accept' => array(), 'accept-charset' => array(), 'action' => array(), 'autocomplete' => array(), 'enctype' => array(), 'method' => array(), 'name' => array(), 'novalidate' => array(), 'target' => array(), 'id' => array(), 'class' => array()),
	'h1' => array('class' => array()), 'h2' => array('class' => array()), 'h3' => array('class' => array()), 'h4' => array('class' => array()), 'h5' => array('class' => array()), 'h6' => array('class' => array()),
	'hr' => array(), 
	'i' => array('class' => array()), 
	'iframe' => array('name' => array(), 'seamless' => array(), 'src' => array(), 'srcdoc' => array(), 'width' => array()),
	'img' => array('alt' => array(), 'crossorigin' => array(), 'height' => array(), 'ismap' => array(), 'src' => array(), 'usemap' => array(), 'width' => array()),
	'input' => array('align' => array(), 'alt' => array(), 'autocomplete' => array(), 'autofocus' => array(), 'checked' => array(), 'disabled' => array(), 'form' => array(), 'formaction' => array(), 'formenctype' => array(), 'formmethod' => array(), 'formnovalidate' => array(), 'formtarget' => array(), 'height' => array(), 'list' => array(), 'max' => array(), 'maxlength' => array(), 'min' => array(), 'multiple' => array(), 'name' => array(), 'pattern' => array(), 'placeholder' => array(), 'readonly' => array(), 'required' => array(), 'size' => array(), 'src' => array(), 'step' => array(), 'type' => array(), 'value' => array(), 'width' => array(), 'id' => array(), 'class' => array()),
	'ins' => array('cite' => array(), 'datetime' => array()),
	'label' => array('for' => array(), 'form' => array()),
	'legend' => array('align' => array()), 
	'li' => array('type' => array(), 'value' => array(), 'class' => array()),
	'link' => array('crossorigin' => array(), 'href' => array(), 'hreflang' => array(), 'media' => array(), 'rel' => array(), 'sizes' => array(), 'type' => array()),
	'main' => array(), 
	'map' => array('name' => array()), 
	'mark' => array(), 
	'menu' => array('label' => array(), 'type' => array()),
	'menuitem' => array('checked' => array(), 'command' => array(), 'default' => array(), 'disabled' => array(), 'icon' => array(), 'label' => array(), 'radiogroup' => array(), 'type' => array()),
	'meta' => array('charset' => array(), 'content' => array(), 'http-equiv' => array(), 'name' => array()),
	'object' => array('form' => array(), 'height' => array(), 'name' => array(), 'type' => array(), 'usemap' => array(), 'width' => array()),
	'ol' => array('class' => array(), 'reversed' => array(), 'start' => array(), 'type' => array()),
	'p' => array('class' => array()), 
	'q' => array('cite' => array()), 
	'section' => array(), 
	'select' => array('autofocus' => array(), 'disabled' => array(), 'form' => array(), 'multiple' => array(), 'name' => array(), 'required' => array(), 'size' => array()),
	'small' => array(), 
	'source' => array('media' => array(), 'src' => array(), 'type' => array()),
	'span' => array('class' => array()), 
	'strong' => array(),
	'style' => array('media' => array(), 'scoped' => array(), 'type' => array()),
	'sub' => array(),
	'sup' => array(),
	'table' => array('sortable' => array()), 
	'tbody' => array(), 
	'td' => array('colspan' => array(), 'headers' => array()),
	'textarea' => array('autofocus' => array(), 'cols' => array(), 'disabled' => array(), 'form' => array(), 'maxlength' => array(), 'name' => array(), 'placeholder' => array(), 'readonly' => array(), 'required' => array(), 'rows' => array(), 'wrap' => array()),
	'tfoot' => array(),
	'th' => array('abbr' => array(), 'colspan' => array(), 'headers' => array(), 'rowspan' => array(), 'scope' => array(), 'sorted' => array()),
	'thead' => array(), 
	'time' => array('datetime' => array()), 
	'title' => array(), 
	'tr' => array(), 
	'track' => array('default' => array(), 'kind' => array(), 'label' => array(), 'src' => array(), 'srclang' => array()), 
	'u' => array(), 
	'ul' => array('class' => array()), 
	'var' => array(), 
	'video' => array('autoplay' => array(), 'controls' => array(), 'height' => array(), 'loop' => array(), 'muted' => array(), 'muted' => array(), 'poster' => array(), 'preload' => array(), 'src' => array(), 'width' => array()), 
	'wbr' => array(), 
);
# Data Validation END
?>