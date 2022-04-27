<?php
session_start();
$servidor = $_SERVER["DOCUMENT_ROOT"]."/controle-diario";
require_once($servidor."/model/usuario_model.php");
require_once($servidor."/model/limite_model.php");
require_once($servidor."/include/funcoes_globais.php");

$url_retorno = $_SERVER["HTTP_REFERER"];

$id_registro = addslashes($_GET['id']);

if (empty($id_registro)) {
	header("Location: https://fernandogaspar.dev.br/controle-diario/");
	exit;
}

$usuario = new Usuario();
$id_usuario = $usuario->usuarioVerificaLogado();

$limite = new Limite();
$dados_log = $limite->logDescricaoGastoMes($id_registro, $id_usuario);

if(!$dados_log){
	header("Location: https://fernandogaspar.dev.br/controle-diario/");
	exit;
}

$id = $dados_log->id;
$titulo = formataTexto($dados_log->titulo);
$categoria = formataTexto($dados_log->categoria);
$valor = formataMoeda($dados_log->valor);
$descricao = formataTexto($dados_log->descricao);
$data = formataData($dados_log->data);
?>

<?php require_once($servidor."/include/header.php") ?>

<section class="container">
	<h1 class="titulo">Dados do custo</h1>
	
	<a class="btn" href="<?= $url_retorno ?>"><i class="far fa-angle-left"></i> Voltar</a>
	
	<div class="caixa">	
		<p class="item_custo"><strong>Titulo:</strong> <?= $titulo ?></p>
		<p class="item_custo"><strong>Categoria:</strong> <?= $categoria ?></p>
		<p class="item_custo"><strong>Valor:</strong> R$ <?= $valor ?></p>
		<p class="item_custo"><strong>Descrição:</strong> <?= $descricao ?></p>
		<p class="item_custo"><strong>Data:</strong> <?= $data ?></p>
		<div class="item_custo_box_acoes">
			<!-- <a class="btn" href="https://fernandogaspar.dev.br/controle-diario/registro/edita-registro.php?id=<?= $id ?>"><i class="fas fa-pen"></i> Editar</a> -->
			<a class="btn" href="https://fernandogaspar.dev.br/controle-diario/registro/deleta-registro.php?id=<?= $id ?>"><i class="fas fa-trash"></i> Excluir</a>
		</div>
	</div>
</section>

<?php require_once($servidor."/include/footer.php") ?>