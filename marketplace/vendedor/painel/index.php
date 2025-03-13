<?php 
    session_start();
    if(!isset($_SESSION['admin'])){
        $_SESSION['admin'] = 'nao';
    }

    include_once"../../conexao.php";

    $sql = $conexao->prepare("SELECT * FROM vendedores WHERE id_vendedor = ?");
    $sql->bind_param('s', $_SESSION['id']);
    $sql->execute();
    $resultado = $sql->get_result();
    
    $dados = $resultado->fetch_assoc();

    if(empty($dados)){
        die("Vendedor não encontrado");
    }

    date_default_timezone_set('America/Sao_paulo');

    $abertura = !($dados['abertura'] == '00:00:00') ? $dados['abertura'] : '08:00:00';
    $fechamento = !($dados['fechamento']  == '00:00:00') ? $dados['fechamento'] : '16:00:00';    ;
    $horarioAtual = date('H:i:s');

    if($horarioAtual > $abertura && $horarioAtual < $fechamento){
        $status = 'Aberto';
    }else{
        $status = 'Fechado';
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <input type="file" name="bannerInput" id="bannerInput" class="image-input" accept="image/*" onchange="alterarImg(event, 'banner img')">
        <div id="banner">
            <?php 
                if(!empty($dados['banner'])){
                    echo '<img src="'.$dados['banner'].'" alt="">';
                }else{
                    echo '<img src="http://localhost/marketplace/fotosUsuarios/bannerPadrao.png" alt="">';
                }
            ?>
        </div>
        <section>
            <div id="userInfos">
                <input type="file" name="userImgInput" id="userImgInput" class="image-input" accept="image/*" onchange="alterarImg(event, 'userImg')">
                <img id="userImg" src="<?=$dados['foto']?>" alt="">
                <div id="text">
                    <input type="text" name="usename" value="<?=$dados['nome_vendedor']?>">
                    <p><?=$dados['vendas']?> Vendas | <?=$dados['itens_a_venda']?> itens à venda</p>
                </div>
            </div>
        </section>
    </div>

    <section>
        <div id="apresentacaoBox">
            <div id="apresentacao">
                <h3><?=$dados['nome_vendedor']?></h3>
                <input type="text" value="<?=$dados['apresentacao']?>">
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
                    <span id="telContato"><?=$dados['telefone_contato']?></span>
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
            </ul>
        </div>
    </section>

    <script>
        const banner = document.querySelector('#banner');
        const bannerInput = document.querySelector('#bannerInput');

        const userImg = document.querySelector('#userImg');
        const userInput = document.querySelector('#userImgInput');

        openFile(banner, bannerInput);
        openFile(userImg, userInput);

        function openFile(div, input){
            div.addEventListener('click', function(){
                input.click();
            })
        } 

        function alterarImg(event, input) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.querySelector('#'+input)
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>