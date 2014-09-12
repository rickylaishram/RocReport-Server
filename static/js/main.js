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
			self: this,
			keyUpPass1: function() {
				/* If password length is less than 5 char do not allow registration */
				if(this.self.el.pass1Input.val().length < 5){
					this.self.el.messageWarn.show().text(this.messg.passLength);
					this.self.el.submitBtn.prop('disabled', true);
				} else {
					this.self.el.messageWarn.hide();
					this.self.el.submitBtn.prop('disabled', false);
				}
			},
			keyUpPass2: function() {
				var pass = this.self..el.pass1Input.val();

				/* Check if passwords match */
				if(this.self.el.pass2Input.val() == pass) {
					this.self.el.messageWarn.show().text(this.messg.passMismatch);
					this.self.el.submitBtn.prop('disabled', true);
				} else {
					this.self.el.messageWarn.hide();
					this.self.el.submitBtn.prop('disabled', false);
				}
			},
			keyUpName: function() {
				if(this.self.el.nameInput.val().length > 0 ){
					this.self.el.messageWarn.hide();
					this.self.el.submitBtn.prop('disabled', false);
				} else {
					this.self.el.messageWarn.show().text(this.messg.nameEmpty);
					this.self.el.submitBtn.prop('disabled', true);
				}
			},
			keyUpEmail: function() {
				if(this.self.el.emailInput.val().length > 0 ){
					this.self.el.messageWarn.hide();
					this.self.el.submitBtn.prop('disabled', false);
				} else {
					this.self.el.messageWarn.show().text(this.messg.emailEmpty);
					this.self.el.submitBtn.prop('disabled', true);
				}
			}
		},
		init: function() {
			console.log($);
			this.el.messageWarn.hide();
			
			this.el.pass1Input.on('keyup',  this.handler.keyUpPass1);
			this.el.pass2Input.on('keyup', this.handler.keyUpPass2);
			this.el.nameInput.on('keyup', this.handler.keyUpName);
			this.el.emailInput.on('keyup', this.handler.keyUpEmail);
		}
	};
	window['register'] = register;


})(window)