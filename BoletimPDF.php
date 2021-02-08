<?php 
	// referenciar o DomPDF com namespace
	// use Dompdf\Dompdf;

    // // require_once("cabecalhoPDF.php");
	// require_once 'dompdf/autoload.inc.php';

	require_once("DAO/Conexao.php");
	require_once("DAO/config.php");

	$aluno = $_GET['aluno'];
	$nome = $_GET['nome'];
	$turma = $_GET['turma'];
	$bimestre = $_GET['bimestre'];

	$response = array();	

	try
	{
		$query = "	SELECT d.nome as disciplina, b.prova1, b.prova2, b.trabalho, b.recuperacao, b.media, b.faltas, b.media_parcial
					FROM boletim b
					INNER JOIN turma t
					ON b.id_turma = t.id_turma
					INNER JOIN disciplina d
					ON b.id_disciplina = d.id
					INNER JOIN aluno a
					ON b.id_aluno = a.id_aluno
					WHERE b.id_turma = $turma 
					AND b.id_aluno = $aluno 
					AND b.bimestre = $bimestre";

		$conexao = Conexao::pegarConexao();
		$stmt = $conexao->prepare($query);
		$stmt->execute();
		$fetchAll = $stmt->fetchAll();

		}

	catch (Exception $e)
	{
		//Erro::trataErro($e);
		$response['mensagem'] = 'erro';
		$response['title'] = "Ops...";
		$response['text'] = (string) $e;
		echo json_encode($response);
	}
	
	// // criando a instancia do DOMPDF:
	// $dompdf = new DOMPDF(["enable_remote" => true]);

	// $dompdf->load_html('
	// 	<h1>Hello World!</h1>
	// ');

    // ob_start();
    // require 'BoletimPDF.php';
    // $dompdf->loadHtml(ob_get_clean());

	

	// $dompdf->setPaper('A4', 'portrait');

	// // Renderizar o html
	// $dompdf->render();

	// // Exibir a página
	// $dompdf->stream(
	// 	"boletimAluno.pdf",
	// 	array(
	// 		"Attachment" => false // Para realizar o download somente alterar para true
	// 	)
	// );
?>

<!doctype html>
<html>
    <head>
    	<meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.0/jspdf.umd.min.js"></script>
		
        <link rel="stylesheet" href="node_modules/bootstrap/compiler/bootstrap.css">
        <link rel="stylesheet" href="node_modules/bootstrap/compiler/home.css">
        <link rel="stylesheet" href="node_modules/bootstrap/compiler/jquery-ui-1.10.3.custom.min.css">
		<link rel="stylesheet" href="node_modules/bootstrap/compiler/animate.css">
        <script type="text/javascript" src="node_modules/bootstrap/js/jquery-3.3.1.min.js"></script>
        <script src="js/sweetalert.js"></script>

        <title>Boletim</title>
    </head>
    <body>
		<div id="conteudo">
			<!-- Optional JavaScript -->
			<!-- jQuery first, then Popper.js, then Bootstrap JS -->
			<script src="node_modules/jquery/dist/jquery.js"></script>
			<script src="node_modules/popper.js/dist/umd/popper.js"></script>
			<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
			<div class="container">
				<div class="principal">
					<link rel="stylesheet" type="text/css" href="node_modules/DataTables/datatables.min.css"/>
					<link href="datepicker/css/bootstrap-datepicker.css" rel="stylesheet"/>

					
					
					<div class="container">
						<!-- <button id="btGerarPDF" href="domPdf.php">gerar PDF</button> -->
						<div class="row ">
							<div class="col-8">
								<h5><?php echo $nome ?></h5>
							</div>
							<div class="col ">
							<h5 class="text-right"><?php echo $bimestre ?>º Bimestre</h5>
							</div>
						</div>
					</div>
					<!-- <div class="table-responsive"> -->
						<table 
								class="table table-hover table-bordered table-striped tabelaBoletimPDF border border-dark" 
								id="tabelaBoletimPDF"
							>
							<thead class="thead" align="center" style="color: black">
								<tr>
									<th class="align-middle" style="color: black" >Disciplina</th>
									<th class="align-middle" style="color: black">Prova 1</th>
									<th class="align-middle" style="color: black">Prova 2</th>
									<th class="align-middle" style="color: black">Trabalho</th>
									<th class="align-middle" style="color: black" width="90">Média Parcial</th>
									<th class="align-middle" style="color: black" width="90">Recuperação</th>
									<th class="align-middle" style="color: black" width="100">Média Final</th>
									<th class="align-middle" style="color: black" >Faltas</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($fetchAll as $linha): ?>
								<tr>
									<td align="center"><?php echo $linha['disciplina']?></td>
									<td align="center"><?php echo $linha['prova1']?></td>
									<td align="center"><?php echo $linha['prova2']?></td>
									<td align="center"><?php echo $linha['trabalho']?></td>
									<td align="center"><?php echo $linha['recuperacao']?></td>
									<td align="center"><?php echo $linha['media']?></td>
									<td align="center"><?php echo $linha['faltas']?></td>
									<td align="center"><?php echo $linha['media_parcial']?></td>
								</tr>
							<?php endforeach ?>
							</tbody>
						</table>
					<!-- </div> -->


					<script type="text/javascript" src="node_modules/bootstrap/js/jquery.mask.min.js"></script>
					<script src="js/popper.min.js"></script>
					<script type="text/javascript" src="node_modules/DataTables/datatables.min.js"></script>
					<script src="js/dataTable.js"></script>

					<script type="module" src="js/formataCamposBoletimPDF.js"></script>
					<!-- <script type="module" src="js/pdfTeste.js"></script> -->
					
					<!-- <script src="js/alterarVinculoProfessor.js"></script>
					<script src="js/salvarBoletim.js"></script> -->



				</div>
			</div>
		</div>
		<div id="editor"></div>
    </body>
</html>