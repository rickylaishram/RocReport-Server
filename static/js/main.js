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
			btnSearchjobs: $('#btn_search_job'),
			inputLongitude: $('#longitude'),
			inputLatitide: $('#latitude'),
			inputRadius: $('#radius'),
			listJobs: $('.contractor-search-results'),
			listBids: $('.contractor-bid-results'),
		},
		data: {
			token: null,
			id: null,
			nonce: null,
		},
		url: {
			fetchCategories: null,
			fetchJobs: null,
			fetchBids: null,
		},
		tmpl: {
			selectorOption: function(val, name) {
				return $('<option></option>').attr('value', val).text(name);
			},
			searchItem: function(description, image, time, latitude, longitude, address, reportid, distance) {
				return $('<div></div>').addClass('search-item row').append([
						$('<div></div>').addClass('col-lg-4').append(
							//$('<img></img>').attr('src', image)
							$('<img></img>').attr('src', 'http://i.imgur.com/lLCho4e.jpg')
						),
						$('<div></div>').addClass('col-lg-8').append([
							$('<div></div>').addClass('description').text(description),
							$('<div></div>').addClass('address').text(address),
							$('<div></div>').addClass('row form-group').append([
								$('<div></div>').addClass('col-lg-3').append(
									$('<button></button>').addClass('btn btn-primary btn-map btn-block').attr('type', 'submit').append(
										$('<span></span>').addClass('glyphicon glyphicon-map-marker')
									)
								),
								$('<div></div>').addClass('col-lg-3').append(
									$('<button></button>').addClass('btn btn-primary btn-bid btn-block').attr('type', 'submit').text('Bid')
								)
							]),
						]),
					]);
			},
			bidItem: function(description, image, time, latitude, longitude, address, reportid, distance, amount, duration) {
				return $('<div></div>').addClass('bid-item row').append([
						$('<div></div>').addClass('col-lg-4').append(
							//$('<img></img>').attr('src', image)
							$('<img></img>').attr('src', 'http://i.imgur.com/lLCho4e.jpg')
						),
						$('<div></div>').addClass('col-lg-8').append([
							$('<div></div>').addClass('description').text(description),
							$('<div></div>').addClass('address').text(address),
							$('<div></div>').addClass('bid-amount').text('Amount: $ '+amount),
							$('<div></div>').addClass('bid-duration').text('Duration: '+duration+' days'),
							$('<div></div>').addClass('row form-group').append([
								$('<div></div>').addClass('col-lg-3').append(
									$('<button></button>').addClass('btn btn-primary btn-map btn-block').attr('type', 'submit').append(
										$('<span></span>').addClass('glyphicon glyphicon-map-marker')
									)
								),
							]),
						]),
					]);
			},
			horizontalDivider: function() {
				return $('<div></div>').addClass('divider-horizontal');
			},
		},
		show: {
			categories: function(self, data) {
				for (var i = data.length - 1; i >= 0; i--) {
					self.el.categorySelector.append(self.tmpl.selectorOption(data[i].id, data[i].name));
				};
			},
			searchResults: function(self, data) {
				self.el.listJobs.empty();

				for (var i = data.length - 1; i >= 0; i--) {
					self.el.listJobs.append(self.tmpl.searchItem(data[i].description, data[i].picture, data[i].added_at, data[i].latitude, data[i].longitude, data[i].formatted_address, data[i].report_id, data[i].distance));
					if(i > 0) {
						self.el.listJobs.append(self.tmpl.horizontalDivider());
					}
				};
			},
			bids: function(self, data) {
				self.el.listBids.empty();

				for (var i = data.length - 1; i >= 0; i--) {
					self.el.listBids.append(self.tmpl.bidItem(data[i].description, data[i].picture, data[i].added_at, data[i].latitude, data[i].longitude, data[i].formatted_address, data[i].report_id, data[i].distance, data[i].amount, data[i].duration));
					if(i > 0) {
						self.el.listBids.append(self.tmpl.horizontalDivider());
					}
				};
			},
		},

		handler: {
			searchJobs: function(e) {
				var self = e.data.self;

				self.connect.fetchJobs(self);
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
			},
			fetchJobs: function(self) {
				gl.showLoading();

				$.ajax({
					url: self.url.fetchJobs,
					headers: {
						'Auth-id': self.data.id,
						'Auth-token': self.data.token,
						'Auth-nonce': self.data.nonce,
					},
					cache: false,
					type: 'GET',
					data: {
						'type': self.el.categorySelector.val(),
						'lat': self.el.inputLatitide.val(),
						'lng': self.el.inputLongitude.val(),
						'dist': self.el.inputRadius.val(),
					},
					success: function(data) {
						gl.hideLoading();
						data = JSON.parse(data);

						if(data.status) {
							self.show.searchResults(self, data.data);
						} else {
							// Error
						}
					}
				});
			},
			fetchBids: function(self) {
				gl.showLoading();

				$.ajax({
					url: self.url.fetchBids,
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
							self.show.bids(self, data.data);
						} else {
							// Error
						}
					}
				});
			},
		},
		misc: {

		},
		init: function(){
			this.connect.fetchCategories(this);
			this.connect.fetchBids(this);

			this.el.btnSearchjobs.on('click', {self: this}, this.handler.searchJobs);
		}
	};


	gl.init();
	r['register'] = register;
	r['login'] = login;
	r['contractor'] = contractor;


	window['r'] = r;
})(window)