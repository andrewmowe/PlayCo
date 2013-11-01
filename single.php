<?php
get_header();

the_post();

	$sections = get_field('sections');
	$regions = get_the_terms($post->ID, 'regions');
	// Filter var
	$filter = get_bloginfo('url') . '/category/hub/#filter=.';
// echo '<pre>';
// print_r($region);
// echo '</pre>';

if(is_singular('plays')) {
	// ACF FIELDS
	$active = get_field('active');
	$start = get_field('start_date');
	$start_date = date('M d', strtotime($start));
	$start_yr = date('Y', strtotime($start));
	$end = get_field('end_date');
	$end_date = date('M d', strtotime($end));
	$end_yr = date('Y', strtotime($end));
	$unspec = get_field('unspecified_date');
	$pri_credits = get_field('primary_credits');
	$credits = get_field('credits');
	$theater = get_field('theater');
	$loc = get_field('theater_location');
	$slider = get_field('media_slider');
	?>
	
	<div class="play">
	<?php if(!empty($slider)) { ?>
		<div class="image">
			<?php
// echo '<pre>';
// print_r($slider);
// echo '</pre>';
			?>
			<div class="slider">
				<img class="slider-dummy" src="<?php bloginfo('template_directory'); ?>/images/dummy.gif" width="1500" />
				<?php
				foreach($slider as $slide) {
					if($slide['acf_fc_layout'] == 'image') {
					echo '<div class="slide">';
					echo '<img class="slide-img" src="'.$slide['image']['sizes']['large'].'" alt="'.$slide['image']['alt'].'" />';
					echo '</div>';
					} elseif($slide['acf_fc_layout'] == 'video') {
					echo '<div class="slide">';
					echo strip_tags($slide['video'], '<iframe>');
					echo '</div>';
					}
				}
				?>
				<div class="slidenav"></div>
			</div>
			<span class="updown"></span>
		</div>
	<?php } else { ?>
		<div class="image">
			<div class="centerwrap">
		<?php the_post_thumbnail('large'); ?>
			</div><!-- end centerwrap -->
		</div><!-- end image -->
	<?php } ?>
		<div class="play-text">
			<div class="centerwrap">
				<h3>
				<?php
				$title = get_the_title();
				if(!empty($title)) {
					echo $title;
				} else {
					$raw_cont = get_the_content();
					$stripped = strip_tags($raw_cont);
					$new_title = (strlen($stripped) > 40) ? substr($stripped,0,30).'...' : $stripped;
					echo $new_title;
				}
				?>
				</h3>
				<?php
				if(!empty($pri_credits)) echo apply_filters('the_content', $pri_credits);
				?>
				<?php
					if($active == true) {
						$buy_tix = get_field('online_tickets_link');
						if(!empty($buy_tix)) {
						?>
						<div class="play-link"><a href="<?php echo $buy_tix; ?>">Buy Tickets</a></div>
						<?php }
					}
				?>
			</div><!-- end centerwrap -->
		</div><!-- end play-text -->
		
		<div class="play-main">
			<div class="centerwrap">
				<div class="content">
					<?php the_content(); ?>
				</div>

				<div class="sidebar right">
					<div>
						<h4>
						<?php if(!empty($start) && !empty($end)) {
						echo $start_date . ($start_yr == $end_yr ? ' - ' : ', ' . $start_yr) . $end_date . ', ' . $end_yr;
						} else if(empty($start) && !empty($unspec)) {
						echo $unspec;
						} else if(empty($start) && empty($unspec)) {
						echo 'Coming Soon';
						}
						?>
						</h4>
						<p><?php echo $credits; ?></p>
						<h4><?php echo $theater; ?></h4>
						<p><?php echo $loc; ?></p>
					</div>
					<?php
						if(!empty($regions)) : foreach($regions as $region) {
						}
					?>
					<a class="region-link" href="<?php echo $filter . $region->slug; ?>"><?php echo $region->name; ?></a>
					<?php else : ?>
					<a class="region-link" href="<?php echo $filter . 'new-york'; ?>">New York</a>
					<?php endif; ?>
				</div><!-- end sidebar -->
			</div><!-- end centerwrap -->
			
		</div><!-- end play-main -->
<?php	
} else {
	// ACF FIELDS
	$related_play = get_field('related_play');
	
	?>
	
	<div class="post">
		
		<div class="post-main">
			<div class="post-text">
				<div class="centerwrap">
					<h3>
				<?php
				$title = get_the_title();
				if(!empty($title)) {
					echo $title;
				} else {
					$raw_cont = get_the_content();
					$stripped = strip_tags($raw_cont);
					$new_title = (strlen($stripped) > 40) ? substr($stripped,0,30).'...' : $stripped;
					echo $new_title;
				}
				?>
					</h3>
					<p><?php the_time('M d, Y'); ?></p>
					<?php
					if(!empty($tags)) {				
					?>
					<p>Tags:
					<?php
						$tags = get_the_tags();
							$count = count($tags);
							$i = 0;
							foreach($tags as $tag) {
								$i++;
								echo '<a href="'.$filter.$tag->slug.'">'.$tag->name.'</a>';
								if($i < $count) echo ', ';
							}
					?>
					</p>
					<?php } ?>
					<?php
					if(!empty($related_play)) {
					$slug = $related_play->post_name;
					?>
					<p>Related Play: <a href="<?php echo $filter . $slug; ?>"><?php echo $related_play->post_title; ?></a></p>
					<?php
						}
					?>
					<?php
						if(!empty($regions)) : foreach($regions as $region) {
						}
					?>
					<div class="post-link"><a href="<?php echo $filter . $region->slug; ?>"><?php echo $region->name; ?></a></div>
					<?php else : ?>
					<div class="post-link"><a href="<?php echo $filter . 'new-york'; ?>">New York</a></div>
					<?php endif; ?>
				</div><!-- end centerwrap -->
			</div><!-- end post-text -->
			<div class="post-main">
				<div class="centerwrap">
					<div class="post-content<?php if(has_post_thumbnail) echo ' wide'; ?>">
						<?php the_content(); ?>
					</div>
					<?php if(has_post_thumbnail) { ?>
					<div class="post-img">
						<?php the_post_thumbnail('large'); ?>
					</div>
					<?php } ?>		
				</div><!-- end centerwrap -->
			</div><!-- end post-main -->
<?php } ?>
	</div><!-- end play/post -->
<?php include('sections.php'); ?>

<?php
get_footer();
?>