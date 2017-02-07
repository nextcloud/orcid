<?php

/**
 * Orcid - based on user_orcid from Lars Næsbye Christensen
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Lars Næsbye Christensen, DeIC
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

class OrcidController extends Controller
{

    private $configService;

    private $userId;

    private $miscService;

    public function __construct($appName, IRequest $request, ConfigService $configService, $userId, $miscService)
    {
        parent::__construct($appName, $request);
        $this->configService = $configService;
        $this->userId = $userId;
        $this->miscService = $miscService;
    }
    
    
    /**
     * @NoCSRFRequired
     */
    public function OrcidCode()
    {
        $this->miscService->log("ORCID_CODE !!");
        
        return true;
    }
}

// \OCP\Util::writeLog('user_orcid','Received code: '.serialize($_GET), \OC_Log::WARN);

// $code = $_GET['code'];

// $user = \OCP\User::getUser();

// $clientAppID  = OC_Appconfig::getValue('user_orcid', 'clientAppID');
// $clientSecret = OC_Appconfig::getValue('user_orcid', 'clientSecret');

// $appUri = \OC::$WEBROOT . 'apps/user_orcid/receive_orcid.php';
// if(\OCP\App::isEnabled('files_sharding')){
// 	$redirectURL = \OCA\FilesSharding\Lib::getMasterURL().$appUri;
// }
// else{
// 	$redirectURL = (empty($_SERVER['HTTPS'])?'http':'https') . '://' . $_SERVER['SERVER_NAME'] .
// 	$appUri;
// }

// $content = "client_id=".$clientAppID."&".
// 		"client_secret=".$clientSecret."&".
// 		"grant_type=authorization_code&".
// 		"code=".$code."&".
// 		"redirect_uri=".$redirectURL;

// $url = "https://orcid.org/oauth/token";
// $curl = curl_init($url);
// curl_setopt($curl, CURLOPT_HEADER, false);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($curl, CURLOPT_POST, true);
// curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
// curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
// curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
// curl_setopt($curl, CURLOPT_UNRESTRICTED_AUTH, TRUE);

// $json_response = curl_exec($curl);
// $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
// curl_close($curl);
// if($status===0 || $status>=300 || $json_response===null || $json_response===false){
// 	\OCP\Util::writeLog('files_sharding', 'ERROR: bad ws response. '.$json_response, \OC_Log::ERROR);
// 	OCP\JSON::error();
// }
// else{
// 	$response = json_decode($json_response, true);
// }

// \OCP\Util::writeLog('user_orcid','Got token: '.serialize($response), \OC_Log::WARN);

// if(!empty($response) && !empty($response['orcid'])){
// 	\OCP\Config::setUserValue($user, 'user_orcid', 'orcid', $response['orcid']);
// 	\OCP\Config::setUserValue($user, 'user_orcid', 'access_token', $response['access_token']);
// 	$tmpl = new OCP\Template("user_orcid", "thanks");
// 	echo $tmpl->fetchPage();
// }
// else{
// 	OCP\JSON::error();
// }
