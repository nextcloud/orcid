/*
 *
 * Orcid - Authenticate with Orcid.org
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Maxence Lange <maxence@pontapreta.net>
 * @author Lars Naesbye Christensen, DeIC
 * @copyright 2016-2017
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

		var orcidAdmin = {

			init: function () {
				orcidAdmin.getInfo();
			},

			getInfo: function () {
				$.post(OC.filePath('orcid', 'ajax/settings',
					'getOrcidConfig.php'), {}, orcidAdmin.display);
			},

			submit: function () {
				orcidAdmin.saving(true);
				var data = {
					client_app_id: $('#orcid_client_appid').val(),
					client_secret: $('#orcid_client_secret').val()
				};

				$.post(OC.filePath('orcid', 'ajax/settings',
					'setOrcidConfig.php'), data, orcidAdmin.display);
			},

			saving: function (load) {
				if (load) {
					$('#orcid_saving').fadeIn(50);
				} else
					$('#orcid_saving').fadeOut(50);
			},

			display: function (response) {
				if (response === null)
					return;
				orcidAdmin.saving(false);

				$('#orcid_client_appid').val(response.orcidAppID);
				$('#orcid_client_secret').val(response.orcidSecret);
				$('#redirecturl').text(response.redirUrl);
			}
		};

		$('#clientsubmit').mousedown(function () {
			orcidAdmin.submit();
		});

		orcidAdmin.init();
	});
