<?php
/**
 * Content View Helper to resolve translated pages.
 * This is basically a wrapper around the PageLocator.
 *
 * PHP version 7
 *
 * Copyright (C) Villanova University 2010.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 2,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category VuFind
 * @package  View_Helpers
 * @author   Mario Trojan <mario.trojan@uni-tuebingen.de>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://vufind.org/wiki/development Wiki
 */
namespace VuFind\View\Helper\Root;

use Laminas\View\Helper\AbstractHelper;
use VuFind\Content\PageLocator;
use VuFind\View\Helper\Root\Context;

/**
 * Content View Helper to resolve translated pages.
 * This is basically a wrapper around the PageLocator.
 *
 * @category VuFind
 * @package  View_Helpers
 * @author   Mario Trojan <mario.trojan@uni-tuebingen.de>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://vufind.org/wiki/development Wiki
 */
class Content extends AbstractHelper
{
    /**
     * PageLocator instance to resolve translated pages.
     *
     * @var PageLocator
     */
    protected $pageLocator;

    /**
     * Context View Helper instance to resolve translated pages.
     *
     * @var Context
     */
    protected $contextHelper;

    /**
     * Search for a translated template and render it using a temporary context.
     *
     * @param string $pageName   Name of the page
     * @param string $pathPrefix Path where the template should be located
     * @param type   $context    Optional array of context variables
     *
     * @return string            Rendered template output
     */
    public function renderTranslated($pageName, $pathPrefix='content',
        $context=[]
    ) {
        if (!str_ends_with($pathPrefix, '/')) {
            $pathPrefix .= '/';
        }
        $pathPrefix = 'templates/' . $pathPrefix;
        $pageDetails = $this->pageLocator->determineTemplateAndRenderer(
            $pathPrefix, $pageName
        );
        $path = preg_replace(
            '"^.+' . $pageDetails['theme'] . '/templates/"', '',
            $pageDetails['path']
        );
        return $this->contextHelper->renderInContext($path, $context);
    }

    /**
     * Constructor
     *
     * @param PageLocator $pageLocator   Page locator
     * @param Context     $contextHelper Context view helper
     */
    public function __construct(PageLocator $pageLocator,
        Context $contextHelper
    ) {
        $this->pageLocator = $pageLocator;
        $this->contextHelper = $contextHelper;
    }
}
