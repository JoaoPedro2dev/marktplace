<?php 
    header('Content-Type: Application/json');
    include_once"../conexao.php";

    $id_usuario = trim($_GET['id'] ?? '');
    $admin = trim($_GET['admin'] ?? '');
    $cidade = trim($_GET['cidade'] ?? '');
    $rua = trim($_GET['rua'] ?? '');
    $bairro = trim($_GET['bairro'] ?? '');
    $numero = trim($_GET['numero'] ?? '');
    $cep = trim($_GET['cep'] ?? '');
    $uf = trim($_GET['uf'] ?? '');

   if(!empty($id_usuario) && !empty($admin) && !empty($cidade) && !empty($rua) && !empty($bairro) && !empty($numero) && !empty($cep) && !empty($uf)){
        session_start();
        $_SESSION['cep'] = $cep;
        $_SESSION['rua'] = $rua;
        $_SESSION['numero'] = $numero;

        function cadastrar($conexao, $rua, $tabela, $campo, $uf, $bairro, $cidade, $cep, $numero, $id_usuario){
            $endereco = "$rua, $numero - $bairro, $cidade - $uf, $cep";

            $sql = $conexao -> prepare("UPDATE $tabela SET endereco = ?, bairro = ?, cidade = ?, UF = ?, CEP =?, num_residencia =? WHERE $campo = ?");
            $sql->bind_param('sssssii',$endereco, $bairro, $cidade, $uf, $cep, $numero, $id_usuario);
            if($sql->execute()){
                ob_clean();
                return ['status' => 'sucesso'];
            }else{
                ob_clean();
                return ['status' => 'erro ao enserir dados'];
            }
        }

        if($admin == 'nao'){
            $json = cadastrar($conexao, $rua, 'usuarios', 'id_usuario', $uf, $bairro, $cidade, $cep, $numero, $id_usuario);
        }else if($admin == 'sim'){
            $json = cadastrar($conexao, $rua, 'vendedores', 'id_vendedor', $uf, $bairro, $cidade, $cep, $numero, $id_usuario);
        }

        ob_clean();
        echo json_encode($json);
   }
?>