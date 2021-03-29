<?php

namespace BioDATEN\RecordDriver;

class PluginManager extends \VuFind\RecordDriver\PluginManager
{
    public function __construct($configOrContainerInstance = null,
        array $v3config = []
    ) {
        $this->aliases['solrdefault'] = SolrDefault::class;
        $this->factories[SolrDefault::class] = \VuFind\RecordDriver\SolrDefaultFactory::class;
        parent::__construct($configOrContainerInstance, $v3config);
    }
}
