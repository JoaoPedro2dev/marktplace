<?php 
    header('Content-Type: Application/json');

    if(empty($_POST['nome']) || empty($_POST['descricao']) || empty($_POST['categoria']) || empty($_POST['genero']) || empty($_POST['valor']) || empty($_POST['condicao']) || empty($_POST['coresDisponiveis']) || empty($_POST['tamanhosDisponiveis']) || empty($_POST['dataMaxima'])){
        die(json_encode(['status' => 'erroVazil']));
    }

    include_once"../../conexao.php";

    session_start();
    
    $nomeProduto = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $genero = trim($_POST['genero'] ?? '');
    $valor = trim($_POST['valor'] ?? 0);
    $condicao = trim($_POST['condicao'] ?? '');
    $coresDisponiveis = trim($_POST['coresDisponiveis'] ?? '');
    $tamanhosDisponiveis = trim($_POST['tamanhosDisponiveis'] ?? '');
    $frete = trim($_POST['frete'] ?? 0);
    $prazoEntrega = trim($_POST['dataMaxima'] ?? '');
    $id_produto = trim($_POST['id_produto'] ?? '');

    $slqImg = $conexao->prepare("SELECT foto_1, foto_2, foto_3 FROM produtos WHERE id =? AND id_vendedor = ?");
    $slqImg -> bind_param('ii', $id_produto, $_SESSION['id']);
    $slqImg->execute();
    $resultado = $slqImg -> get_result();

    $dados = $resultado->fetch_assoc();


    $img1 = !empty($_FILES['imagem-principal']['name']) ? $_FILES['imagem-principal'] : $dados['foto_1'];
    $img2 = !empty($_FILES['imagem-secundaria-1']['name']) ? $_FILES['imagem-secundaria-1'] : $dados['foto_2'];
    $img3 = !empty($_FILES['imagem-secundaria-2']['name']) ? $_FILES['imagem-secundaria-2'] : $dados['foto_3'];

    $imagens = [$img1, $img2, $img3];
    $arquivoImg = [];

    foreach($imagens as $img){
        if(is_array($img)){
            if($img['error'] !== UPLOAD_ERR_OK){
                die(json_encode(['status' => 'erroImagem', 'error' => $img['error']]));
            }
    
            if($img['size'] > 32997250){
                die(json_encode(['status' => 'imgemGrande']));
            }
    
            $pasta = 'fotoProdutos/';
            $nomeImagem = $img['name'];
            $novoNome = uniqid();
            $extencao = strtolower(pathinfo($nomeImagem, PATHINFO_EXTENSION));
    
    
            if($extencao != "jpg" && $extencao != "png" && $extencao != "jpeg"){
                die(json_encode(['status' => 'erroExtencao']));
            }
            
            $funcionou = move_uploaded_file($img['tmp_name'], '../../'.$pasta.$novoNome.".".$extencao);
            $arquivoImg[] = ' http://localhost/marketplace/'.$pasta.$novoNome.".".$extencao;

            if(!$funcionou){
                die(json_encode(['status' => 'erroMovimentacaoArquivo']));
            }
        }else{
            $arquivoImg[] = $img;
        }
    }

    $sqlProdutos = $conexao->prepare("UPDATE produtos SET produto_nome =?, categoria = ?, genero = ?, cores_disponiveis = ?, tamanhos_disponiveis =? , descricao = ?, preco = ?, frete = ?, prazo_entrega = ?, foto_1 = ?, foto_2 = ?, foto_3 = ? WHERE id = ? AND id_vendedor = ?");
    $sqlProdutos->bind_param('ssssssddisssii', $nomeProduto, $categoria, $genero,$coresDisponiveis, $tamanhosDisponiveis, $descricao, $valor, $frete, $prazoEntrega, $arquivoImg[0], $arquivoImg[1], $arquivoImg[2], $id_produto ,$_SESSION['id']);
    
    if($sqlProdutos -> execute()){
        echo json_encode(['status' => 'alterado']);
    }else{
        die(json_encode(['status' => 'erroAlterar']));
    }
?>