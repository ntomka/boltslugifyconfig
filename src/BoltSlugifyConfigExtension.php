<?php

namespace Bolt\Extension\Ntomka\BoltSlugifyConfig;

use Bolt\Extension\SimpleExtension;

class BoltSlugifyConfigExtension extends SimpleExtension
{

    public function boot(\Silex\Application $app)
    {
        parent::boot($app);

        $config = $this->getConfig();

        if (isset($config['rulesets']) && isset($config['rulesets'][$app['locale']])) {
            $slugifyLocaleRuleset = $config['rulesets'][$app['locale']];
            if (!empty($slugifyLocaleRuleset)) {
                $app['slugify']->addRuleset($app['locale'], $slugifyLocaleRuleset);
                $app['slugify']->activateRuleset($app['locale']);
            }
        }

        if (isset($config['custom_ruleset']) && !empty($config['custom_ruleset'])) {
            $app['slugify']->addRuleset('custom_ruleset', $config['custom_ruleset']);
            $app['slugify']->activateRuleset('custom_ruleset');
        }

        if (isset($config['regexp'])) {
            $app['slugify']->setRegExp((bool) $config['regexp']);
        }

        if (isset($config['options']) && is_array($config['options'])) {
            $app['slugify']->setOptions($config['options']);
        }
    }

}
