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
use \OCA\Orcid\Controller\OrcidController;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;

class SettingsController extends Controller
{

    private $configService;

    private $miscService;

    public function __construct($appName, IRequest $request, ConfigService $configService, $miscService)
    {
        parent::__construct($appName, $request);
        $this->configService = $configService;
        $this->miscService = $miscService;
    }
    
    //
    // Admin
    //
    
    /**
     * @NoCSRFRequired
     */
    public function admin()
    {
        return new TemplateResponse($this->appName, 'settings.admin', [], 'blank');
    }

    public function getOrcidInfo()
    {
        $params = [
            'clientAppID' => $this->configService->getAppValue('clientAppID'),
            'clientSecret' => $this->configService->getAppValue('clientSecret')
        ];
        
        return $params;
    }

    public function setOrcidInfo($clientAppID, $clientSecret)
    {
        $this->configService->setAppValue('clientAppID', $clientAppID);
        $this->configService->setAppValue('clientSecret', $clientSecret);
        
        return;
    }
    
    //
    // Personal
    //
    
    /**
     * @NoCSRFRequired
     * @NoAdminRequired
     */
    public function personal()
    {
        // 'orcid_token' => $this->configService->getUserValue($this->userId, 'orcid_token')
        $params = [
            'orcid' => $this->configService->getUserValue('orcid')
        ];
        
        return new TemplateResponse($this->appName, 'settings.personal', $params, 'blank');
    }

    /**
     * @NoAdminRequired
     */
    public function getClient()
    {
        $redirectURL = OrcidController::generateOrcidUrl();
        
        // 'clientSecret' => $this->configService->getAppValue('clientSecret'),
        $params = [
            'clientAppID' => $this->configService->getAppValue('clientAppID'),
            'redirectURL' => $redirectURL
        ];
        
        return $params;
    }

    /**
     * @NoAdminRequired
     */
    public function getOrcid()
    {
        $params = [
            'orcid' => $this->configService->getUserValue('orcid')
        ];
        return $params;
    }

    /**
     * @NoAdminRequired
     */
    public function setOrcid()
    {
        $this->configService->setUserValue('orcid', $_POST['orcid']);
        return $this->getOrcid();
    }
}