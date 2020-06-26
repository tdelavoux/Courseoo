<?php

	namespace apps\frontend\account;

	class Route extends \Route
	{
            protected static $routes = array(
                'index' => array(
                        'pattern' => '',
                        'controller' => 'MainAction::execute'
                ),
                'modifyPict' => array(
                        'pattern' => 'modifyPict',
                        'controller' => 'MainAction::modifyPict'
                )
            );
	}

?>
