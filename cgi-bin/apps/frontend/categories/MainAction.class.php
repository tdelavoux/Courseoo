<?php

    namespace apps\frontend\categories;
    
    class MainAction
    {
        public static function execute($fkCategorie=null, $limit=1)
        {
            \Form::retrieveErrorsAndParams();
            \Page::set('title', 'Categories');
            
            \Form::addParams('fkCategorie', $fkCategorie, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            \Form::addParams('limit', $limit, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            
            if(\Form::param('fkCategorie')){
                
                $nbByCat = \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                    ->data('courseoo\\Recette')->getNbByCategories(\Form::param('fkCategorie'));
                \Page::set('nbByCat', $nbByCat);
                
                $RecByCat = \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                    ->data('courseoo\\Recette')->getAllByCategories((intval(\Form::param('limit')) -1) * \data\courseoo\Recette::OFFSET_AFFICHE, \Form::param('fkCategorie'));
                \Page::set('RecByCat', $RecByCat);      
            }else{           
                $allCat = \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                    ->data('courseoo\\Recette')->getAllCategories();
                \Page::set('allCat', $allCat);
            }
            
            \Page::display();
        }
    }

?>
