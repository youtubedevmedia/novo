<?php
session_start();
$servidor = $_SERVER["DOCUMENT_ROOT"]."/controle-diario";
require_once($servidor."/model/usuario_model.php");
require_once($servidor."/model/categoria_model.php");

$id_registo = addslashes($_GET['id']);
echo "EDITA: ".$id_registo;