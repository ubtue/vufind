<?php
namespace IxTheo\Search\Factory;

use IxTheo\Search\Backend\Solr\Backend;
use IxTheo\Search\Backend\Solr\LuceneSyntaxHelper;
use IxTheo\Search\Backend\Solr\QueryBuilder;
use VuFind\I18n\Translator\TranslatorAwareInterface;
use VuFindSearch\Backend\Solr\Connector;
use VuFindSearch\Backend\Solr\HandlerMap;
use TueFindSearch\Backend\Solr\Response\Json\RecordCollectionFactory;

class SolrDefaultBackendFactory extends \TueFind\Search\Factory\SolrDefaultBackendFactory implements TranslatorAwareInterface
{
    use \VuFind\I18n\Translator\TranslatorAwareTrait;

     /**
     * Create the SOLR backend.
     *
     * @param Connector $connector Connector
     *
     * @return Backend
     */
    protected function createBackend(Connector $connector)
    {
        $backend = new Backend($connector);
        $backend->setQueryBuilder($this->createQueryBuilder());
        $backend->setSimilarBuilder($this->createSimilarBuilder());
        if ($this->logger) {
            $backend->setLogger($this->logger);
        }
        $manager = $this->serviceLocator->get(\VuFind\RecordDriver\PluginManager::class);
        $factory = new RecordCollectionFactory([$manager, 'getSolrRecord']);
        $backend->setRecordCollectionFactory($factory);
        return $backend;
    }


    /**
     * Create the SOLR connector
     * Set the language code
     *
     * @return Connector
     */
    protected function createConnector()
    {
        $config = $this->config->get($this->mainConfig);
        $this->setTranslator($this->serviceLocator->get(\Laminas\Mvc\I18n\Translator::class));
        $current_lang = $this->getTranslatorLocale();

        // On the Solr side we use different naming scheme
        // so map traditional and simplified chinese accordingly
        $chinese_lang_map = [ "zh" => "hant", "zh-cn" => "hans"];
        if (array_key_exists($current_lang, $chinese_lang_map))
            $current_lang = $chinese_lang_map[$current_lang];

        $handlers = [
            'select' => [
                'fallback' => true,
                'defaults' => ['fl' => '*,score', 'lang' => $current_lang,
                               'defType' => 'multiLanguageQueryParser', 'df' => 'allfields'
                              ],
                'appends'  => ['fq' => []],
            ],
            'term' => [
                'functions' => ['terms'],
            ],
        ];

        foreach ($this->getHiddenFilters() as $filter) {
            array_push($handlers['select']['appends']['fq'], $filter);
        }

        $connector = new Connector($this->getSolrUrl(), new HandlerMap($handlers), $this->uniqueKey);
        $connector->setTimeout(isset($config->Index->timeout) ? $config->Index->timeout : 30);

        if ($this->logger) {
            $connector->setLogger($this->logger);
        }
        if ($this->serviceLocator->has('VuFind\Http')) {
            $connector->setProxy($this->serviceLocator->get('VuFind\Http'));
        }
        return $connector;
    }

    /**
     * Create the query builder.
     *
     * @return QueryBuilder
     */
    protected function createQueryBuilder()
    {
        $specs   = $this->loadSpecs();
        $config = $this->config->get($this->mainConfig);
        $defaultDismax = isset($config->Index->default_dismax_handler)
                         ? $config->Index->default_dismax_handler : 'dismax';
        $builder = new QueryBuilder($specs, $defaultDismax);

        // Configure builder:
        $search = $this->config->get($this->searchConfig);
        $caseSensitiveBooleans = isset($search->General->case_sensitive_bools)
                                 ? $search->General->case_sensitive_bools : true;
        $caseSensitiveRanges = isset($search->General->case_sensitive_ranges)
                               ? $search->General->case_sensitive_ranges : true;
        $helper = new LuceneSyntaxHelper($caseSensitiveBooleans, $caseSensitiveRanges);
        $builder->setLuceneHelper($helper);
        return $builder;
    }
}
