<?php

namespace CedricZiel\FormEngine\Map\Controller;

use CedricZiel\FormEngine\Map\Configuration;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Http\AjaxRequestHandler;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

class GeocodingController
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

    public function geocode(ServerRequestInterface $request): JsonResponse
    {
        /** @var ServerRequest $request */
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

        return (new JsonResponse())->setPayload((array)json_decode($result));
    }
}
