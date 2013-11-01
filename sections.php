	<?php if(!empty($sections)) { ?>
		<div class="sections">
<?php foreach($sections as $section) {
 //echo '<pre>'; print_r($section); echo '</pre>';
				if($section['acf_fc_layout'] == '6040') { ?>
					<div class="section sixty40<?php echo ($section['bg_color'] != '' ? ' '.$section['bg_color'] : ''); ?>">
						<div class="centerwrap">
							<?php if(!empty($section['title'])) echo '<h4>'.$section['title'].'</h4>'; ?>
							<div class="left"><?php echo apply_filters('the_content', $section['left'] ); ?></div>
							<div class="right"><?php echo apply_filters('the_content', $section['right'] ); ?></div>
							</div>
						</div>
					</div>
<?php			} elseif($section['acf_fc_layout'] == '5050') { ?>
					<div class="section fifty50<?php echo ($section['bg_color'] != '' ? ' '.$section['bg_color'] : ''); ?>">
						<div class="centerwrap">
							<?php if(!empty($section['title'])) echo '<h4>'.$section['title'].'</h4>'; ?>
							<div class="left"><?php echo apply_filters('the_content', $section['left'] ); ?></div>
							<div class="right"><?php echo apply_filters('the_content', $section['right'] ); ?></div>
						</div>
					</div>
<?php			} elseif($section['acf_fc_layout'] == 'supporting_media') { ?>
					<div class="section sup-media<?php echo ($section['bg_color'] != '' ? ' '.$section['bg_color'] : ''); ?>">
						<div class="centerwrap">
							<?php if(!empty($section['title'])) echo '<h4>'.$section['title'].'</h4>'; 
							if(!empty($section['media'])): foreach($section['media'] as $media) { ?>
								<div class="media"><?php echo apply_filters('the_content', $media['image_video'] ); ?></div>
								<div class="media-text"><?php echo $media['description']; ?></div>
<?php						} endif;
							?>
							<div class="left"><?php echo apply_filters('the_content', $section['left'] ); ?></div>
							<div class="right"><?php echo apply_filters('the_content', $section['right'] ); ?></div>
						</div>
					</div>
<?php			} elseif($section['acf_fc_layout'] == 'media_gallery') { ?>
					<div class="section media-gallery<?php echo ($section['bg_color'] != '' ? ' '.$section['bg_color'] : ''); ?>">
						<div class="centerwrap">
						<?php if(!empty($section['title'])) { ?><strong><?php echo $section['title']; ?></strong><?php } ?>
						<div class="slider">
							<img class="slider-dummy" src="<?php bloginfo('template_directory'); ?>/images/dummy.gif" width="696" height="392" />
							<?php
							if(!empty($section['gallery'])) : foreach($section['gallery'] as $media) { ?>
								<img class="slide" src="<?php echo $media['media']['sizes']['medium']; ?>" alt="<?php echo $media['media']['alt']; ?>" />
<?php
// echo '<pre>';
// print_r($media);
// echo '</pre>';
						} endif;
							?>
							<div class="slidenav"></div>
						</div>
						</div>
					</div>
<?php			}
			}
			?>
		</div>
	<?php } ?>
