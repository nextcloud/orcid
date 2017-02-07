<?php
namespace OCA\Orcid;

$app = new \OCA\Orcid\AppInfo\Application();

$response = $app->getContainer()
    ->query('SettingsController')
    ->personal();

return $response->render();


