<?php
declare(strict_types = 1);

namespace CedricZiel\FormEngine\Map;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

final class Configuration
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $apiLanguage;

    /**
     * @var string
     */
    protected $mode;

    /**
     * @var string
     */
    protected $oraclePassword;

    public function __construct()
    {
        if (class_exists(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)) {
            $configuration = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)->get('formengine_map');
        } else {
            $objectManager = GeneralUtility::makeInstance(ObjectManagerInterface::class);
            $configurationUtility = $objectManager->get(\TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility::class);
            $extensionConfiguration = $configurationUtility->getCurrentConfiguration('formengine_map');
            $configuration = [
                'googleMapsGeocodingApiKey' => $extensionConfiguration['googleMapsGeocodingApiKey']['value'],
                'googleMapsGeocodingApiLanguage' => $extensionConfiguration['googleMapsGeocodingApiLanguage']['value'],
                'mode' => $extensionConfiguration['mode']['value'],
            ];
        }


        if (empty($configuration['googleMapsGeocodingApiKey'])) {
            throw new \InvalidArgumentException('Missing/invalid "googleMapsGeocodingApiKey" in "Formengine map configuration"', 1598300684);
        }

        if (empty($configuration['googleMapsGeocodingApiLanguage'])) {
            throw new \InvalidArgumentException('Missing/invalid "googleMapsGeocodingApiLanguage" in "Formengine map configuration"', 1598300685);
        }

        if (empty($configuration['mode'])) {
            throw new \InvalidArgumentException('Missing/invalid "mode" in "Formengine map configuration"', 1598300685);
        }

        $this->apiKey = $configuration['googleMapsGeocodingApiKey'];
        $this->apiLanguage = $configuration['googleMapsGeocodingApiLanguage'];
        $this->mode = $configuration['mode'];
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function getApiLanguage()
    {
        return $this->apiLanguage;
    }

    public function getMode()
    {
        return $this->mode;
    }
}
