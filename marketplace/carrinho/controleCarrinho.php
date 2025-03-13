<?php 
    header('Content-Type: Application/json');
    include_once"../conexao.php";

    $id_usuario = trim($_GET['id_usuario'] ?? '');
    $id_produto = trim($_GET['id_produto'] ?? '');
    $comando = trim($_GET['comando'] ?? '');

    if(!empty($id_usuario) && !empty($id_produto) && !empty($comando)){

        function cartControl($conexao, $sinal, $id_usuario, $id_produto){
            $sql = $conexao->prepare("UPDATE carrinhos SET quantidade = quantidade $sinal 1 WHERE id_usuario = ? AND id_produto = ?");
            $sql->bind_param('ii', $id_usuario, $id_produto);
            
            if($sql -> execute()){
                return json_encode(['status' => 'sucesso']);
            }else{
                return json_encode(['status' => 'erro no controle de carrinho']);
            }

            $sql->close();
            $conexao->close();
        }

        if($comando == 'more'){
            ob_clean();
            echo cartControl($conexao, '+', $id_usuario, $id_produto);
        }else if($comando === 'less'){
            ob_clean();
            echo cartControl($conexao, '-', $id_usuario, $id_produto);
        }else{
            echo json_encode(['status' => 'erro no controle de comando']);
        }
    }
?>