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
        $spec->setLine('Organism', 'getOrganism');
        $spec->setLine('Organ', 'getOrgan');
        $spec->setLine('Sample Type', 'getSampleType');
        $spec->setLine('Study Type', 'getStudyType');
        $spec->setLine('Experiment Type', 'getExperimentType');
        $spec->setLine('Institution', 'getInstitution');
        $spec->setLine('Keywords', 'getKeywords');
        $spec->setLine('License', 'getLicense');
        $spec->setLine('Access Right', 'getAccessRight');

        return $spec->getArray();
    }
}
