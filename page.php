<?php
get_header();

the_post();

	$sections = get_field('sections');
	$content = get_the_content();
	
?>
	<?php if(!empty($content) || is_page('donate')) { ?>
	<div class="subhead-content"><div class="centerwrap">
		<?php if(is_page('donate')) {
			$donate_link = get_field('donate_link');
			$pdf = get_field('pdf');
		?>
			<div class="donate-link">
				<a class="donate-button" href="<?php echo $donate_link; ?>">Donate</a>
				<a class="donate-download" href="<?php echo $pdf; ?>">or download the printable form</a>
			</div>
		<?php } ?>
		<?php echo the_content(); ?>
	</div></div>
	<?php } ?>

<?php include('sections.php'); ?>

<?php get_footer(); ?>