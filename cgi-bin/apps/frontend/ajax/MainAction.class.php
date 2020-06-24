<?php

    namespace apps\frontend\ajax;

    class MainAction
    {
        public static function getIngredients()
        {
            \Form::addParams('pattern', $_POST, \Form::TYPE_STRING, 0, 255);
            $ingredients = \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                ->data('courseoo\\Ingredients')->getTypeaheadIngredients(\Form::param('pattern'));
            
            $res = array();
            foreach($ingredients as $ing){
                $res[] = \Db::decode($ing);
            }
            echo \json_encode($res);
        }
    }

?>
