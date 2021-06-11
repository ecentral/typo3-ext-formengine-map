<?php

$EM_CONF[$_EXTKEY] = [
    'title'            => 'FormEngine map node type',
    'description'      => 'Embed a map search into your TCA forms',
    'category'         => 'misc',
    'version'          => '0.2.2',
    'state'            => 'beta',
    'uploadfolder'     => false,
    'createDirs'       => '',
    'clearcacheonload' => true,
    'author'           => 'Cedric Ziel',
    'author_email'     => 'cedric@cedric-ziel.com',
    'author_company'   => '',
    'constraints'      => [
        'depends'   => [
            'typo3' => '9.5.27-10.4.99',
        ],
        'conflicts' => [
        ],
        'suggests'  => [
        ],
    ],
    'autoload'         => [
        'psr-4' => [
            "CedricZiel\\FormEngine\\Map\\" => 'Classes',
        ],
    ],
];
