<?php

namespace IdnoPlugins\GraphQL {
    
    class Main extends \Idno\Common\Plugin
    {

        function registerPages()
        {
	    
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
