<?php

namespace CedricZiel\FormEngine\Map\Controller;

use CedricZiel\FormEngine\Map\Configuration;
use TYPO3\CMS\Core\Http\AjaxRequestHandler;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

class GeocodingLegacyController
{
    const API_URL = 'https://maps.googleapis.com/maps/api/geocode/json?';

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct()
    {
        $this->configuration = GeneralUtility::makeInstance(Configuration::class);
    }
    /**
     * @param array              $ajaxParameters
     * @param AjaxRequestHandler $ajaxRequestHandler
     */
    public function geocode(array $ajaxParameters, AjaxRequestHandler $ajaxRequestHandler)
    {
        /** @var ServerRequest $request */
        $request = $ajaxParameters['request'];
        $address = $request->getQueryParams()['query'];
        $queryData = http_build_query(
            [
                'key'     => $this->configuration->getApiKey(),
                'address' => $address,
                'language' => $this->configuration->getApiLanguage(),
            ]
        );

        $report = [];
        $url = static::API_URL.$queryData;

        $result = GeneralUtility::getUrl($url, 0, false, $report);

        $ajaxRequestHandler->setContentFormat('application/json');
        $ajaxRequestHandler->setContent(['data' => $result]);
    }
}
