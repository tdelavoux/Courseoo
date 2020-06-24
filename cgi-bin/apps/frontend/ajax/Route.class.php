<?php

	namespace apps\frontend\ajax;

	class Route extends \Route
	{
            protected static $routes = array(
                'getIngredients' => array(
                        'pattern' => 'getIngredients',
                        'controller' => 'MainAction::getIngredients'
                )
            );
	}

?>
