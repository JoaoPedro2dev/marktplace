<?php 
    header('Content-Type: Aplication/json');
    include_once"../conexao.php";

    $id_produto = trim($_GET['id_produto'] ?? '');
    $id_usuario = trim($_GET['id_usuario'] ?? '');

    if(!empty($id_usuario) && !empty($id_produto)){
        $sql = $conexao->prepare("DELETE FROM carrinhos WHERE id_produto = ? AND id_usuario = ?");
        $sql->bind_param('ii', $id_produto, $id_usuario);
        
        if($sql->execute()){
            echo json_encode(['status' => 'sucesso']);
        }else{
            echo json_encode(['status' => 'erro ao deletar']);
        }
    }else{
        echo json_encode(['status' => 'erro variaveis']);
    }
?>