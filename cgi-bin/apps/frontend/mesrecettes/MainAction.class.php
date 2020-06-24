<?php

    namespace apps\frontend\mesrecettes;

    class MainAction
    {
        public static function execute()
        {
            \Form::retrieveErrorsAndParams();
            \Page::set('title', 'Mes recettes');

                $categories = \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                        ->data('courseoo\\CategoriesRecettes')->getAllCategories();
                \Page::set('categories', $categories);
               
                $userRecepe = \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                    ->data('courseoo\\Recette')->getRecepeByUser(\User::getId());
                \Page::set('userRecepe', $userRecepe);

            \Page::display();
        }
    }

?>
