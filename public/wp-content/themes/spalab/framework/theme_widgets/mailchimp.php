<?php
/** My Twitter Widget
  * Objective:
  *		1.To list out the latest tweets
**/
class MY_Mailchimp extends WP_Widget {
	
	#1.constructor
	function __construct() {
		$widget_options = array("classname"=>'mailchimp', 'description'=>__('Use this widget to add a mailchimp newsletter to your site.', 'spalab'));
		parent::__construct(false,IAMD_THEME_NAME.__(' Mailchimp Newsletter Widget','spalab'),$widget_options);
	}
	
	#2.widget input form in back-end
	function form($instance) {
		
		$mailchimp_file_path = IAMD_CORE_PLUGIN.'/apis/mailchimp/mailchimp.php';
		if(file_exists($mailchimp_file_path)){
			require_once IAMD_CORE_PLUGIN.'/apis/mailchimp/mailchimp.php';
		}

		$instance = wp_parse_args( (array) $instance,array( 'title' => "", "list_id" => "") );
		
		$title 		= 	empty($instance['title']) ?	'' : strip_tags($instance['title']);
		$desc 		= 	empty($instance['desc']) ?	'' : strip_tags($instance['desc']);
		$list_id 	=	empty($instance['list_id']) ? '' : strip_tags($instance['list_id']);
		
		if( dttheme_option('general','mailchimp-key') ):

			$apiKey = dttheme_option('general','mailchimp-key');
			$lists = dt_theme_mailchimp_list_ids($apiKey); ?>

            <p><label for="<?php echo ( $this->get_field_id('title') ); ?>"><?php _e('Title:','spalab');?> 
               <input class="widefat" id="<?php echo ( $this->get_field_id('title') ); ?>" name="<?php echo ( $this->get_field_name('title') ); ?>"  
                      type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
                      
            <p><label for="<?php echo ( $this->get_field_id('desc') ); ?>"><?php _e('Description:','spalab');?>
               <textarea class="widefat" id="<?php echo ( $this->get_field_id('desc') ); ?>" name="<?php echo ( $this->get_field_name('desc') ); ?>" ><?php echo esc_attr($desc); ?></textarea>	 
               </label></p>
               
            <p><label for="<?php echo ( $this->get_field_id('list_id') ); ?>"><?php _e('Select List:','spalab'); ?></label>
               <select id="<?php echo ( $this->get_field_id('list_id') ); ?>" name="<?php echo ( $this->get_field_name('list_id') );?>">
               <?php foreach ($lists as $key => $value):
			   			$id = $value['id'];
						$name = $value['name'];
						$selected = ( $list_id == $id ) ? ' selected="selected" ' : '';
						echo "<option $selected value='$id'>$name</option>";
					 endforeach;?></select></p>
                      
<?php   else:
			echo "<p>".__("Paste your mailchimp api key in BPanel at General Settings tab",'spalab')."</p>";
		endif;
	}
	
	#3.processes & saves the mailchimp widget option
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['desc']  = strip_tags($new_instance['desc']);
		$instance['list_id'] = strip_tags($new_instance['list_id']);
		return $instance;
	}
	
	#4.output in front-end
	function widget($args, $instance) {
		extract($args);
		echo ( $before_widget );
		$title = empty($instance['title']) ? '' : strip_tags($instance['title']);
		$title = apply_filters( 'widget_title', $title );
		$desc = empty($instance['desc']) ? '' : strip_tags($instance['desc']);
		$desc = apply_filters( 'widget_title', $desc );
		$list_id = $instance['list_id'];
		
		if ( !empty( $title ) ) echo ( $before_title.$title.$after_title );
		
		if ( !empty( $desc ) ) echo "<p>$desc</p>";

		$mcapi = dttheme_option('general','mailchimp-key');

		echo '<p>'.__('Subscribe to your newsletter for latest offers and discounts. We will not spam you.', 'spalab').'</p>';

		echo '<form name="frmsubscribe" method="post" class="subscribe-frm">';
		echo '<input type="email" required name="dt_mc_emailid" id="dt_mc_emailid" placeholder="'.__('Enter Email', 'spalab').'" />';
		echo "	<input type='hidden' name='dt_mc_apikey' id='dt_mc_apikey' value='$mcapi' />";
		echo "	<input type='hidden' name='dt_mc_listid' id='dt_mc_listid' value='$list_id' />";
		echo '<input type="submit" name="submit" class="dt-sc-button small" value="'.__('Subscribe', 'spalab').'" />';
		echo '</form>';

		echo '<div id="ajax_newsletter_msg"></div>';
		
		echo ( $after_widget );		
	}
}?>