<?php
session_start();
$servidor = $_SERVER["DOCUMENT_ROOT"]."/controle-diario";
require_once($servidor."/model/usuario_model.php");
require_once($servidor."/model/limite_model.php");
require_once($servidor."/model/categoria_model.php");
require_once($servidor."/include/funcoes_globais.php");

$url_retorno = $_SERVER["HTTP_REFERER"];

$usuario = new Usuario();
$id_usuario = $usuario->usuarioVerificaLogado();

$id_categoria = addslashes($_GET['c']);
$ano = addslashes($_GET['a']);
$mes = addslashes($_GET['m']);
$nome_mes = retornaNomeMes($mes);

$categoria = new Categoria();
$nome_categoria = $categoria->categoriaRetornaNome($id_usuario, $id_categoria);

$limite = new Limite();
$dados_categoria = $limite->limiteDescricaoGastoCategoria($id_usuario, $id_categoria, $mes, $ano);
?>

<?php require_once($servidor."/include/header.php") ?>

<section class="container">
	<h1 class="titulo">O que você gastou na categoria <?= $nome_categoria ?> no mês de <?= $nome_mes ?>: </h1>

	<a class="btn" href="<?= $url_retorno ?>"><i class="far fa-angle-left"></i> Voltar</a>
	
	<div class="caixa registro">
		<table class="tabela_registro">
			<thead>
				<th class="tabela_col_mob">#</th>
				<th class="tabela_col_left">Titulo</th>
				<th>Valor</th>
				<th>Data</th>
			</thead>
			<tbody>
				<?php foreach ($dados_categoria as $row) { ?>
					<tr>
						<td class="tabela_col_center tabela_col_mob"><?= $row->id ?></td>
						<td><?= formataTexto($row->titulo) ?></td>
						<td class="tabela_col_center">R$ <?= formataMoeda($row->valor) ?></td>
						<td class="tabela_col_center"><?= formataData($row->data) ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>

		<?php if (isset($_SESSION['msg_retorno'])) { ?>
			<p class="label_msg"><?= $_SESSION['msg_retorno'] ?></p>
		<?php unset($_SESSION['msg_retorno']); } ?>
	</div>
</section>

<?php require_once($servidor."/include/footer.php") ?>