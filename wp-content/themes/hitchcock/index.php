<?php get_header(); ?>
<link href='http://fonts.googleapis.com/css?family=Archivo+Narrow&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="//ciasteczka.eu/cookiesEU-latest.min.js"></script>

<div class="content section-inner">
																	                    
	<?php if ( have_posts() ) : ?>
	
		<?php
		
		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		
		if ( 1 < $paged ) : ?>
		
			<div class="page-title">
			
				<h4><?php printf( __( 'Page %1$s of %2$s', 'hitchcock' ), $paged, $wp_query->max_num_pages ); ?></h4>
				
			</div><!-- .page-title -->
			
			<div class="clear"></div>
		
		<?php endif; ?>
	
		<div class="posts" id="posts">
				
			<?php 
			while ( have_posts() ) : the_post();
	    	
	    		get_template_part( 'content', get_post_format() );
	    		
			endwhile; 
			?>
	        
	        <div class="clear"></div>
				
		</div><!-- .posts -->
		
	<?php endif; ?>
	
	<div class="clear"></div>
	
	<?php hitchcock_archive_navigation(); ?>
		
</div><!-- .content -->
	              	        <script type="text/javascript">

jQuery(document).ready(function(){
	jQuery.fn.cookiesEU();
});

</script>
<?php get_footer(); ?>