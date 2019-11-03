<?php

namespace IdnoPlugins\GraphQL {
    
    class Main extends \Idno\Common\Plugin
    {

        function registerPages()
        {
	    \Idno\Core\Idno::site()->routes()->addRoute('graphql', '\IdnoPlugins\GraphQL\Endpoint');
        }

        function registerTranslations()
        {

            \Idno\Core\Idno::site()->language()->register(
                new \Idno\Core\GetTextTranslation(
                    'graphql', dirname(__FILE__) . '/languages/'
                )
            );
        }

    }

}
