<?php

	namespace apps\frontend\categories;

	class Route extends \Route
	{
            protected static $routes = array(
                'index' => array(
                        'pattern' => 'index-{fkCategorie}-{limit}',
                        'controller' => 'MainAction::execute'
                )
            );
	}

?>
