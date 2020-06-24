<?php

	namespace apps\frontend\login;

	class Route extends \Route
	{
            protected static $routes = array(
                'delog' => array(
                    'pattern' => '',
                    'controller' => 'MainAction::execute'
                ),
                'login' => array(
                    'pattern' => 'login',
                    'controller' => 'MainAction::login'
                ),
                'inscriptionForm' => array(
                    'pattern' => 'inscriptionForm',
                    'controller' => 'InscriptionAction::execute'
                ),
                'signup' => array(
                    'pattern' => 'signup',
                    'controller' => 'InscriptionAction::signup'
                ),
                'updatePasswd' => array(
                    'pattern' => 'updatePasswd',
                    'controller' => 'MainAction::updatePasswd'
                ),
                'closeAccount' => array(
                    'pattern' => 'closeAccount-{fkUser}',
                    'controller' => 'MainAction::closeAccount'
                )
            );
	}

?>
