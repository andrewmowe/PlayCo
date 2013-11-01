<?php get_header(); ?>

	<div class="subhead-content"><div class="centerwrap">
		<?php
		$plays_pages = get_option('t8_options_two_plays_pages');
		echo apply_filters('the_content', stripslashes($plays_pages['t8_archive_message']));
// echo '<pre>';
// print_r($plays_pages);
// echo '</pre>';
		?>
	</div></div>
	
	<div class="centerwrap">

<?php
				$seasons = get_terms('seasons');
				
				function sort_by_slug($a, $b) {
				  return $b->slug - $a->slug;
				}


				usort($seasons, "sort_by_slug");				
// echo '<pre>';
// print_r($seasons);
// echo '</pre>';	

				foreach($seasons as $season) {
					$season_query = new WP_Query( array(
						'post_type' => 'plays',
						'order' => 'ASC',
						'tax_query' => array(
							array(
								'taxonomy' => 'seasons',
								'field' => 'slug',
								'terms' => array( $season->slug ),
								'operator' => 'IN'
							)
						),
						'meta_key' => 'start_date',
						'orderby' => 'meta_value_num',
					) );
// echo '<pre>';
// print_r($season_query);
// echo '</pre>';	
    			?>
    				<?php if($season->slug != 'current-season') { ?>
						<div class="arch-head">
							<div class="arch-text"><h4><?php echo $season->name; ?></h4></div>
							<a class="arch-expand" href=""><h4>+</h4></a>
						</div>
						<div class="archives">
						<?php
						if(!empty($season_query)) {
							if ( $season_query->have_posts() ) : while ( $season_query->have_posts() ) : $season_query->the_post(); ?>
							<div class="arch">
								<?php the_post_thumbnail('archive', array('class' => 'arch-img')); ?>
								<div class="arch-info">
									<h4><?php the_title(); ?></h4>
									<?php
									$start = get_field('start_date');
									$start_date = date('M d', strtotime($start));
									$start_yr = date('Y', strtotime($start));
									$end = get_field('end_date');
									$end_date = date('M d', strtotime($end));
									$end_yr = date('Y', strtotime($end));
									$unspec = get_field('unspecified_date');
									?>
									<?php if(!empty($start) && !empty($end)) {
									echo $start_date . ($start_yr == $end_yr ? ' - ' : ', ' . $start_yr) . $end_date . ', ' . $end_yr;
									} else if(empty($start) && !empty($unspec)) {
									echo $unspec;
									} else if(empty($start) && empty($unspec)) {
									echo 'Coming Soon';
									}
									?>
									<p>Written by <?php echo get_field('writer'); ?></p>
									<p>Directed by <?php echo get_field('director'); ?></p>
								</div>
								<a class="arch-link" href="<?php echo get_permalink(); ?>"><h4>Learn More</h4></a>
							</div>
						<?php
							endwhile; endif;
						} ?>
						</div><!-- end features -->
<?php				}
				}
			?>
			
	</div>
 
<?php get_footer(); ?>