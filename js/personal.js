$(document).ready(
	function () {

		var orcidUsers = {

			requestUserOrcidUrl: '',
			orcidOauthPopup: null,

			init: function () {
				var self = this;
				orcidUsers.getOrcid();
			},

			getOrcid: function () {
				$.post(OC.filePath('orcid', 'ajax/settings',
					'getUserOrcid.php'), {}, orcidUsers.display);
			},

			display: function (response) {
				if (response == null)
					return;

				if (response.user_orcid != '') {
					$('#orcid_id').text(response.user_orcid);
					$('#orcid_user_content').fadeIn(400);
				} else
					$('#orcid_user_content').fadeOut(400);

				if (response.request_user_orcid_url != '') {
					self.requestUserOrcidUrl = response.request_user_orcid_url;
					$('#orcid_request_button').fadeIn(400);
					$('#orcid_request_button').prop('disabled', false);
				}
			},


		};

		$('#orcid_user_content').hide();
		$('#orcid_request_button').fadeTo('0.1');
		$('#orcid_request_button').prop('disabled', true);

		$('#orcid_request_button').on('click', function () {
			if (self.orcidOauthPopup && !self.orcidOauthPopup.closed)
				self.orcidOauthPopup.focus();
			else {
				self.orcidOauthPopup =
					window.open(self.requestUserOrcidUrl, '_blank',
						'scrollbars=yes,height=620,width=600,top=100,left=300');
				$(self.orcidOauthPopup).unload(function () {
					orcidUsers.getOrcid();
				});
			}
		});

		orcidUsers.init();
	});

