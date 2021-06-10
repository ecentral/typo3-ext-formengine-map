<?php

namespace CedricZiel\FormEngine\Map\Form\Element;

use CedricZiel\FormEngine\Map\Configuration;
use CedricZiel\FormEngine\Map\Utility\StaticMaps;
use TYPO3\CMS\Backend\Form\Element\InputTextElement;
use TYPO3\CMS\Backend\Form\NodeFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class MapElement extends InputTextElement
{
    /**
     * @var StandaloneView
     */
    protected $view;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @param NodeFactory $nodeFactory
     * @param array       $data
     */
    public function __construct(NodeFactory $nodeFactory, array $data)
    {
        parent::__construct($nodeFactory, $data);

        $this->configuration = GeneralUtility::makeInstance(Configuration::class);

        $this->view = $this->prepareView();
    }

    /**
     * Handler for single nodes
     *
     * @return array As defined in initializeResultArray() of AbstractNode
     */
    public function render()
    {
        $parameterArray = $this->data['parameterArray'];
        $resultArray = $this->initializeResultArray();

        $config = $parameterArray['fieldConf']['config'];
        $size = MathUtility::forceIntegerInRange(
            $config['size'] ?: $this->defaultInputWidth,
            $this->minimumInputWidth,
            $this->maxInputWidth
        );
        // Add a wrapper to remain maximum width
        $width = (int) $this->formMaxWidth($size);

        $currentValue = json_decode($parameterArray['itemFormElValue']) ?: [];
        $attributes = [
            'class'       => 'form-control',
            'placeholder' => $this->preparePlaceholderAttribute($currentValue),
        ];

        $this->view->assignMultiple(
            [
                'apiKey'           => $this->configuration->getApiKey(),
                'currentValue'     => $currentValue ? $currentValue : [],
                'currentValueJson' => json_encode($currentValue),
                'inputAttributes'  => $this->buildInputAttributes($attributes),
                'parameterArray'   => $parameterArray,
                'mode'             => $this->configuration->getMode(),
                'staticMapUrl'     => StaticMaps::getStaticMapsUrl($currentValue),
                'width'            => $width,
            ]
        );

        $resultArray['html'] = $this->view->render();

        $resultArray['requireJsModules'] = ['TYPO3/CMS/FormengineMap/MapHandler'];

        return $resultArray;
    }

    /**
     * @param array $attributes
     *
     * @return string
     */
    protected function buildInputAttributes($attributes)
    {
        $attributeString = '';
        foreach ($attributes as $attributeName => $attributeValue) {
            $attributeString .= ' '.$attributeName.'="'.htmlspecialchars($attributeValue).'"';
        }

        return $attributeString;
    }

    /**
     * @param string $currentValue
     *
     * @return string
     */
    protected function preparePlaceholderAttribute($currentValue)
    {
        if ($currentValue === null || empty($currentValue)) {
            return 'Please enter an address or place.';
        } else {
            return $currentValue->formatted_address;
        }
    }


    /**
     * @return StandaloneView
     */
    protected function prepareView()
    {
        $view = new StandaloneView();
        $view->setTemplateRootPaths(
            [10 => GeneralUtility::getFileAbsFileName('EXT:formengine_map/Resources/Private/Templates/')]
        );
        $view->setTemplate('MapElement.html');

        return $view;
    }
}
