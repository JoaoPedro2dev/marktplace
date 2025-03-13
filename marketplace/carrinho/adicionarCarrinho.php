<?php 
    header('Content-Type: Application/json');
    include_once"../conexao.php";

    $id_produto = trim($_GET['id_produto'] ?? '');
    $id_usuario = trim($_GET['id_usuario'] ?? '');
    $qnt = trim($_GET['qnt'] ?? '');

    $sqlVerifica = $conexao->prepare("SELECT * FROM carrinhos WHERE id_produto = ? AND id_usuario = ?");
    $sqlVerifica->bind_param('ii', $id_produto, $id_usuario);
    $sqlVerifica->execute();
    $resultado = $sqlVerifica->get_result();

    if($resultado->num_rows > 0){
        $sql = $conexao->prepare("UPDATE carrinhos SET quantidade = quantidade + ? WHERE id_produto = ? AND id_usuario = ?");
        $sql -> bind_param('iii', $qnt, $id_produto, $id_usuario);   
    }else{
        $sql = $conexao->prepare("INSERT INTO carrinhos (id_produto, id_usuario, quantidade) VALUES(?, ?, ?)");
        $sql -> bind_param('iii', $id_produto, $id_usuario, $qnt);   
    }

    if($sql -> execute()){
        echo json_encode(['status' => 'sucesso']);
    }else{
        echo json_encode(['status' => 'erro ao adicionar carrinho']);
    }

    $sqlVerifica->close();
    $sql->close();
    $conexao->close();
?>