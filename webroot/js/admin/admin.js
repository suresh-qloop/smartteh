var body = $('body');

/**
 * Executed when document is finished loading elements into DOM
 */
$(document).ready(function () {

	/**
	 * Display confirmation dialog whenever link with class 'confirm' is clicked
	 */
	body.on('click', 'a.confirm, button.confirm', function (e) {
		var message = $(this).attr('data-message');

		if (typeof (message) === 'undefined' || message === '') {
			message = 'Do you really want to continue?';
		}

		if (confirm(message)) {
			return true;
		} else {
			e.stopImmediatePropagation();
			e.preventDefault();
			return false;
		}
	});

	/**
	 * Display confirmation dialog whenever form with class 'confirm' is submitted
	 */
	body.on('submit', 'form.confirm', function (e) {
		var message = $(this).attr('data-message');

		if (typeof (message) === 'undefined' || message === '') {
			message = 'Do you really want to continue?';
		}

		return confirm(message);
	});

	body.on('click', '.input-append.fa-calendar', function () {
		$(this).siblings('input').focus();
	});

	/**
	 * If selected option has data-redirect-url attribute, redirect to it
	 */
	body.on('change', 'select', function () {
		var option = $(this).find(':selected');
		if (option.attr('data-redirect-url')) {
			redirect(option.attr('data-redirect-url'));
		}
	});

	// allow only digits in price field
	body.on('keypress', '.price', function (e) {
		var charCode = (e.which) ? e.which : event.keyCode;

		if (charCode === 46 && $(this).val().indexOf('.') === -1) {
			return true;
		}

		return !(charCode > 31 && (charCode < 48 || charCode > 57));
	});

	// allow only digits in integer field
	body.on('keypress', '.integer', function (e) {
		var charCode = (e.which) ? e.which : event.keyCode;

		return !(charCode > 31 && (charCode < 48 || charCode > 57));
	});

	// allow only digits, minus sign and dot in decimal field
	body.on('keypress', '.decimal, [type=number]', function (e) {
		var charCode = (e.which) ? e.which : event.keyCode;

		if (charCode === 46 && $(this).val().indexOf('.') === -1) {
			return true;
		}

		if (charCode === 45 && $(this).val().indexOf('-') === -1) {
			return true;
		}

		return !(charCode > 31 && (charCode < 48 || charCode > 57));
	});

	/**
	 * Toggle elements based on selected select/radio value
	 */
	body.on('change', '[data-toggle-block]', function () {
		var _this = $(this),
			value = _this.val(),
			block = _this.attr('data-toggle-block');

		if (_this.attr('type') === 'checkbox') {
			value = _this.is(':checked') ? '1' : '0';
		}

		$('[data-block=' + block + ']').each(function () {
			var _this = $(this),
				values = _this.attr('data-block-values').split(',');

			if (values.indexOf(value) !== -1) {
				enableBlock(_this);
			} else {
				disableBlock(_this);
			}
		});
	});

	/**
	 * Main nav
	 */
	body.on('click', '.main-nav .nav-item', function () {
		var _this = $(this),
			li = _this.parent(),
			subnav = li.find('.subnav');

		if (subnav.length) {
			li.toggleClass('active').siblings().removeClass('active').find('.subnav').slideUp().find('.active').removeClass('active');
			subnav.slideToggle();
		} else {
			if (li.hasClass('active')) {
				return;
			}

			if (li.parent().hasClass('subnav')) {
				li.parent().parent().siblings().removeClass('active').find('.subnav').slideUp().find('.active').removeClass('active');
				li.siblings().removeClass('active');
			} else {
				li.siblings().removeClass('active').find('.subnav').slideUp().find('.active').removeClass('active');
			}

			li.addClass('active');
		}
	});

	initUploadElement();

	rebindPlugins();

	ajaxify();
});

function unbindAllEditors() {
	if (typeof (tinyMCE) !== 'undefined') {
		var length = tinyMCE.editors.length;
		for (var i = length; i > 0; i--) {
			tinyMCE.editors[i - 1].remove();
		}
	}
}

/**
 * Find closest parent which has specified class
 *
 * $(element).findParentByClass('menu')
 */
