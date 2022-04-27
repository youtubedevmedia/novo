<?php
session_start();
$servidor = $_SERVER["DOCUMENT_ROOT"]."/controle-diario";
require_once($servidor."/model/usuario_model.php");
require_once($servidor."/model/categoria_model.php");
require_once($servidor."/include/funcoes_globais.php");

$usuario = new Usuario();
$id_usuario = $usuario->usuarioVerificaLogado();

$categoria = new Categoria();
$lista_categorias = $categoria->categoriaLista($id_usuario);
?>

<?php require_once($servidor."/include/header.php") ?>

<section class="container">
	<h1 class="titulo">Informe qual foi seu novo custo</h1>
	
	<div class="caixa novo_custo">
		<p class="label">Qual foi o seu gasto?</p>
		<form class="form" action="https://fernandogaspar.dev.br/controle-diario/controller/limite_controller.php" method="POST">
			<input type="text" name="titulo" placeholder="Com o que você gastou?" role="presentation" autocomplete="off">	
			<a class="btn_add_categoria" href="https://fernandogaspar.dev.br/controle-diario/configuracao.php#categoria">Adicionar nova categoria</a>
			<select name="categoria">
				<option value="-1">Informe uma categoria para organizar seus custos</option>
				<?php foreach ($lista_categorias as $row) { ?>
					<option value="<?= $row->id ?>"><?= formataTexto($row->descricao) ?></option>
				<?php } ?>
			</select>
			<input type="number" name="valor" placeholder="Quanto custou? Exemplo: 19,99" role="presentation" autocomplete="off" step=".01">	
			<input type="date" name="data">	
			<textarea name="descricao" placeholder="Adicionar uma descrição, pode te ajudar a lembrar no futuro."></textarea>	
			<input type="hidden" name="id_usuario" value="<?= $id_usuario ?>">
			<input type="hidden" name="acao" value="adicionarGasto">
			<input type="submit" name="enviar" value="Salvar">
		</form>
	</div>

	<?php if (isset($_SESSION['msg_retorno'])) { ?>
		<p class="label_msg"><?= $_SESSION['msg_retorno'] ?></p>
	<?php unset($_SESSION['msg_retorno']); } ?>

</section>

<?php require_once($servidor."/include/footer.php") ?>