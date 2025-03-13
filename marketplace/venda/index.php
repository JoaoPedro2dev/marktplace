<?php 
    include_once"../conexao.php";
    
    session_start();

    $id_produto = $_GET['id_produto']; 

    $sql = $conexao->prepare(
        "
            SELECT produtos.*, vendedores.*
            FROM produtos
            INNER JOIN vendedores ON produtos.id_vendedor = vendedores.id_vendedor 
            WHERE produtos.id = ?; 
        "
    );
    $sql->bind_param("i", $id_produto);
    $sql->execute();
    $resultado = $sql->get_result();

    $sqlComentario = $conexao->prepare(
        "
            SELECT comentarios.*, usuarios.*
            FROM comentarios
            INNER JOIN usuarios ON comentarios.id_usuario = usuarios.id_usuario 
            WHERE comentarios.id_produto = ?; 
        "
    );
    $sqlComentario->bind_param("i", $id_produto);
    $sqlComentario->execute();
    $resultadoComentarios = $sqlComentario->get_result();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../style.css">
    <script src="script.js" defer></script>
    <script src="../script.js" defer></script>
    <title></title>
</head>
<body>
    <header>
        <!-- <button class="closeBtn backBtn" onclick="window.location.href='../index.php'">
            <i class="bi bi-arrow-left"></i>
        </button> -->
        <span onclick="window.location.href='../index.php'">Marketplace</span>
        <div id="searchBox">
            <input type="text" placeholder="Pesquise seu item" id="searchInput">
            <i class="bi bi-search" id="searchIcon"></i>
            <i class="bi bi-x-lg" id="clearSearch"></i>
        </div>
    </header>

    <div id="telaVenda">
        <div id="container">
            <?php 
                if($resultado->num_rows > 0){

                    while($dados = $resultado->fetch_assoc()){
                        echo '
                            <input type="hidden" name="id_produto" id="idProduto" value="'.htmlspecialchars($dados['id']).'"> 
                            <input type="hidden" name="id_usuario" id="idUsuario" value="
                        ';
                            if(isset($_SESSION['id'])){
                               echo htmlspecialchars($_SESSION['id']);
                            }
                        echo '
                            ">

                            <div id="produtoContainer">
                                <div class="produto-galeria">
                                    <img id="foto-principal" class="imagem-destaque" src="" alt="Imagem principal do produto">
                                    <div class="miniaturas">
                                        <img src="'.htmlspecialchars($dados["foto_1"]).'" class="selectedImg" alt="Produto 1" onclick="alterarImagem(this)">
                                        <img src="'.htmlspecialchars($dados["foto_2"]).'" alt="Produto 2" onclick="alterarImagem(this)">
                                        <img src="'.htmlspecialchars($dados["foto_3"]).'" alt="Produto 3" onclick="alterarImagem(this)">
                                    </div>
                                </div>
                                <div id="produtoInfosBox">
                                    <div id="lojaBox" onclick="window.location.href=\'../vendedor/?nome='.$dados['nome_url'].'\'">
                                        <img src="'.htmlspecialchars($dados['foto']).'" alt="">
                                        <p>'.htmlspecialchars($dados['nome_vendedor']).'</p>
                                    </div>
                                    <div id="produtoInfos">
                                        <strong>'.htmlspecialchars($dados["produto_nome"]).'</strong>
                                        <div id="valorBox">
                             ';
                                        if($dados['valor_promocao'] > 0){
                                            echo '
                                                <p id="PreçoAnterior">R$ '.htmlspecialchars(number_format($dados["preco"], 2, ',', '.')).'</p>
                                                <p id="valor">R$ '.htmlspecialchars(number_format($dados["valor_promocao"], 2, ',', '.')).'</p>
                                            ';
                                        }else{
                                            echo '
                                                <p id="valor">R$ '.htmlspecialchars(number_format($dados["preco"], 2, ',', '.')).'</p>
                                            ';
                                        }
                        echo '
                                        </div>
                                        <div id="colorBox">
                                            <p>Cores disponíveis</p>
                                            <select name="" id="">
                        ';
                                        $cores = explode(',', $dados['cores_disponiveis']);
                                        $i = 0;
                                        while($i < count($cores)){
                                            echo '
                                                <option value="'.htmlspecialchars($cores[$i]).'">'.htmlspecialchars($cores[$i]).'</option>
                                            ';
                                            $i++;
                                        }
                                            
                        echo '
                                            </select>
                                        </div>
                                        
                                        <div id="tamanhosBox">
                                            <p>Tamanhos disponíveis</p>
                                            <select name="" id="">
                        ';
                                        $tamanhos = explode(',',$dados['tamanhos_disponiveis']);
                                        $j = 0;
                                        while($j < count($tamanhos)){
                                            echo '<option value="'.htmlspecialchars($tamanhos[$j]).'">'.htmlspecialchars($tamanhos[$j]).'</option>';
                                            $j++;
                                        }
                        echo '
                                           </select>
                                        </div>

                                        <p id="descricao">
                                            '.htmlspecialchars($dados["descricao"]).'
                                        </p>
                                        <p id="guiaTamanho">Guia de tamanhos</p>
                                    </div>
                                </div>
                                <div id="compraBox">
                                    <span id="contVendas">'.htmlspecialchars($dados['quantidade_vendas']).' vendidos</span>
                                    <div id="dataBox">
                        ';
                        
                                        
                                        date_default_timezone_set("America/Sao_paulo");

                                        $data_usuario = new DateTime();
                                        $data_usuario -> modify('+'.$dados['prazo_entrega'].'day');

                        echo '

                                        <p><span class="green">Chegará até o dia</span> <span>'.htmlspecialchars($data_usuario->format("d/m/Y")).'</span></p>
                                        <p>Comprando dentro de 24 horas</p>
                                    </div>
                                    <div id="freteBox">
                        ';
            ?>
                            <?php
                                if($dados['frete'] > 0){
                                    echo "<p><span class=\"green\">Frete de </span>R$".htmlspecialchars(number_format($dados['frete'], 2, ",", "."))."</p>";
                                }else{
                                    echo "<p><span class=\"green\">Frete Grátis</p>";
                                }
                            ?>
            <?php
                            
                        echo '
                                </div> 
                        ';      
                            if(isset($_SESSION['admin']) && $_SESSION['admin'] == 'sim' && $_SESSION['id'] == $dados['id_vendedor']){
                                echo '<button class="editarProduto">Editar Produto</button>';
                            }else{
                                echo '
                                    <div id="quantidade">
                                    <p>Quantidade</p>
                                    <div class="contBox">
                                        <button class="moreBtn"><i class="bi bi-plus-lg"></i></button>
                                        <span class="qntDisplay qnt">1</span>
                                        <button class="lessBtn"><i class="bi bi-dash"></i></button>
                                    </div>  
                                    </div>
                                    <div id="buttonsBox">
                                        <button>Comprar agora</button>
                                        <button id="btnCart" onclick="' . (isset($_SESSION['id']) ? 'addCart()' : 'window.location.href=\'../login\'' ). '">Adicionar ao carrinho</button>
                                    </div>
                                    <div id="garantiaBox">
                                        <p><i class="bi bi-shield-check"></i>Garantia</p>
                                        <p>Devolva o produto em até 30 dias após o recebimento</p>
                                    </div>
                                ';
                            }

                        echo '
                                </div>
                            </div>
                        ';
                    }
                }else{
                    echo "Não encontramos o produto :(";
                }
            ?>
                <?php       
                    if($resultadoComentarios->num_rows > 0){
                        echo '
                            <div id="comentariosContainer">
                                <h3>Comentarios de quem comprou</h3>
                        ';

                            while($dadosComentario = $resultadoComentarios->fetch_assoc()){
                                $dataComentario = new DateTime($dadosComentario['data_comentario']);

                                echo '
                                    <div class="comentarioBox">
                                        <div class="usuarioInfos">
                                            <img src="'.htmlspecialchars($dadosComentario['foto']).'" alt="">
                                            <p>
                                                <strong>'.htmlspecialchars($dadosComentario['nome_usuario']).'</strong>
                                                <span>'.htmlspecialchars($dataComentario->format("d/m/Y")).'</span>
                                            </p>
                                        </div>
                                        <div class="userText">
                                            <p>'.htmlspecialchars($dadosComentario['texto_comentario']).'</p>
                                        </div>
                                        <div class="likeBox">
                                            <button class="like"><i class="bi bi-hand-thumbs-up"></i></button>
                                            <p><span>'.htmlspecialchars($dadosComentario['likes']).'<span> likes</p>
                                            <i class="bi bi-flag"></i>
                                        </div>
                                    </div> 
                                ';
                            }

                        echo '</div>
                                <p id="mostarComentariosBtn">Mostrar mais comentarios</p>
                        ';
                    }
                ?>
        </div>
    </div>

    <section class="produtos" id="maisComprados">
        <strong>Conheça itens semelhantes</strong>
        <button class="nav-controls prev-btn cinco"><i class="bi bi-arrow-left"></i></button>
        <div class="carousel-wrapper">
            <div class="carousel-track">
            <?php 
                $categoria = $_GET['categoria']; 

                $sqlCategoria = $conexao->prepare("SELECT * FROM produtos WHERE categoria = ? AND id != ?");
                $sqlCategoria->bind_param("si", $categoria, $id_produto);
                $sqlCategoria->execute();
                $resultadoCategoria = $sqlCategoria->get_result();

                if($resultadoCategoria->num_rows > 0){
                    while($dadosCategoria = $resultadoCategoria->fetch_assoc()){
                        echo "
                            <div class=\"carousel-element\" onclick='window.location.href=\"./index.php?id_produto=".htmlspecialchars($dadosCategoria["id"])."&categoria=".htmlspecialchars($dadosCategoria['categoria'])."\"'>
                                <img src=\"".htmlspecialchars($dadosCategoria['foto_1'])."\" alt=\"\">
                                <div class=\"produtoInfosz\">
                                    <p>".htmlspecialchars($dadosCategoria['produto_nome'])."</p>
                                    <strong>R$".htmlspecialchars($dadosCategoria['preco'])."</strong>
                                    <p>".htmlspecialchars($dadosCategoria['frete'])."</p>
                                </div>
                            </div>
                        ";
                    }
                }
            ?>
            </div>
        </div>
        <button class="nav-controls next-btn cinco"><i class="bi bi-arrow-right"></i></button>
    </section>

</body>
</html>

<?php 
    $sql->close();
    $sqlComentario->close();
    $sqlCategoria->close();
    $conexao-> close()
?>