jQuery.fn.findParentByClass = function (class_name) {
	var el = this;

	while (true) {
		el = el.parent();

		if (el.hasClass(class_name)) {
			return el;
		}

		if (el[0].tagName === 'HTML') {
			return [];
		}
	}
};

/**
 * Global AJAX activity indicator
 */
$(document).ajaxStart(function () {
	$('#ajax-loading').show();
}).ajaxStop(function () {
	$('#ajax-loading').hide();
});

/**
 * Replace existing content with new data
 */
function loadContent(data, target) {
	unbindAllEditors();

	if (typeof (target) === 'undefined') {
		target = '.content';
	}

	$(target).html(data);
	var title = $('.content h2').eq(0).text();

	if (title.length) {
		window.document.title = title + ' [admin]';
	}

	$('[data-toggle-block]').change();

	rebindPlugins();

	afterLoadContent();
}

/**
 * Ajaxify cms
 */
function ajaxify() {
	var History = window.History;

	if ((typeof (History) !== 'object' && typeof (History) !== 'function') || typeof (History.pushState) !== 'function') {
		return false;
	}

	// used internaly to determine if History's statechange was called because we pushed/replaced
	// state or user clicked back/forward button
	var internalStateChange = false;

	var saveState = function (url, replace) {
		internalStateChange = true;

		if (!url) {
			url = window.location.pathname + window.location.hash;
		}

		// update language switch links
		var url_chunks = url.split('/');
		$('[data-switch-lang]').each(function () {
			var _this = $(this),
				new_lang = _this.attr('data-switch-lang');
			url_chunks[2] = new_lang;
			_this.attr('href', url_chunks.join('/'));
		});

		if (replace) {
			History.replaceState({html: $('.container').html()}, window.document.title, url);
		} else {
			History.pushState({html: $('.container').html()}, window.document.title, url);
		}

		return true;
	};

	History.Adapter.bind(window, 'statechange', function () {
		if (!internalStateChange) {
			$('.container').html(History.getState().data.html);
			rebindPlugins();
		}
		internalStateChange = false;
	});

	// move up/down, delete and paginator ajax version
	var selector = '';
	selector += '.list .fa-search,';
	selector += '.list .icons a,';
	selector += '.tools .btn-add,';
	selector += '.paginator a,';
	selector += '.list th a,';
	selector += '.nav-item,';
	selector += '.tabs a,';
	selector += '.js-ajax';

	body.on('click', selector, function (e) {
		if (e.ctrlKey || e.metaKey) {
			return;
		}

		var el = $(this),
			addr = el.attr('href');

		if (!addr || addr === '#') {
			return true;
		}

		if (el.hasClass('no-ajax')) {
			return true;
		}

		$.ajax({
			url: addr,
			cache: false,
			success: function (data) {
				loadContent(data);

				var replace =
					el.hasClass('fa-arrow-circle-down') ||
					el.hasClass('fa-arrow-circle-up') ||
					el.hasClass('fa-eye-slash') ||
					el.hasClass('fa-eye') ||
					el.hasClass('fa-star') ||
					el.hasClass('fa-star-o') ||
					el.hasClass('fa-trash') ||
					el.hasClass('fa-trash-o');

				if (replace) {
					saveState(null, true);
				} else {
					saveState(addr, false);
				}
			},
			error: function () {
				toastr.error('Could not complete action due to an error', 'Error!');
			}
		});

		return false;
	});

	body.on('submit', '.content form', function () {
		var form = $(this),
			addr = form.attr('action'),
			target = form.attr('data-content-target');

		if (form.hasClass('no-ajax') || !form.find('.search-row').length) {
			return true;
		}

		$.post(addr, form.serialize(), function (data) {
			loadContent(data, target);
			if (!target) {
				saveState(addr);
			}
		});

		return false;
	});

	saveState(null, true);
}

/**
 * Rebind all plugins
 *
 * This should be called after AJAX replaces .content
 */
