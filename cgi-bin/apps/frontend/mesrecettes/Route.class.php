<?php

	namespace apps\frontend\mesrecettes;

	class Route extends \Route
	{
            protected static $routes = array(
                'index' => array(
                    'pattern' => '',
                    'controller' => 'MainAction::execute'
                ),
                'newRecepe' => array(
                    'pattern' => 'newRecepe',
                    'controller' => 'RecepeAction::addRecepe'
                ),
                'showRecette' => array(
                    'pattern' => 'showRecette-{fkRecette}',
                    'controller' => 'RecepeAction::showRecette'
                ),
                'updateRecepe' => array(
                    'pattern' => 'updateRecepe',
                    'controller' => 'RecepeAction::updateRecepe'
                ),
                'newIngredient' => array(
                    'pattern' => 'newIngredient',
                    'controller' => 'RecepeAction::newIngredient'
                ),
                'deleteRecette' => array(
                    'pattern' => 'deleteRecette-{fkRecette}',
                    'controller' => 'RecepeAction::deleteRecette'
                ),
                'deleteIngredients' => array(
                    'pattern' => 'deleteIngredients-{fkIngredient}-{fkRecette}',
                    'controller' => 'RecepeAction::deleteIngredients'
                )
            );
	}

?>
