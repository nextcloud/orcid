<?php
namespace OCA\Orcid;

$app = new \OCA\Orcid\AppInfo\Application();

$response = $app->getContainer()
    ->query('SettingsController')
    ->admin();

return $response->render();
