<?php get_header();
	if(is_category('idea-lab')) {
		$lab = get_option('t8_options_two_lab');
		$subhead = $lab['t8_lab_subhead'];
	} else {
		$hub = get_option('t8_options_two_hub');
		$subhead = $hub['t8_hub_subhead'];
	}


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
			<?php if(is_category('hub')) { ?>
			<span data-filter-group=".cats">Category<span class="updown"></span></span>
			<?php } ?>
			<form name="tag-search" id="tag-search" action="" method="post">
				<input type="text" name="tag" id="search-field" placeholder="search tags" />
				<input type="submit" name="search" id="search-button" />
			</form>		
		</div></div>
		<div class="centerwrap">
		<div class="filter-list region">
		<li class="filter"><a href="#filter=*">Show All</a></li>
		<?php
			$regions = get_terms('regions');
			if(!empty($regions)) : foreach($regions as $region) { ?>
				<li class="filter"><a href="#filter=.<?php echo $region->slug; ?>"><?php echo $region->name; ?></a></li>
<?php		} endif;
		?>
		</div>
		<div class="filter-list cats">
		<li class="filter"><a href="#filter=*">Show All</a></li>
		<?php
			$hubObj = get_category_by_slug('hub');
			$hubID = $hubObj->term_id;
			$uncatObj = get_category_by_slug('uncategorized');
			$uncatID = $uncatObj->term_id;
			$cats = get_categories('exclude='.$uncatID.','.$hubID.'');
			if(!empty($cats)) : foreach($cats as $cat) { ?>
				<li class="filter"><a href="#filter=.<?php echo $cat->slug; ?>"><?php echo $cat->name; ?></a></li>
<?php		} endif;
		?>
		</div>
		</div>
	</div>

<?php if( have_posts() ): ?>
		<div class="cat-wrap">
				<div class="gutter"></div>
			<div class="centerwrap" id="isotope">
	<?php while ( have_posts() ) : the_post(); ?>
	<?php 	$regions = get_the_terms($post->ID, 'regions');
			
			$post_cats = wp_get_post_categories($post->ID);
			$cats = array();
			foreach($post_cats as $c) {
				$cat = get_category($c);
				if($cat->slug == 'hub' || $cat->slug == 'uncategorized') continue;
				$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug );
			}
			$tags = get_the_tags();
			$rel_play = get_field('related_play');
			?>
	<?php
		if(!empty($regions)) {
			foreach($regions as $region) {
				$reg = $region;
			}
		} else {
			$reg = new stdClass();
			$reg->slug = "new-york";
			$reg->name = "New York";
		}
	?>
				<div class="cat show <?php echo $reg->slug; ?><?php if(!empty($cats)) { foreach($cats as $cat) echo ' ' . $cat['slug']; } ?><?php if(!empty($tags)) { foreach($tags as $tag) echo ' ' . $tag->slug; } ?><?php if(!empty($rel_play)) echo ' ' . $rel_play->post_name ?>">
					<a href="<?php the_permalink(); ?>">
					<?php
					if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'large' ); 
					}else{
						$cont = strip_tags(get_the_content(), '<img>');
						$find = '<img';
						$pos = strpos($cont, $find);
						if ($pos === false) {
						} else {
							$img = explode('<img', $cont , 2);
							$img2 = $img[1];
							$img = explode( '>', $img2, 2 );
							echo '<img'.$img[0].'>';
						}
					}
					?>
					</a>
					<div class="cat-info">
						<a href="<?php the_permalink(); ?>"><h4>
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
						</h4></a>
						<?php the_excerpt(); ?>
						<?php if(!empty($cats)) : ?>
						<p>In:
						<?php
						$count = count($cats);
						$i = 0;
						foreach($cats as $cat) {
							$i++;
							echo '<a href="#filter=.'.$cat['slug'].'">'.$cat['name'].'</a>';
							if($i < $count) echo ', ';
						} ?>
						</p>
						<?php endif; ?>
						<?php if(!empty($tags)) : ?>
						<p>Tags:
						<?php
						$count = count($tags);
						$i = 0;
						foreach($tags as $tag) {
							$i++;
							echo '<a href="#filter=.'.$tag->slug.'">'.$tag->name.'</a>';
							if($i < $count) echo ', ';
						} ?>
						</p>
						<?php endif; ?>
					</div>
					<div class="cat-meta">
						<div class="cat-date"><?php the_time('M j, Y'); ?></div>
						<a class="cat-link" href="#filter=.<?php echo $reg->slug; ?>"><?php echo $reg->name; ?></a>
					</div>
				</div>
	<?php endwhile; ?>
			</div>
		</div>
		<div id="temp"></div>
		<div class="navigation"><?php next_posts_link(); ?></div>
<?php endif; ?>
 
<?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>
<?php get_footer(); ?>