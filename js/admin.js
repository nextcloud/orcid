$(document).ready(
		function() {

			var orcidSettings = {

				init : function() {
					orcidSettings.getInfo();
				},

				getInfo : function() {
					$.post(OC.filePath('orcid', 'ajax/settings',
							'getOrcidInfo.php'), {}, orcidSettings.display);
				},

				submit : function() {
					orcidSettings.saving(true);
					var data = {
						client_app_id : $('#inputclientappid').val(),
						client_secret : $('#inputclientsecret').val()
					};

					$.post(OC.filePath('orcid', 'ajax/settings',
							'setOrcidInfo.php'), data, orcidSettings.display);
				},

				saving : function(load) {
					if (load) {
						$('#orcid_saving').fadeIn(50);
					} else
						$('#orcid_saving').fadeOut(50);
				},

				display : function(response) {
					if (response == null)
						return;
					orcidSettings.saving(false);
					$('#inputclientappid').val(response.clientAppID);
					$('#inputclientsecret').val(response.clientSecret);
					$('#redirecturl').text(response.redirUrl);
				}
			};

			$('#clientsubmit').mousedown(function() {
				orcidSettings.submit();
			});

			orcidSettings.init();
		});
