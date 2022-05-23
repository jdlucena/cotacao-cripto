<!doctype html>
<html lang="pt-br">

<head>
	<title>Teste Dev PHP</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="assets/css/iziToast.min.css">
</head>

<body>
	<main role="main">
		<section class="text-center mt-5">
			<div class="container">
				<h1 class="jumbotron-heading">Cotação Cripto</h1>
				<p class="lead text-muted">Selecione 1 ou mais criptomoedas e clique em Enviar.<br>Visualize o preço atual e o preço médio com base nos últimos 100 registros.</p>
				<p>
				<form action="./" method="post">
					<div class="row text-center">
						<div class="col-md-12 mb-3">
							<select name="symbol[]" class="selectpicker" data-live-search="true" multiple title="Escolha um dos seguintes...">
								<?php foreach ($binance->allCriptomoedas() as $value) { ?>
									<option><?= $value['symbol'] ?></option>
								<?php } ?>
							</select>
							<input type="submit" class="btn btn-primary my-2" name="cadastrar" value="Enviar">
						</div>
					</div>
				</form>
				<hr class="mb-4">
				</p>
			</div>
		</section>

		<?php if ($binance->status) { ?>
			<div class="container">
				<div class="row">
					<?php foreach ($binance->result_consulta_preco as $value) { ?>
						<div class="col-md-4 text-center">
							<div class="card mb-4 box-shadow">
								<div class="card-header">
									<h4 class="my-0 font-weight-normal"><?= $value->symbol ?></h4>
								</div>
								<div class="card-body">
									<h1 class="card-title pricing-card-title"><small class="text-muted">Última Cotação</small> <br>$ <?= $value->price ?></h1>
									<ul class="list-unstyled mt-3 mb-4">
										<li class="mt-3 mb-4">Preço Médio: <?= $value->precoMedio ?></li>
										<?= $binance->checkAvgBigPrice($value->price, $value->precoMedio) ?>
									</ul>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>

	</main>

	<script src="assets/js/jquery-3.2.1.slim.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/bootstrap-select.min.js"></script>
	<script src="assets/js/iziToast.min.js"></script>

	<!-- Select Bootstrap -->
	<script>
		$(function() {
			$('.selectpicker').selectpicker();
		});
	</script>

	<!-- Evita o reenvio do formulário caso usuário atualize a página -->
	<script>
		if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}
	</script>

</body>

</html>

<!-- erros e mensagens -->
<?php
if (isset($binance)) {
    if ($binance->errors) {
        foreach ($binance->errors as $error) { ?><script>iziToast.error({title: "<?=$error;?>",position: 'topRight',timeout: 7000,});</script><?php } }
    if ($binance->messages) {
        foreach ($binance->messages as $message) { ?><script>iziToast.success({title: "<?=$message;?>",position: 'topRight',timeout: 10000,});</script><?php } }
} ?>