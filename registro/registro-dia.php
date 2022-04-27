<?php
session_start();
$servidor = $_SERVER["DOCUMENT_ROOT"]."/controle-diario";
require_once($servidor."/model/usuario_model.php");
require_once($servidor."/model/limite_model.php");
require_once($servidor."/include/funcoes_globais.php");

$url_retorno = $_SERVER["HTTP_REFERER"];

$usuario = new Usuario();
$id_usuario = $usuario->usuarioVerificaLogado();

$data = addslashes($_GET['d']);
$data_exibir = formataData($data);  

$limite = new Limite();
$dados_gasto = $limite->limiteDescricaoGastoMes($id_usuario, $data);
?>

<?php require_once($servidor."/include/header.php") ?>

<section class="container">
	<h1 class="titulo">O que você gastou no dia: <?= $data_exibir ?></h1>

	<a class="btn" href="<?= $url_retorno ?>"><i class="far fa-angle-left"></i> Voltar</a>
	<a class="btn" href="https://fernandogaspar.dev.br/controle-diario/registro/novo-registro.php"><i class="far fa-plus"></i> Adicionar novo</a>
	
	<div class="caixa registro">
		<table class="tabela_registro">
			<thead>
				<th class="tabela_col_mob">#</th>
				<th class="tabela_col_left">Titulo</th>
				<th class="tabela_col_left tabela_col_mob">Categoria</th>
				<th>Valor</th>
				<th class="tabela_col_mob">Data</th>
				<th>Ação</th>
			</thead>
			<tbody>
				<?php foreach ($dados_gasto as $row) { ?>
					<tr>
						<td class="tabela_col_center tabela_col_mob"><?= $row->id ?></td>
						<td><?= formataTexto($row->titulo) ?></td>
						<td class="tabela_col_mob"><?= formataTexto($row->categoria) ?></td>
						<td class="tabela_col_center">R$ <?= formataMoeda($row->valor) ?></td>
						<td class="tabela_col_center tabela_col_mob"><?= formataData($row->data) ?></td>
						<td class="tabela_btn_acao">
							<div class="box_icons_acao">							
								<a class="icon_acao" href="https://fernandogaspar.dev.br/controle-diario/registro/visualiza-registro.php?id=<?= $row->id ?>" title="Visualizar"><i class="fas fa-eye"></i></a>
								<!-- <a class="icon_acao" href="https://fernandogaspar.dev.br/controle-diario/registro/edita-registro.php?id=<?= $row->id ?>" title="Editar"><i class="fas fa-pen"></i></a> -->
								<a class="icon_acao" href="https://fernandogaspar.dev.br/controle-diario/registro/deleta-registro.php?id=<?= $row->id ?>" title="Remover"><i class="fas fa-trash"></i></a>
								<a id="close_acao_mob" class="icon_acao close_acao_mob" href="#" title="Fechar"><i class="fas fa-times"></i></a>
							</div>
							<i id="acao_mob" class="icon_acao_mob fas fa-th"></i>
						</td>
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