<?php
// Template Name: Staff and Board
get_header();

the_post();

?>

	<div class="subhead-content"><div class="centerwrap">
		<?php
			$execs = get_field('executive_producers');
			$i = 0;
			if(!empty($execs)) : foreach($execs as $exec) {
// echo '<pre>';
// print_r($exec);
// echo '</pre>';
				?>
				<div class="producer <?php echo ($i%2 ? "right" : "left" ); ?>" data-id="<?php echo 'id-'.$exec['image']['id'];?>">
					<img src="<?php echo $exec['image']['sizes']['medium']; ?>" alt="<?php echo $exec['image']['alt']; ?>" />
					<h3><?php echo $exec['name']; ?></h3>
					<p><?php echo $exec['job_title']; ?></p>
				</div>
				<?php
				$i++;
			} endif;
		?>
	</div></div>
		<?php
			if(!empty($execs)) : foreach($execs as $exec) {
				?>
	<div class="prod-info" data-id="<?php echo 'id-'.$exec['image']['id'];?>"><div class="centerwrap">
				<div class="info">
					<?php echo apply_filters('the_content', $exec['desc']); ?>
				</div>
	</div></div>
				<?php
			} endif;
		?>
	<?php
		$staff = get_field('staff');
// echo '<pre>';
// print_r($staff);
// echo '</pre>';
		if(!empty($staff)) : foreach($staff as $content) {
			?>
			<div class="section fifty50 grey"><div class="centerwrap">
				<div class="left"><img src="<?php echo $content['image']['sizes']['large']; ?>" alt="<?php echo $content['image']['alt']; ?>" /></div>
				<div class="right"><?php echo apply_filters('the_content', $content['text']); ?></div>
			</div></div>
			<?php
		} endif;
	?>
	<?php
		$board = get_field('board');
		if(!empty($board)) : foreach($board as $content) {
			?>
			<div class="section fifty50 orange"><div class="centerwrap">
				<div class="left"><?php echo apply_filters('the_content', $content['text']); ?></div>
				<div class="right"><img src="<?php echo $content['image']['sizes']['large']; ?>" alt="<?php echo $content['image']['alt']; ?>" /></div>
			</div></div>
			<?php
		} endif;
	?>
<?php
get_footer();
?>