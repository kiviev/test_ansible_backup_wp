    <div id="bbar-wrapper" class="type4">
    	<div id="bbar-body">
        	<div class="container">
            	<div class="column dt-sc-one-half first"><?php 
				global $dt_allowed_html_tags;
				$top_msg = stripslashes(dttheme_option('general','top-message'));
					echo wp_kses(do_shortcode($top_msg), $dt_allowed_html_tags );
					?></div>
                <div class="column dt-sc-one-half alignright"><?php
					if (function_exists('wp_nav_menu')) :
						$topMenu = wp_nav_menu(array('theme_location'=>'top_menu','menu_id'=>'','menu_class'=>'top-menu','echo'=>false,'container'=>false,'depth' => 1, 'fallback_cb'=>'dttheme_default_navigation'));
                    endif;
                    if(!empty($topMenu)) echo ( $topMenu );?></div>
            </div>
        </div>
        <span class="bbar-divider"></span>
    </div>