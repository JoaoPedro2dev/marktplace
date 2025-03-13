<?php 
    header('Content-Type: Application/json');

    if(empty($_POST['nome']) || empty($_POST['descricao']) || empty($_POST['categoria']) || empty($_POST['genero']) || empty($_POST['valor']) || empty($_POST['condicao']) || empty($_POST['coresDisponiveis']) || empty($_POST['tamanhosDisponiveis']) || empty($_POST['dataMaxima']) || empty($_FILES['imagem-principal']) || empty($_FILES['imagem-secundaria-1']) || empty($_FILES['imagem-secundaria-2'])){
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

    $img1 = $_FILES['imagem-principal'] ?? null;
    $img2 = $_FILES['imagem-secundaria-1'] ?? null;
    $img3 = $_FILES['imagem-secundaria-2'] ?? null;

    if(!$img1 || $img1['error'] !== UPLOAD_ERR_OK || 
       !$img2 || $img2['error'] !== UPLOAD_ERR_OK ||
       !$img3 || $img3['error'] !== UPLOAD_ERR_OK){
        die(json_encode(['status' => 'erroImagem']));
    }

    if($img1['size'] > 32997250 || $img2['size'] > 32997250 || $img3['size'] > 32997250){
        die(json_encode(['status' => 'imgemGrande']));
    }

    $pasta = 'fotoProdutos/';
    $nomeImagem1 = $img1['name'];
    $nomeImagem2 = $img2['name'];
    $nomeImagem3 = $img3['name'];
    $novoNome1 = uniqid();
    $novoNome2 = uniqid();
    $novoNome3 = uniqid();
    $extencao1 = strtolower(pathinfo($nomeImagem1, PATHINFO_EXTENSION));
    $extencao2 = strtolower(pathinfo($nomeImagem2, PATHINFO_EXTENSION));
    $extencao3 = strtolower(pathinfo($nomeImagem3, PATHINFO_EXTENSION));

    $extencoes = [$extencao1, $extencao2, $extencao3];

    foreach($extencoes as $extencao){
        if($extencao != "jpg" && $extencao != "png" && $extencao != "jpeg"){
            die(json_encode(['status' => 'erroExtencao']));
        }
    }

    $imagens = [$img1, $img2, $img3];
    $novosNomes = [$novoNome1, $novoNome2, $novoNome3];
    $extencoes = [$extencao1, $extencao3, $extencao3];

    foreach ($imagens as $index => $img) {
        $funcionou[$index] = move_uploaded_file($img['tmp_name'], '../../'.$pasta.$novosNomes[$index].".".$extencoes[$index]);
        $arquivoImg[$index] = ' http://localhost/marketplace/'.$pasta.$novosNomes[$index].".".$extencoes[$index];
    }

    $funcionouArray = [$funcionou[0], $funcionou[1], $funcionou[2]];

    foreach($funcionouArray as $funcionou){
        if(!$funcionou){
            die(json_encode(['status' => 'erroMovimentacaoArquivo']));
        }
    }
    

    $sqlProdutos = $conexao->prepare("INSERT INTO produtos (id_vendedor, produto_nome, categoria, genero,cores_disponiveis, tamanhos_disponiveis, descricao, preco, frete, prazo_entrega, foto_1, foto_2, foto_3) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sqlProdutos->bind_param('issssssddisss', $_SESSION['id'], $nomeProduto, $categoria, $genero,$coresDisponiveis, $tamanhosDisponiveis, $descricao, $valor, $frete, $prazoEntrega, $arquivoImg[0], $arquivoImg[1], $arquivoImg[2]);

    $sqlVendedor = $conexao->prepare("UPDATE vendedores SET itens_a_venda = itens_a_venda + 1 WHERE id_vendedor = ?");
    $sqlVendedor->bind_param('i', $_SESSION['id']);
    $sqlVendedor->execute();
    
    if($sqlProdutos -> execute()){
        echo json_encode(['status' => 'cadastrado']);
    }else{
        die(json_encode(['status' => 'erroCadastro']));
    }
?>