<?php
session_start();
$servidor = $_SERVER["DOCUMENT_ROOT"]."/controle-diario";
require_once($servidor."/model/usuario_model.php");

$usuario = new Usuario();
$usuario->usuarioLogout();
?>