(function($){
	"use strict";
	$(document).ready(function(){
		var app = {
			elMsg: $('#debounce-message'),
			elList: $('#debounce-list'),
			show: function(){
				$(this.elMsg).show();
			},
			hide: function(){
				$(this.elMsg).hide();
			},
			empty: function(){
				$(this.elMsg).html('');

				return this.hide();
			},
			setMessage: function(text){
				$(this.elMsg).html(text);

				return this.show();
			},
			append: function(mail,status){
				var template = _.template( debounce.ul_tpl );
				$(this.elList).append( template( {mail:mail, status: debounce[ status ]} ) );
			},
			request: function(mail){
				if(!$('body').hasClass('debounce-loading')){
					var self = this;

					$('body').addClass('debounce-loading');

					$.ajax({
						url: debounce.AJAX_URL,
						type: 'POST',
						cache: false,
						crossDomain: true,
						data: {
							'action'     : 'debounce-verify-email',
							'debounce-nonce' : debounce.nonce,
							'email'       : mail
						},
						dataType: 'json',
						success: function (data) {
							$('body').removeClass('debounce-loading');
							self.append( mail, data.status );
						},
						error: function(){
							$('body').removeClass('debounce-loading');
							self.setMessage(debounce[801]);
						}
					});
				}
			}
		};

		$('#debounce-button-validate').on('click',function(){
			if($('#debounce-mail').val().length){
				app.hide();
				app.request( $('#debounce-mail').val() );
			} else {
				app.setMessage(debounce[800]);
			}

			return false;
		});
	});
}(jQuery));