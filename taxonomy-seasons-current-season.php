<?php get_header();

// args
$args = array(
	'numberposts' => 1,
	'order' => 'ASC',
	'post_type' => 'plays',
    'category_name' => 'current-season',
	'meta_query' => array(
		array(
			'key' => 'active',
			'value' => '',
			'compare' => 'NOT IN'
		)
	)
);
 
// get results
$the_query = new WP_Query( $args );

		$plays_pages = get_option('t8_options_two_plays_pages');
		$msg_on = $plays_pages['t8_curr_season_message_on'];
		$curr_season_msg = apply_filters('the_content', stripslashes($plays_pages['t8_curr_season_welcome']));
		?>
	<div class="subhead-content"><div class="centerwrap">
	<?php if($msg_on == true) {
		echo $curr_season_msg;
	} else {
	if( $the_query->have_posts() ): ?>
		<div class="features">
			<div class="centerwrap">
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
	<?php
		$start = get_field('start_date');
		$start_date = date('M d', strtotime($start));
		$start_yr = date('Y', strtotime($start));
		$end = get_field('end_date');
		$end_date = date('M d', strtotime($end));
		$end_yr = date('Y', strtotime($end));
		$unspec = get_field('unspecified_date');
	?>
				<div class="feature">
					<?php the_post_thumbnail('large', array("class" => "feat-img")); ?>
					<div class="feat-info orange">
						<div class="feat-text">
							<h4><?php the_title(); ?></h4>
							<p>
							<?php if(!empty($start) && !empty($end)) {
							echo $start_date . ($start_yr == $end_yr ? ' - ' : ', ' . $start_yr) . $end_date . ', ' . $end_yr;
							} else if(empty($start) && !empty($unspec)) {
							echo $unspec;
							} else if(empty($start) && empty($unspec)) {
							echo 'Coming Soon';
							}
							?>
							</p>
						</div>
						<?php
						$buy_tix = get_field('online_tickets_link');
						if(!empty($buy_tix)) {
						?>
						<a class="feat-link orange" href="<?php echo $buy_tix; ?>">Buy Tickets</a>
						<?php } ?>
					</div>
				</div>
	<?php endwhile; ?>
			</div>
		</div>
<?php endif; ?>
 
<?php	} ?>
		
	</div></div>

<?php 
 
// The Loop
?>
<?php if($msg_on == true) { ?>
<?php if( $the_query->have_posts() ): ?>
		<div class="features">
			<div class="centerwrap">
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
	<?php
		$start = get_field('start_date');
		$start_date = date('M d', strtotime($start));
		$start_yr = date('Y', strtotime($start));
		$end = get_field('end_date');
		$end_date = date('M d', strtotime($end));
		$end_yr = date('Y', strtotime($end));
		$unspec = get_field('unspecified_date');
	?>
				<div class="feature">
					<?php if(has_post_thumbnail()) : ?><a href="<?php echo get_permalink(); ?>"><? the_post_thumbnail('large', array("class" => "feat-img")); ?></a><?php endif; ?>
					<div class="feat-info orange">
						<div class="feat-text">
							<a href="<?php echo get_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
							<p>
							<?php if(!empty($start) && !empty($end)) {
							echo $start_date . ($start_yr == $end_yr ? ' - ' : ', ' . $start_yr) . $end_date . ', ' . $end_yr;
							} else if(empty($start) && !empty($unspec)) {
							echo $unspec;
							} else if(empty($start) && empty($unspec)) {
							echo 'Coming Soon';
							}
							?>
							</p>
						</div>
						<?php
						$buy_tix = get_field('online_tickets_link');
						?>
						<a class="feat-link orange" href="<?php echo $buy_tix; ?>">Buy Tickets</a>
					</div>
				</div>
	<?php endwhile; ?>
			</div>
		</div>
<?php endif; ?>
 
<?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>
<?php } ?>
<?php 
// args
$args = array(
	'numberposts' => -1,
	'post_type' => 'plays',
	'order' => 'ASC',
	'meta_key' => 'start_date',
	'orderby' => 'meta_value',
	'meta_query' => array(
		array(
			'key' => 'active',
			'value' => '',
			'compare' => 'IN'
		)
	)
);
 
// get results
$the_query = new WP_Query( $args );
 
// The Loop
?>
<?php if( $the_query->have_posts() ): ?>
		<div class="features">
			<div class="centerwrap">
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
	<?php
		$start = get_field('start_date');
		$start_date = date('M d', strtotime($start));
		$start_yr = date('Y', strtotime($start));
		$end = get_field('end_date');
		$end_date = date('M d', strtotime($end));
		$end_yr = date('Y', strtotime($end));
		$unspec = get_field('unspecified_date');
	?>
				<div class="feature">
					<?php if(has_post_thumbnail()) : ?><a href="<?php echo get_permalink(); ?>"><? the_post_thumbnail('large', array("class" => "feat-img")); ?></a><?php endif; ?>
					<div class="feat-info">
						<div class="feat-text">
							<a href="<?php echo get_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
							<p>
							<?php if(!empty($start) && !empty($end)) {
							echo $start_date . ($start_yr == $end_yr ? ' - ' : ', ' . $start_yr) . $end_date . ', ' . $end_yr;
							} else if(empty($start) && !empty($unspec)) {
							echo $unspec;
							} else if(empty($start) && empty($unspec)) {
							echo 'Coming Soon';
							}
							?>
							</p>
							</div>
						<a class="feat-link" href="<?php echo get_permalink(); ?>">More Info</a>
					</div>
				</div>
	<?php endwhile; ?>
			</div>
		</div>
<?php endif; ?>
 
<?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>
<?php get_footer(); ?>