<?php

namespace CedricZiel\FormEngine\Map\Utility;

use CedricZiel\FormEngine\Map\Configuration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

class StaticMaps
{
    const GOOGLE_STATICMAP_URL = 'https://maps.googleapis.com/maps/api/staticmap?';

    /**
     * Computes a static maps url.
     *
     * @param array $currentValue
     *
     * @return string
     */
    public static function getStaticMapsUrl($currentValue = null)
    {
        $formattedAddress = ObjectAccess::getPropertyPath($currentValue, 'formatted_address');

        if ($formattedAddress === null) {
            return '';
        }

        /** @var Configuration $configuration */
        $configuration = GeneralUtility::makeInstance(Configuration::class);

        $parameters = http_build_query(
            [
                'key'     => $configuration->getApiKey(),
                'size'    => '1000x200',
                'zoom'    => 14,
                'center'  => $formattedAddress,
                'markers' => $formattedAddress,
            ]
        );

        return static::GOOGLE_STATICMAP_URL.$parameters;
    }
}
