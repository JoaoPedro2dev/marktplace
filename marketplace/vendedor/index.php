<?php 
    include_once"../conexao.php";

    session_start();
    if(!isset($_SESSION['admin'])){
        $_SESSION['admin'] = 'nao';
    }

    if(!isset($_GET['nome'])){
        die("erro");
    }

    if(empty($_GET['nome'])){
        die("erro vazil");
    }

    $nomeVendedor = trim($_GET['nome'] ?? '');

    $sql = $conexao->prepare("SELECT vendedores.*, produtos.*
                              FROM vendedores
                              LEFT JOIN produtos ON produtos.id_vendedor = vendedores.id_vendedor
                              WHERE nome_url = ?");
    $sql->bind_param('s', $nomeVendedor);
    $sql->execute();
    $resultado = $sql->get_result();
    
    while($row = $resultado->fetch_assoc()){
        $dados[] = $row;
    }

    if(empty($dados)){
        die("Vendedor não encontrado");
    }

    date_default_timezone_set('America/Sao_paulo');

    $abertura = !($dados[0]['abertura'] == '00:00:00') ? $dados[0]['abertura'] : '08:00:00';
    $fechamento = !($dados[0]['fechamento']  == '00:00:00') ? $dados[0]['fechamento'] : '16:00:00';    ;
    $horarioAtual = date('H:i:s');

    if($horarioAtual > $abertura && $horarioAtual < $fechamento){
        $status = 'Aberto';
    }else{
        $status = 'Fechado';
    }

    // var_dump($dados);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="../script.js" defer></script>
    <title><?=$dados[0]['nome_vendedor']?></title>
</head>
<body>
    <header>
        <span onclick="window.location.href='../index.php'">Marketplace</span>
        <?php 
            if(!isset($_SESSION['cep'])){
                echo '
                <button id="cepBtn"'.(isset($_SESSION['id']) ? 'onclick="window.location.href=\'../cep\'"' : 'onclick="window.location.    href=\'../login\'"').'>
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
                        <button id="userLogin" onclick="window.location.href=\'../login\'">
                            <i class="bi bi-person-circle"></i>
                            <p>Entrar</p>
                        </button>      
                    ';
                }
            ?>

        </div>

    </header>

    <div class="container">
        <div id="banner">
            <?php 
                if(!empty($dados[0]['banner'])){
                    echo '<img src="'.$dados[0]['banner'].'" alt="">';
                }else{
                    echo '<img src="http://localhost/marketplace/fotosUsuarios/bannerPadrao.png" alt="">';
                }
            ?>
        </div>
        <section>
            <div id="userInfos">
                <img src="<?=$dados[0]['foto']?>" alt="">
                <div id="text">
                    <h2><?=$dados[0]['nome_vendedor']?></h2>
                    <p><?=$dados[0]['vendas']?> Vendas | <?=$dados[0]['itens_a_venda']?> itens à venda</p>
                </div>
                <?php 
                      if($_SESSION['admin'] === 'sim' && $_SESSION['id'] === $dados[0]['id_vendedor'] && $_SESSION['nome'] === $dados[0]['nome_vendedor']){
                        echo '
                            <button id="btnEditar" onclick="window.location.href=\'painel\'">
                                <i class="bi bi-pencil"></i>
                                <span>Editar<span>
                            </button>
                        ';
                    }
                ?>
            </div>
        </section>
    </div>

    <section>
        <div id="apresentacaoBox">
            <div id="apresentacao">
                <h3><?=$dados[0]['nome_vendedor']?></h3>
                <p><?=$dados[0]['apresentacao']?></p>
            </div>
            <ul>
                <li>
                    <i class="bi bi-stopwatch"></i>
                    <p>Horários:</p>
                    <span> <?= date('H:i', strtotime($abertura))?> ás <?=date('H:i', strtotime($fechamento))?> </span>
                </li>

                <li>
                    <i class="bi bi-telephone"></i>
                    <p>Contato:</p>
                    <span id="telContato"><?=$dados[0]['telefone_contato']?></span>
                </li>

                <li>
                    <i class="bi bi-calendar"></i>
                    <p>Finais de semana:</p>
                    <span>Não trabalhamos</span>
                </li>

                <li>
                    <i class="bi bi-app-indicator"></i>
                    <p>Status:</p>
                    <span id="status" class="<?=($status == 'Aberto' ? 'green' : 'red')?>"><?=$status?></span>
                </li>

                <?php 
                    // if($_SESSION['admin'] === 'sim' && $_SESSION['id'] === $dados[0]['id_vendedor'] && $_SESSION['nome'] === $dados[0]['nome_vendedor']){
                    //     echo '
                    //         <li id="btnEditarAprensentacao">
                    //             <i class="bi bi-pencil"></i>
                    //             <p>Editar</p>
                    //         </li>
                    //     ';
                    // }
                ?>
            </ul>
        </div>
        <div id="prdoutosBox">
            <h2>Produtos</h2>
            <ul>
                <?php 
                    if($_SESSION['admin'] === 'sim' && $_SESSION['id'] === $dados[0]['id_vendedor'] && $_SESSION['nome'] === $dados[0]['nome_vendedor']){
                        echo '
                            <li id="adicionarProduto" onclick="window.location.href=\'./produtos\'">
                                <i class="bi bi-plus-circle-dotted"></i>
                                <p>Adicionar produto</p>
                            </li>
                        ';
                    }
                ?>

                <?php 
                    if($dados[0]['id']){
                        foreach($dados as $dadosProduto){
                            if(!empty($dadosProduto)){
                                echo '
                                    <li  onclick="window.location.href=\'../venda/index.php?id_produto='.htmlspecialchars($dadosProduto['id']).'&categoria='.htmlspecialchars($dadosProduto['categoria']).'\'">
                                        <img src="'.$dadosProduto['foto_1'].'" alt="">
                                        <div class="produtoInfos">
                                            <p>'.$dadosProduto['produto_nome'].'</p>
                                            <div class="controlePreco">
                                                
                                ';
                                            if($dadosProduto['valor_promocao'] > 0){
                                                echo '
                                                    <span>R$'.number_format($dadosProduto['preco'], 2, ",", ".").'</span>
                                                    <strong>R$'.number_format($dadosProduto['valor_promocao'], 2, ",", ".").'</strong>
                                                ';
                                            }else{
                                                echo '<strong>R$'.number_format($dadosProduto['preco'], 2, ",", ".").'</strong>';
                                            }
                                echo '
                                            </div>
                                            <p class="frete">Frete: <span
                                            '.($dadosProduto['frete'] > 0 ? '' : 'class="green"').'>
                                            '.($dadosProduto['frete'] > 0 ? 'R$'.number_format($dadosProduto['frete'], 2, ",", ".") : 'Grátis').'
                                            </span></p>
                                    '; 
                                    if($_SESSION['admin'] === 'sim' && $_SESSION['id'] === $dados[0]['id_vendedor'] && $_SESSION['nome'] === $dados[0]['nome_vendedor']){
                                        echo '
                                            <p>'.$dadosProduto['descricao'].'</p>
                                            <p class="categoria">Categoria: <span>'.$dadosProduto['categoria'].'</span></p>
                                            <button class="editarProduto" onclick="window.location.href=\'produtos/editarForm.php?id_produto='.$dadosProduto['id'].'\'">Editar Produto</button>
                                        ';
                                    }
                                echo '  
                                        </div>
                                    </li>
                                ';
                            }
                        }
                    }else{
                        echo '<h3>Este vendedor ainda não tem produtos</h3>';
                    }
                ?>
            </ul>
        </div>
    </section>
    
    <script>
        const buttons = document.querySelectorAll('.editarProduto')

        buttons.forEach((btn) => {
            btn.addEventListener('click', function(event){
                event.stopPropagation();
            })
        })

        const tel = document.querySelector('#telContato');

        if(tel.textContent != ''){
            tel.textContent = `(${tel.textContent.slice(0,2)}) ${tel.textContent.slice(2,7)}-${tel.textContent.slice(7)}`;
        }
    </script>
</body>
</html>