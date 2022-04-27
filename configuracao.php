<?php
session_start();
$servidor = $_SERVER["DOCUMENT_ROOT"]."/controle-diario";
require_once($servidor."/model/usuario_model.php");
require_once($servidor."/model/limite_model.php");
require_once($servidor."/model/categoria_model.php");

$usuario = new Usuario();
$id_usuario = $usuario->usuarioVerificaLogado();

$limite = new Limite();
$valor_limite = $limite->limiteExibir($id_usuario);
$valor_limite = number_format($valor_limite, 2, ",", "");

$categoria = new Categoria();
$lista_categorias = $categoria->categoriaListaUsuario($id_usuario);
?>

<?php require_once($servidor."/include/header.php") ?>

<section class="container">
	<h1 class="titulo">Configuração</h1>

	<div class="caixa configuracao">
		<p class="label">Informe o valor que você pretende gastar no mês:</p>
		<form class="form" action="https://fernandogaspar.dev.br/controle-diario/controller/limite_controller.php" method="POST">
			<input type="text" name="limite" placeholder="Valor mensal que você quer gastar" value="<?= $valor_limite ?>" role="presentation" autocomplete="off" step=".01" required>	
			<input type="hidden" name="acao" value="ajustarLimite">
			<input type="submit" name="enviar" value="Salvar">

			<?php if (isset($_SESSION['msg_retorno'])) { ?>
				<p class="label_msg"><?= $_SESSION['msg_retorno'] ?></p>
			<?php unset($_SESSION['msg_retorno']); } ?>
		</form>
	</div>
	
	<div class="caixa configuracao">
		<p id="categoria" class="label">Adicionar categoria:</p>
		<form class="form" action="https://fernandogaspar.dev.br/controle-diario/controller/categoria_controller.php" method="POST">
			<input type="text" name="descricao" placeholder="Informe a categoria você quer adicionar?" value="">	
			<input type="hidden" name="acao" value="categoriaCadastrar">
			<input type="submit" name="enviar" value="Adicionar">

			<?php if (isset($_SESSION['msg_retorno'])) { ?>
				<p class="label_msg"><?= $_SESSION['msg_retorno'] ?></p>
			<?php unset($_SESSION['msg_retorno']); } ?>
		</form>
	</div>

	<?php if (!empty($lista_categorias)) { ?>
		<div class="caixa configuracao">
			<p class="label">Categorias cadastradas:</p>
			<table class="tabela_registro">
				<thead>
					<th class="tabela_col_mob">#</th>
					<th class="tabela_col_left">Descricao</th>
					<th>Ação</th>
				</thead>
				<tbody>
					<?php foreach ($lista_categorias as $row) { ?>
						<tr>
							<td class="tabela_col_center tabela_col_mob"><?= $row->id ?></td>
							<td><?= $row->descricao ?></td>
							<td class="tabela_btn_acao">
								<a class="icon_acao" href="https://fernandogaspar.dev.br/controle-diario/categoria/deleta-categoria.php?id=<?= $row->id ?>" title="Remover"><i class="fas fa-trash"></i></a>
							</td>
						</tr>
					<?php } ?>
			</tbody>
		</div>
	<?php } ?>
</section>

<?php require_once($servidor."/include/footer.php") ?>