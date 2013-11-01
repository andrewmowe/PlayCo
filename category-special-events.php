<?php get_header();

// args
$args = array(
	'numberposts' => -1,
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

	$spec_events = get_option('t8_options_two_special_events');
	$subhead = $spec_events['t8_spec_events_subhead'];
// echo '<pre>';
// print_r($spec_events);
// echo '</pre>';
if(!empty($subhead)) : ?>
	<div class="subhead-content"><div class="centerwrap">
	<?php
		echo apply_filters('the_content', $subhead);
	?>
	</div></div>
<?php endif; ?>

<?php if($the_query->have_posts()) : ?>
	<div class="events"><div class="centerwrap">
		<?php while($the_query->have_posts()) : $the_query->the_post(); ?>
				<div class="event">
					<?php the_post_thumbnail('large', array("class" => "event-img")); ?>
					<div class="event-info">
						<div class="event-text">
							<h4><?php the_title(); ?></h4>
							<?php
								$date = get_field('date');
								$date = date('M d, Y', strtotime($date));
								if(!empty($date)) echo '<p>'.$date.'</p>';
								$more = get_field('link_text');
							?>
							<?php echo the_content(); ?>
						</div>
						<a class="event-link" href="<?php echo get_permalink(); ?>"><?php echo (!empty($more) ? $more : 'Learn More'); ?></a>
					</div>
				</div>
		<?php endwhile; ?>
	</div></div>
<?php endif; ?>

<?php get_footer(); ?>