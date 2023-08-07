;(function($){

	$.fn.galleryUpload = function(options) {
		if (!this.length) {
			return this;
		}

		var defaults = {
			name: 'Filedata',
			id: 'gallery-upload',
			overlayId: 'gallery-upload-overlay',
			cancelOne: 'Skip current',
			cancelAll: 'Stop all',
			onFileFinish: function() {},
			onError: function() {},
			onFinish: function() {}
		};

		var elements = this,
				settings = {},
				total = 0,
				queue = [],
				el = [],
				request;

		var init = function() {
			settings = $.extend({}, defaults, options);

			createUploader();

			elements.each(function() {
				var form = $(this),
						input = form.find('input[type=file]'),
						upload_url = form.attr('action');

				input.on('change', function(e) {
					total += this.files.length;

					for (var i = total - 1; i >= 0; i--) {
						queue.push({file: this.files[i], url: upload_url, form: form});
					}

					showUploader();

					processQueue();
				});

			});

			el['container'] = $('#'+settings.id);
			el['progress_text'] = $('#'+settings.id+'-text');
			el['progress_bar'] = $('#'+settings.id+'-progress-bar');
			el['preview'] = $('#'+settings.id+'-preview');
			el['overlay'] = $('#'+settings.overlayId);
			el['cancel_one'] = $('#'+settings.id+'-cancel-one');
			el['cancel_all'] = $('#'+settings.id+'-cancel-all');

			el['cancel_one'].on('click', function(){
				request.abort();
			});

			el['cancel_all'].on('click', function(){
				queue = [];
				request.abort();
				finishQueue();
			});
		};

		function createUploader() {
			if (typeof(el['container']) !== 'undefined') {
				return;
			}

			var html = ' \
			<div id="'+settings.overlayId+'"></div> \
			<div id="'+settings.id+'"> \
				<div id="'+settings.id+'-preview"></div> \
				<div id="'+settings.id+'-text"></div> \
				<div class="'+settings.id+'-tools"> \
					<button id="'+settings.id+'-cancel-one" class="btn btn-compact btn-w-icon"><span class="fa fa-forward"></span>'+settings.cancelOne+'</button> \
					<button id="'+settings.id+'-cancel-all" class="btn btn-compact btn-w-icon btn-danger"><span class="fa fa-stop"></span>'+settings.cancelAll+'</button> \
				</div> \
				<div id="'+settings.id+'-progress"> \
					<div id="'+settings.id+'-progress-bar"></div> \
				</div> \
			</div>';

			body.append(html);
		}

		function showUploader() {
			el['overlay'].fadeIn('fast');
			el['container'].fadeIn('fast');
		}

		function hideUploader() {
			el['container'].fadeOut('fast');
			el['overlay'].fadeOut('fast');
		}

		function showPreview(file) {
			var reader = new FileReader();

			reader.onload = (function(theFile) {
				return function(e) {
					el['preview'].css('background-image', 'url('+e.target.result+')');
				};
			})(file);

			reader.readAsDataURL(file);
		}

		function setProgressText(text) {
			el['progress_text'].text((total - queue.length) + ' / ' + total);
		}

		function setProgressBar(percents) {
			el['progress_bar'].css('width', percents + '%');
		}

		function resetProgressBar() {
			setProgressBar(0);
		}

		function processQueue() {
			if (!queue.length) {
				finishQueue();
				return;
			}

			var item = queue.pop(),
					file = item.file;

			resetProgressBar();

			setProgressText((total - queue.length) + ' / ' + total);

			showPreview(file);

			var formdata = new FormData();
			formdata.append(settings.name, file);
			item.form.find('input').each(function(){
				formdata.append($(this).attr('name'), $(this).val());
			});

			request = $.ajax({
				url: item.url,
				type: 'POST',
				xhr: function() {
					myXhr = $.ajaxSettings.xhr();
					if (myXhr.upload){
						myXhr.upload.addEventListener('progress', function(e){
							var percents = Math.floor((e.loaded / e.total) * 100);
							setProgressBar(percents);
						}, false);
					}
					return myXhr;
				},
				success: function(data) {
					settings.onFileFinish(data);
					processQueue();
				},
				error: function() {
					settings.onError(item.file);
					processQueue();
				},
				data: formdata,
				cache: false,
				contentType: false,
				processData: false
			}, 'html');
		}

		function finishQueue() {
			total = 0;
			hideUploader();
			settings.onFinish();
		}

		init();

		return this;
	};
})(jQuery);