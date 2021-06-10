<?php

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry']['cz_map'] = [
    'nodeName' => 'cz_map',
    'priority' => 40,
    'class'    => \CedricZiel\FormEngine\Map\Form\Element\MapElement::class,
];

if (\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(\TYPO3\CMS\Core\Utility\VersionNumberUtility::getNumericTypo3Version()) < 9000000) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler(
        'tx_formenginemap_address_geocode_handler',
        \CedricZiel\FormEngine\Map\Controller\GeocodingLegacyController::class . '->geocode',
        true
    );
}
