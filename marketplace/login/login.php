<?php 
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        header('Content-Type: Application/json');
        include_once'../conexao.php';
        session_start();

        $usuario = trim($_POST['user'] ?? 0);
        $senha = trim($_POST['pass'] ?? 0);

        if(!empty($usuario) && !empty($senha)){
            $sql1 = $conexao->prepare('SELECT * FROM usuarios WHERE nome_usuario = ?');
            $sql1->bind_param('s', $usuario);
            $sql1->execute();
            $resultado1 = $sql1->get_result();
    
            $sql2 = $conexao->prepare('SELECT * FROM vendedores WHERE nome_vendedor = ?');
            $sql2->bind_param('s', $usuario);
            $sql2->execute();
            $resultado2 = $sql2->get_result();
    
            if($resultado1 -> num_rows > 0){
                $dados1 = $resultado1->fetch_assoc();

                if(password_verify($senha, $dados1['senha'])){
                    sessionLogin($dados1['id_usuario'], $dados1['nome_usuario'], $dados1['foto'], $dados1['admin'], '');
                    echo json_encode(['status' => 'sucesso']);
                }else{
                    echo json_encode(['status' => 'erro']);
                }
            }else if($resultado2 -> num_rows > 0){
                $dados2 = $resultado2->fetch_assoc();

                if(password_verify($senha, $dados2['senha'])){
                    sessionLogin($dados2['id_vendedor'], $dados2['nome_vendedor'], $dados2['foto'], $dados2['admin'], $dados2['nome_url']);
                    echo json_encode(['status' => 'sucesso']);
                }else{
                    echo json_encode(['status' => 'erro']);
                }
            }else{
                echo json_encode(['status' => 'erro']);
            }
        }else{
            echo json_encode(['status' => 'erro3']);
        }
    }

    function sessionLogin($dadoId, $dadoNome, $dadoImg, $dadoAdmin, $dadoUrl){
        if(!isset($_SESSION['id'])){
            $_SESSION['nome'] = $dadoNome;
            $_SESSION['admin'] = $dadoAdmin;
            $_SESSION['id'] = $dadoId;
            $_SESSION['foto'] = $dadoImg;
            $_SESSION['url'] = $dadoUrl;
        };
    }

    $sql1->close();
    $sql2->close();
    $conexao->close();
?>