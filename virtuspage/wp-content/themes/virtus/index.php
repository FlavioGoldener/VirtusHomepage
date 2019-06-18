<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Unbenanntes Dokument</title>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/reset.css">

<style>

.mainNavLink {
	line-height:46px;
	display:inline-block; 
	margin-left:20px; 
	color:#FFF; 
	font-weight:normal; 
	font-size:20px; 
	font-family: Impact;
	letter-spacing: 1px;
	padding-left:0px; 
	padding-right:0px;
	vertical-align:top;
}

.dropdown{
	visibility: hidden;
}

.dropdown a{
	background-color: #FD0002;
	color:#FFF !important;
}

.mainNavLink:hover .dropdown{
	visibility: visible;
	background-color: #FD0002;
}

.dropdown:hover{
	background-color: #FFF;
	color:#FFF !important;
}

.singleMainNavLink {
	color:#FFF;
	background-color:#FD0002;
	display:inline-block;
	padding-left:10px;
	padding-right:10px;
	width:150px;
}

.singleMainNavLink a {
	padding-left:10px;
}

.singleMainNavLink:hover {
	color:#FD0002;
	background-color:#FFF;
}

.leftNavFocused {
	background-color:rgba(253, 0, 2, .2);
	border-bottom:1px solid black;
}

.leftNavNotFocused {
	background-color:#FFF;
  	border-bottom:1px solid black;
}

p {
	margin-bottom:10px;
}

</style>


</head>

<body>
<div style="width:100vw; position:fixed">
	<div style="position:relative; background-image:url(<?php echo get_template_directory_uri()?>/images/background.jpg); z-index:0">
    	<div style="width:1200px; height:145px; margin:auto; z-index:1;">
        	<img src="<?php echo get_template_directory_uri()?>/images/logos.jpg" alt="" />
            <div style="display:inline-block; height:46px; position:absolute; bottom:0px; line-height:45px; margin-left:20px;">
				<?php
                $main_pages = new WP_Query( array(
                    'post_type'      => 'page', // set the post type to page
                    'posts_per_page' => 10, // number of posts (pages) to show
					'post_parent' => '0',
					'order' => 'ASC',
					'orderby' => 'menu_order',
                    'no_found_rows'  => true, // no pagination necessary so improve efficiency of loop
                ) );
                
                if ( $main_pages->have_posts() ) : while ( $main_pages->have_posts() ) : $main_pages->the_post();
				ob_start();
				the_title();
				$title = ob_get_clean();
				
				ob_start();
				the_permalink();
				$permalink = ob_get_clean();
				
				ob_start();
				the_id();
				$id = ob_get_clean();?>
				
                <div class="mainNavLink">
                <a href="<?php echo($permalink)?>">
                    <span class="singleMainNavLink">
                    <?php echo($title);?>
                    </span>
                </a>
				<?php		
				$child_pages = new WP_Query( array(
                    'post_type'      => 'page', // set the post type to page
                    'posts_per_page' => 10, // number of posts (pages) to show
					'post_parent' => $id,
					'order' => 'ASC',
					'orderby' => 'menu_order',
                    'no_found_rows'  => true, // no pagination necessary so improve efficiency of loop
                ) );
				
				if ( $child_pages->have_posts() ) : while ( $child_pages->have_posts() ) : $child_pages->the_post();?>
                
                <div class="dropdown">
                <a href="<?php the_permalink(); ?>">
                	<span class="singleMainNavLink">
                		<?php the_title();?>
                    </span>
                </a>
                </div>
                <?php
				endwhile; endif;  
                    echo('</div><!--
                 -->');
				 //the_title()
                    // Do whatever you want to do for every page. the_title(), the_permalink(), etc...
                endwhile; endif;  
                
                wp_reset_postdata();
                ?>
            </div>
    	</div>
    	<div style="position:absolute; bottom:0px; width:100vw; background-color:#FD0002; height:46px; z-index:-1">
        </div>
 
    </div>
    
    <div style="width:1200px; margin:auto">
    	<div style="width:200px; margin-top:100px">
        	<?php	
				ob_start();
				the_title();
				$title = ob_get_clean();
				
				ob_start();
				the_id();
				$currentId = ob_get_clean();
				
				if(wp_get_post_parent_id( $currentId ) != 0) {
					$parentId = wp_get_post_parent_id( $currentId );
				}
				else {
					$parentId = $currentId;
				}
				
				$parentTitle = get_the_title( $parentId );
					
				$child_pages = new WP_Query( array(
                    'post_type'      => 'page', // set the post type to page
                    'posts_per_page' => 10, // number of posts (pages) to show
					'post_parent' => $parentId,
					'order' => 'ASC',
					'orderby' => 'menu_order',
                    'no_found_rows'  => true, // no pagination necessary so improve efficiency of loop
                ) );
				
				?>
				
				<div style="background-color:#FD0002; height:30px; line-height:30px; color:#FFF; margin-bottom:10p; padding-left:5px">
                	<?php echo($parentTitle);?>
				</div>
				<?php
				
				if ( $child_pages->have_posts() ) : while ( $child_pages->have_posts() ) : $child_pages->the_post();?>
                
                <?php ob_start();
				the_id();
				$childId = ob_get_clean();?>
                
                <?php 
					if($childId == $currentId) {
						$className = 'leftNavFocused';
					}
					else {
						$className = 'leftNavNotFocused';
					}
				?>
                
                <div style="height:30px; line-height:30px; padding-left:10px" class="<?php echo($className)?>">
               	 <a href="<?php the_permalink(); ?>" style="color:#FD0002; text-decoration:none">
                 	<?php the_title();?>
                 </a>
                </div>
                
                <?php
				endwhile; endif;  
				?>
        </div>
    </div>
</div>

<div style="width:1200px; margin:auto; padding-top:150px">
	<div style="margin-left:250px; margin-top:20px">
    	<div style="width:200px; height:30px; background-color: #FD0002; line-height:30px; color:#FFF">
        	<?php	
				$currentTitle = get_the_title($currentId);
				echo($currentTitle);
			?>
   		</div>
        <br />
        <hr />
			<?php	
				$currentPage = get_page($currentId);
				echo($currentPage->post_content);
            ?>
    </div>
	<?php
    echo $post->post_content;
	?>
</div>
</body>
</html>
