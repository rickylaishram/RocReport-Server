(function(window, undefined) {"use strict";

	var $ 	= window.jQuery,
		d3 	= window.d3,
		document = window.document;

	/**
	 * Register Page
	 */
	var register = {
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
	};
	window['RR']['register'] = register;

	/**
	 * Login page
	 */
	var login = {
		el: {
			passInput: 	$('#pass'),
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
			checkAutofill: function() {
				if((this.el.passInput.val().length > 0)
					&& (this.el.emailInput.val().length > 0)) {
					this.el.submitBtn.prop('disabled', false);
				} else {
					this.el.submitBtn.prop('disabled', true);
				}
			},
		},
		init: function() {
			this.misc.checkAutofill();

			this.el.passInput.on('keyup', {self: this}, this.handler.keyUpPass);
			this.el.emailInput.on('keyup', {self: this}, this.handler.keyUpEmail);
		}
	};
	window['RR']['login'] = login;


})(window)