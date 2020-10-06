<?php require 'php/redirecionamento.php';
	  require 'classes/classes.php';
?>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>App Lista Tarefas</title>

		<link rel="stylesheet" href="css/estilo.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	</head>

	<body>
		<nav class="navbar navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="#">
					<img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
					App Lista Tarefas
				</a>
				<a href="php/sair.php" class="btn btn-outline-info">Sair</a>

			</div>
		</nav>

		<div class="container app">
			<div class="row">
				<div class="col-sm-3 menu">
					<ul class="list-group">
						<li class="list-group-item"><a href="pendentes.php">Tarefas pendentes</a></li>
						<li class="list-group-item"><a href="nova_tarefa.php">Nova tarefa</a></li>
						<li class="list-group-item active"><a href="#">Todas tarefas</a></li>
					</ul>
				</div>

				<div class="col-sm-9">
					<div class="container pagina">
						<div class="row">
							<div class="col">
								<h4>Todas tarefas</h4>
								<hr />
								<?php 
									$tarefa = new Tarefa();
									$tarefa_service = new TarefaService();

									$tarefa->id = $_SESSION['id'];

									$query ="
										SELECT
											t.id AS tarefa_id ,t.tarefa AS tarefa_nome ,s.id AS status_id
										FROM
											tb_usuarios AS u RIGHT JOIN tb_tarefas AS t ON (u.id_usuario = t.id_usuario) LEFT JOIN tb_status AS s ON(t.id_status = s.id) 
										WHERE
											u.id_usuario = :id ;
									";

									$tarefas = $tarefa_service->recuperar($query,[':id' => $tarefa->id]);

									foreach($tarefas as $tarefa){
										$status = $tarefa['status_id'] == 1 ? 'pendente' : 'realizado';
										$cor = $status == 'pendente'?'text-info': 'text-success';
								?>
								<div class="row mb-3 d-flex align-items-center tarefa">
									<div class="col-sm-9"> <?= $tarefa['tarefa_nome']. "<span class=$cor> ($status)</span>" ?></div>
									<div class="col-sm-3 mt-2 d-flex justify-content-between">
										<a href="php/apagar_tarefa.php?tarefa_id=<?=$tarefa['tarefa_id']?>"> <i class="fas fa-trash-alt fa-lg text-danger"></i></a>
										<a href=""><i class="fas fa-edit fa-lg text-info"></i></a> 
										<a href="php/concluir_tarefa.php?tarefa_id=<?=$tarefa['tarefa_id'].'&&status_id='.$tarefa['status_id'].'&&pag=todas'?>"><i class="fas fa-check-square fa-lg text-success"></i></a> 
									</div>
								</div>
									<?php }?>
								
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>