<?php

namespace Bolt\Extension\Ntomka\BoltSlugifyConfig;

use Bolt\Extension\SimpleExtension;
use Cocur\Slugify\Slugify;
use Silex\Application;

/**
 * @author Nagy Tamás <nagy.tomi@gmail.com>
 * @version 2.0.0
 */
class BoltSlugifyConfigExtension extends SimpleExtension
{
    /**
     * {@inheritdoc}
     */
    protected function registerServices(Application $app)
    {
        $config = $this->getConfig();

        $app['slugify.options'] = array_merge_recursive($app['slugify.options'], $config['options']);

        $app['slugify'] = $app->share(
            function ($app) use ($config) {
                $slugify = new Slugify($app['slugify.options'], $app['slugify.provider']);

                if (isset($config['ruleset']) && !empty($config['ruleset'])) {
                    $slugify->activateRuleset($config['ruleset']);
                }

                if (isset($config['custom_rules']) && !empty($config['custom_rules'])) {
                    $slugify->addRules($config['custom_rules']);
                }

                return $slugify;
            }
        );
    }
}
