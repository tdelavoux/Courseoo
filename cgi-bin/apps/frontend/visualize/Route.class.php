<?php

	namespace apps\frontend\visualize;

	class Route extends \Route
	{
            protected static $routes = array(
                'recepe' => array(
                    'pattern' => 'recepe-{fkRecepe}',
                    'controller' => 'ShowRecette::visalizeRecepe'
                ),
                'user' => array(
                    'pattern' => 'user-{fkUser}',
                    'controller' => 'ShowUser::visalizeUser'
                )
            );
	}

?>
