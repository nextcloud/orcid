<?php
/**
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

namespace OCA\Orcid\Controller;

use \OCA\Orcid\Service\ConfigService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;

class OrcidController extends Controller {

	private $configService;

	private $miscService;

	public function __construct(
		$appName, IRequest $request, ConfigService $configService, $miscService
	) {
		parent::__construct($appName, $request);
		$this->configService = $configService;
		$this->miscService = $miscService;
	}

	public static function generateOrcidUrl() {
		$redirectURL = \OC::$server->getURlGenerator()
								   ->linkToRouteAbsolute('orcid.orcid.OrcidCode');

		return $redirectURL;
	}

	/**
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function AboutOrcid() {
		return new TemplateResponse($this->appName, 'about', [], 'blank');
	}

	/**
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function OrcidCode() {

		if (!key_exists('code', $_GET)) {
			return false;
		}

		$code = $_GET['code'];

		$orcidAppID = trim($this->configService->getAppValue(ConfigService::ORCID_CLIENT_APPID));
		$orcidSecret = trim($this->configService->getAppValue(ConfigService::ORCID_CLIENT_SECRET));

		$redirectURL = self::generateOrcidUrl();

		$url = "https://orcid.org/oauth/token";
		$content = "client_id=" . $orcidAppID . "&" . "client_secret=" . $orcidSecret . "&"
				   . "grant_type=authorization_code&" . "code=" . $code . "&" . "redirect_uri="
				   . $redirectURL;

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_UNRESTRICTED_AUTH, true);

		$json_response = curl_exec($curl);
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		if ($status === 0 || $status >= 300 || $json_response === null
			|| $json_response === false
		) {
			// $this->miscService->log('ERROR: bad ws response. ' . $json_response);
			return false;
		} else {
			$response = json_decode($json_response, true);
		}

		// $this->miscService->log('Got token: ' . serialize($response));

		if (!empty($response) && !empty($response['orcid'])) {
			$this->configService->setUserValue('orcid', $response['orcid']);
			$this->configService->setUserValue('access_token', $response['access_token']);

			return new TemplateResponse($this->appName, 'thanks', [], 'blank');
		} else {
			return false;
		}

		return true;
	}
}

