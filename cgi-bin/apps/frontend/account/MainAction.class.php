<?php

    namespace apps\frontend\account;
    
    class MainAction
    {
        public static function execute()
        {
            \Form::retrieveErrorsAndParams();
            \Page::set('title', 'Mon Compte'); 
            
            $userInfos = \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                ->data('courseoo\\User')->getUserInfos(\User::getId());
            $userInfos['dInsc'] = \Date::getDiffrence($userInfos['dInsc'], date('Ymd'));
            \Page::set('userInfos', $userInfos);

            \Page::display();
        }
    }

?>
