<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $helpers     = array('Html', 'Form', 'Session','Js');
    public $paginate    = array(
        'limit' => 10 ,
        'order' => array('Comentario.id' => 'Desc')
    );
    
    public $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect'     => array('userModel' => 'Usuario', 'action' => 'index'),//'authorize' => array('controller'), // essa linha é tensa 
            'logoutRedirect'    => array('controller' => 'pages', 'action' => 'index', 'home'),
//            'authorize'         => array('Controller'),// Linha retirada: erro ao identificar o root como controller
//            'authorize'         => array('Actions' => array('actionPath' => 'controllers')),
            'RequestHandler',
            
        )
        ,'DebugKit.Toolbar'//Para o debug da página. O log de erro esta no diretório tmp
    );

    function beforeFilter() {
        $this->Auth->a
        $this->Auth->allow('index', 'view','login','add','logout');
        //Definicao do formulario para login
        $this->Auth->authenticate = array(
            //username:campo do banco que sera usado para identificar o usuario
        AuthComponent::ALL => array('userModel' => 'Usuario','fields' => array('username' => 'email')),'Form');
        
        $this->Auth->loginAction = array(
            'plugin'        => null,
            'controller'    => 'usuarios',
            'action'        => 'login'
	);
        $this->Auth->loginRedirect = array(
            'plugin'        => null,
            'controller'    => 'comentarios',
            'action'        => 'index',
        );
        $this->Auth->logoutRedirect = array(
            'plugin'        => null,
            'controller'    => 'comentarios',
            'action'        => 'index',
        );
        $this->Auth->authError = __('É necessário autorização para esta ação.');
    }
    
    public function isAuthorized($usuario) {
        if (isset($usuario['role']) && $usuario['role'] === 'admin') {
            return true; // Admin pode acessar todas actions
        }
        return false; // Os outros usuários não podem
    }

}
