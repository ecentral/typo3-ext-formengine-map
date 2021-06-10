<?php

return [
    'tx_formenginemap_address_geocode_handler' => [
        'path' => '/formenginemap/geocode',
        'target' => \CedricZiel\FormEngine\Map\Controller\GeocodingController::class. '::geocode',
    ]
];
