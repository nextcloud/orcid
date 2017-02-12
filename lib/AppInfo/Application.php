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

namespace OCA\Orcid\AppInfo;

use \OCA\Orcid\Controller\SettingsController;
use \OCA\Orcid\Service\ConfigService;
use \OCA\Orcid\Service\MiscService;
use OCP\AppFramework\App;

class Application extends App {

	/**
	 *
	 * @param array $params
	 */
	public function __construct(array $params = array()) {
		parent::__construct('orcid', $params);
		$container = $this->getContainer();

		/**
		 * Controllers
		 */
		$container->registerService(
			'MiscService', function ($c) {
			return new MiscService($c->query('Logger'), $c->query('AppName'));
		}
		);

		$container->registerService(
			'ConfigService', function ($c) {
			return new ConfigService(
				$c->query('AppName'), $c->query('CoreConfig'), $c->query('UserId'),
				$c->query('MiscService')
			);
		}
		);

		$container->registerService(
			'SettingsController', function ($c) {
			return new SettingsController(
				$c->query('AppName'), $c->query('Request'), $c->query('ConfigService'),
				$c->query('MiscService')
			);
		}
		);

		/**
		 * Core
		 */
		$container->registerService(
			'Logger', function ($c) {
			return $c->query('ServerContainer')
					 ->getLogger();
		}
		);
		$container->registerService(
			'CoreConfig', function ($c) {
			return $c->query('ServerContainer')
					 ->getConfig();
		}
		);

		$container->registerService(
			'UserId', function ($c) {
			$user = $c->query('ServerContainer')
					  ->getUserSession()
					  ->getUser();

			return is_null($user) ? '' : $user->getUID();
		}
		);
	}

	public function registerSettingsAdmin() {
		\OCP\App::registerAdmin(
			$this->getContainer()
				 ->query('AppName'), 'lib/admin'
		);
	}

	public function registerSettingsPersonal() {
		\OCP\App::registerPersonal(
			$this->getContainer()
				 ->query('AppName'), 'lib/personal'
		);
	}
}

