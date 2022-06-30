<?php
	session_start();
	class Init{
		public $route;
		public $subpagePath;
		public $pages = array(
			'start' => array('path' => 'subpages/start.php', 'title' => ''),
			'login' => array('path' => 'login.php', 'title' => ''),
			'logout' => array('path' => 'control/logout.php', 'title' => ''),
			'listausuario' => array('path' => 'subpages/usuario/usuario.php', 'title' => ''),
			'nuevousuario' => array('path' => 'subpages/usuario/nuevo.php', 'title' => ''),
			'editarusuario' => array('path' => 'subpages/usuario/editar.php', 'title' => ''),
			'nuevorol' => array('path' => 'subpages/roles/nuevo.php', 'title' => ''),
			'listarol' => array('path' => 'subpages/roles/rol.php', 'title' => ''),
			'editarrol' => array('path' => 'subpages/roles/editar.php', 'title' => ''),
			'listaprovincia' => array('path' => 'subpages/provincia/provincia.php', 'title' => ''),
			'nuevaprovincia' => array('path' => 'subpages/provincia/nuevo.php', 'title' => ''),
			'editarprovincia' => array('path' => 'subpages/provincia/editar.php', 'title' => ''),
			'listacanton' => array('path' => 'subpages/canton/canton.php', 'title' => ''),
			'nuevocanton' => array('path' => 'subpages/canton/nuevo.php', 'title' => ''),
			'editarcanton' => array('path' => 'subpages/canton/editar.php', 'title' => ''),
			'listaparroquia' => array('path' => 'subpages/parroquia/lista.php', 'title' => ''),
			'nuevoparroquia' => array('path' => 'subpages/parroquia/nuevo.php', 'title' => ''),
			'editarparroquia' => array('path' => 'subpages/parroquia/editar.php', 'title' => ''),
			'listabarrio' => array('path' => 'subpages/barrio/lista.php', 'title' => ''),
			'nuevobarrio' => array('path' => 'subpages/barrio/nuevo.php', 'title' => ''),
			'editarbarrio' => array('path' => 'subpages/barrio/editar.php', 'title' => ''),
			'listatipopropiedad' => array('path' => 'subpages/tipopropiedad/lista.php', 'title' => ''),
			'nuevotipopropiedad' => array('path' => 'subpages/tipopropiedad/nuevo.php', 'title' => ''),
			'editartipopropiedad' => array('path' => 'subpages/tipopropiedad/editar.php', 'title' => ''),
			'listapersona' => array('path' => 'subpages/persona/lista.php', 'title' => ''),
			'nuevopersona' => array('path' => 'subpages/persona/nuevo.php', 'title' => ''),
			'editarpersona' => array('path' => 'subpages/persona/editar.php', 'title' => ''),
			'listapropiedad' => array('path' => 'subpages/propiedad/lista.php', 'title' => ''),
			'nuevopropiedad' => array('path' => 'subpages/propiedad/nuevo.php', 'title' => ''),
			'editarpropiedad' => array('path' => 'subpages/propiedad/editar.php', 'title' => ''),
			'addFotos' => array('path' => 'subpages/propiedad/addFotos.php', 'title' => ''));
		
		public function __construct(){
			$this -> CheckIfPageRequestIsLegal();
		}
		
		public function CheckIfPageRequestIsLegal(){
			
			if($_SESSION['autentica'] == md5('Inmo2022')){
				$request = isset($_REQUEST['modulo']) ? $_REQUEST['modulo'] : 'start';
			}else{
				$request = isset($_REQUEST['modulo']) ? $_REQUEST['modulo'] : 'login';
			}
			
			if(array_key_exists($request,$this -> pages)){
				$this -> subpagePath = $this -> pages[$request]['path'];
			}else{
				$this -> subpagePath = '404.php';
			}
		}
	}
?>