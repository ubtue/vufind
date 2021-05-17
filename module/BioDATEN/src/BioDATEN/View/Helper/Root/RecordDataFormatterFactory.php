<?php

namespace BioDATEN\View\Helper\Root;

use VuFind\View\Helper\Root\RecordDataFormatter\SpecBuilder;

class RecordDataFormatterFactory extends \VuFind\View\Helper\Root\RecordDataFormatterFactory
{
    /**
     * Get default specifications for displaying data in core metadata.
     *
     * @return array
     */
    public function getDefaultCoreSpecs()
    {
        $spec = new SpecBuilder();

        $spec->setLine('Project', 'getProject');
        $spec->setLine('Experiment Type', 'getExperimentType');
        $spec->setTemplateLine('Organism', 'getOrganism', 'data-organism.phtml');
        $spec->setLine('Organ', 'getOrgan');
        $spec->setLine('Sample Type', 'getSampleType');
        $spec->setLine('Platform', 'getPlatform');
        $spec->setLine('Study Type', 'getStudyType');
        $spec->setLine('Keywords', 'getKeywords');
        $spec->setLine('Access Right', 'getAccessRight');
        $spec->setLine('License', 'getLicense');
        $spec->setLine('Creation Date', 'getCreationDate');
        $spec->setLine('Creator', 'getCreator');
        $spec->setLine('Institution', 'getInstitution');
        $spec->setLine('External Link', 'getMetsDocumentId', null,
            ['itemPrefix' => '<a href="https://132.230.223.164/records/',
             'itemSuffix' => '" target="_blank">METS Document</a>']
        );

        return $spec->getArray();
    }
}
