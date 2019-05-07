<?php get_header();?>
<?php $page_layout =  dttheme_option('specialty','404-layout');
	  $show_sidebar = false;
	  $show_sidebar = $show_left_sidebar = $show_right_sidebar =  false;
	  
	switch($page_layout):
		case 'full-width':
			$page_layout 	= 	"content-full-width";
		break;
		
		case 'with-left-sidebar':
			$page_layout 	=	"with-left-sidebar";
			$show_sidebar 	= 	true;
			$sidebar_class 	=	"left-sidebar";
		break;
		
		case 'with-right-sidebar':
			$show_sidebar 	= 	true;
		break;		
	endswitch;  ?>
    
      <!-- **Primary Section** -->
      <section id="primary" class="<?php echo esc_attr( $page_layout ); ?>">
        <div class="error-info">
          <div class="error-info-content">
       		<?php global $dt_allowed_html_tags;
				  echo wp_kses(stripcslashes(dttheme_option('specialty','404-message')), $dt_allowed_html_tags ); ?>
                                            
            <a href="<?php echo home_url();?>" title="" class="dt-sc-button small"><?php _e('Back to Home','spalab');?> <i class="fa fa-home"></i></a> 
          </div>
        </div>
      </section><!-- **Primary Section** -->
        
<?php if($show_sidebar): ?>
	  <!-- **Secondary Section ** -->
      <section id="secondary" class="<?php echo esc_attr( $sidebar_class ); ?>">
<?php 	get_sidebar();?>      
      </section><!-- **Secondary Section - End** -->
<?php endif; ?>
    
<?php get_footer();?>