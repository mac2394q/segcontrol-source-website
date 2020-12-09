<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/directorio.php');
require_once(CONTROLLER_PATH."usuariosController.php");
require_once(PERSISTENCIA_PATH."usuarioDao.php");

$controller_usuario = new usuarioController();
if($controller_usuario->verificarUsuario($_POST['user'])==0){
  echo "<span>No se puede utilizar el usuario , ya<br/> se encuentra en uso</span>";
}else{echo "<span> usuario disponible </span>";}

 ?>
