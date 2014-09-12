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
			messageWarn: 	$('#message alert'),
			submitBtn: 		$('#btn_submit'),
		},
		messg: {
			passLength: 	'Password cannot be less than 5 characters',
			passMismatch: 	'Password do not match',
			nameEmpty: 		'Name cannot be empty',
			emailEmpty: 	'Email cannot be empty',
		},
		handler: {
			keyUpPass1: function() {
				/* If password length is less than 5 char do not allow registration */
				if(this.el.pass1Input.val().length < 5){
					this.el.messageWarn.show().text(this.messg.passLength);
					this.el.submitBtn.prop('disabled', true);
				} else {
					this.el.messageWarn.hide();
					this.el.submitBtn.prop('disabled', false);
				}
			},
			keyUpPass2: function() {
				var pass = this.el.pass1Input.val();

				/* CHeck if passwords match */
				if(this.el.pass2Input.val() == pass) {
					this.el.messageWarn.show().text(this.messg.passMismatch);
					this.el.submitBtn.prop('disabled', true);
				} else {
					this.el.messageWarn.hide();
					this.el.submitBtn.prop('disabled', false);
				}
			},
			keyUpName: function() {
				if(this.el.nameInput.val().length > 0 ){
					this.el.messageWarn.hide();
					this.el.submitBtn.prop('disabled', false);
				} else {
					this.el.messageWarn.show().text(this.messg.nameEmpty);
					this.el.submitBtn.prop('disabled', true);
				}
			},
			keyUpEmail: function() {
				if(this.el.emailInput.val().length > 0 ){
					this.el.messageWarn.hide();
					this.el.submitBtn.prop('disabled', false);
				} else {
					this.el.messageWarn.show().text(this.messg.emailEmpty);
					this.el.submitBtn.prop('disabled', true);
				}
			}
		},
		init: function() {
			this.el.messageWarn.hide();
			
			this.el.pass1Input.on('keyup', this.handler.keyUpPass1);
			this.el.pass2Input.on('keyup', this.handler.keyUpPass2);
			this.el.nameInput.on('keyup', this.handler.keyUpName);
			this.el.emailInput.on('keyup', this.handler.keyUpEmail);
		}
	};
	window['register'] = register;

	
})(window)