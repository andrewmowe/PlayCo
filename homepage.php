<?php
/* Template Name: Home Page */
get_header();

the_post();
?>

<div class="subhead-content">
	<div class="centerwrap">
	<?php the_content(); ?>
	</div>
</div>
<div class="features">
	<div class="centerwrap">
	<?php
	$features = get_field('featured');
	if(!empty($features)) : foreach($features as $feat) {
		echo '<div class="feature">';
		echo '<img class="feat-img" src="'.$feat['image']['sizes']['large'].'" alt="'.$feat['image']['alt'].'" />';
		echo '<div class="feat-info clear">';
		echo '<div class="feat-text"><a href="'.$feat['link'].'">'.$feat['text'].'</a></div>';
		echo '<a class="feat-link" href="'.$feat['link'].'">'.$feat['link_text'].'</a>';
		echo '</div></div>';
	} endif;
	?>
	</div>
</div>

<?php get_footer(); ?>