var body = $('body');

/**
 * Executed when document is finished loading elements into DOM
 */
$(document).ready(function () {
	body.removeClass('preload');
	$(".requisite-btn").click(function(){
		$(".requisite-block").toggle();
	});
	if (location.hash) {
		var elem = $(location.hash);
		if (elem.length) {
			scrollToSection(elem);
		}
	}

	// replace all textual info[at]domain.com style emails to js
	$('.email').each(function () {
		var el = $(this);
		if (el.children().length === 0) {
			var email = el.text().replace('[at]', '@');
			el.html('<a href="mailto:' + email + '">' + email + '</a>');
		}
	});

	// slides
	var slides = $('.slides').slides({
		preloadImage: '/img/loading.gif',
		container: 'slides-container',
		generatePagination: true,
		generateNextPrev: false,
		slideSpeed: 1000,
		fadeSpeed: 0, // disable fade in on page load
		preload: true,
		play: 7000,
		animationStart: function (number) {
			$('#bg-top-' + number).hide().addClass('active very-active').fadeIn(1000);
		},
		animationComplete: function (number) {
			$('#bg-top-' + number).removeClass('very-active').siblings().hide().removeClass('active');
		}
	});

	var slider = $('.js-section-slider--partners').bxSlider({
		autoDirection: 'next',
		slideMargin: 0,
		minSlides: 1,
		maxSlides: 1,
		pager: false,
		pause: 7000,
		auto: true
	});

	$('.section-content--partners  .btn-more').click(function () {
		var el = $('.partners-slider-container .section-slider');
		if(el.hasClass('js-section-slider--partners')){
			slider.destroySlider();
			el.removeClass('js-section-slider--partners');
			$(this).html($(this).attr('data-less'));
		}else{
			el.addClass('js-section-slider--partners');
			slider.reloadSlider();
			$(this).html($(this).attr('data-more'));
		}
	});

	$('.js-section-slider').bxSlider({
		autoDirection: 'next',
		slideMargin: 0,
		minSlides: 1,
		maxSlides: 1,
		pager: false,
		pause: 7000,
		auto: true
	});
	$('.js-gallery').each(function () {
		$(this).magnificPopup({
			closeBtnInside: true,
			delegate: '.pop',
			removalDelay: 300,
			preloader: false,
			type: 'image',
			gallery: {
				enabled: true
			}
		});
	});

	// confirm box
	body.on('click', '.confirm', function () {
		return confirm('Vai tiešām vēlaties turpināt?');
	});

	(function () {
		body.on('click', function () {
			autosuggest.fadeOut('fast');
		});

		var autosuggest = $('#autosuggest'),
			search_el = $('#main-search'),
			base_url = '/search/autosuggest/?q=',
			t;

		body.on('keyup', '#main-search', function (e) {
			var _this = $(this),
				q = _this.val();

			if (!autosuggest.length) {
				var x = _this.offset().left - body.scrollLeft() - 420,
					y = _this.offset().top - body.scrollTop() + 39;
				$('<div id="autosuggest" />').appendTo(body).css({left: x + 'px', top: y + 'px'});
				autosuggest = $('#autosuggest');

				autosuggest.on('click', function (e) {
					e.stopPropagation();
				});
			}

			if (e.which === 27) {
				autosuggest.fadeOut('fast');
				return;
			}

			clearTimeout(t);
			t = setTimeout(performSearch, 500);
		});

		function performSearch() {
			var q = search_el.val(),
				url = base_url + q;

			if (q.length < 2) {
				autosuggest.hide();
				return;
			}

			$.ajax(url)
				.done(function (data) {
					autosuggest.html(data).fadeIn('fast');
				})
				.fail(function (data) {
					console.log('Error. Could not complete search. Server returned: ', data);
					autosuggest.hide();
				});
		}
	})();

	var helpbox = $('#helpbox');
	if (helpbox.length) {
		body.on('click', '#helpbox-minimize', function (e) {
			helpbox.addClass('minimized');
			setCookie('helpbox', 'minimized', 365);
			e.stopPropagation();
		});

		body.on('click', '#helpbox-maximize', function (e) {
			helpbox.removeClass('minimized');
			setCookie('helpbox', 'maximized', 365);
			e.stopPropagation();
		});

		body.on('click', '#helpbox-close', function (e) {
			helpbox.remove();
			setCookie('helpbox', 'closed', 365);
			e.stopPropagation();
		});

		body.on('click', '#helpbox-titlebar', function () {
			if (helpbox.hasClass('minimized')) {
				$('#helpbox-maximize').click();
			}
		});
	}

	body.on('click', '#site-navbar a', function () {
		var _this = $(this),
			submenu = _this.data('submenu'),
			$submenu = submenu ? $('#' + submenu) : null;

		if ($submenu && $submenu.length) {
			$submenu.slideDown(1000);
			return false;
		}
	});

	// smooth animation when clicking on anchors
	body.on('click', 'a[href*=#]', function (e) {
		var elem = $(this.hash);
		if (elem.length) {
			e.preventDefault();
			scrollToSection(elem);
		}
	});

	body.on('click', '#next-quote-button', function () {
		var $current = $('.quote-item.active'),
			$next = $current.next('.quote-item');

		if (!$next.length) {
			$next = $('.quote-item:first');
		}

		$current.removeClass('active');
		$next.addClass('active');
	});
	var scroll = sessionStorage.getItem("scroll");
	if (scroll) {
		sessionStorage.removeItem("scroll");
		window.scrollTo(0, scroll);
	}
	$(".site-header-langs .item").click(function (evt) {
		evt.preventDefault();
		sessionStorage.setItem("scroll", document.documentElement.scrollTop);
		window.location.href = $(this).attr("href");
	});
	$('ol').has("a img").each(function () {
		var ol = $(this);
		var links = ol.find('a');
		var slider = makeSlider(links);
		slider.insertAfter(ol);
		initSlides(slider.find('.slick-slider'));
		ol.remove();
	});

	var modal;
	// When the user clicks on the button, open the modal
	$("#callbackForm").click(function (evt) {
		$("#callbackModal").css('display', 'flex');
		modal = document.getElementById('callbackModal');
		// Get the <span> element that closes the modal
		$("#callbackModal .close-modal").on('click', function (evt) {
			modal.style.display = "none";
		});
	});
	$("#contactForm").click(function (evt) {
		$("#contactsModal").css('display', 'flex');
		modal = document.getElementById('contactsModal');
		// Get the <span> element that closes the modal
		$("#contactsModal .close-modal").on('click', function (evt) {
			modal.style.display = "none";
		});
	});

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function (event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}

	$("#callback-get-news").click(function (evt) {
		if ($(this).prop("checked") == true) {
			$("#getNewsFields").css('display', 'block');
			$("#CallbacksCompany").prop('required', true);
			$("#CallbacksEmail").prop('required', true);
		} else {
			$("#getNewsFields").css('display', 'none');
			$("#CallbacksCompany").removeAttr('required');
			$("#CallbacksEmail").removeAttr('required');
		}
	});

	$("#callbacksForm").bind("submit", function (event) {
		$.ajax({
			async: true,
			data: $("#callbacksForm").serialize(),
			dataType: "html",
			beforeSend: function (XMLHttpRequest) {
				$('#loading').fadeIn();
				$('#callbacksSubmit').attr('disabled', 'disabled');
			},
			success: function (data, textStatus) {
				$("#callbacksUpdate").html(data);
			},
			complete: function (XMLHttpRequest, textStatus) {
				$('#loading').fadeOut();
				$('#callbacksSubmit').removeAttr('disabled');
			},
			type: "POST",
			url: "/smartteh/callbacks"
		});
		return false;
	});
	$("#contactsForm").bind("submit", function (event) {
		$.ajax({
			async: true,
			data: $("#contactsForm").serialize(),
			dataType: "html",
			beforeSend: function (XMLHttpRequest) {
				$('#loadingCon').fadeIn();
				$('#contactsSubmit').attr('disabled', 'disabled');
			},
			success: function (data, textStatus) {
				$("#contactsUpdate").html(data);
			},
			complete: function (XMLHttpRequest, textStatus) {
				$('#loadingCon').fadeOut();
				$('#contactsSubmit').removeAttr('disabled');
			},
			type: "POST",
			url: "/kontakti"
		});
		return false;
	});

});

