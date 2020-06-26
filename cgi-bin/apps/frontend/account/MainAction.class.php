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
        
        public static function modifyPict(){
            
            $fileName =  \User::getId() . '.jpg';
            $uploadfile = \config\Configuration::$vars['quaiUser']['pathUser'] . $fileName;
            
            if (move_uploaded_file($_FILES['images']['tmp_name'], $uploadfile)) {
                
                \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                ->data('courseoo\\User')->uploadImage(\User::getId(),$fileName );
                
                \Form::addConfirmation('Photo chargée avec succès !');
                \Form::displayResult(\Application::getRoute('account', 'index'));
            } else {
                \Form::addError('fileLoad', 'Errueur lors du chargement de l\'image');
                \Form::displayErrors(\Applcation::getRoute('account', 'index'));
            }
        }
    }

?>
