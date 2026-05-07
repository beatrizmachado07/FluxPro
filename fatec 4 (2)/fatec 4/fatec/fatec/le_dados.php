<?php
	//$key = "estacao";

    $data=$_REQUEST;

    include_once("config.php");

    $conexao = db_connect();

    extract($data);
	$setor 	= $data_setor;

	$resultado = " ";
	
	$sql = "select proDescricao, proQuantidade, proValor,
				   proSetor, proStatus
			from produto 
			where proSetor = :setor
			order by proCodigo";

    $comando = $conexao->prepare($sql);

    $comando->bindParam(':setor', $setor);

    $comando->execute();

	
	if( $comando->rowCount() > 0)
	{
		$resultado = $comando->fetchall(PDO::FETCH_ASSOC);
	}
	else
	{
		$resultado = "ERRO";
	}
	
	echo json_encode($resultado);
?>