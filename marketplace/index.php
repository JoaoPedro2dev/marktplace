<?php 
    include_once"conexao.php";

    $sql = "SELECT * FROM produtos";

    $resultado = $conexao->query($sql);

    session_start();

    echo $_SESSION['nome'] . " " . " " . $_SESSION['id']. " " . $_SESSION['admin'] ."<a href='login/deslogar.php'>Deslogar</a>";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <title>Marketplace</title>
</head>
<body>
    <header>
        <span>Marketplace</span>
        <?php 
            if(!isset($_SESSION['cep'])){
                echo '
                <button id="cepBtn"'.(isset($_SESSION['id']) ? 'onclick="window.location.href=\'./cep\'"' : 'onclick="window.location.    href=\'./login\'"').'>
                    <p>Entregar em</p>
                    <strong><i class="bi bi-geo-alt"></i>CEP</strong>
                </button>';
            }else{
                echo '
                <button id="cepBtn">
                    <p>Entregar em</p>
                    <strong><i class="bi bi-geo-alt"></i>'.$_SESSION['cep'].'</strong>
                </button>';
            }
        ?>

        <div id="searchBox">
            <input type="text" placeholder="Pesquise seu item" id="searchInput">
            <i class="bi bi-search" id="searchIcon"></i>
            <i class="bi bi-x-lg" id="clearSearch"></i>
        </div>
        <div id="userBox">
            <?php 
                if(!isset($_SESSION['id'])){
                    echo '
                        <button id="userLogin" onclick="window.location.href=\'./login\'">
                            <i class="bi bi-person-circle"></i>
                            <p>Entrar</p>
                        </button>      
                    ';
                }else{
                    echo '
                        <button class="logado" id="loginBtn" onclick="">
                            <img src="'.htmlspecialchars($_SESSION['foto']).'"/>
                        </button>      
                    ';
                }
            ?>

            <i class="bi bi-bag" id="carrinhoIcon" <?php echo isset($_SESSION['id']) ? '' :  'onclick="window.location.href=\'./login\'"' ?>></i>
        </div>
    </header>

    <div id="cartBox" class="hidden">
        <button class="closeBtn">
            <i class="bi bi-x-lg"></i>
        </button>
        <ul id="cartItensBox">
            <?php 
                if(isset($_SESSION['id'])){
                    echo '<input type="hidden" id="idUsuario" value="'.$_SESSION['id'].'">';
                    $sqlCart = "SELECT carrinhos.*, produtos.* 
                            FROM carrinhos 
                            INNER JOIN produtos ON produtos.id = carrinhos.id_produto
                            WHERE id_usuario = ".$_SESSION['id'];

                    $resultadoCart = $conexao->query($sqlCart);

                    $total = 0;

                    while($dadosCart = $resultadoCart->fetch_assoc()){
                        echo '
                                <li class="cartIten">
                                    <input type="hidden" class="idProduto" value="'.$dadosCart['id'].'">

                                    <img src="'.htmlspecialchars($dadosCart['foto_1']).'" alt="" onclick="window.location.href=\'./venda/index.php?id_produto='.htmlspecialchars($dadosCart['id']).'&categoria='.htmlspecialchars($dadosCart['categoria']).'\'">
                                    <div class="itenInfos">
                                        <p>'.htmlspecialchars($dadosCart['produto_nome']).'</p>
                                        <strong>
                        ';
                                        
                                        if($dadosCart['valor_promocao'] > 0){
                                            echo '
                                                    <span class="valorOriginal">R$'.htmlspecialchars(number_format($dadosCart['preco'], 2, ",",".")).'</span>
                                                    <span class="valorPromocao">R$'.htmlspecialchars(number_format($dadosCart['valor_promocao'], 2, ",",".")).'</span>  
                                                ';
                                        }else{
                                            echo '<span class="precoItemCart">'.htmlspecialchars($dadosCart['preco']).'</span>';
                                        }

                        echo            '</strong>
                                    </div>
                                    <div class="contBox">
                                        <button class="moreBtn"><i class="bi bi-plus-lg"></i></button>
                                        <span class="qntDisplay">'.htmlspecialchars($dadosCart['quantidade']).'</span>
                                        <button class="lessBtn"><i class="bi bi-dash"></i></button>
                                    </div>
                                    <p class="itemRemoveBtn">
                                        <i class="bi bi-trash"></i>
                                    </p>
                                </li>
                        ';

                        if($dadosCart['valor_promocao'] > 0){
                            $total += $dadosCart['valor_promocao'] * $dadosCart['quantidade'];
                        }else{
                            $total += $dadosCart['preco'] * $dadosCart['quantidade'];
                        }
                    }

                    if($resultadoCart -> num_rows > 0){
                        echo '
                         <div id="buyBox">
                            <div id="buyInfos">
                                <p>Total</p>
                                <strong id="totalCart"></strong>
                            </div>
                            <button id="buyBtn">
                                Comprar tudo
                            </button>
                        </div>
                    ';
                    }else{
                        echo "<h2>Seu carrinho esta vazil</h2> <br> <p>Aproveite nossas promoções</p>";
                    }
                }
            ?>
        </ul>
    </div>

    <div id="accountBox" class="hidden">
        <button class="closeBtn">
            <i class="bi bi-x-lg"></i>
        </button>
        <div id="accountInfos">
            <h3>Olá <?=$_SESSION['nome']?></h3>

            <?php 
                if(isset($_SESSION['rua']) && isset($_SESSION['numero'])){
                    echo "
                        <p>".$_SESSION['rua'].", ".$_SESSION['numero']."</p>
                    ";
                }
            ?>

            <ul>
                <li>
                    <a href="">
                        <i class="bi bi-person-circle"></i>
                        <p>Minha conta</p>
                    </a>
                </li>

                
                <?php 
                    if($_SESSION['admin'] === 'sim'){
                        echo '
                            <li>
                                <a href="./vendedor/?nome='.$_SESSION['url'].'">
                                    <i class="bi bi-tablet-landscape"></i>
                                    <p>Painel administrativo</p>
                                </a>
                            </li>
                        ';
                    }
                ?>

                <li>
                    <a href="">
                        <i class="bi bi-cart"></i>
                        <p>Minhas compras</p>
                    </a>
                </li>

                <li>
                    <a href="">
                        <i class="bi bi-clock"></i>
                        <p>Histórico</p>
                    </a>
                </li>

                <li>
                    <a href="">
                        <i class="bi bi-headset"></i>
                        <p>Suporte</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="carousel-container">
        <div class="carousel">
            <div class="slide"><img src="../e-commerce/img/6750864b3190e.jpg" alt="Oferta 1"></div>
            <div class="slide"><img src="../e-commerce/img/675787489dd7f.png" alt="Oferta 2"></div>
            <div class="slide"><img src="../e-commerce/img/67578772b94da.png" alt="Oferta 3"></div>
        </div>

        <!-- Botões de navegação -->
        <button class="carouselBtn prev">&#10094;</button>
        <button class="carouselBtn next">&#10095;</button>

        <!-- Indicadores -->
        <div class="indicators">
            <input type="radio" name="indicator" id="ind0" checked>
            <input type="radio" name="indicator" id="ind1">
            <input type="radio" name="indicator" id="ind2">
        </div>
    </div>

    <nav>
        <a href="#ofertas">Ofertas do dia</a>
        <a href="#masculino">Masculino</a>
        <a href="#feminino">Feminino</a>
        <a href="#infantil">Infantil</a>
        <a href="#acessorios">Acessorios</a>
        <a href="#calçados">Calçados</a>
    </nav>

    <div id="sectionContainers">
        <section class="produtos" id="ofertas">
            <strong>Conheça ofertas do dia</strong>
            <button class="nav-controls prev-btn"><i class="bi bi-arrow-left"></i></button>
            <div class="carousel-wrapper">
                <div class="carousel-track">
                    <?php 
                        $data = new DateTime();

                        $sqlOferta = "SELECT * FROM produtos WHERE data_inicio_promocao = '".$data->format('Y-m-d')."'";

                        $resultadoOferta = $conexao->query($sqlOferta);

                        while($dadosOferta = $resultadoOferta->fetch_assoc()){
                            echo "
                                <div class='carousel-element' onclick='window.location.href=\"./venda?id_produto=".htmlspecialchars($dadosOferta["id"])."&categoria=".htmlspecialchars($dadosOferta['categoria'])."\"'>
                                    <img src='".htmlspecialchars($dadosOferta['foto_1'])."' alt=''>
                                    <div class='produtoInfos'>
                                        <p>".htmlspecialchars($dadosOferta['produto_nome'])."</p>
                                        <strong>R$".htmlspecialchars($dadosOferta['preco'])."</strong>
                                        <p>Frete grátis</p>
                                    </div>
                                </div>
                            ";
                        }
                    ?>
                </div>
            </div>
            <button class="nav-controls next-btn"><i class="bi bi-arrow-right"></i></button>
        </section>

        <section class="produtos" id="masculino">
            <strong>Conheça itens masculinos</strong>
            <button class="nav-controls prev-btn dois"><i class="bi bi-arrow-left"></i></button>
            <div class="carousel-wrapper">
                <div class="carousel-track">
                <?php 
                    $sqlMasculino = "SELECT * FROM produtos WHERE categoria = 'Masculino'";

                    $resultadoMasculino = $conexao->query($sqlMasculino);

                    while($dadosMasculino = $resultadoMasculino->fetch_assoc()){
                        echo "
                            <div class='carousel-element' onclick='window.location.href=\"./venda?id_produto=".htmlspecialchars($dadosMasculino["id"])."&categoria=".htmlspecialchars($dadosMasculino['categoria'])."\"'>
                                <img src='".htmlspecialchars($dadosMasculino['foto_1'])."' alt=''>
                                <div class='produtoInfos'>
                                    <p>".htmlspecialchars($dadosMasculino['produto_nome'])."</p>
                                    <strong>R$".htmlspecialchars($dadosMasculino['preco'])."</strong>
                                    <p>Frete grátis</p>
                                </div>
                            </div>
                        ";
                    }
                ?>
                </div>
            </div>
            <button class="nav-controls next-btn dois"><i class="bi bi-arrow-right"></i></button>
        </section>
        
        <section class="produtos" id="feminino">
            <strong>Conheça itens femininos</strong>
            <button class="nav-controls prev-btn tres"><i class="bi bi-arrow-left"></i></button>
            <div class="carousel-wrapper">
                <div class="carousel-track">
                <?php 
                    $sqlFeminino = "SELECT * FROM produtos WHERE categoria = 'Feminino'";

                    $resultadoFeminino = $conexao->query($sqlFeminino);

                    while($dadosFeminino = $resultadoFeminino->fetch_assoc()){
                        echo "
                            <div class='carousel-element' onclick='window.location.href=\"./venda?id_produto=".htmlspecialchars($dadosFeminino["id"])."&categoria=".htmlspecialchars($dadosFeminino['categoria'])."\"'>
                                <img src='".htmlspecialchars($dadosFeminino['foto_1'])."' alt=''>
                                <div class='produtoInfos'>
                                    <p>".htmlspecialchars($dadosFeminino['produto_nome'])."</p>
                                    <strong>R$".htmlspecialchars($dadosFeminino['preco'])."</strong>
                                    <p>Frete grátis</p>
                                </div>
                            </div>
                        ";
                    }
                ?>
                </div>
            </div>
            <button class="nav-controls next-btn tres"><i class="bi bi-arrow-right"></i></button>
        </section>

        <section class="produtos" id="infantil">
            <strong>Conheça itens infantis</strong>
            <button class="nav-controls prev-btn quarto sete"><i class="bi bi-arrow-left"></i></button>
            <div class="carousel-wrapper">
                <div class="carousel-track">
                <?php 
                    $sqlInfantil = "SELECT * FROM produtos WHERE categoria = 'Infantil'";

                    $resultadoInfantil = $conexao->query($sqlInfantil);

                    while($dadosInfantil = $resultadoInfantil->fetch_assoc()){
                        echo "
                            <div class='carousel-element' onclick='window.location.href=\"./venda?id_produto=".htmlspecialchars($dadosInfantil["id"])."&categoria=".htmlspecialchars($dadosInfantil['categoria'])."\"'>
                                <img src='".htmlspecialchars($dadosInfantil['foto_1'])."' alt=''>
                                <div class='produtoInfos'>
                                    <p>".htmlspecialchars($dadosInfantil['produto_nome'])."</p>
                                    <strong>R$".htmlspecialchars($dadosInfantil['preco'])."</strong>
                                    <p>Frete grátis</p>
                                </div>
                            </div>
                        ";
                    }
                ?>
                </div>
            </div>
            <button class="nav-controls next-btn quarto sete"><i class="bi bi-arrow-right"></i></button>
        </section>
        
        <section class="produtos" id="acessorios">
            <strong>Esta procurando acessórios?</strong>
            <button class="nav-controls prev-btn oito"><i class="bi bi-arrow-left"></i></button>
            <div class="carousel-wrapper">
                <div class="carousel-track">
                <?php 
                    $sqlAcessorio = "SELECT * FROM produtos WHERE categoria = 'Acessorio'";

                    $resultadoAcessorio = $conexao->query($sqlAcessorio);

                    while($dadosAcessorio = $resultadoAcessorio->fetch_assoc()){
                        echo "
                            <div class='carousel-element' onclick='window.location.href=\"./venda?id_produto=".htmlspecialchars($dadosAcessorio["id"])."&categoria=".htmlspecialchars($dadosAcessorio['categoria'])."\"'>
                                <img src='".htmlspecialchars($dadosAcessorio['foto_1'])."' alt=''>
                                <div class='produtoInfos'>
                                    <p>".htmlspecialchars($dadosAcessorio['produto_nome'])."</p>
                                    <strong>R$".htmlspecialchars($dadosAcessorio['preco'])."</strong>
                                    <p>Frete grátis</p>
                                </div>
                            </div>
                        ";
                    }
                ?>
                </div>
            </div>
            <button class="nav-controls next-btn oito"><i class="bi bi-arrow-right"></i></button>
        </section>

        <section class="produtos" id="calçados">
            <strong>Esta procurando calçados?</strong>
            <button class="nav-controls prev-btn nove"><i class="bi bi-arrow-left"></i></button>
            <div class="carousel-wrapper">
                <div class="carousel-track">
                <?php 
                    $sqlCalcado = "SELECT * FROM produtos WHERE categoria = 'Calcado'";

                    $resultadoCalcado = $conexao->query($sqlCalcado);

                    while($dadosCalcado = $resultadoCalcado->fetch_assoc()){
                        echo "
                            <div class='carousel-element' onclick='window.location.href=\"./venda?id_produto=".htmlspecialchars($dadosCalcado["id"])."&categoria=".htmlspecialchars($dadosCalcado['categoria'])."\"'>
                                <img src='".htmlspecialchars($dadosCalcado['foto_1'])."' alt=''>
                                <div class='produtoInfos'>
                                    <p>".htmlspecialchars($dadosCalcado['produto_nome'])."</p>
                                    <strong>R$".htmlspecialchars($dadosCalcado['preco'])."</strong>
                                    <p>Frete grátis</p>
                                </div>
                            </div>
                        ";
                    }
                ?>
                </div>
            </div>
            <button class="nav-controls next-btn nove"><i class="bi bi-arrow-right"></i></button>
        </section>
    </div>

    <footer>
        <h2>SOBRE NOSSO SITE</h2>
        <p>  
            <span id="textoSite">
                Este marktplace é um TCC (Trabalho de conclusão de curso). iniciado por 4 alunos do curso técnico de Desenvolvimento de Sistemas na escola ETEC Joaquim Ferreira do Amaral na cidade de jaú, por enquanto a ideia permanece como um projeto escolar, mas aceitamos feedbacks que nos ajudem a ter ideia de como o público reagiu ao site, isso será usado caso o site venha a se tornar algo mais profissional.

                caso queira nos ajudar, seu feedback serão ben-vindos, e com certeza serão de grande ajuda.
            </span>
        </p>

        <form action="" method="">
            <p>
                <label for="">Email</label>
                <input type="email" placeholder="Digite um e-mail" required>
            </p>

            <p>
                <label for="">Feedbacks</label>
                <textarea name="" id="" placeholder="Deixe seu feedback" required></textarea>
            </p>

            <input type="submit" value="Enviar feedback">

            <a href="#">Porque pedimos seu e-mail</a>
        </form>
    </footer>
</body>
</html>