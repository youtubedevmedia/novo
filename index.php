<?php
session_start();
$servidor = $_SERVER["DOCUMENT_ROOT"]."/controle-diario";
require_once($servidor."/model/usuario_model.php");
require_once($servidor."/model/limite_model.php");
require_once($servidor."/include/funcoes_globais.php");

$mes_atual = date("m");
$ano_atual = date("Y");

if (isset($_REQUEST['m']) && is_numeric($_REQUEST['m'])) {
    $mes_atual = addslashes($_REQUEST['m']);
}

$nome_mes = retornaNomeMes($mes_atual);

$usuario = new Usuario();
$id_usuario = $usuario->usuarioVerificaLogado();

$limite = new Limite();
$valor_limite = $limite->limiteExibir($id_usuario);
$valor_gasto = $limite->logTotalGastoMes($id_usuario, $mes_atual, $ano_atual);
$registros_dia = $limite->logTotalGastoDiaNoMes($id_usuario, $mes_atual, $ano_atual);

$cat_nome = "";
$cat_valor = "";
$categoria_gasto = $limite->limiteGastoCategoriaMes($id_usuario, $mes_atual, $ano_atual);
foreach ($categoria_gasto as $row) {
    $cat_nome .= "'$row->descricao',";
    $cat_valor .= "".formataMoeda($row->valor_total, 1).",";
}

$limite = $valor_limite;
$gasto = $valor_gasto;
$disponivel = $limite - $gasto;

$dias_total = date("t");
$dia_atual = date("d");
$dias_faltantes = $dias_total - $dia_atual;

$disponivel_dia = $disponivel / $dias_faltantes; 
?>

<?php require_once($servidor."/include/header.php") ?>

<section class="container_dash_topo">   
    <h1 class="titulo">Controle de gasto mensal:</h1>
    <form class="form_dash" method="GET">
        <select class="select_mes" name="m">
            <option value="1" <?= ($mes_atual == "1") ? "selected" : "";  ?>>Janeiro</option>
            <option value="2" <?= ($mes_atual == "2") ? "selected" : "";  ?>>Fevereiro</option>
            <option value="3" <?= ($mes_atual == "3") ? "selected" : "";  ?>>Março</option>
            <option value="4" <?= ($mes_atual == "4") ? "selected" : "";  ?>>Abril</option>
            <option value="5" <?= ($mes_atual == "5") ? "selected" : "";  ?>>Maio</option>
            <option value="6" <?= ($mes_atual == "6") ? "selected" : "";  ?>>Junho</option>
            <option value="7" <?= ($mes_atual == "7") ? "selected" : "";  ?>>Julho</option>
            <option value="8" <?= ($mes_atual == "8") ? "selected" : "";  ?>>Agosto</option>
            <option value="9" <?= ($mes_atual == "9") ? "selected" : "";  ?>>Setembro</option>
            <option value="10" <?= ($mes_atual == "10") ? "selected" : "";  ?>>Outrubro</option>
            <option value="11" <?= ($mes_atual == "11") ? "selected" : "";  ?>>Novembro</option>
            <option value="12" <?= ($mes_atual == "12") ? "selected" : "";  ?>>Dezembro</option>
        </select>
        <input type="hidden" name="a" value="<?= $ano_atual?>">
        <button class="btn">Exibir</button>
    </form>
</section>

<section class="container_dash">
    <section>
    	<?php if (!empty($categoria_gasto)) { ?>
	        <div class="info_dash">
	            <?php if ($mes_atual == date("m")) { ?>
	                <p class="label">Quanto quero gastar: R$ <?=  formataMoeda($limite); ?></p>
	                <p class="label">Quanto já gastei: R$ <?=  formataMoeda($gasto); ?></p>
	                <br>
	                <p class="label">Ainda posso gastar: R$ <?=  formataMoeda($disponivel); ?></p>
	                <p class="label">Posso gastar por dia: R$ <?=  formataMoeda($disponivel_dia) ?></p>
	            <?php } else { ?>
	                <p class="label">Quanto eu gastei: R$ <?=  formataMoeda($gasto); ?></p>
	            <?php } ?>
	        </div>
	<?php } ?>

        <?php if (!empty($categoria_gasto)) { ?>
            <div class="grafico_dash">
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
        <?php } ?>
    </section>

    <section class="coluna2_dash">
        <?php if (!empty($categoria_gasto)) { ?>
            <div class="categoria_dash">
                <h2 class="label_mes">Com o que você gastou no mês de <?= $nome_mes ?></h2>
                <div class="categoria_box">
                    <?php foreach ($categoria_gasto as $row) { ?>
                        <a class="categoria_link" href="https://fernandogaspar.dev.br/controle-diario/relatorio/categoria.php?c=<?= $row->id_categoria ?>&m=<?= $mes_atual ?>&a=<?= $ano_atual ?>"><?= $row->descricao ?></a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <div class="mes_dash">
            <h2 class="label_mes">Os dias que você gastou no mês de <?= $nome_mes ?></h2>
            <div class="mes">
            	<?php if (!empty($registros_dia)) {
                    foreach ($registros_dia as $row) { ?>
                		<a class='dia passado' href='https://fernandogaspar.dev.br/controle-diario/registro/registro-dia.php?d=<?= $row->data ?>'>
                			<label class='label_dia'>DIA <?= $row->dia ?></label>
                			<label>R$ <?= formataMoeda($row->valor_total) ?></label>
                		</a>
                    <?php }	
                } else { ?>
                    <p class="sem_dia">Você não possui nenhum gasto nesse mês.</p>
                <?php }  ?>
            </div>
        </div>
    </section>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const cores = [
        '#0074b4',
        '#f71e6c',
        '#00b34c',	  
        '#e72313',	           
        '#ffca1b',
        '#9061c2',
        '#f85313',
        '#6ecf42',
        '#0074b4',
        '#ffd41f',
        '#5b1d99',	  
    ];
    const data = {
        labels: [ <?= $cat_nome ?> ],
        datasets: [{
            label: 'Gastos',
            data: [ <?= $cat_valor ?> ],
            backgroundColor: cores
        }]
    };
    const config = {
        type: 'pie',
        data: data,
        options: {
    		responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Gastos do mês'
                }
            }
    	}
    };
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>

<?php require_once($servidor."/include/footer.php") ?>