function rebindPlugins() {

	$('.js-gallery').each(function () {
		$(this).magnificPopup({
			closeBtnInside: true,
			delegate: '.pop',
			removalDelay: 300,
			preloader: false,
			type: 'image',
			gallery: {
				enabled: true
			},
			disableOn: function () {
				return !body.hasClass('sortable-dnd');
			}
		});
	});

	// datepicker

	var settings = {
		format: 'YYYY-MM-DD',
		firstDay: 1,
		i18n: {
			previousMonth: 'Iepriekšējais mēnesis',
			nextMonth: 'Nākamais mēnesis',
			months: ['Janvāris', 'Februāris', 'Marts', 'Aprīlis', 'Maijs', 'Jūnijs', 'Jūlijs', 'Augusts', 'Septembris', 'Oktobris', 'Novembris', 'Decembris'],
			weekdays: ['Svētdiena', 'Pirmdiena', 'Otrdiena', 'Trešdiena', 'Ceturtdiena', 'Piektdiena', 'Sestdiena'],
			weekdaysShort: ['Sv', 'Pi', 'Ot', 'Tr', 'Ce', 'Pi', 'Se']
		}
	};

	$('.datepicker').each(function () {
		settings.field = $(this)[0];
		new Pikaday(settings);
	});

	// sortbale
	if (typeof (jQuery.fn.sortable) === 'function') {
		$('[data-sortable]').sortable({
			placeholder: 'placeholder',
			containment: 'parent',
			handle: 'img',
			revert: true,
			items: 'li',

			start: function (e, ui) {
				body.addClass('sortable-dnd');
			},

			stop: function (e, ui) {
				body.removeClass('sortable-dnd');
			},

			update: function (event, ui) {
				var ids = [];
				$(this).find('li').each(function (k, el) {
					ids.push($(el).attr('data-id'));
				});

				$.ajax({
					url: $(this).attr('data-sortable') + ids.join(','),
					cache: false,
					success: function (data) {
						if (data !== 'OK') {
							alert('Could not sort gallery items');
						}
					}
				});
			}
		});
	}

	// uploadify
	if (typeof (jQuery.fn.uploadify) === 'function') {
		if (typeof (uploadifySelector) === 'string') {
			$(uploadifySelector).uploadify(uploadifySettings);
		}
	}

	// tinymce
	if (typeof (jQuery.fn.tinymce) === 'function') {
		var general_tinymce_settings = {
			selector: '.js-rte',
			plugins: 'autolink code table image paste lists link autoresize filemanager responsivefilemanager quickbars',
			toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | forecolor backcolor fontsizeselect | bullist numlist | link unlink | image table | removeformat code',
			invalid_elements: 'onclick,ondblclick,onkeydown,onkeypress,onkeyup,onmousedown,onmousemove,onmouseout,onmouseover,onmouseup,font',
			block_formats: 'Paragraph=p;Header 1=h1;Header 2=h2;Header 3=h3;Blockquote=blockquote',
			quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 image quicktable',
			quickbars_insert_toolbar: 'image quicktable',
			extended_valid_elements: 'iframe[*],embed[*],param[*],object[*]',
			content_css: '/build/css/editor.css',
			body_class: 'article',
			external_filemanager_path: '/tinymce/filemanager/',
			filemanager_title: 'File manager',
			filemanager_access_key: 'dU2LSvXUw33MqeqD9PvJHkqLy6vDsPNWQVAp0a15TJDjKJKseNZR5sXARXbrV5AfE22a7LSH',
			external_plugins: {
				responsivefilemanager: '/tinymce/plugins/responsivefilemanager/plugin.min.js',
				filemanager: '/tinymce/filemanager/plugin.min.js'
			},
			table_default_attributes: {},
			table_advtab: false,
			table_cell_advtab: false,
			table_row_advtab: false,
			table_resize_bars: false,
			// table_class_list: [
			// 	{title: 'Bez stila', value: ''},
			// 	{title: 'Ar stilu', value: 'table'},
			// ],
			table_appearance_options: false,
			autoresize_overflow_padding: 15,
			autoresize_bottom_margin: 0,
			remove_script_host: true,
			fix_list_elements: true,
			entity_encoding: 'raw',
			relative_urls: false,
			paste_as_text: true,
			image_caption: true,
			convert_urls: true,
			keep_styles: false,
			statusbar: false,
			menubar: false,
			width: '100%',
			height: '300',
			language: 'lv',
			language_url: '/js/admin/tinymce/lang.lv.js',
		};

		$('.js-rte').tinymce($.extend({}, general_tinymce_settings, {}));

		$('.js-rte-simple').tinymce($.extend({}, general_tinymce_settings, {
			toolbar: 'formatselect | bold italic underline | alignleft aligncenter alignright | superscript subscript charmap',
			plugins: 'autolink code paste link charmap',
			height: '200'
		}));
	}

	if (typeof (jQuery.fn.galleryUpload) === 'function') {
		$('.js-gallery-upload').galleryUpload({
			onFileFinish: function (data) {
				if (data.indexOf('<tr') !== -1) {
					$('.list tbody').append(data);
				} else {
					$('.gallery-items').append(data);
				}
			},
			onError: function (file) {
				toastr.error('Error uploading file: ' + file.name);
			},
			onFinish: function () {
			}
		});
	}

	if (typeof (jQuery.fn.minicolors) === 'function') {
		$('.js-color-picker').minicolors();
	}
}

