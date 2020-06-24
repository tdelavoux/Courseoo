<?php

    namespace apps\frontend\visualize;
    
    class ShowUser
    {
        public static function visalizeUser($fkUser)
        {
            \Form::addParams('fkUser', $fkUser, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            \Form::retrieveErrorsAndParams();
            \Page::set('title', 'Voir Utilisateur');
            
            $userInfos = \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                ->data('courseoo\\User')->getUserInfos(\Form::param('fkUser'));
            \Page::set('userInfos', $userInfos);
            
            $userRecepe = \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                    ->data('courseoo\\Recette')->getRecepeByUser(\Form::param('fkUser'));
            \Page::set('userRecepe', $userRecepe);


            \Page::display('user.template.php');
        }
    }

?>
