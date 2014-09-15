(function(window, undefined) {"use strict";

	var $ 	= window.jQuery,
		d3 	= window.d3,
		document = window.document,
		r = [];

	/**
	 * Global functions
	 */
	var gl = {
		showLoading: function() {
			$('#loading-container').show();
		},
		hideLoading: function() {
			$('#loading-container').hide();
		},
		init: function() {
			$(document).ajaxError(function(data) {
				try {
					consolee.log(data);
				} catch (e) {}
			});
		},
	},
	
	/**
	 * Register Page
	 */
	register = {
		el: {
			pass1Input: 	$('#pass1'),
			pass2Input: 	$('#pass2'),
			nameInput: 		$('#name'),
			emailInput: 	$('#email'),
			messageWarn: 	$('#message .alert'),
			submitBtn: 		$('#btn_submit'),
		},
		messg: {
			passLength: 	'Password cannot be less than 5 characters',
			passMismatch: 	'Password do not match',
			nameEmpty: 		'Name cannot be empty',
			emailEmpty: 	'Email cannot be empty',
		},
		handler: {
			keyUpPass1: function(e) {
				var self = e.data.self;

				/* If password length is less than 5 char do not allow registration */
				if(self.el.pass1Input.val().length < 5){
					self.el.messageWarn.show().text(self.messg.passLength);
					self.el.submitBtn.prop('disabled', true);
				} else {
					self.el.messageWarn.hide();
					self.el.submitBtn.prop('disabled', false);
				}
			},
			keyUpPass2: function(e) {
				var self = e.data.self,
					pass = self.el.pass1Input.val();

				/* Check if passwords match */
				if(self.el.pass2Input.val() != pass) {
					self.el.messageWarn.show().text(self.messg.passMismatch);
					self.el.submitBtn.prop('disabled', true);
				} else {
					self.el.messageWarn.hide();
					self.el.submitBtn.prop('disabled', false);
				}
			},
			keyUpName: function(e) {
				var self = e.data.self;

				if(self.el.nameInput.val().length > 0 ){
					self.el.messageWarn.hide();
					self.el.submitBtn.prop('disabled', false);
				} else {
					self.el.messageWarn.show().text(self.messg.nameEmpty);
					self.el.submitBtn.prop('disabled', true);
				}
			},
			keyUpEmail: function(e) {
				var self = e.data.self;

				if(self.el.emailInput.val().length > 0 ){
					self.el.messageWarn.hide();
					self.el.submitBtn.prop('disabled', false);
				} else {
					self.el.messageWarn.show().text(self.messg.emailEmpty);
					self.el.submitBtn.prop('disabled', true);
				}
			}
		},
		init: function() {
			this.el.messageWarn.hide();
			
			this.el.pass1Input.on('keyup', {self: this}, this.handler.keyUpPass1);
			this.el.pass2Input.on('keyup', {self: this}, this.handler.keyUpPass2);
			this.el.nameInput.on('keyup', {self: this}, this.handler.keyUpName);
			this.el.emailInput.on('keyup', {self: this}, this.handler.keyUpEmail);
		}
	},
	
	/**
	 * Login page
	 */
	login = {
		el: {
			passInput: 		$('#pass'),
			emailInput: 	$('#email'),
			submitBtn: 		$('#btn_submit'),
		},
		handler: {
			keyUpPass: function(e) {
				var self = e.data.self;

				/* If password length is less than 5 char do not allow registration */
				if(self.el.passInput.val().length < 1){
					self.el.submitBtn.prop('disabled', true);
				} else {
					self.el.submitBtn.prop('disabled', false);
				}
			},
			keyUpEmail: function(e) {
				var self = e.data.self;

				if(self.el.emailInput.val().length > 0 ){
					self.el.submitBtn.prop('disabled', false);
				} else {
					self.el.submitBtn.prop('disabled', true);
				}
			}
		},
		misc: {
			/* Check for auto filled email, pass */
			checkAutofill: function(e) {
				var self = e.data.self;

				if((self.el.passInput.val().length > 0)
					&& (self.el.emailInput.val().length > 0)) {
					self.el.submitBtn.prop('disabled', false);
				} else {
					self.el.submitBtn.prop('disabled', true);
				}
			},
		},
		init: function() {
			$(document).on('ready', {self: this}, this.misc.checkAutofill);

			this.el.passInput.on('keyup', {self: this}, this.handler.keyUpPass);
			this.el.emailInput.on('keyup', {self: this}, this.handler.keyUpEmail);
		}
	},

	/**
	 * Contractor page
	 */
	contractor = {
		el: {
			categorySelector: $('#category'),
		},
		handler: {

		},
		data: {
			token: null,
			id: null,
			nonce: null,
		},
		url: {
			fetchCategories: null,
		},
		tmpl: {
			selectorOption: function(val, name) {
				return $('option').attr('val', val).text(name);
			},
		},
		show: {
			categories: function(self, data) {
				for (var i = data.length - 1; i >= 0; i--) {
					self.el.categorySelector.append(self.tmpl.selectorOption(data[i].id, data[i].name));
				};
			},
		},
		connect: {
			fetchCategories: function(self) {
				gl.showLoading();

				$.ajax({
					url: self.url.fetchCategories,
					headers: {
						'Auth-id': self.data.id,
						'Auth-token': self.data.token,
						'Auth-nonce': self.data.nonce,
					},
					cache: false,
					type: 'GET',
					success: function(data) {
						gl.hideLoading();
						data = JSON.parse(data);

						if(data.status) {
							self.show.categories(self, data.data);
						} else {
							// Error
						}
					}
				});
			}
		},
		misc: {

		},
		init: function(){
			this.connect.fetchCategories(this);
		}
	};


	gl.init();
	r['register'] = register;
	r['login'] = login;
	r['contractor'] = contractor;


	window['r'] = r;
})(window)