/**
 *
 * @param {jQuery} links
 *
 * @return jQuery
 */
function makeSlider(links) {
	var div = $('<div class="slick-slider-container">' +
		'<div class="slick-slider"></div>' +
		'</div>');
	var container = div.find('.slick-slider');
	links.each(function () {
		var link = $(this);
		var src = link.find('img').attr('src');
		var href = link.attr('href');
		var title = link.find('img').attr('alt');
		container.append('<a href="' + href + '"><div class="item" style="background-image: url(\'' + src + '\')"><div><p>' + title + '</p></div></div></a>');
	});
	return div;
}

/**
 *
 * @param {jQuery} slides
 */
function initSlides(slides) {
	slides.slick({
		infinite: true,
		slidesToShow: 3,
		slidesToScroll: 1,
		focusOnSelect: true,
		easing: 'in-out',
		speed: 700,
		adaptiveHeight: true,
		autoplay: true,
		arrows: true
	});
}

function scrollToSection(elem) {
	$('html, body').animate({
		scrollTop: elem.offset().top - $('#site-header').outerHeight(true) - $('#site-navbar').outerHeight(true)
	}, 1000);
}

/**
 * Write cookie
 *
 * @param name Cookie name
 * @param value Cookie value
 * @param days Cookie life expectancy in days
 */
function setCookie(name, value, days) {
	var expires, date;

	if (days) {
		date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		expires = '; expires=' + date.toGMTString();
	} else {
		expires = '';
	}
	document.cookie = name + '=' + value + expires + '; path=/';
}

/**
 * Read cookie
 *
 * @param name Cookie name
 */
function getCookie(name) {
	var nameEQ = name + '=';
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) === ' ') {
			c = c.substring(1, c.length);
		}
		if (c.indexOf(nameEQ) === 0) {
			return c.substring(nameEQ.length, c.length);
		}
	}
	return null;
}