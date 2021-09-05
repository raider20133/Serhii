(function($){
	"use strict";
	var app = {
		el: '',
		msgContainer: false,
		validMails: [],

		submit: function(){
			var self = this;
			$(self.el).trigger('submit');
		},

		request: function(mail){
			if(!$('body').hasClass('debounce-loading')){
				var self = this;

				$('body').addClass('debounce-loading');

				var inputs = $(self.el).find('.debounce-mail');
				_.each($(inputs),function(el,key){
					if($(el).val()==mail){
						$(el).addClass('debounce-loading-mail');
					}
				});

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
						var inputs = $(self.el).find('.debounce-mail');
						_.each($(inputs),function(el,key){
							if($(el).val()==mail){
								$(el).removeClass('debounce-loading-mail');
							}
						});

						if( data.is_valid ){
							self.validMails.push( mail );
							self.submit();
						} else {
							self.showError(mail, data.status);
						}
					},
					error: function(){
						$('body').removeClass('debounce-loading');
					}
				});
			}
		},
		validateForm: function( form ){
			var self = this,
				inputs = $(form).find('.debounce-mail');

			self.el = form;

			if( $(self.el).find('.wpcf7-response-output').length ){
				self.msgContainer = $(self.el).find('.wpcf7-response-output');
			} else {
				self.msgContainer = false;
			}

			var mails = [],
				inputs = $(form).find('.debounce-mail');

			_.each( inputs, function(el, key){
				mails.push( $(inputs[key]).val() );
			});

			if( _.isEmpty( _.difference( mails, app.validMails ) ) ){
				self.submit();
			} else {
				var mail = _.difference( mails, app.validMails );
				self.request( mail[0] );
			}


		},
		showError: function(mail, status){
			var self = this;
			if(self.msgContainer){
				var template = _.template( debounce.tpl );
				$(self.msgContainer).html( template( {mail:mail, status: debounce[ status ]} ) ).show();
			} else {
				var inputs = $(self.el).find('.debounce-mail');
				_.each($(inputs),function(el,key){
					if($(el).val()==mail){
						var template = _.template( debounce.tpl );
						$(el).after( template( {mail:mail, status: debounce[ status ]} ) );
					}
				});
			}
		}
	};

	$(document).ready(function(){
		if($('form').length){
			_.each( $('form'), function( form, key ){
				if($(form).find('.debounce-mail').length){
					$(form).on('submit', function(){
						var mails = [],
							inputs = $(form).find('.debounce-mail');

						$(form).find('.debounce-error').remove();

						_.each( inputs, function(el, key){
							mails.push( $(inputs[key]).val() );
						});

						if( _.isEmpty( _.difference( mails, app.validMails ) ) ){
							$(form).removeClass( debounce.form_class );
							return true;
						} else {
							app.validateForm( $(form) );
						}

						return false;
					});
				}
			});
		}
	});
}(jQuery));