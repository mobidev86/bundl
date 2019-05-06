'use strict';
$ = jQuery;
$(function () {
	var $window = $(window),
		$document = $(document),
		$body = $('body'),
		ww, wh, ot, lastScroll = 0,
		pillarsCarousel, reasonsCarousel, highlightsCarousel, storiesCarousel, clientLogosInterval, breakpoint = 768,
		headerHeight = 66,
		scrollController = new ScrollMagic.Controller();
	if ($('.logosliderV').length) $(function () {
		var x = 0,
			intervalTime = 20;
		setInterval(function () {
			x -= 1;
			$('.logosliderV .wrapper').css('background-position', '0 ' + x + 'px')
		}, intervalTime)
	});
	if ($('.logosliderH').length) $(function () {
		var x = 0,
			intervalTime = 20;
		setInterval(function () {
			x -= 1;
			$('.logosliderH .wrapper').css('background-position', x + 'px 0')
		}, intervalTime)
	})

	function init() {
		initDrawAnimations();
		initNavigation();
		initPillars();
		initLogos();
		initReasons();
		initFeaturedStory();
		initHomeCarousel();
		initBlogPosts();
		initMediaCarousel();
		initOfficeTimes();
		initServiceFlow();
		initContactIntro();
		updateContactNav();
		initSplash();
		addListeners();
		initScrollToForm()
	}

	function initScrollToForm() {
		if ($('a#scrolltoform').length) setTimeout(function () {
			$('a#scrolltoform').click()
		}, 1)
	}

	function addListeners() {
		$('#nav-toggle').on('click', toggleNavigation);
		$('.btn-chat').on('click', toggleChat);
		$('.btn-play').on('click', playVideo);
		$('.btn-unlock').on('click', unlockCase);
		$('.story-nav a').on('click', scrollTo);
		$('.section-intro .inner > .showContactForm').on('click', showContactForm);
		$('.section-intro .btn-close').on('click', closeContactForm);
		$('.section-startups .inner > .btn-green').on('click', showGarageForm);
		$('.section-startups .btn-close').on('click', closeGarageForm);
		$('.offices h4').on('click', toggleOffice);
		$('.pillar-item, .cta-item').on('click', triggerMoreLink);
		$('.pillars').on('changed.owl.carousel initialized.owl.carousel', updatePillarsCarousel);
		$('.contact-form').on('DOMSubtreeModified', updateContactNav);
		$('form').on('keyup keypress', preventFormSubmit);
		$('a#scrolltoform').on('click', scrollTo);
		initVentures();
		$window.on('load resize', resizeHandler)
	}

	function resizeHandler() {
		ww = $window.width();
		wh = $window.height();
		resizeNavigation();
		resizeFeaturedStory();
		resizePillars();
		resizeReasons();
		resizeHighlights();
		resizeCTA();
		resizeCases();
		resizeContactInformation();
		resizeContactForm();
		resizePager();
		resizeClientLogos();
		resizeVentureOnDemand();
		resizeHomepageIntro();
		var posts = document.querySelectorAll('.col-sm-4.blogitem');
		imagesLoaded(posts, function () {
			pubequalHeights($(".col-sm-4.blogitem"), $(".col-sm-4.blogitem"))
		})
	}

	function initDrawAnimations() {
		$('.draw').not('.not-animated').each(function (i) {
			$(this).prepend('<object onload="applyDrawAnimation(' + i + ')" id="draw-' + i + '" type="image/svg+xml" data="' + templateUrl + '/assets/images/draw-animated.svg"></object>')
		})
	}

	function initSplash() {
		if ($body.hasClass('splash')) {
			var $videoHome = $('video');
			if ($videoHome.length) {
				setTimeout(function () {
					$body.removeClass('splash')
				}, 1e3);
				var $playButton = $('.section-intro .btn-play');
				$playButton.addClass('hidden');
				setTimeout(function () {
					$playButton.trigger('click')
				}, 0)
			} else $body.removeClass('splash')
		}
	}

	function initNavigation() {
		var bodyClasses = '';
		if ($(".js-dark-nav").length > 0) var inview = new Waypoint.Inview({
			element: $('.js-dark-nav'),
			enter: function enter(direction) {
				$('header').removeClass('light')
			},
			exited: function exited(direction) {
				$('header').addClass('light')
			}
		});
		var location = window.location.pathname.split('/')[1];
		if (location !== undefined)
			if (location == '') {
				bodyClasses += 'page-home'
			} else {
				var $item = $('nav.primary li').filter(function () {
					return $.trim($(this).text().toLowerCase()) == $.trim(location.toLowerCase())
				});
				$item.addClass('selected');
				bodyClasses += 'page-' + $item.text().toLowerCase()
			};
		var sublocation = window.location.pathname.split('/')[2];
		if (sublocation !== undefined) $('nav.secondary li').filter(function () {
			return $.trim($(this).text().toLowerCase()) == $.trim(sublocation.split('.')[0].toLowerCase().replace(/-/g, ' '))
		}).addClass('selected');
		$body.addClass(bodyClasses)
	}

	function toggleNavigation(e) {
		e.preventDefault();
		var $this = $(this);
		$body.toggleClass('nav-active')
	}

	function scrollTo(e) {
		e.preventDefault();
		var $this = $(this),
			offset = $('header').height(),
			duration = 1e3;
		if ($this.data('offset') !== undefined) offset = $this.data('offset');
		if ($this.data('duration') !== undefined) offset = $this.data('duration');
		$('html, body').animate({
			scrollTop: $($this.data('element')).offset().top - offset
		}, duration)
	}

	function resizeNavigation() {
		if (ww >= breakpoint) $body.removeClass('nav-active')
	}

	function resizePager() {
		var $pager = $('.section-pager a');
		if ($pager.length) {
			$pager.removeAttr('style');
			equalHeights($pager, $pager)
		}
	}

	function initBlogPosts() {
		equalHeights($('.blog-item h3'), $('.blog-item h3'));
		if ($(".blogDetail").length > 0) {
			$(".bef-select-as-links .active").removeClass("active");
			$(".bef-select-as-links #edit-cat-" + $(".blogDetail").attr("data-cat") + " a").addClass("active")
		};
		if ($(".view-blog .filterhuls").length > 0) {
			$(".form-type-bef-link a").off();
			$(".form-type-bef-link a").on("click", function (e) {
				window.location = $(this).attr("href");
				return false
			})
		}
	}

	function toggleChat(e) {
		e.preventDefault();
		talkus('open')
	}

	function resizeClientLogos() {
		var $logos = $('.section-clients .client-logos, .section-media .client-logos');
		if ($logos.length) {
			var isotopeEnabled = $logos[0].hasAttribute('style');
			if (ww < breakpoint) {
				if (!isotopeEnabled) {
					$logos.isotope({
						itemSelector: 'li',
						sortBy: 'random',
						layoutMode: 'horiz',
						transitionDuration: 300,
						horiz: {
							verticalAlignment: 0.5
						}
					});
					clientLogosInterval = setInterval(function () {
						$logos.isotope('shuffle')
					}, 5e3)
				}
			} else if (isotopeEnabled) {
				clearInterval(clientLogosInterval);
				$logos.isotope('destroy')
			}
		}
	}

	function showGarageForm(e) {
		e.preventDefault();
		$('.garage-form').removeClass('hidden')
	}

	function closeGarageForm(e) {
		e.preventDefault();
		$('.garage-form').addClass('hidden')
	}

	function resizePillars() {
		var $pillars = $('.pillars');
		if ($pillars.length) {
			var $pillarItems = $pillars.find('.pillar-item'),
				$pillarTitles = $pillars.find('h3'),
				isCarousel = pillarsCarousel !== undefined;
			if (ww <= breakpoint) {
				if (!isCarousel) initPillarsCarousel($pillars)
			} else if (isCarousel) destroyPillarsCarousel();
			if (isCarousel) {
				equalHeights($pillarItems, $pillars.find('.owl-stage'))
			} else {
				$pillarItems.removeAttr('style');
				equalHeights($pillarItems, $pillarItems);
				equalHeights($pillarTitles, $pillarTitles)
			}
		}
	}

	function initPillars() {
		inView($('.pillars'), $('.pillar-item'))
	}

	function initPillarsCarousel($pillars) {
		pillarsCarousel = $pillars.owlCarousel({
			items: 1,
			center: true,
			loop: true,
			responsive: {
				0: {
					stagePadding: 50
				},
				481: {
					stagePadding: 120
				},
				570: {
					stagePadding: 140
				},
				640: {
					stagePadding: 160
				},
				720: {
					stagePadding: 180
				}
			}
		});
		equalHeights($pillars.find('.pillar-item'), $pillars.find('.owl-stage'))
	}

	function updatePillarsCarousel(e) {
		var index = e.item.index;
		if (isNumber(index)) {
			var $items = $('.pillars .owl-item'),
				$thisItem = $items.eq(index);
			$items.removeClass('left right');
			$thisItem.prevAll().addClass('left');
			$thisItem.nextAll().addClass('right')
		}
	}

	function destroyPillarsCarousel() {
		pillarsCarousel.trigger('destroy.owl.carousel');
		pillarsCarousel = function () {
			return
		}()
	}

	function initReasons() {
		inView($('.reasons'), $('.reason-item'))
	}

	function resizeReasons() {
		var $reasons = $('.reasons');
		if ($reasons.length) {
			var $reasonItems = $reasons.find('.reason-item'),
				$reasonTitles = $reasons.find('h3'),
				isCarousel = reasonsCarousel !== undefined;
			if (ww <= breakpoint) {
				if (!isCarousel) initReasonsCarousel($reasons)
			} else if (isCarousel) destroyReasonsCarousel();
			if (isCarousel) {
				equalHeights($reasonItems, $reasons.find('.owl-stage'))
			} else {
				$reasonItems.removeAttr('style');
				equalHeights($reasonItems, $reasonItems);
				equalHeights($reasonTitles, $reasonTitles)
			}
		}
	}

	function initReasonsCarousel($reasons) {
		reasonsCarousel = $reasons.owlCarousel({
			items: 1,
			center: true,
			loop: true,
			autoplay: true,
			autoplayTimeout: 5e3,
			autoplayHoverPause: true,
			autoplaySpeed: 200
		});
		equalHeights($reasons.find('.reason-item'), $reasons.find('.owl-stage'))
	}

	function destroyReasonsCarousel() {
		reasonsCarousel.trigger('destroy.owl.carousel');
		reasonsCarousel = function () {
			return
		}()
	}

	function resizeHighlights() {
		var $highlights = $('.highlights');
		if ($highlights.length) {
			var $reasonItems = $highlights.find('.highlight-item'),
				isCarousel = highlightsCarousel !== undefined;
			if (ww < breakpoint) {
				if (!isCarousel) initHighlightsCarousel($highlights)
			} else if (isCarousel) destroyHighlightsCarousel()
		}
	}

	function initHighlightsCarousel($highlights) {
		highlightsCarousel = $highlights.owlCarousel({
			items: 1,
			center: true,
			loop: true,
			autoplay: true,
			autoplayTimeout: 5e3,
			autoplayHoverPause: true,
			autoplaySpeed: 200
		})
	}

	function destroyHighlightsCarousel() {
		highlightsCarousel.trigger('destroy.owl.carousel');
		highlightsCarousel = function () {
			return
		}()
	}

	function resizeCTA() {
		var $cta = $('.cta-item span.sh');
		if ($cta.length)
			if (ww >= breakpoint) equalHeights($cta, $cta)
	}

	function resizeCases() {
		var $cases = $('.case-item'),
			$cases_p = $('.case-item .sh');
		if ($cases.length) {
			$cases.removeAttr('style');
			equalHeights($cases, $cases);
			equalHeights($cases_p, $cases_p)
		}
	}

	function setCaseTitle() {
		$('.case-item.unlocking .form-email').off("click", setCaseTitle);
		var caseTitle = $(".case-item.unlocking .formwrapper").data("case");
		$('.case-item.unlocking .webform-component--case input').val(caseTitle)
	}

	function unlockCase(e) {
		e.preventDefault();
		var $this = $(this),
			$item, $formdestination;
		if ($this.hasClass('case-item')) {
			$item = $this
		} else $item = $this.parents('.case-item'); if ($('.form-loader .links').length && $(".form-module .webform-confirmation").length) {
			$('.links a.ajax-processed')[0].dispatchEvent(new Event('mousedown'));
			$(".form-module .webform-confirmation").remove()
		};
		$('.case-item').removeClass('unlocking');
		$item.addClass('unlocking');
		$formdestination = $item.find('.form-loader');
		$(".form-module :input").removeClass("error");
		$(".form-module").appendTo($formdestination);
		var checkForm = setInterval(function () {
			if ($('.case-item.unlocking .form-email').length) {
				$('.case-item.unlocking .form-email').on("click", setCaseTitle);
				clearInterval(checkForm)
			}
		}, 10)
	}

	function initChatButton() {
		var offset = 300,
			offset_opacity = 300,
			$back_to_top = $('.cd-top');
		$(window).scroll(function () {
			($(this).scrollTop() > offset) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
			if ($(this).scrollTop() > offset_opacity) $back_to_top.addClass('cd-fade-out')
		})
	}

	function resizeHomepageIntro() {
		var $ventureIntro = $('.section-homepage-intro');
		if ($ventureIntro.length) {
			equalOuterHeights($('.section-homepage-intro .tag'), $('.section-homepage-intro .tag'));
			equalOuterHeights($('.section-homepage-intro .title'), $('.section-homepage-intro .title'));
			equalOuterHeights($('.section-homepage-intro .content'), $('.section-homepage-intro .content'));
			equalOuterHeights($('.section-homepage-intro .left'), $('.section-homepage-intro .center'))
		}
	}

	function resizeVentureOnDemand() {
		var $ventureIntro = $('.section-venture-intro');
		if ($ventureIntro.length) {
			equalOuterHeights($('.section-venture-intro .tag'), $('.section-venture-intro .tag'));
			equalOuterHeights($('.section-venture-intro .title'), $('.section-venture-intro .title'));
			equalOuterHeights($('.section-venture-intro .left .content'), $('.section-venture-intro .center .content'))
		}
	}

	function initContactIntro() {
		var $intro = $('.js-contact-intro');
		if ($intro.length) {
			var $heading = $intro.find('h1');
			Modernizr.on('videoautoplay', function (result) {
				if (result) {
					$intro.find('video').on('timeupdate', function (e) {
						var location = '',
							time = this.currentTime;
						if (time > 0 && time <= 3.3) {
							location = 'New York'
						} else if (time > 3.3 && time <= 7) location = 'Antwerp';
						var sentence = 'You can find us in <br><strong class="draw not-animated">' + location + '</strong>';
						if ($heading.html() != sentence) $heading.html(sentence)
					})
				} else $heading.html('We\'re just <strong class="draw not-animated">around</strong> the corner')
			})
		}
	}

	function updateContactNav(e) {
		var index = $('.contact-form input[name="details[page_num]"]').val() - 1;
		$('.contact-form ul.form-nav li').removeClass("active");
		$('.contact-form ul.form-nav li:eq(' + index + ')').addClass("active")
	}

	function showContactForm(e) {
		e.preventDefault();
		$('.section-intro > .inner').addClass('hidden');
		$('#intro-video').addClass('hidden-video');
		$('.section-intro .contact-form').removeClass('hidden');
		resizeContactForm()
	}

	function closeContactForm(e) {
		e.preventDefault();
		$('.section-intro > .inner').removeClass('hidden');
		$('#intro-video').removeClass('hidden-video');
		$('.section-intro .contact-form').addClass('hidden')
	}

	function resizeContactInformation() {
		var $info = $('.contact-item');
		if ($info.length) {
			$info.removeAttr('style');
			if (ww >= breakpoint) equalHeights($info, $info)
		}
	}

	function resizeContactForm() {}

	function toggleOffice() {
		var $item = $(this).parent();
		$item.toggleClass('expanded')
	};
	var $story_images = new Array();
	if ($('.featured-story-layers').length) $('.story-item').each(function (i) {
		$story_images[i] = new Array();
		var identifier = $(this).data('identifier'),
			$layers_specific = '.featured-story-layers.' + identifier;
		for (var j = 0; j < $($layers_specific).find('img').length; j++) {
			$story_images[i][j] = new Image();
			$story_images[i][j].src = $($layers_specific + ' img').eq(j).attr('src')
		}
	})

	function initFeaturedStory($layers) {
		var $layers = $('.featured-story-layers');
		if ($layers.length) {
			var wrapperScene = new ScrollMagic.Scene({
					triggerElement: '.stories',
					triggerHook: 0,
					duration: function duration() {
						return $('.stories').height()
					},
					offset: -headerHeight
				}).setClassToggle('.story-nav, .featured-story-layers', 'stuck').addTo(scrollController),
				steamScene = new ScrollMagic.Scene({
					triggerElement: '.stories',
					triggerHook: 0,
					duration: function duration() {
						return $('.stories').height() - $('.story-item:last-child').height() / 2
					}
				}).setClassToggle('.steam', 'stuck').addTo(scrollController);
			$('.story-item').each(function (i) {
				var selector = '.story-item:nth-child(' + (i + 1) + ')',
					tween = TweenMax.to('.layer', 0.5, {
						className: '-=switch',
						repeat: 1,
						yoyo: true
					}),
					storyScene = new ScrollMagic.Scene({
						triggerElement: selector,
						duration: function duration() {
							return $(selector).height()
						},
						offset: -(headerHeight * 2)
					}).setTween(tween).setClassToggle('.story-nav li:nth-child(' + (i + 1) + ')', 'active').addTo(scrollController).on('enter', function (event) {
						$layers.eq(0).find('img').each(function (k) {
							$(this).attr('src', $story_images[i][k].src)
						})
					})
			})
		}
	}

	function resizeFeaturedStory() {
		var $layers = $('.featured-story-layers');
		if ($layers.length) equalHeights($('body').find('.storiesH'), $('.featured-story-layers, .storiesH'));
		var $stories = $('.stories');
		if ($stories.length) {
			var $pillarItems = $stories.find('.story-item'),
				isCarousel = storiesCarousel !== undefined;
			if (ww <= breakpoint) {
				if (!isCarousel) initStoriesCarousel($stories)
			} else if (isCarousel) destroyStoriesCarousel()
		}
	}

	function initStoriesCarousel($stories) {
		var $layers = $('.featured-story-layers').eq(0),
			$layerImages = $layers.find('img');
		if ($('.featured-story-layers').length > 1) {
			storiesCarousel = $stories.owlCarousel({
				items: 1,
				center: true,
				loop: true
			});
			storiesCarousel.on('changed.owl.carousel', function (e) {
				var identifier = $('.story-item').eq(e.item.index).data('identifier'),
					storyIndex = ($('.story-nav li.' + identifier).index());
				if ($layers.data('identifier') != identifier) {
					$layerImages.addClass('switch');
					setTimeout(function () {
						$layerImages.each(function (i) {
							$(this).attr('src', $story_images[storyIndex][i].src)
						});
						$layers.data('identifier', identifier);
						$layerImages.removeClass('switch')
					}, 300)
				}
			})
		};
		$layerImages.removeClass('switch').removeAttr('style');
		scrollController.enabled(false)
	}

	function destroyStoriesCarousel() {
		storiesCarousel.trigger('destroy.owl.carousel');
		storiesCarousel = function () {
			return
		}();
		$('.featured-story-layers img').addClass('switch');
		scrollController.enabled(true);
		scrollController.update(true)
	}

	function initLogos() {
		inView($('.logos'), $('.logos li'))
	}

	function initHomeCarousel() {
		var $carousel = $('.section-culture .images-carousel-wrapper'),
			options = {
				items: 5,
				slideBy: 1,
				loop: true,
				autoplay: true,
				autoplayTimeout: 3e3,
				autoplaySpeed: 1e3,
				autoplayHoverPause: true,
				responsive: {
					1414: {
						items: 6
					},
					2424: {
						items: 10
					}
				}
			};
		$carousel.owlCarousel(options)
	}

	function initMediaCarousel() {
		var $carousel = $('.section-social .images-carousel-wrapper'),
			options = {
				items: 3,
				slideBy: 1,
				loop: true,
				autoplay: true,
				autoplayTimeout: 3e3,
				autoplaySpeed: 1e3,
				autoplayHoverPause: true,
				responsive: {
					1024: {
						items: 5
					},
					1400: {
						items: 7
					}
				}
			};
		$carousel.owlCarousel(options)
	}

	function initInstagramCarousel($carousel, options) {
		if ($carousel.length) $.get($carousel.data('feed'), function (data) {
			var images = '';
			$(data).find('item').each(function () {
				var $this = $(this),
					$image = $($this.find('description').text()),
					src = $image.attr('src'),
					text = $this.find('title').text();
				text = text.replace(/(^|)(#[^ ]+)/ig, '<span>$2</span>');
				text = text.replace(/(^|)(@[^ ]+)/ig, '<span>$2</span>');
				images += '<a class="image-item" href="' + $this.find('link').text() + '" target="_blank" style="background-image: url(\'' + src + '\');"><div>' + text + '</div></a>'
			});
			$carousel.append(images);
			$carousel.owlCarousel(options)
		})
	}

	function initServiceFlow() {
		var $flow = $('.service-flow');
		if ($flow.length) var inview = new Waypoint.Inview({
			element: $flow[0],
			enter: function enter(direction) {
				var time = 300,
					timing = 0,
					$flowBlocks = $flow.find('.service-block');
				$flowBlocks.each(function (i) {
					var $this = $(this),
						$flowItems = $this.find('.service-item');
					setTimeout(function () {
						$this.addClass('show');
						$flowItems.each(function (i) {
							var $item = $(this),
								itemTiming = i * time;
							setTimeout(function () {
								$item.addClass('show')
							}, itemTiming)
						})
					}, timing);
					timing += $flowItems.length * time
				});
				inview.destroy()
			}
		})
	}

	function initOfficeTimes() {
		updateOfficeTimes();
		setInterval(function () {
			updateOfficeTimes()
		}, 6e4)
	}

	function updateOfficeTimes() {
		var $timeLabels = $('.present-time'),
			$timeBlocks = $('.contact-item'),
			startDay = 8,
			endDay = 8;
		if ($timeLabels.length) $('.present-time').each(function () {
			var $this = $(this);
			if ($this.attr('data-timezone')) {
				var time_tmp = moment().tz($this.data('timezone')),
					time = time_tmp.format('hh:mm a'),
					state;
				if ((time_tmp.format('a') == "am" && time_tmp.format('h') >= startDay && time_tmp.format('h') < 12) || (time_tmp.format('a') == "pm" && (time_tmp.format('h') <= endDay || time_tmp.format('h') == 12))) {
					state = "day"
				} else state = "night";
				$this.removeClass('day night');
				$this.text(time).addClass(state)
			}
		});
		if ($timeBlocks.length) $('.contact-item').each(function () {
			var $this = $(this);
			if ($this.attr('data-timezone')) {
				var time_tmp = moment().tz($this.data('timezone')),
					time = time_tmp.format('hh:mm a'),
					state;
				if ((time_tmp.format('a') == "am" && time_tmp.format('h') >= startDay && time_tmp.format('h') < 12) || (time_tmp.format('a') == "pm" && (time_tmp.format('h') <= endDay || time_tmp.format('h') == 12))) {
					state = "day"
				} else state = "night";
				$this.find('object').attr('data', templateUrl + '/assets/images/icon-' + state + '.svg')
			}
		})
	}

	function playVideo(e) {
		e.preventDefault();
		var $this = $(this),
			videoID = $this.data('video'),
			$video = $('#' + videoID);
		$video.removeClass('hidden-video');
		$video.find('video').get(0).play();
		$this.addClass('disabled')
	}

	function inView($wrapper, $items) {
		if ($wrapper.length) var inview = new Waypoint.Inview({
			element: $wrapper[0],
			enter: function enter(direction) {
				$items.addClass('in-view')
			}
		})
	}

	function equalHeights($toCheck, $toSet) {
		var heighestHeight = 0;
		$toSet.height('auto');
		$toCheck.each(function () {
			var height = $(this).height();
			if (height > heighestHeight) heighestHeight = height
		});
		$toSet.height(heighestHeight)
	}

	function equalOuterHeights($toCheck, $toSet) {
		var heighestHeight = 0;
		$toSet.height('auto');
		$toCheck.each(function () {
			var height = $(this).outerHeight();
			if (height > heighestHeight) heighestHeight = height
		});
		$toSet.height(heighestHeight)
	}

	function isNumber(n) {
		return !isNaN(parseFloat(n)) && isFinite(n)
	}

	function titleCase(string) {
		return string.charAt(0).toUpperCase() + string.slice(1)
	}

	function triggerMoreLink() {
		var $link = $(this).find('a');
		if ($link.is(':visible')) window.location = $link.attr('href')
	}

	function validateFields($fields) {
		var errors = 0;
		$fields.removeClass('error');
		$fields.each(function () {
			var $field = $(this),
				fieldType = $field.attr('type'),
				fieldValue = $field.val(),
				fieldRequired = $field.prop('required'),
				error = false;
			switch (fieldType) {
			case undefined:
				error = fieldValue.length <= 0 && fieldRequired;
				break;
			case 'email':
				var regex = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/i;
				error = fieldValue.length <= 0 && fieldRequired || fieldValue.match(regex) == null;
				break;
			case 'text':
			case 'tel':
				error = fieldValue.length <= 0 && fieldRequired;
				break
			};
			if (error) {
				errors++;
				$field.addClass('error').val('').attr('placeholder', $field.data('error'))
			}
		});
		return errors == 0
	}

	function preventFormSubmit(e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) {
			e.preventDefault();
			return false
		}
	};
	init()
})

function applyDrawAnimation(index) {
	var id = 'draw-' + index,
		animation = new Vivus(id, {
			duration: 30,
			type: 'oneByOne',
			start: 'manual',
			animTimingFunction: Vivus.EASE
		}),
		waypoint = new Waypoint({
			element: document.getElementById(id),
			handler: function handler(direction) {
				animation.play(1)
			},
			offset: '50%'
		})
};
$('a').each(function () {
	var a = new RegExp('/' + window.location.host + '/');
	if (!a.test(this.href) && this.href.indexOf("javascript:") != 0 && this.href.indexOf("mailto:") != 0 && this.href.indexOf("tel:") != 0) $(this).click(function (event) {
		event.preventDefault();
		event.stopPropagation();
		window.open(this.href, '_blank')
	})
});
var vfasegraphgc, vfasegraphgp, vfasegraphb = [],
	fasegraphgc, fasegraphp, fasegraphb, tfasegraphgc, tfasegraphp, tfasegraphb, ventureHolderTop, ventureHolderHeight, venturefaseHeight, ventureSliderHeight, currentVentureFase, ventureFases, ventureChangeListener, ventureLabel

function initVentures() {
	window.addEventListener('DOMContentLoaded', function () {
		new ModalVideo(".fase-video")
	});
	$(document).ready(function () {
		if ($("#fase-graph-complete").length > 0) {
			fasegraphgc = d3.select("#fase-graph-complete");
			fasegraphp = d3.select("#fase-graph-part");
			fasegraphb = d3.select("#fase-graph-background");
			fasegraphgc.append("g").attr("class", "labels");
			vfasegraphgc = vizuly.viz.radial_progress(document.getElementById("fase-graph-complete"));
			vfasegraphgp = vizuly.viz.radial_progress(document.getElementById("fase-graph-part"));
			vfasegraphb = vizuly.viz.radial_progress(document.getElementById("fase-graph-background"));
			vfasegraphgc.data(0).duration(1400).height(400).width(400).min(0).max(fase_totalweeks).capRadius(0).on("tween", vizonTween).on("mouseover", vizonMouseOver).on("mouseout", vizonMouseOut).on("click", vizonClick);
			vfasegraphgp.data(0).duration(1400).height(340).width(340).min(0).max(fase_totalweeks).capRadius(0).on("tween", vizonTween).on("mouseover", vizonMouseOver).on("mouseout", vizonMouseOut).on("click", vizonClick);
			vfasegraphb.data(fase_totalweeks).duration(0).height(400).width(400).min(0).max(fase_totalweeks).capRadius(0).on("tween", vizonTween).on("mouseover", vizonMouseOver).on("mouseout", vizonMouseOut).on("click", vizonClick);
			tfasegraphgc = vizuly.theme.radial_progress(vfasegraphgc).skin(vizuly.skin.RADIAL_PROGRESS_BUSINESS);
			tfasegraphp = vizuly.theme.radial_progress(vfasegraphgp).skin(vizuly.skin.RADIAL_PROGRESS_BUSINESS);
			tfasegraphb = vizuly.theme.radial_progress(vfasegraphb).skin(vizuly.skin.RADIAL_PROGRESS_BUSINESS);
			vfasegraphgc.startAngle(220).endAngle(140).arcThickness(.12).update();
			vfasegraphgp.startAngle(220).endAngle(140).arcThickness(.12).update();
			vfasegraphb.startAngle(180).endAngle(180).arcThickness(.01).update();
			var divWidth = 400;
			fasegraphgc.style("width", divWidth + 'px').style("margin-left", -(divWidth / 2) + "px").style("margin-top", -(divWidth / 2) + "px");
			vfasegraphgc.width(divWidth).height(divWidth).radius(divWidth / 2.2).update();
			divWidth = 320;
			fasegraphp.style("width", divWidth + 'px').style("margin-left", -(divWidth / 2) + "px").style("margin-top", -(divWidth / 2) + "px");
			vfasegraphgp.width(divWidth).height(divWidth).radius(divWidth / 2.2).update();
			divWidth = 302;
			fasegraphb.style("width", divWidth + 'px').style("margin-left", -(divWidth / 2) + "px").style("margin-top", -(divWidth / 2) + "px");
			vfasegraphb.width(divWidth).height(divWidth).radius(divWidth / 2.2).update();
			ventureFases = $(".section-venture-blocks-fases-container .fase").length;
			vizonSelectFase(0);
			ventureChangeListener = false;
			ventureHolderTop = $('.section-venture-blocks-fases').offset().top;
			ventureHolderHeight = $('.section-venture-blocks-fases').height();
			venturefaseHeight = $('.fase').height();
			ventureSliderHeight = $(".section-venture-blocks-fases-scroll").height();
			$('.section-venture-blocks-fases').addClass("fase-overscroll-margin");
			$(window).scroll(function () {
				venturesScroll()
			});
			$(window).resize(function () {
				ventureResize()
			});
			$(".fase-move-up").on("click", function (e) {
				e.preventDefault();
				vizonSelectPreviousFase()
			});
			$(".fase-move-down").on("click", function (e) {
				e.preventDefault();
				vizonSelectNextFase()
			});
			$(".fase-graph-pager-item").on("click", function (e) {
				e.preventDefault();
				vizonSelectIdxFase($(this).index())
			});
			$('.fase-box-slider').cycle({
				speed: 600,
				manualSpeed: 600,
				slides: "> div"
			}).cycle('pause');
			$(".fase a[href='#contactform']").on("click", function (e) {
				e.preventDefault();
				$('html, body').animate({
					scrollTop: $($(this).attr("href")).offset().top - $("header nav.primary ul").height()
				}, 1e3)
			})
		}
	})
}

function vizonTween(viz, i) {}

function vizonMouseOver(viz, d, i) {}

function vizonMouseOut(viz, d, i) {}

function vizonClick(viz, d, i) {}

function venturesScroll() {
	var windowTop = $(window).scrollTop(),
		controlsoffset = venturefaseHeight / 4;
	if (ventureHolderTop - controlsoffset < windowTop && ventureHolderTop + ventureHolderHeight - ventureSliderHeight > windowTop) {
		$(".fase-controls").css({
			position: 'fixed',
			bottom: '60px'
		});
		ventureChangeListener = true
	} else {
		if (ventureHolderTop < windowTop && ventureHolderTop + ventureHolderHeight - ventureSliderHeight <= windowTop) {
			$(".fase-controls").css({
				position: 'absolute',
				bottom: '60px'
			})
		} else $(".fase-controls").css({
			position: 'absolute',
			bottom: '60px'
		});
		ventureChangeListener = false
	}; if (ventureHolderTop < windowTop && ventureHolderTop + controlsoffset + ventureHolderHeight - ventureSliderHeight > windowTop) {
		$('.venturesticky').css({
			position: 'fixed',
			top: '0px',
			bottom: 'auto'
		});
		ventureChangeListener = true
	} else {
		if (ventureHolderTop < windowTop && ventureHolderTop + ventureHolderHeight - ventureSliderHeight <= windowTop) {
			$('.venturesticky').css({
				position: 'absolute',
				bottom: '0px',
				top: 'auto'
			})
		} else $('.venturesticky').css({
			position: 'relative',
			top: 'auto',
			bottom: 'auto'
		});
		ventureChangeListener = false
	}; if (ventureChangeListener) {
		var scrolledrest = windowTop - ventureHolderTop;
		scrolledrest = Math.floor((scrolledrest / venturefaseHeight) + 0.3);
		if (Math.floor(scrolledrest) != currentVentureFase) vizonSelectFase(Math.floor(scrolledrest))
	}
}

function ventureResize() {
	$('.fase-overscroll-margin').removeClass("fase-overscroll-margin");
	ventureHolderTop = $('.section-venture-blocks-fases').offset().top;
	ventureHolderHeight = $('.section-venture-blocks-fases').height();
	venturefaseHeight = $('.fase').height();
	ventureSliderHeight = $(".section-venture-blocks-fases-scroll").height();
	$('.section-venture-blocks-fases').addClass("fase-overscroll-margin")
}

function vizonSelectPreviousFase() {
	if (currentVentureFase > 0) {
		var ventureTarget = currentVentureFase - 1;
		$('html, body').animate({
			scrollTop: $(".fase:eq(" + ventureTarget + ")").offset().top
		}, 800)
	}
}

function vizonSelectNextFase() {
	if (currentVentureFase < ventureFases - 1) {
		var ventureTarget = currentVentureFase + 1;
		$('html, body').animate({
			scrollTop: $(".fase:eq(" + ventureTarget + ")").offset().top
		}, 800)
	}
}

function vizonSelectIdxFase(idx) {
	if (currentVentureFase != idx) {
		var ventureTarget = idx;
		$('html, body').animate({
			scrollTop: $(".fase:eq(" + idx + ")").offset().top
		}, 800)
	}
}

function vizonSelectFase(idx) {
	if (idx != currentVentureFase) {
		currentVentureFase = idx;
		var $fase = $(".section-venture-blocks .fase:eq(" + idx + ")"),
			singlefase = $fase.attr("data-timing"),
			totalfase = $fase.attr("data-totaltiming"),
			offsetfase = $fase.attr("data-offsettiming");
		$(".fase-graph-step i").css({
			color: $fase.attr("data-color")
		});
		$(".fase-graph-step i").text(romanize(idx + 1));
		$(".fase-graph-title").text($fase.attr("data-title"));
		$(".fase-graph-teaser").text($fase.attr("data-teaser"));
		$('.fase-box-slider').cycle('goto', idx);
		$('.fase-graph-pager .fase-graph-pager-item').removeClass("active");
		$('.fase-graph-pager .fase-graph-pager-item:eq(' + idx + ')').addClass("active");
		vfasegraphgc.data(totalfase - 0.001).update();
		vfasegraphgp.data(singlefase - 0.001).update();
		var $fase = $(".section-venture-blocks .fase:eq(" + idx + ")"),
			angleoffset = offsetfase / fase_totalweeks,
			labeloffset = totalfase / fase_totalweeks;
		vfasegraphgp.startAngle(220 + (280 * angleoffset)).endAngle(140 + (280 * angleoffset)).update();
		$("#fase-graph-part .vz-radial_progress-arc").attr("style", "fill: " + $fase.attr("data-color") + " !important;");
		var label_radius = 195,
			label_center_x = 200,
			label_center_y = 200,
			label_angle = Math.sqrt((140 + (74 * labeloffset)) * Math.PI),
			label_x = label_center_x + label_radius * Math.cos(label_angle),
			label_y = label_center_y + label_radius * Math.sin(label_angle),
			label_margin = -70;
		if (labeloffset > 0.5) label_margin = 0;
		$(".fase-credits-total").fadeOut('fast', function () {
			$(".fase-credits-total").css({
				top: label_y + "px",
				left: label_x + "px",
				"margin-left": label_margin + "px"
			});
			$(".fase-credits-total i").text(totalfase);
			$('.fase-credits-total').fadeIn('fast')
		})
	}
}

function romanize(num) {
	if (!+num) return NaN;
	var digits = String(+num).split(""),
		key = ["", "C", "CC", "CCC", "CD", "D", "DC", "DCC", "DCCC", "CM", "", "X", "XX", "XXX", "XL", "L", "LX", "LXX", "LXXX", "XC", "", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX"],
		roman = "",
		i = 3;
	while (i--) roman = (key[+digits.pop() + (i * 10)] || "") + roman;
	return Array(+digits.join("") + 1).join("M") + roman
}

function midAngle(d) {
	return d.startAngle + (d.endAngle - d.startAngle) / 2
}

function filterBlog(_this) {
	$(_this).closest(".dropdown").find("form").slideToggle()
}

function social_media_popup(social_media, page_url, text) {
	var url;
	switch (social_media) {
	case "facebook":
		url = "https://www.facebook.com/sharer/sharer.php?u=" + page_url;
		break;
	case "twitter":
		url = "https://twitter.com/intent/tweet?text=" + text + "&url=" + page_url;
		break;
	case "linkedin":
		url = "https://www.linkedin.com/shareArticle?mini=true&url=" + page_url + "&title=" + text + "&summary=" + text + "&source=LinkedIn";
		break;
	case "googleplus":
		url = "https://plus.google.com/share?url=" + page_url + "&hl=en-US";
		break
	};
	popupWindow = window.open(url, 'popUpWindow', 'height=500,width=600,left=250,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');
	return false
}

function resizeblogitems() {
	jQuery(".col-sm-4.blogitem").matchHeight({
		byRow: true
	})
}

function pubequalHeights($toCheck, $toSet) {
	var heighestHeight = 0;
	$toSet.height('auto');
	$toCheck.each(function () {
		var height = $(this).height();
		if (height > heighestHeight) heighestHeight = height
	});
	$toSet.height(heighestHeight)
};
$(document).ready(function () {
	$(".js-rotating").Morphext({
		animation: "fadeIn",
		separator: ",",
		speed: 5e3,
		complete: function () {}
	})
});; /*})'"*/