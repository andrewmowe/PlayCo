<?php get_header();

	$hub = get_option('t8_options_two_hub');
	$subhead = $hub['t8_hub_subhead'];
	
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';

if(!empty($subhead)) : ?>
	<div class="subhead-content"><div class="centerwrap">
	<?php
		echo apply_filters('the_content', $subhead);
	?>
	</div></div>
<?php endif; ?>

	<div class="hub-filters">
		<div class="filter-tabs"><div class="centerwrap">
			<span data-filter-group=".region">Region<span class="updown"></span></span>
			<span data-filter-group=".cats">Category<span class="updown"></span></span>
			<form name="tag-search" id="tag-search" action="" method="post">
				<input type="text" name="tag" id="search-field" />
				<input type="submit" name="search" id="search-button" />
			</form>
		</div></div>
		<div class="centerwrap">
		<div class="filter-list region">
		<span data-filter="*">Show All</span>
		<?php
			$regions = get_terms('regions');
			if(!empty($regions)) : foreach($regions as $region) { ?>
				<span data-filter=".<?php echo $region->slug; ?>"><?php echo $region->name; ?></span>
<?php		} endif;
		?>
		</div>
		<div class="filter-list cats">
		<span data-filter="*">Show All</span>
		<?php
			$hubObj = get_category_by_slug('hub');
			$hubID = $hubObj->term_id;
			$cats = get_categories(array('exclude' => $hubID));
			if(!empty($cats)) : foreach($cats as $cat) { ?>
				<span data-filter=".<?php echo $cat->slug; ?>"><?php echo $cat->name; ?></span>
<?php		} endif;
		?>
		</div>
		</div>
	</div>

<?php if( have_posts() ): ?>
		<div class="cat-wrap">
			<div class="centerwrap" id="isotope">
				<div class="gutter"></div>
	<?php while ( have_posts() ) : the_post(); ?>
	<?php 	$regions = get_the_terms($post->ID, 'regions');
			$post_cats = wp_get_post_categories($post->ID);
			$cats = array();
			foreach($post_cats as $c) {
				$cat = get_category($c);
				$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
			}
			$tags = get_the_tags();
			?>
	<?php
		if(!empty($regions)) : foreach($regions as $region) {
			$term_link = get_term_link($region);
		} endif;
	?>
				<div class="cat show <?php echo ($region->slug != '' ? $region->slug : 'new-york'); ?><?php if(!empty($cats)) { foreach($cats as $cat) echo ' ' . $cat['slug']; } ?><?php if(!empty($tags)) { foreach($tags as $tag) echo ' ' . $tag->slug; } ?>">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large'); ?></a>
					<div class="cat-info">
						<a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
						<?php the_excerpt(); ?>
						<?php echo get_the_category_list(', '); ?>
						<?php echo get_the_tag_list('<p>Tags: ',', ','</p>'); ?>
					</div>
					<div class="cat-meta">
						<div class="cat-date"><?php the_time('M j, Y'); ?></div>
						<a class="cat-link" href="<?php echo $term_link; ?>"><?php echo $region->name; ?></a>
					</div>
				</div>
	<?php endwhile; ?>
			</div>
		</div>
		<div id="temp"></div>
		<div class="navigation"><?php next_posts_link(); ?></div>
<?php else : ?>
	<div>NOOOO</div>
<?php endif; ?>
 
<?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>
<?php get_footer(); ?>