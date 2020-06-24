<?php

    namespace apps\frontend\visualize;
    
    class ShowRecette
    {
        public static function visalizeRecepe($fkRecepe)
        {
            \Form::addParams('fkRecepe', $fkRecepe, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            \Form::retrieveErrorsAndParams();
            \Page::set('title', 'Voir Recette');
            
            $recepeInfo =  \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                      ->data('courseoo\\Recette')->getRecepeById(\Form::param('fkRecepe'));
            \Page::set('recepeInfo', $recepeInfo);
            
            $ingredients =  \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                      ->data('courseoo\\IngredientRecette')->getIngredientsByRecette(\Form::param('fkRecepe'));
            \Page::set('ingredients', $ingredients);

            \Page::display('recette.template.php');
        }
    }

?>
