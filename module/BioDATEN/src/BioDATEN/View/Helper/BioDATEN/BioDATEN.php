<?php

namespace BioDATEN\View\Helper\BioDATEN;

use BioDATEN\RecordDriver\SolrDefault;

/**
 * Put logic here for shared use in multiple templates.
 */
class BioDATEN extends \Laminas\View\Helper\AbstractHelper
{
    public function getOrganism(SolrDefault $driver, $addSchemaOrg=false): string
    {
        $organism = $driver->getOrganism();
        if ($organism == '')
            return '';

        // Do not use urlencode($organism) in href to get better search results
        $html = '';
        if ($addSchemaOrg)
            $html .= '<span property="studySubject">';
        $html .= '<a href="//en.wikipedia.org/wiki/' . $organism . '" target="_blank">' . htmlspecialchars($organism) . '</a>';
        if ($addSchemaOrg)
            $html .= '</span>';
        return $html;
    }
}
