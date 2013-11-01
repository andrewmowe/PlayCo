	</div> <!-- end main content -->
	<div id="footer"><div class="centerwrap">
		<div class="info">
			<?php
				$footer = get_option('t8_options_two_footer');
				echo apply_filters('the_content', stripslashes($footer['t8_playco_contact']));
			?>
		</div>
		<div class="social">
			<a class="fb" href="<?php echo $footer['t8_facebook_link']; ?>" title="Facebook"></a>
			<a class="twit" href="<?php echo $footer['t8_twitter_link']; ?>" title="Twitter"></a>
			<a class="yt" href="<?php echo $footer['t8_youtube_link']; ?>" title="YouTube"></a>
		</div>
		<div class="mailing">
			<?php include('mailing-list.php'); ?>
		</div>
	</div></div>
	<script type="text/javascript">
	
	jQuery.fn.visible = function() {
		return this.css('visibility', 'visible');
	};

	jQuery.fn.invisible = function() {
		return this.css('visibility', 'hidden');
	};

	jQuery.fn.visibilityToggle = function() {
		return this.css('visibility', function(i, visibility) {
			return (visibility == 'visible') ? 'hidden' : 'visible';
		});
	};
	
  	jQuery(document).ready(function($j) {
		// modified Isotope methods for gutters in masonry
		  $j.Isotope.prototype._getMasonryGutterColumns = function() {
			var gutter = this.options.masonry && this.options.masonry.gutterWidth || 0;
				containerWidth = this.element.width();
  
			this.masonry.columnWidth = this.options.masonry && this.options.masonry.columnWidth ||
						  // or use the size of the first item
						  this.$filteredAtoms.outerWidth(true) ||
						  // if there's no items, use size of container
						  containerWidth;

			this.masonry.columnWidth += gutter;

			this.masonry.cols = Math.floor( ( containerWidth + gutter ) / this.masonry.columnWidth );
			this.masonry.cols = Math.max( this.masonry.cols, 1 );
		  };

		  $j.Isotope.prototype._masonryReset = function() {
			// layout-specific props
			this.masonry = {};
			// FIXME shouldn't have to call this again
			this._getMasonryGutterColumns();
			var i = this.masonry.cols;
			this.masonry.colYs = [];
			while (i--) {
			  this.masonry.colYs.push( 0 );
			}
		  };

		  $j.Isotope.prototype._masonryResizeChanged = function() {
			var prevSegments = this.masonry.cols;
			// update cols/rows
			this._getMasonryGutterColumns();
			// return if updated cols/rows is not equal to previous
			return ( this.masonry.cols !== prevSegments );
		  };
	
		var $touch = $j('.touch'),
			$notouch = $j('.no-touch'),
			$gallery = $j('.slider'),
			$header = $j('#header'),
			$homeslider = $j('.home-slider');
			$window = $j(window),
			$doc = $j(document),
			$navlink = $j('#nav > .centerwrap > ul > li'),
			$subhead = $j('.subhead-content'),
			$tagurl = "<?php echo get_bloginfo('url'); ?>/category/hub";
			$logomd = $j('.logo-img.md');
			
		
		function afterHomeSlide(curr, next, opt, flag) {
			if($notouch.length) {
				$j(curr).find('.slide-info').hide();
				$j(next).find('.slide-info').fadeIn();
			}
		}
		
		// HOME PAGE SPECIFIC FUNCTIONS
	
		
		if($header.hasClass('home')) {
		
			$gallery.cycle({
				slideExpr: '.slide',
				fx:    'scrollLeft', 
				speed:  1000,
 				slideResize: true,
                containerResize: false,
                width: '100%',
                height: '100%',
                fit: 1,
                after: afterHomeSlide,
				pager: '.slidenav'
			});

			if($notouch.length) {
				$window.scroll(function () {
					var top = $homeslider.outerHeight(true);
					var scroll = $doc.scrollTop();
								
					if(scroll >= top) { // should be small header
						if($header.hasClass('sticky')) {
							//
						} else {
							$navlink.children('a').animate({
								'padding': '20px 10px'
							}, 400);
							$logomd.fadeOut(400, function() {
								$j('.logo-img.sm').fadeIn(400);					
							});
							$header.addClass('sticky');
							$subhead.animate({'padding-top': '9%'});
						}
					} else { // should be big header
						if($header.hasClass('sticky')) {
							$j('.logo-img.sm').fadeOut(400, function() {
								$logomd.fadeIn(400);						
							});
							$navlink.children('a').animate({
								'padding': '50px 10px'
							}, 400);
							$header.removeClass('sticky');
							$subhead.animate({'padding-top': '5%'});
						} else {
						 //
						}
					}
				});
			}
			if($touch.length || $j('#drop-nav:visible').length) {
				var h = $j('.home-slider').outerHeight(true);
				$j('.home-slider').height(h + 133);
			}
		}
		
		// CYCLE MEDIA GALLERY
		
		if($j('.media-gallery').length) {
			$j('.media-gallery').children('.centerwrap').cycle({
				slideExpr: '.slide',
				fx:    'scrollLeft', 
				speed:  800,
				slideResize: 1,
				pager: '.slidenav'
			});
		}
		
		// SUBNAV FUNCTION
				
		function subnav() {
		
			$navlink.hover(function() {
				if($j('.current-menu-ancestor').length) {
					//console.log('there is a subnav open');
					if($j(this).hasClass('current-menu-ancestor')) {
						// do nothing, we're already showing this subnav
					} else {
						if($j(this).children('.sub-menu').length > 0) {
							$j('.sub-menu:animated').stop(true, true);
							$j(this).children('.sub-menu').css('z-index', '1').toggle();
						} else {
							$j('.sub-menu:animated').stop(true, true);
							$j(this).append('<ul class="sub-menu"></ul>').children('.sub-menu').css({'z-index': '1', 'height': '39px'}).toggle();
						}
					}
				} else {
					//console.log('there is not an open subnav');
					if($j(this).hasClass('current-menu-item')) {
						// do nothing, we're already showing this subnav
					} else {
						if($header.hasClass('home')) {
							var h = $header.outerHeight(true);
							$j('.sub-menu:animated').stop(true, true);
							$j(this).children('.sub-menu').slideToggle('fast');
						} else {
							$j('.sub-menu:animated').stop(true, true);
							$j(this).children('.sub-menu').slideToggle('fast');
						}
					}
				}
			}, function() {
				if($j('.current-menu-ancestor').length) {
					if($j(this).hasClass('current-menu-ancestor')) {
						// do nothing, we're already showing this subnav
					} else {
						if($j(this).children('.sub-menu').length > 0) {
							$j('.sub-menu:animated').stop(true, true);
							$j(this).children('.sub-menu').css('z-index', '1').toggle();
						} else {
							$j('.sub-menu:animated').stop(true, true);
							$j(this).append('<ul class="sub-menu"></ul>').children('.sub-menu').css({'z-index': '1', 'height': '39px'}).toggle();
						}
					}
				} else {
					//console.log('there is not an open subnav');
					if($j(this).hasClass('current-menu-item')) {
						// do nothing, we're already showing this subnav
					} else {
						if($header.hasClass('home')) {
							var h = $header.outerHeight(true);
							$j('.sub-menu:animated').stop(true, true);
							$j(this).children('.sub-menu').slideToggle('fast');
						} else {
							$j('.sub-menu:animated').stop(true, true);
							$j(this).children('.sub-menu').slideToggle('fast');
						}
					}
				}
			});
		}
		subnav();
		
		// HUB FILTER FUNCTIONS
		
		// tag search
		var tags =
		<?php
			$toJSON = array();
			$tags = get_tags();
			foreach($tags as $num => $val) {
				$toJSON[$num]['value'] = $val->slug;
				$toJSON[$num]['label'] = $val->name;
			}
			echo json_encode($toJSON);
		?>;
		//console.log(tags);
		var plays =
		<?php
			$toJSON = array();
			$args = array(
				'post_type' => 'plays',
				'numberposts' => -1
			);
			$plays = get_posts($args);
			foreach($plays as $num => $val) {
				$toJSON[$num]['value'] = $val->post_name;
				$toJSON[$num]['label'] = $val->post_title;
			}
			echo json_encode($toJSON);
		?>;
		//console.log(plays);
		
		var source = tags.concat(plays);
		
		$j('#search-field').autocomplete({
			source: source,
			focus: true,
		});
		
		$j( "#search-field" ).on( "autocompleteselect", function( event, ui ) {
			//console.log(ui);
			$j.bbq.pushState('filter=.'+ui.item.value);
		} );
		
		$j('#search-button').click(function(e) {
			e.preventDefault();
			var term = $j('#search-field').val();
			//console.log(term);
			$j.bbq.pushState('filter=.'+term);
		});
		
		$j('#search-field').attr('autocomplete', 'on');		
		
		// filter tab functions
		$j('.filter-tabs > .centerwrap > span').click(function(){
			$j('#search-field').val('');
			if($j(this).hasClass('active')) {
				$j(this).removeClass('active');
				var selector = $j(this).attr('data-filter-group');
				$j('.filter-list'+selector+'').slideToggle('fast');

			} else {
				$j(this).addClass('active').siblings().removeClass('active');
				var selector = $j(this).attr('data-filter-group');
				$j('.filter-list:visible').slideToggle('fast');
				$j('.filter-list'+selector+'').slideToggle('fast');
			}
		});
		
		if($notouch.length && $j('#nav:visible').length) {
			$window.scroll(function () {
				var top = $j('.subhead-content').outerHeight(true);
				var move = $j('.isotope').outerHeight(true);
				var scroll = $doc.scrollTop();
							
				if(scroll >= top) { // should be sticky header
					if($j('.hub-filters').hasClass('sticky')) {
						//
					} else {
						$j('.hub-filters').addClass('sticky');
					}
				} else { // should be flowed header
					if($j('.hub-filters').hasClass('sticky')) {
						$j('.hub-filters').removeClass('sticky');
					} else {
					 //
					}
				}
			});
		}
		
		// isotope
		
		var w = $j('#isotope').outerWidth();
		var column = Math.ceil(w * 0.4);
		if($notouch.length && $j('#nav:visible').length) {
		var gutter = Math.floor(w * 0.2);
		} else {
		var gutter = Math.floor(w * 0.1);
		}
		var min = <?php echo get_option('posts_per_page'); ?>;
				
		//console.log( w + ', ' + column + ', ' + gutter);
		
		var $isotope = $j('#isotope'),
			isotopeOptions = {},
			// defaults, used if not explicitly set in hash
          	defaultOptions = {
        		filter: '*'
        	};
		
		$isotope.imagesLoaded(function() {
			$isotope.isotope({
				masonry: {
					columnWidth: column,
					gutterWidth: gutter
				},
				itemSelector: '.cat'
			});
					if($j('.isotope-item:visible').length < min) {
						$j('#pbd-alp-load-posts a').trigger('click');
						//console.log('hashchange click');
					}
		});
		
// 		function getMore() {
// 			var vis = $j('.isotope-item:visible');
// 			var start = vis.length;
// 			
// 			if(start < min) {
// 				for(start; start < min; start = $j('.isotope-item:visible').length) {
// 				$j('#pbd-alp-load-posts a').trigger('click');
// 				console.log('click one!');
// 				}
// 			} else {
// 				for(var start = vis.length; start < min; start = vis.length) {
// 				$j('#pbd-alp-load-posts a').trigger('click');
// 				console.log('click two!');
// 				}
// 			}
//  	}
 		
 		// get individual filters
 		
 		var $optionSets = $j('.filter-list').find('.filter'),
 			isOptionLinkClicked = false;
		
      // switches selected class on buttons
      function changeSelectedLink( $elem ) {
        // remove selected class on previous item
        $j('.selected').removeClass('selected');
        // set selected class on new item
        $elem.addClass('selected');
      }
      
		// filter items when filter link is clicked
		$optionSets.find('a').on('click', function(){
			var $this = $j(this);
			if($this.hasClass('selected')) {
				return;
			}
			changeSelectedLink($this);
			
			var href = $this.attr('href').replace( /^#/, '' ),
				// convert href into object
				// i.e. 'filter=.inner-transition' -> { filter: '.inner-transition' }
				option = $j.deparam( href, true );
			// apply new option to previous
			$j.extend( isotopeOptions, option );
			//console.log(option);
			// set hash, triggers hashchange on window
			$j.bbq.pushState( isotopeOptions );
			isOptionLinkClicked = true;
			return false;
		});
		
		var hashChanged = false;
			
      $j(window).bind( 'hashchange', function( event ){
        // get options object from hash
        var hashOptions = window.location.hash ? $j.deparam.fragment( window.location.hash, true ) : {},
            // do not animate first call
            aniEngine = hashChanged ? 'best-available' : 'none',
            // apply defaults where no option was specified
            options = $j.extend( {}, defaultOptions, hashOptions, { animationEngine: aniEngine } );
            //console.log(hashOptions);
        // apply options from hash
        $isotope.isotope( options );
					if($j('.isotope-item:visible').length < min) {
						$j('#pbd-alp-load-posts a').trigger('click');
						//console.log('hashchange click');
					}
        // save options
        isotopeOptions = hashOptions;
    
        // if option link was not clicked
        // then we'll need to update selected links
        if ( !isOptionLinkClicked ) {
          // iterate over options
          var hrefObj, hrefValue, $selectedLink;
          for ( var key in options ) {
            hrefObj = {};
            hrefObj[ key ] = options[ key ];
            // convert object into parameter string
            // i.e. { filter: '.inner-transition' } -> 'filter=.inner-transition'
            hrefValue = $j.param( hrefObj );
            // get matching link
            $selectedLink = $optionSets.find('a[href="#' + hrefValue + '"]');
            changeSelectedLink( $selectedLink );
          }
        }
    
        isOptionLinkClicked = false;
        hashChanged = true;
      })
        // trigger hashchange to capture any hash data on init
        .trigger('hashchange');

// 			var selector = $j(this).attr('data-filter');
// 			$isotope.isotope({ filter: selector }, function noResultsCheck() {
// 				var noItems = $j('<div class="cat no-results"><p>Sorry Charlie</p></div>');
// 				var yesItems = $j('.no-results');
// 				var numItems = $j('.cat:not(.isotope-hidden)').length;
// 				if (numItems == 0) {
// 					$isotope.append(noItems).isotope( 'appended', noItems );
// 				}else{ 
// 					$isotope.isotope( 'remove', yesItems);
// 				}
// 			});
// 			return false;
// 		});

		$j('.filter-list .filter:not(.selected) a').hover(function() {
			var selector = $j(this).attr('href');
            hrefObj = {};
            hrefObj[ key ] = selector[ key ];
            hrefValue = $j.param( hrefObj );
            // get matching link
            $selectedLink = $optionSets.find('a[href="#' + hrefValue + '"]');
			$selected.toggleClass('selected');
			//console.log(selector);
		});

		// PLAY ARCHIVE SHOW/HIDE
		$j('.arch-expand').click(function(e) {
			e.preventDefault();
			if($j(this).parent().hasClass('orange')) {
				$j(this).html('<h4>+</h4>');
				$j(this).parent().removeClass('orange', 500).next('.archives').removeClass('orange', 500).slideToggle(700);
			} else {
				$j(this).html('<h4>- </h4>')
				$j('.orange').removeClass('orange', 500).next('.archives').removeClass('orange', 500).slideToggle(700);
				$j(this).parent().addClass('orange').next('.archives').addClass('orange').slideToggle(700);
			}
		});
		
		// RESIZE VIDEOS
		
		$j(function() {

			// Find all YouTube videos
			var $allVideos = $j("iframe[src^='http://www.youtube.com']"),

				// The element that is fluid width
				$fluidEl = $j(".slide");

			// Figure out and save aspect ratio for each video
			$allVideos.each(function() {

				$j(this)
					.data('aspectRatio', this.height / this.width)
			
					// and remove the hard coded width/height
					.removeAttr('height')
					.removeAttr('width');

			});

			// When the window is resized
			// (You'll probably want to debounce this)
			$j(window).resize(function() {

				var newWidth = $fluidEl.width();
		
				// Resize all videos according to their own aspect ratio
				$allVideos.each(function() {

					var $el = $j(this);
					$el
						.width(newWidth)
						.height(newWidth * $el.data('aspectRatio'));

				});

			// Kick off one resize to fix all videos on page load
			}).resize();

		});

		// SINGLE PLAY SCROLL STICKY
		
		if($j('.single .play .slider').length) {
		
			var left = $j('.play-text .centerwrap').position().left;
			var offset = $j('.play-text .centerwrap').width();
			var updown = left + offset - 50;
			
			$j('.updown').css('left', updown + 'px');
			
			console.log('single play');
		
			$gallery.cycle({
				slideExpr: '.slide',
				fx:    'scrollLeft', 
				speed:  800,
				slideResize: 0,
				pager: '.slidenav'
			});
			$gallery.cycle('pause');			
			
			$gallery.imagesLoaded(function() {
				var height = $j('.slider').height();
				$j('.image').delay(700).css('overflow', 'hidden').animate({ 'height': (height * .5)+'px' }, 700);
			});
			
			$j('.image .updown').click(function() {
				var height = $j('.slider').height();
				if($j('.image').hasClass('open')) {
					$j('.image').animate({ 'height': (height * .5)+'px'}, 700).removeClass('open');
					$j('.image .updown').css('background-position', '0 50%');
					$gallery.cycle('pause');
				} else {
					$j('.image').animate({ 'height': height}, 700).addClass('open');
					$j('.image .updown').css('background-position', '-15px 50%');
					$gallery.cycle('resume');
				}
			})
		}
		
		// STAFF AND BOARD
		var prducrPadding = $j('div.subhead-content div.centerwrap').css('padding-bottom');
		$j('.producer').click(function() {
			var prdcr = $j(this);
			var id = prdcr.data('id');
			if( prdcr.hasClass('open') ) {
				// if open then close and hide vis
				//console.log('self open')
				$j('.prod-info[data-id="'+id+'"]').removeClass('open').slideUp('slow', function(){
					$j('div.subhead-content div.centerwrap').animate({ 'padding-bottom' : prducrPadding }, 'fast');
					$j('.producer').removeClass('open');
				});
			} else if($j('.prod-info[data-id="'+id+'"]').siblings('.prod-info').hasClass('open')) {
				//console.log('sibling open');
				$j('.prod-info[data-id="'+id+'"]').siblings('.prod-info').slideUp('slow').removeClass('open');
				$j('.prod-info[data-id="'+id+'"]').slideDown('slow').addClass('open');
				$j('.producer').removeClass('open');
				prdcr.addClass('open');
			} else {
				// if closed then open and show vis
				//console.log('not open');
				$j('div.subhead-content div.centerwrap').animate(
					{ 'padding-bottom' : 0 }, 'fast', function() {
					$j('.prod-info[data-id="'+id+'"]').addClass('open').slideDown('slow');
					prdcr.addClass('open');
				});
			}
		});
		
		// TICKETS
		$j('a.tix-info').click(function(e) {
			e.preventDefault();
			var thisOpen = $j(this).closest('div.active-tix').next('div.tix-info');
			$j('div.tix-info').not(thisOpen).slideUp();
			thisOpen.slideToggle();
		});
		
		// zone color reveal
		function elementAboveFold(el) {
		  var top = el.offsetTop;
		
		  while(el.offsetParent) {
			el = el.offsetParent;
			top += el.offsetTop;
		  }
		  return (
			( ( window.pageYOffset + window.innerHeight ) - top )
		  );
		}		
		
		var homehead = $j('div#header.home');
		if(homehead.length){
			homeheadel = document.getElementById('header');
			var headshow = elementAboveFold(homeheadel);
			//console.log(headshow);
			var hhHeight = homehead.height();
			if(headshow < hhHeight + 30 ) {
				//console.log(headshow - hhHeight - 30);
				var scrollToHead = hhHeight + 30 - headshow,
					scrollTime = scrollToHead*5;
				$j('html, body').animate({
					scrollTop: scrollToHead 
				 }, scrollTime );
			}
		}
		
		//set beginning and current background colors
		// final color = #242535, R:36, G:37, B:53
		$j('div#content div.section, div#content div.subhead-content, div#content div.features').each(function(){
			var bgCol = $j(this).css('background-color');
			var elTop = elementAboveFold(this) - 100;
			var wScroll = window.pageYOffset;
			//console.log('scroll'+wScroll);
			$j(this).data("finCol", bgCol );
			if(	elTop < 0 ) { $j(this).css('background-color', '#242535'); }
		});
		
		$j(window).scroll(function(){
			newScroll = window.pageYOffset;			   
			$j('div#content div.section, div#content div.subhead-content, div#content div.features').each(function(){
				var elToppos = elementAboveFold(this) - 100;
				if(	elToppos > 0 ) {
					var finCol = $j(this).data("finCol");
					if( elToppos < 100 ) {
						var percent = elToppos/100;
						if(	newScroll > wScroll	){ // scrolling down
							$j(this).stop(true).animate({
								backgroundColor: $j.Color('#242535').transition( finCol, percent )
							}, 500 );
						} else { // scrolling up
							$j(this).stop(true).animate({
								backgroundColor: $j.Color(finCol).transition( '#242535', 1 - percent )
							}, 500 );
						}
					} else { // past full
						$j(this).stop(true).animate({
							backgroundColor: finCol
						}, 500 );
					}
				} else { // back to hide
					$j(this).stop(true).animate({
						backgroundColor: '#242535'
					}, 500 );
				}
				wScroll = newScroll;
			});
		});
		
		
		// subNav horizontal adjustment
		$j('div#nav ul.menu li').has( "ul li" ).each( function() {//.each on any nav items with sub items
			//get center position of this element in relation to full width
			var mNavItem = $j(this);
			var mniPos = mNavItem.position();
			var center = mNavItem.outerWidth()/2;
			var subNav = $j('.sub-menu li');
			//mNavItem
			$j('~ li', this).each(function(){
				center += $j(this).outerWidth();
				console.log( $j(this).outerWidth() );			  
			});
			var parCenter = mNavItem.parent().width();
			var subnavWidth = 0;
			mNavItem.find('.sub-menu li').each(function(){
				subnavWidth += $j(this).outerWidth();									
			});
			//
			if( parCenter/2 < center ) {
				//	mNavItem is more left of center
				if( ( ( parCenter/2 ) - (subnavWidth/2) ) < ((center - (parCenter/2))*2) ) {
					//too wide to move that far
					mNavItem.find('.sub-menu li').first().css('margin-left', '-'+ ( ( parCenter/2 ) - (subnavWidth/2) ) + 'px' );
				}else{
					mNavItem.find('.sub-menu li').first().css('margin-left', '-'+ ((center - (parCenter/2))*2) + 'px' );
				}
			} else {
				if( ( ( parCenter/2 ) - (subnavWidth/2) ) < ( ( (parCenter/2) - center ) * 2 ) ) {
					//too wide to move that far
					mNavItem.find('.sub-menu li').first().css('margin-left', ( ( parCenter/2 ) - (subnavWidth/2) ) + 'px' );
				}else{
					mNavItem.find('.sub-menu li').first().css('margin-left', ( (parCenter/2) - center ) * 2 + 'px' );
				}
			}
			subNav.visible();
		});
		
		// Header Mailing List
		
		if($notouch.length) {
			// get the position and offsetwidth of the mailing-list-link
			var $link = $j('li.mailing-list-link');
			var $div = $j('.mailing.head');
			var $cont = $j('#nav').outerWidth();
			var width = $div.outerWidth();
			var left = $link.position().left;
			var offset = $link.outerWidth();
			var right = left + offset - width;
			console.log($link);
			console.log('$cont:' + $cont + ', left:' +left + ', offset:' + offset + ', width:' + width);
			
			// set mailing-list right pos
			$div.css('left', right+'px');
			
			// show mailing-list on click
			$link.click(function(e) {
				e.preventDefault();
				if($div.hasClass('open')) {
					$link.removeClass('active');
					$div.slideUp().removeClass('open');
				} else {
					$link.addClass('active');
					$div.slideDown().addClass('open');
				}
			});
		}
		
		// Mininav functions
		
		var $mini = $j('#drop-nav');
		
		$mini.change(function() {
			var $sel = $mini.find('option:selected');
			if($sel.hasClass('mailing-list-link')) {
				$j('html, body').animate({scrollTop:$j(document).height()}, 500);
			} else {
				window.location = $mini.find('option:selected').val();
			}
		});

	});

	</script>
<?php wp_footer(); ?>
</body>
</html>