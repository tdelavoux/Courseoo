<?php

	namespace apps\frontend\imprimerliste;

	class Route extends \Route
	{
            protected static $routes = array(
                'index' => array(
                        'pattern' => '',
                        'controller' => 'MainAction::execute'
                )
            );
	}

?>
