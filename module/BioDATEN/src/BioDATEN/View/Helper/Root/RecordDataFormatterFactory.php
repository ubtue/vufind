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

        $spec->setLine('Project', 'getProject', null,
            ['itemPrefix' => '<span property="name">',
             'itemSuffix' => '</span>']
        );
        $spec->setLine('Experiment Type', 'getExperimentType', null,
            ['itemPrefix' => '<span property="relevantSpecialty">',
             'itemSuffix' => '</span>']
        );
        $spec->setTemplateLine('Organism', 'getOrganism', 'data-organism.phtml',
            ['context' => ['schemaOrg' => true]]
        );
        $spec->setLine('Organ', 'getOrgan', null,
            ['itemPrefix' => '<span property="studySubject">',
             'itemSuffix' => '</span>']
        );
        $spec->setLine('Sample Type', 'getSampleType', null,
            ['itemPrefix' => '<span property="studySubject">',
             'itemSuffix' => '</span>']
        );
        $spec->setLine('Platform', 'getPlatform', null,
            ['itemPrefix' => '<span property="usesDevice" typeof="MedicalDevice"><span property="name">',
             'itemSuffix' => '</span></span>']
        );
        $spec->setLine('Study Type', 'getStudyType', null,
            ['itemPrefix' => '<span property="status">',
             'itemSuffix' => '</span>']
        );
        $spec->setLine('Keywords', 'getKeywords', null,
            ['itemPrefix' => '<span property="keywords">',
             'itemSuffix' => '</span>']
        );
        $spec->setLine('Access Right', 'getAccessRight', null,
            ['itemPrefix' => '<span property="copyrightNotice">',
             'itemSuffix' => '</span>']
        );
        $spec->setLine('License', 'getLicense', null,
            ['itemPrefix' => '<span property="license">',
             'itemSuffix' => '</span>']
        );
        $spec->setLine('Creation Date', 'getCreationDate');
        $spec->setLine('Creator', 'getCreator', null,
            ['itemPrefix' => '<span property="creator" typeof="Person"><span property="name">',
             'itemSuffix' => '</span></span>']
        );
        $spec->setLine('Institution', 'getInstitution', null,
            ['itemPrefix' => '<span property="copyrightHolder" typeof="Organization"><span property="name">',
             'itemSuffix' => '</span></span>']
        );
        $spec->setLine('External Link', 'getMetsDocumentId', null,
            ['itemPrefix' => '<a href="https://132.230.223.164/records/',
             'itemSuffix' => '" target="_blank">METS Document</a>']
        );

        return $spec->getArray();
    }
}