/**
 * Check all checkboxes within specified container
 *
 * @param {string} container Container
 */
function checkAll(container) {
	$(container + ' input[type="checkbox"]').prop('checked', true);
}

/**
 * Uncheck all checkboxes within specified container
 *
 * @param {string} container Container
 */
function uncheckAll(container) {
	$(container + ' input[type="checkbox"]').prop('checked', false);
}

/**
 * Redirect user to specified page
 *
 * @param {string} url Address to redirect to
 */
function redirect(url) {
	document.location = url;
}

function initUploadElement() {

	function removeFileFromUploadElement(container, preview) {
		container.removeClass('has-file');
		container.find('.js-filename').text('');
		preview.removeClass('audio video image generic');
		preview.find('img').remove();
		$(container).find('[id^="upload-element-delete-"]').val('1');
	}

	body.on('click', '.upload-element [data-upload-element-delete]', function () {
		var container = $(this).findParentByClass('upload-element'),
			preview = container.find('.preview');

		if (!confirm('Do you really want to continue?')) {
			return false;
		}

		removeFileFromUploadElement(container, preview);

		return false;
	});

	body.on('change', '.upload-element input[type=file]', function () {
		var container = $(this).findParentByClass('upload-element'),
			preview = container.find('.preview'),
			extensions = {
				video: ['flv', 'avi', 'mp4', 'mpg', 'mpeg', 'mkv'],
				image: ['jpg', 'jpeg', 'png', 'gif'],
				audio: ['mp3', 'wav', 'flac']
			},
			extension,
			file;

		preview.removeClass('audio video image pdf');

		if (this.files && this.files[0]) {
			container.addClass('has-file');
			file = this.files[0];
		} else {
			removeFileFromUploadElement(container, preview);
			return;
		}

		$(container).find('[id^="upload-element-delete-"]').val('0');
		$(container).find('.js-filename').text(file.name);
		preview.find('img').remove();

		extension = file.name.split('.').pop().toLowerCase();

		if (extensions.video.indexOf(extension) !== -1) {
			preview.addClass('video');
		} else if (extensions.audio.indexOf(extension) !== -1) {
			preview.addClass('audio');
		} else if (extensions.image.indexOf(extension) !== -1) {
			preview.addClass('image');

			var reader = new FileReader();

			reader.onload = function (e) {
				$('<img />').attr('src', e.target.result).appendTo(preview);

				var img = preview.find('img');
				dimensions = img[0].naturalWidth * img[0].naturalHeight;
				if (dimensions > 9000000) {
					toastr.error('Image is too big. Max dimensions are 3000x3000');
				}
			};

			reader.readAsDataURL(file);
		} else {
			preview.addClass('generic');
		}
	});
}

function disableBlock(block) {
	block
		.addClass('disabled hidden')
		.find('input, select, textarea').attr('disabled', true);
}

function enableBlock(block) {
	block
		.removeClass('disabled hidden')
		.find('input, select, textarea').attr('disabled', false);
}
