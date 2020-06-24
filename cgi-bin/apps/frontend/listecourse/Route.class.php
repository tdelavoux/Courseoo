<?php

	namespace apps\frontend\listecourse;

	class Route extends \Route
	{
            protected static $routes = array(
                'index' => array(
                        'pattern' => '',
                        'controller' => 'MainAction::execute'
                ),
                'addIngredientToList' => array(
                        'pattern' => 'addIngredientToList',
                        'controller' => 'MainAction::addIngredientToList'
                ),
                'addIngredientToListByRecepe' => array(
                        'pattern' => 'addIngredientToListByRecepe',
                        'controller' => 'MainAction::addIngredientToListByRecepe'
                ),
                'deleteElements' => array(
                    'pattern' => 'deleteElements',
                    'controller' => 'MainAction::deleteElements'
                ),
                'deleteAll' => array(
                    'pattern' => 'deleteAll',
                    'controller' => 'MainAction::deleteAll'
                )
            );
	}

?>
