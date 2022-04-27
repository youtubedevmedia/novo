<?php
session_start();
$servidor = $_SERVER["DOCUMENT_ROOT"]."/controle-diario";

if (isset($_SESSION['autenticado'])) {
	header("Location: https://fernandogaspar.dev.br/controle-diario/");
	exit;
}
?>

<?php require_once($servidor."/include/header.php") ?>

<section class="login">
	<form class="form" action="https://fernandogaspar.dev.br/controle-diario/controller/usuario_controller.php" method="POST">
		<h1>Bem vindo ao Controle Diário!</h1>
		<p>Faça seu login para acessar o sistema.</p>	
		
		<input type="text" name="email" placeholder="Email">	
		<input type="password" name="senha" placeholder="Senha">
		<input type="hidden" name="acao" value="autenticarUsuario">
		<input type="submit" name="enviar" value="Acessar">
		
		<?php if (isset($_SESSION['erro_autenticacao'])) { ?>
			<p class="erro_login"><?= $_SESSION['erro_autenticacao'] ?></p>
		<?php unset($_SESSION['erro_autenticacao']); } ?>
	</form>
</section>

<?php require_once($servidor."/include/footer.php") ?>