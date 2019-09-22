<?php
	if (array_key_exists("removido", $_GET) && $_GET["removido"] == "true") {
?>
		<p class="alert alert-success">Dado apagado com sucesso</p>
<?php
	}
?>

<table class="table table-striped table-bordered">
	<thead class="thead-success">
	    <tr>
	      <th scope="col">Criado por:</th>
	      <th scope="col">Nome do experimento</th>
	      <th scope="col">Descrição</th>
	      <th scope="col"><a href="lista-usuario-atual-asc.php" class="text-primary">Data de criação<i class="small material-icons md-dark icones">arrow_drop_down</i></a></th>
	      <th scope="col"></th>
	      <th scope="col"></th>
	      <th scope="col"></th>
	    </tr>
  	</thead>
	<?php
		if (isset($_GET["page"])) { 
			$page  = $_GET["page"]; 
		} 
		else {
			$page=1;
		};
		//Variável que pode servir para alterar número de resultado páginas
		$resultadoPorPagina = 10; 
		$inicio = ($page - 1) * $resultadoPorPagina;

		$experimentos = listarUserExperimentosLimitado ($conexao, $_SESSION["usuario_logado"], "desc", $inicio, $resultadoPorPagina);

		foreach ($experimentos as $experimento) {
	?>
  	<tbody>
		<tr>
			<td><?= $experimento['nomeUser']; ?></td>
			<td><?= $experimento['nomeExperimento']; ?></td>
			<td><?= substr($experimento['descricao'], 0, 40); ?></td>
			<td><?= $experimento['reg_date']; ?></td>
			<td>
				<form action="exibir-relatorio.php" method="POST">
					<input type="hidden" name="id_tabela" value="<?=$experimento['id']?>">
					<button class="btn btn-success"><i class="material-icons md-18 white icones">search</i></button>
				</form>
			</td>
			<td>
				<form action="#" method="POST">
					<input type="hidden" name="id_tabela" value="<?=$experimento['id']?>">
					<button class="btn btn-warning text-white">
						<i class="material-icons md-18 white icones">edit</i>
					</button>
				</form>
			</td>
			<td>
				<form action="remover-experimento.php" method="POST">
					<input type="hidden" name="id_tabela" value="<?=$experimento['id']?>">
					<button class="btn btn-danger" onclick="return confirm('Remover é uma ação irreversível! Continuar a ação mesmo assim?');">
						<i class="material-icons md-18 white icones">delete_forever</i>
					</button>
				</form>
			</td>
		</tr>
	</tbody>
	<?php
		}
	?>
</table>
<!--Controle do número de páginas da tabela -->
<p class="text-center h6">
<?php 
	$totalLinhas = totalExperimentosUser($conexao, $_SESSION["usuario_logado"]);
	$numeroPaginas = ceil($totalLinhas/$resultadoPorPagina);
	for ($i = 1; $i <= $numeroPaginas; $i++) {
?>
	<a href="lista-usuario-atual.php?page=<?=$i;?>"><?=$i . "</a> ";?>
<?php
	}
?>
</p>
<?php
	include("rodape.php"); 
?>