<?php
// Template Name: Tickets
get_header();

// args
$args = array(
	'numberposts' => 1,
	'post_type' => 'plays',
	'order' => 'ASC',
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

?>

	<div class="subhead-content"><div class="centerwrap">
	<?php
	if($the_query->have_posts()) : while($the_query->have_posts()) : $the_query->the_post();
	?>
		<div class="active-tix">
			<?php the_post_thumbnail('archive', array('class' => 'active-tix-img')); ?>
			<div class="active-tix-info">
				<h4><?php the_title(); ?></h4>
				<?php
				$start = get_field('start_date');
				$start_date = date('M d', strtotime($start));
				$start_yr = date('Y', strtotime($start));
				$end = get_field('end_date');
				$end_date = date('M d', strtotime($end));
				$end_yr = date('Y', strtotime($end));
				$unspec = get_field('unspecified_date');
				$buy_tix = get_field('online_tickets_link');
				$in_person = get_field('tickets_in_person');
				$pri_credits = get_field('primary_credits');
				?>
				<?php if(!empty($start) && !empty($end)) {
				echo $start_date . ($start_yr == $end_yr ? ' - ' : ', ' . $start_yr) . $end_date . ', ' . $end_yr;
				} else if(empty($start) && !empty($unspec)) {
				echo $unspec;
				} else if(empty($start) && empty($unspec)) {
				echo 'Coming Soon';
				}
				?>
				<?php if(!empty($pri_credits)) {
					echo apply_filters('the_content', $pri_credits);
				} ?>
			</div>
			<div class="active-tix-links">
				<a class="tix-link" href="<?php echo $buy_tix; ?>"><h4>Buy Tickets</h4></a>
				<a class="tix-info" href="">Tickets by phone or in person</a>
				<span class="updown"></span>
			</div>
		</div>
		<div class="tix-info">
			<p>TICKETS BY PHONE<br />
			OvationTix (866) 811-4111<br />
			<br />
			<span>TICKETS IN PERSON</span>
			<br />
			<?php echo $in_person; ?>
			</p>
		</div>
	<?php
	endwhile; endif;
	
	wp_reset_query();
	?>
	</div></div>
	
	<div class="content"><div class="centerwrap">
	
<?php
	the_post();

	$specials = get_field('ticket_specials');
// echo '<pre>';
// print_r($specials);
// echo '</pre>';
	if(!empty($specials)) : foreach($specials as $special) {
	?>
		<div class="special">
			<div class="special-title"><h4><?php echo $special['title']; ?></h4></div>
			<div class="special-desc"><?php echo apply_filters('the_content', $special['desc']); ?></div>
		</div>
	<?php
	} endif;
?>

<?php
get_footer();
?>