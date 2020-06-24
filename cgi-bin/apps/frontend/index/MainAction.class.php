<?php

    namespace apps\frontend\index;
    
    class MainAction
    {
        public static function execute()
        {
            \Form::retrieveErrorsAndParams();
            \Page::set('title', 'Index');

            $lastRecepe = \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                ->data('courseoo\\Recette')->getLastRecepe();
            \Page::set('lastRecepe', $lastRecepe);

            
            $bestCat = \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                ->data('courseoo\\Recette')->getPopularCategories();
            \Page::set('bestCat', $bestCat);

            \Page::display();
        }
    }

?>
