var body = $('body');

/**
 * Executed when document is finished loading elements into DOM
 */
$(document).ready(function () {
	body.removeClass('preload');
	$("#theme-btn").click(function(){
		$("#theme-list").toggle();
	});
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
	var slider = $('.js-slider--partners').bxSlider({
		autoDirection: 'prev',
		slideMargin: 0,
		minSlides: 1,
		maxSlides: 1,
		pager: false,
		pause: 4000,
		auto: true
	});
	$('.partners-slider-container  .btn-more').click(function () {
		var el = $('.partners-slider-container .partners-slider');
		if(el.hasClass('js-slider--partners')){
			slider.destroySlider();
			el.removeClass('js-slider--partners');
			$(this).html($(this).attr('data-less'));
		}else{
			el.addClass('js-slider--partners');
			slider.reloadSlider();
			$(this).html($(this).attr('data-more'));
		}
	});

	$('.js-slider').bxSlider({
		autoDirection: 'prev',
		slideMargin: 0,
		minSlides: 1,
		maxSlides: 1,
		pager: false,
		pause: 4000,
		auto: true
	});

	$('.mobile-slider-standard').bxSlider({
		autoDirection: 'next',
		slideMargin: 0,
		minSlides: 1,
		maxSlides: 1,
		pager: false,
		pause: 3000,
		auto: true,
		controls: false
	});
	$('.mobile-slider-static-pagination').bxSlider({
		slideMargin: 0,
		minSlides: 1,
		maxSlides: 1,
		pager: true,
		auto: false,
		controls: false
	});
	$('.mobile-slider-arrows').bxSlider({
		autoDirection: 'next',
		slideMargin: 0,
		minSlides: 1,
		maxSlides: 1,
		pager: false,
		pause: 3000,
		auto: true,
		controls: true
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

	body.on('click', '#mainmenu a', function () {
		var $this = $(this);
		var $submenu = $($this.attr('data-submenu'));

		if ($submenu.length) {
			$submenu.slideToggle();
			return false;
		} else {
			$('#mainmenu').fadeOut();
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

	body.on('click', '.js-menu-btn', function (e) {
		$('#mainmenu').fadeToggle();
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
			url: "/callbacks"
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
	var div = $('<div style="width: 100%; max-width: 700px">' +
		'<div class="slick-slider"></div>' +
		'</div>');
	var container = div.find('.slick-slider');
	links.each(function () {
		var link = $(this);
		var src = link.find('img').attr('src');
		var href = link.attr('href');
		var title = link.find('img').attr('alt');
		container.append('<div class="item" style="background-image: url(\'' + src + '\')"><a href="' + href + '"><div><p>' + title + '</p></div></a></div>');
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
		slidesToShow: 1,
		slidesToScroll: 1,
		focusOnSelect: true,
		easing: 'in-out',
		speed: 700,
		adaptiveHeight: true,
		autoplay: true,
		dots: true
	});
}

function scrollToSection(elem) {
	$('html, body').animate({
		scrollTop: elem.offset().top
	}, 1000);
}
