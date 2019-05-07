<?php $tpl_default_settings = get_post_meta($post->ID,'_dt_post_settings',TRUE);
	  $tpl_default_settings = is_array($tpl_default_settings) ? $tpl_default_settings  : array();
	  
	  $dttheme_options = get_option(IAMD_THEME_SETTINGS);
	  $dttheme_general = $dttheme_options['general'];
	  $globally_enable_single_post_layout =  array_key_exists('disable-page-layout-single-post',$dttheme_general) ? true : false;
	  
	  if($globally_enable_single_post_layout){
		  $globally_single_post_layout  = dttheme_option( 'general', 'global-single-posts-layout' );
		  $post_layout = !empty( $globally_single_post_layout ) ? $globally_single_post_layout : "content-full-width";
	  }else{
		  $post_layout = array_key_exists("layout",$tpl_default_settings) ? $tpl_default_settings['layout'] : "content-full-width";
	  }
	  
  	  $show_sidebar = false;
	  $sidebar_class= "";
	  $featured_img = array_key_exists("disable-featured-image",$tpl_default_settings) ? false : true;
	  $format = get_post_format(  $post->ID );
	  
		  switch($post_layout):
			case 'with-left-sidebar':
				$post_layout 	=	"with-left-sidebar";
				$show_sidebar 	= 	true;
				$sidebar_class 	=	"left-sidebar";
			break;
			
			case 'with-right-sidebar':
				$show_sidebar 	= 	true;
			break;
		  endswitch;
	  
	$hide_date_meta = isset( $tpl_default_settings['disable-date-info'] ) ? " hidden " : "";
	$hide_comment_meta = isset( $tpl_default_settings['disable-comment-info'] ) ? " hidden " : " comments ";
	
	$hide_author_meta = isset( $tpl_default_settings['disable-author-info'] ) ? " hidden " : "";
	$hide_category_meta = isset( $tpl_default_settings['disable-category-info'] ) ? " hidden " : "";
	$hide_tag_meta = isset( $tpl_default_settings['disable-tag-info'] ) ? " hidden " : "tags";
	$hide_author_desc_meta = isset( $tpl_default_settings['disable-author-desc-info'] ) ? " hidden " : "";?>
        <!-- **Primary Section** -->
        <section id="primary" class="<?php echo esc_attr( $post_layout );?>">
            <!-- #post-<?php the_ID()?> starts -->
            <article id="post-<?php the_ID(); ?>" <?php post_class('blog-entry'); ?>>
            
            	<div class="blog-entry-inner">
                
                	<div class="entry-meta">
                    	<a href="<?php the_permalink();?>" title="<?php printf(esc_attr__('%s','spalab'),the_title_attribute('echo=0'));?>" class="entry_format"> </a>
                        <div class="date <?php echo esc_attr( $hide_date_meta );?>">
                        	<p> <?php echo get_the_date('M').' '.get_the_date('d');?> <span> <?php echo get_the_date('Y'); ?> </span> </p>
                        </div>
                        <?php comments_popup_link( __('<span class="fa fa-comments"> </span> 0','spalab'), __('<span class="fa fa-comments"> </span> 1','spalab'),
							  '<span class="fa fa-comments"> </span> % ',$hide_comment_meta ,__('<span class="fa fa-comments-o"> </span>','spalab'));?> 
                    </div><!-- .entry-meta -->
                    
                    <div class="entry-thumb">
					  <?php $post_meta = get_post_meta(get_the_id() ,'_dt_post_settings',TRUE);
                            $post_meta = is_array($post_meta) ? $post_meta  : array();
							
							$dttheme_options = get_option(IAMD_THEME_SETTINGS);
	  		  				$dttheme_general = $dttheme_options['general']; 
							$enable_placeholder =  array_key_exists('disable-posts-placeholder',$dttheme_general) ? true : false; ?>
                            
                          <?php if( $format === "image" || empty($format) ): ?>
                                    <a href="<?php the_permalink();?>" title="<?php printf(esc_attr__('%s','spalab'),the_title_attribute('echo=0'));?>">
                              <?php if($featured_img && has_post_thumbnail() ){ 
                                       the_post_thumbnail("full");
							  		}else {  
										if($enable_placeholder){ ?>
                                       		<img src="http<?php dt_ssl(); ?>://placehold.it/1060x636&text=Image" alt="<?php printf(esc_attr__('%s','spalab'),the_title_attribute('echo=0'));?>" title="<?php printf(esc_attr__('%s','spalab'),the_title_attribute('echo=0'));?>" />
                              <?php 	} 
							  		} ?>
                                    </a> 
                      <?php elseif( $format === "gallery" ):
                              if( array_key_exists("items", $post_meta) ):
                                  echo "<ul class='entry-gallery-post-slider'>";
                                  foreach ( $post_meta['items'] as $item ) {
									  echo "<li><img src='{$item}' alt='blog-gal-image' /></li>";
								  }
                                  echo "</ul>";
                              endif;
          
                            elseif( $format === "video" ):
                               if( array_key_exists('oembed-url', $post_meta) || array_key_exists('self-hosted-url', $post_meta) ):
                                  if( array_key_exists('oembed-url', $post_meta) ):
                                       echo "<div class='dt-video-wrap'>".wp_oembed_get($post_meta['oembed-url']).'</div>';
                                   elseif( array_key_exists('self-hosted-url', $post_meta) ):
                                        echo "<div class='dt-video-wrap'>".apply_filters( 'the_content', $post_meta['self-hosted-url'] ).'</div>';
                                   endif;
                                endif;
                                
                            elseif( $format === "audio" ):
                                if( array_key_exists('oembed-url', $post_meta) || array_key_exists('self-hosted-url', $post_meta) ):
                                    if( array_key_exists('oembed-url', $post_meta) ):
                                        echo wp_oembed_get($post_meta['oembed-url']);
                                    elseif( array_key_exists('self-hosted-url', $post_meta) ):
                                        echo apply_filters( 'the_content', $post_meta['self-hosted-url'] );
                                    endif;
                                endif;
                            else: ?>
                              <a href="<?php the_permalink();?>" title="<?php printf(esc_attr__('%s','spalab'),the_title_attribute('echo=0'));?>"><?php
                                  if( $featured_img && has_post_thumbnail() ):
                                      the_post_thumbnail("full");
                                  else:
								  	if($enable_placeholder){?>
                                      <img src="http<?php dt_ssl(); ?>://placehold.it/1060x636&text=Image" alt="<?php printf(esc_attr__('%s','spalab'),the_title_attribute('echo=0'));?>" title="<?php printf(esc_attr__('%s','spalab'),the_title_attribute('echo=0'));?>" />
                              <?php } endif;?></a>
                      <?php  endif; ?>
                    </div>            
                    
                    <div class="entry-details">
                    
					  <?php if(is_sticky()): ?>
                        	<div class="featured-post"> <span class="fa fa-trophy"> </span> <?php _e('Featured','spalab');?></div>
                  	  <?php endif;?>
                      
                      	<div class="entry-title">
                      		<h4><a href="<?php the_permalink();?>" title="<?php printf( esc_attr__('%s','spalab'), the_title_attribute('echo=0'));?>"><?php the_title();?></a></h4>
                      	</div>
                        
                        <div class="entry-metadata">
                        
                        	<p class="author <?php echo esc_attr( $hide_author_meta );?>"><span class='fa fa-user'> </span> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID'));?>" title="<?php _e('View all posts by ', 'spalab').get_the_author();?>"><?php echo get_the_author();?></a> </p>
                            
                            <?php the_tags("<p class='{$hide_tag_meta}'><span class='fa fa-tags'> </span> ",', ','</p>');?>
                            
                            <p class="<?php echo esc_attr( $hide_category_meta );?> categories"><span class='fa fa-folder-open'> </span><?php the_category(', '); ?></p>
                            
                        </div><!-- .entry-metadata-->
                        
                        <div class="entry-body"><?php
						
							the_content();
							
							echo '<div class="author-bio '.$hide_author_desc_meta.'"><h4>';
							_e('Author Info','spalab');
							echo 	'</h4><div class="author-details">';							
							echo 		'<div class="image">';
							echo 			get_avatar( get_the_author_meta('user_email'));	
							echo 		'</div>';
							echo		'<h4>'.get_the_author().'</h4>';
										the_author_meta('description'); 
							echo 	'</div>';
							echo '</div>';
							
							wp_link_pages( array(	'before'=>'<div class="page-link">', 'after'=>'</div>', 'link_before'=>'<span>', 'link_after'=>'</span>', 
                                            'next_or_number'=>'number',	'pagelink' => '%', 'echo' => 1 ) );
											
							echo '<div class="social-bookmark">';
								show_fblike('post');
								show_googleplus('post');
								show_twitter('post');
								show_stumbleupon('post');
								show_linkedin('post');
								show_delicious('post');
								show_pintrest('post');
								show_digg('post');
							echo '</div>';
							
							echo '<div class="social-share">';
								dttheme_social_bookmarks('sb-post');
                            echo '</div>';
							
							edit_post_link( __( ' Edit ','spalab' ) );											
											
						?></div>
                    
                    </div><!--.entry-details -->
                     
                </div><!-- .blog-entry-inner -->
                
            </article><!-- #post-<?php the_ID()?> Ends -->
            
            

<?php $dttheme_options = get_option(IAMD_THEME_SETTINGS);
	  $dttheme_general = $dttheme_options['general'];
	  $globally_disable_post_comment =  array_key_exists('global-post-comment',$dttheme_general) ? true : false; 
	  if( (!$globally_disable_post_comment) && (! isset($tpl_default_settings['disable-comment'])) ):?>
            <!-- **Comment Entries** -->   	
            <div class="commententries">
                <?php  comments_template('', true); ?>
            </div><!-- **Comment Entries - End** -->
<?php endif;?>          
             
        </section><!-- **Primary Section** -->
<?php if($show_sidebar): ?>
	  <!-- **Secondary Section ** -->
      <section id="secondary" class="<?php echo esc_attr( $sidebar_class ); ?>">
<?php 	get_sidebar();?>      
      </section><!-- **Secondary Section - End** -->
<?php endif; ?>