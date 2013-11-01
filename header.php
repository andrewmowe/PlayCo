<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="no-js ie ie6 lte7 lte8 lte9" dir="<?php bloginfo('text_direction'); ?>" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7 ]><html class="no-js ie ie7 lte7 lte8 lte9" dir="<?php bloginfo('text_direction'); ?>" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8 lte8 lte9" dir="<?php bloginfo('text_direction'); ?>" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9 ]><html class="no-js ie ie9 lte9" dir="<?php bloginfo('text_direction'); ?>" <?php language_attributes(); ?>><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html class="no-js" dir="<?php bloginfo('text_direction'); ?>" <?php language_attributes(); ?>><!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<title><?php
			/*
			 * Print the <title> tag based on what is being viewed.
			 * We filter the output of wp_title() a bit -- see
			 * boilerplate_filter_wp_title() in functions.php.
			 */
			wp_title( '|', true, 'right' );
		?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<link rel="stylesheet" href="<?php bloginfo( 'template_directory' ); ?>/css/responsive.css" />
		<link rel="stylesheet" href="<?php bloginfo( 'template_directory' ); ?>/css/jqueryui.css" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
		/* We add some JavaScript to pages with the comment form
		 * to support sites with threaded comments (when in use).
		 */
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-effects-core', array('jquery'));
		wp_enqueue_script('jquery-ui-core', array('jquery'));
		wp_enqueue_script('jquery-ui-widget', array('jquery'));
		wp_enqueue_script('jquery-ui-position', array('jquery'));
		wp_enqueue_script('jquery-ui-autocomplete', array('jquery'));
		wp_enqueue_script('jquery-color', array('jquery'));
		wp_enqueue_script('isotope', get_template_directory_uri() . '/js/isotope.js', array('jquery'));
		wp_enqueue_script('bbq', get_template_directory_uri() . '/js/bbq.js', array('jquery'));
		wp_enqueue_script('infinite-scroll', get_template_directory_uri() . '/js/infinite-scroll.js', array('jquery'));
		wp_enqueue_script('cycle', get_template_directory_uri() . '/js/cycle.js', array('jquery'));
		wp_head();
?>
	</head>
	<body <?php body_class(); ?>>
		<div class="mininav sticky">
			<a class="logo-link sm" href="<?php echo get_bloginfo('url'); ?>"><img class="logo-img sm" src="<?php echo get_bloginfo('template_directory'); ?>/images/playco_logo_sm-47x30.png" alt="The Play Company logo" /></a>
			<?php
			$walker = new select_menu_walker;
			wp_nav_menu( array(
				'container'			=> false,
				'theme_location'	=> 'mini',
				'items_wrap'		=> '<select id="drop-nav"><option value="">Menu</option>%3$s</select>',
				'walker'			=> $walker
			) ); ?>
		</div>
		<?php if(is_front_page()) { ?>
		<div class="home-slider">
			<div class="slider">
				<img class="slider-dummy" src="<?php bloginfo('template_directory'); ?>/images/dummy.gif" width="1500" />
				<?php
				$slides = get_field('home_slides');
				foreach($slides as $slide) { ?>
					<div class="slide">
						<img class="slide-img" src="<?php echo $slide['image']['sizes']['large']; ?>" alt="<?php echo $slide['image']['alt']; ?>" />
						<div class="slide-info">
							<div class="slide-text"><?php echo $slide['text']; ?></div>
							<a class="slide-link" href="<?php echo $slide['link']; ?>"><?php echo $slide['link_text']; ?></a>
						</div>
					</div>
				<?php
				}
				?>
				<div class="slidenav"></div>
			</div>
		</div>
		<?php } ?>
		<div id="header" role="banner" class="<?php echo (is_front_page() ? 'home' : 'sticky'); ?>">
			<div id="nav" role="navigation">
				<div class="centerwrap">
				<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
				<?php wp_nav_menu( array( 'container' => false, 'theme_location' => 'primary' ) ); ?>
					<div class="mailing head">
					<?php include('mailing-list.php'); ?>
					</div>
				</div>
			</div>
		</div>
		<div id="content" role="main">
