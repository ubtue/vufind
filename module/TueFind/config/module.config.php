<?php
namespace TueFind\Module\Config;

$config = [
    'router' => [
        'routes' => [
            'proxy-load' => [
                'type' => 'Laminas\Router\Http\Literal',
                'options' => [
                    'route'    => '/Proxy/Load',
                    'defaults' => [
                        'controller' => 'Proxy',
                        'action'     => 'Load',
                    ],
                ],
            ],
            'pdaproxy-load' => [
                'type' => 'Laminas\Router\Http\Literal',
                'options' => [
                    'route'    => '/PDAProxy/Load',
                    'defaults' => [
                        'controller' => 'PDAProxy',
                        'action'     => 'Load',
                    ],
                ],
            ],
            'fulltextsnippetproxy-load' => [
                'type' => 'Laminas\Router\Http\Literal',
                'options' => [
                    'route'    => '/FulltextSnippetProxy/Load',
                    'defaults' => [
                        'controller' => 'FulltextSnippetProxy',
                        'action'     => 'Load',
                    ],
                ],
            ],
            'wikidataproxy-load' => [
                'type'    => 'Laminas\Router\Http\Literal',
                'options' => [
                    'route'    => '/WikidataProxy/Load',
                    'defaults' => [
                        'controller' => 'WikidataProxy',
                        'action'     => 'Load',
                    ],
                ],
            ],
            'quicklink' => [
                'type'    => 'Laminas\Router\Http\Segment',
                'options' => [
                    'route'    => '/r/[:id]',
                    'constraints' => [
                        'id'     => '[a-zA-Z0-9._-]+',
                    ],
                    'defaults' => [
                        'controller' => 'QuickLink',
                        'action'     => 'redirect',
                    ]
                ],
            ],
            'redirect' => [
                'type'    => 'Laminas\Router\Http\Segment',
                'options' => [
                    'route'    => '/redirect/:url[/:group]',
                    'constraints' => [
                        // URL needs to be base64, see controller for details
                        'url'     => '[^/]+',
                        'group'   => '[^/]+',
                    ],
                    'defaults' => [
                        'controller' => 'Redirect',
                        'action'     => 'redirect',
                    ]
                ],
            ],
            'static-page' => [
                'type'    => 'Laminas\Router\Http\Segment',
                'options' => [
                    'route'    => "/:page",
                    'constraints' => [
                        'page'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => 'StaticPage',
                        'action'     => 'staticPage',
                    ],
                ],
            ],
            'myresearch-rssfeedraw' => [
                'type'    => 'Laminas\Router\Http\Segment',
                'options' => [
                    'route'    => "/myrssfeed/:user_uuid",
                    'constraints' => [
                        //example: 134b5a64-97ab-11eb-baff-309c23c4daa6
                        'user_uuid'     => '.{8}(-.{4}){3}-.{12}',
                    ],
                    'defaults' => [
                        'controller' => 'MyResearch',
                        'action'     => 'rssFeedRaw',
                    ],
                ],
            ],
            'authority-request-access' => [
                'type'    => 'Laminas\Router\Http\Segment',
                'options' => [
                    'route'    => "/Authority/RequestAccess/:authority_id",
                    'constraints' => [
                        'authority_id'     => '[0-9A-Z]{8,}',
                    ],
                    'defaults' => [
                        'controller' => 'Authority',
                        'action'     => 'requestAccess',
                    ],
                ],
            ],
            'authority-process-request' => [
                'type'    => 'Laminas\Router\Http\Segment',
                'options' => [
                    'route'    => "/Authority/RequestAccess/:authority_id/:user_id",
                    'constraints' => [
                        'authority_id'     => '[0-9A-Z]{8,}',
                        'user_id'          => '\d+',
                    ],
                    'defaults' => [
                        'controller' => 'AdminFrontend',
                        'action'     => 'ProcessUserAuthorityRequest',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            'TueFind\Controller\AdminFrontendController' => 'VuFind\Controller\AbstractBaseFactory',
            'TueFind\Controller\AjaxController' => 'VuFind\Controller\AjaxControllerFactory',
            'TueFind\Controller\AuthorityController' => 'VuFind\Controller\AbstractBaseFactory',
            'TueFind\Controller\CartController' => 'VuFind\Controller\CartControllerFactory',
            'TueFind\Controller\FeedbackController' => 'VuFind\Controller\AbstractBaseFactory',
            'TueFind\Controller\FulltextSnippetProxyController' => '\TueFind\Controller\FulltextSnippetProxyControllerFactory',
            'TueFind\Controller\MyResearchController' => 'VuFind\Controller\AbstractBaseFactory',
            'TueFind\Controller\PDAProxyController' => 'VuFind\Controller\AbstractBaseFactory',
            'TueFind\Controller\ProxyController' => 'VuFind\Controller\AbstractBaseFactory',
            'TueFind\Controller\QuickLinkController' => 'VuFind\Controller\AbstractBaseFactory',
            'TueFind\Controller\RecordController' => 'VuFind\Controller\AbstractBaseWithConfigFactory',
            'TueFind\Controller\RedirectController' => 'TueFind\Controller\RedirectControllerFactory',
            'TueFind\Controller\RssFeedController' => 'VuFind\Controller\AbstractBaseFactory',
            'TueFind\Controller\StaticPageController' => 'VuFind\Controller\AbstractBaseFactory',
            'TueFind\Controller\WikidataProxyController' => 'VuFind\Controller\AbstractBaseFactory',
        ],
        'aliases' => [
            'AdminFrontend' => 'TueFind\Controller\AdminFrontendController',
            'AJAX' => 'TueFind\Controller\AjaxController',
            'ajax' => 'TueFind\Controller\AjaxController',
            'Authority' => 'TueFind\Controller\AuthorityController',
            'authority' => 'TueFind\Controller\AuthorityController',
            'Cart' => 'TueFind\Controller\CartController',
            'cart' => 'TueFind\Controller\CartController',
            'Feedback' => 'TueFind\Controller\FeedbackController',
            'feedback' => 'TueFind\Controller\FeedbackController',
            'fulltextsnippetproxy' => 'TueFind\Controller\FulltextSnippetProxyController',
            'MyResearch' => 'TueFind\Controller\MyResearchController',
            'myresearch' => 'TueFind\Controller\MyResearchController',
            'pdaproxy' => 'TueFind\Controller\PDAProxyController',
            'proxy' => 'TueFind\Controller\ProxyController',
            'QuickLink' => 'TueFind\Controller\QuickLinkController',
            'Record' => 'TueFind\Controller\RecordController',
            'record' => 'TueFind\Controller\RecordController',
            'Redirect' => 'TueFind\Controller\RedirectController',
            'redirect' => 'TueFind\Controller\RedirectController',
            'RssFeed' => 'TueFind\Controller\RssFeedController',
            'rssfeed' => 'TueFind\Controller\RssFeedController',
            'StaticPage' => 'TueFind\Controller\StaticPageController',
            'wikidataproxy' => 'TueFind\Controller\WikidataProxyController',
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            'TueFind\Controller\Plugin\Wikidata' => 'Laminas\ServiceManager\Factory\InvokableFactory',
        ],
        'aliases' => [
            'wikidata' => 'TueFind\Controller\Plugin\Wikidata',
        ],
    ],
    'service_manager' => [
        'allow_override' => true,
        'factories' => [
            'TueFind\Auth\PluginManager' => 'VuFind\ServiceManager\AbstractPluginManagerFactory',
            'TueFind\Captcha\PluginManager' => 'VuFind\ServiceManager\AbstractPluginManagerFactory',
            'TueFind\Config\AccountCapabilities' => 'TueFind\Config\AccountCapabilitiesFactory',
            'TueFind\ContentBlock\BlockLoader' => 'TueFind\ContentBlock\BlockLoaderFactory',
            'TueFind\ContentBlock\PluginManager' => 'VuFind\ServiceManager\AbstractPluginManagerFactory',
            'TueFind\Cookie\CookieManager' => 'VuFind\Cookie\CookieManagerFactory',
            'TueFind\Db\Row\PluginManager' => 'VuFind\ServiceManager\AbstractPluginManagerFactory',
            'TueFind\Db\Table\PluginManager' => 'VuFind\ServiceManager\AbstractPluginManagerFactory',
            'TueFind\Form\Form' => 'TueFind\Form\FormFactory',
            'TueFind\Mailer\Mailer' => 'TueFind\Mailer\Factory',
            'TueFind\MetadataVocabulary\PluginManager' => 'VuFind\ServiceManager\AbstractPluginManagerFactory',
            'TueFind\Recommend\PluginManager' => 'VuFind\ServiceManager\AbstractPluginManagerFactory',
            'TueFind\Record\FallbackLoader\PluginManager' => 'VuFind\ServiceManager\AbstractPluginManagerFactory',
            'TueFind\Record\Loader' => 'VuFind\Record\LoaderFactory',
            'TueFind\RecordDriver\PluginManager' => 'VuFind\ServiceManager\AbstractPluginManagerFactory',
            'TueFind\RecordTab\PluginManager' => 'VuFind\ServiceManager\AbstractPluginManagerFactory',
            'TueFind\Search\Results\PluginManager' => 'VuFind\ServiceManager\AbstractPluginManagerFactory',
            'TueFind\Service\KfL' => 'TueFind\Service\KfLFactory',
            'TueFindSearch\Service' => 'VuFind\Service\SearchServiceFactory',
            'Laminas\Session\SessionManager' => 'TueFind\Session\ManagerFactory',
        ],
        'initializers' => [
            'TueFind\ServiceManager\ServiceInitializer',
        ],
        'aliases' => [
            'VuFind\AccountCapabilities' => 'TueFind\Config\AccountCapabilities',
            'VuFind\AuthPluginManager' => 'TueFind\Auth\PluginManager',
            'VuFind\Auth\PluginManager' => 'TueFind\Auth\PluginManager',
            'VuFind\Captcha\PluginManager' => 'TueFind\Captcha\PluginManager',
            'VuFind\Config\AccountCapabilities' => 'TueFind\Config\AccountCapabilities',
            'VuFind\ContentBlock\BlockLoader' => 'TueFind\ContentBlock\BlockLoader',
            'VuFind\ContentBlock\PluginManager' => 'TueFind\ContentBlock\PluginManager',
            'VuFind\Cookie\CookieManager' => 'TueFind\Cookie\CookieManager',
            'VuFind\CookieManager' => 'TueFind\Cookie\CookieManager',
            'VuFind\DbRowPluginManager' => 'TueFind\Db\Row\PluginManager',
            'VuFind\Db\Row\PluginManager' => 'TueFind\Db\Row\PluginManager',
            'VuFind\DbTablePluginManager' => 'TueFind\Db\Table\PluginManager',
            'VuFind\Db\Table\PluginManager' => 'TueFind\Db\Table\PluginManager',
            'VuFind\Form\Form' => 'TueFind\Form\Form',
            'VuFind\Mailer\Mailer' => 'TueFind\Mailer\Mailer',
            'VuFind\MetadataVocabulary\PluginManager' => 'TueFind\MetadataVocabulary\PluginManager',
            'VuFind\RecommendPluginManager' => 'TueFind\Recommend\PluginManager',
            'VuFind\Recommend\PluginManager' => 'TueFind\Recommend\PluginManager',
            'VuFind\Record\FallbackLoader\PluginManager' => 'TueFind\Record\FallbackLoader\PluginManager',
            'VuFind\Record\Loader' => 'TueFind\Record\Loader',
            'VuFind\RecordLoader' => 'TueFind\Record\Loader',
            'VuFind\RecordDriverPluginManager' => 'TueFind\RecordDriver\PluginManager',
            'VuFind\RecordDriver\PluginManager' => 'TueFind\RecordDriver\PluginManager',
            'VuFind\RecordTabPluginManager' => 'TueFind\RecordTab\PluginManager',
            'VuFind\RecordTab\PluginManager' => 'TueFind\RecordTab\PluginManager',
            'VuFind\Search' => 'TueFindSearch\Service',
            'VuFind\Search\Results\PluginManager' => 'TueFind\Search\Results\PluginManager',
            'VuFindSearch\Service' => 'TueFindSearch\Service',
        ],
    ],
    'view_helpers' => [
        'initializers' => [
            'TueFind\ServiceManager\ServiceInitializer',
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
    'vufind' => [
        'plugin_managers' => [
            'metadatavocabulary' => [],
        ],
    ],
];

$recordRoutes = [];
$dynamicRoutes = [];
$staticRoutes = ['AdminFrontend/ShowAdmins', 'AdminFrontend/ShowUserAuthorities', 'MyResearch/Newsletter', 'MyResearch/RssFeedSettings', 'MyResearch/RssFeedPreview', 'RssFeed/Full'];

$routeGenerator = new \VuFind\Route\RouteGenerator();
$routeGenerator->addRecordRoutes($config, $recordRoutes);
$routeGenerator->addDynamicRoutes($config, $dynamicRoutes);
$routeGenerator->addStaticRoutes($config, $staticRoutes);

return $config;
