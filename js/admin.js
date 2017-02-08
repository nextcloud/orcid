/*
 *
 * Orcid - based on user_orcid from Lars Naesbye Christensen
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Lars Naesbye Christensen, DeIC
 * @author Maxence Lange <maxence@pontapreta.net>
 * @copyright 2017
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

$(document).ready(
	function () {

		var orcidSettings = {

			init: function () {
				orcidSettings.getInfo();
			},

			getInfo: function () {
				$.post(OC.filePath('orcid', 'ajax/settings',
					'getOrcidInfo.php'), {}, orcidSettings.display);
			},

			submit: function () {
				orcidSettings.saving(true);
				var data = {
					client_app_id: $('#inputclientappid').val(),
					client_secret: $('#inputclientsecret').val()
				};

				$.post(OC.filePath('orcid', 'ajax/settings',
					'setOrcidInfo.php'), data, orcidSettings.display);
			},

			saving: function (load) {
				if (load) {
					$('#orcid_saving').fadeIn(50);
				} else
					$('#orcid_saving').fadeOut(50);
			},

			display: function (response) {
				if (response == null)
					return;
				orcidSettings.saving(false);
				$('#inputclientappid').val(response.clientAppID);
				$('#inputclientsecret').val(response.clientSecret);
				$('#redirecturl').text(response.redirUrl);
			}
		};

		$('#clientsubmit').mousedown(function () {
			orcidSettings.submit();
		});

		orcidSettings.init();
	});
