<?php
/**
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

namespace OCA\Orcid\Controller;

use \OCA\Orcid\Service\ConfigService;
use OCA\Orcid\Service\MiscService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;

class SettingsController extends Controller {

	/** @var ConfigService */
	private $configService;

	/** @var MiscService */
	private $miscService;

	/**
	 * SettingsController constructor.
	 *
	 * @param string $appName
	 * @param IRequest $request
	 * @param ConfigService $configService
	 * @param MiscService $miscService
	 */
	public function __construct(
		$appName, IRequest $request, ConfigService $configService, MiscService $miscService
	) {
		parent::__construct($appName, $request);
		$this->configService = $configService;
		$this->miscService = $miscService;
	}

	/**
	 * @NoCSRFRequired
	 *
	 * @return TemplateResponse
	 */
	public function admin() {
		return new TemplateResponse($this->appName, 'settings.admin', [], 'blank');
	}

	/**
	 * @return array
	 */
	public function getOrcidConfig() {
		$params = [
			'orcidAppID'  => $this->configService->getAppValue(ConfigService::ORCID_CLIENT_APPID),
			'orcidSecret' => $this->configService->getAppValue(ConfigService::ORCID_CLIENT_SECRET),
			'redirUrl'    => self::generateOrcidUrl()
		];

		return $params;
	}

	/**
	 * @param string $client_app_id
	 * @param string $client_secret
	 *
	 * @return array
	 */
	public function setOrcidConfig($client_app_id, $client_secret) {
		$this->configService->setAppValue(ConfigService::ORCID_CLIENT_APPID, trim($client_app_id));
		$this->configService->setAppValue(ConfigService::ORCID_CLIENT_SECRET, trim($client_secret));

		return $this->getOrcidConfig();
	}

	/**
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 *
	 * @return TemplateResponse
	 */
	public function personal() {
		return new TemplateResponse($this->appName, 'settings.personal', [], 'blank');
	}

	/**
	 * @NoAdminRequired
	 */
//	public function requestUserOrcid() {
//		$redirectURL = OrcidController::generateOrcidUrl();
//		$params = [
//			'orcidAppID'  => $this->configService->getAppValue(ConfigService::ORCID_CLIENT_APPID),
//			'redirectURL' => $redirectURL
//		];
//
//		return $params;
//	}

	/**
	 * @NoAdminRequired
	 *
	 * @return array
	 */
	public function getUserOrcid() {

		$orcidUp = (($this->configService->getAppValue(ConfigService::ORCID_CLIENT_APPID)
					 !== '') ? '1' : '');
		$params = [
			'orcid_up'               => $orcidUp,
			'request_user_orcid_url' => $this->generateOrcidRequestUrl(),
			'user_orcid'             => $this->configService->getUserValue(
				ConfigService::ORCID_USER_ORCID
			)
		];

		return $params;
	}

	/**
	 * @return string
	 */
	private function generateOrcidRequestUrl() {
		$params = $this->getOrcidConfig();

		return sprintf(
			'https://orcid.org/oauth/authorize?client_id=%s&response_type=code&scope=/authenticate&redirect_uri=%s',
			$params['orcidAppID'], $params['redirUrl']
		);
	}

	/**
	 * @param string $code
	 * @param string $content
	 *
	 * @return string
	 */
	private function generateOrcidOauthUrl($code, &$content = '') {
		$params = $this->getOrcidConfig();
		$redirectURL = self::generateOrcidUrl();

		$content = sprintf(
			'client_id=%s&client_secret=%s&grant_type=authorization_code&code=%s&redirect_uri=%s',
			$params['orcidAppID'], $params['orcidSecret'], $code, $redirectURL
		);

		return 'https://orcid.org/oauth/token';
	}

	/**
	 * @return string
	 */
	public static function generateOrcidUrl() {
		$redirectURL = \OC::$server->getURlGenerator()
								   ->linkToRouteAbsolute('orcid.settings.OrcidCode');

		return $redirectURL;
	}


	/**
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 *
	 * @return string
	 */
	public function OrcidCode() {

		if (!key_exists('code', $_GET)) {
			return 'no code';
		}

		$code = $_GET['code'];
		$url = $this->generateOrcidOauthUrl($code, $content);

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
//		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_UNRESTRICTED_AUTH, true);

		$json_response = curl_exec($curl);
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

		if ($status === 0 || $status >= 300 || $json_response === null
			|| $json_response === false
		) {
			return 'wrong status';
		} else {
			$response = json_decode($json_response, true);
		}

		if (!empty($response) && !empty($response['orcid'])) {
			$this->configService->setUserValue(ConfigService::ORCID_USER_ORCID, $response['orcid']);
			$this->configService->setUserValue(
				ConfigService::ORCID_USER_TOKEN, $response['access_token']
			);

			return new TemplateResponse($this->appName, 'oauth.done', [], 'blank');
		}

		return 'bad response';
	}
}