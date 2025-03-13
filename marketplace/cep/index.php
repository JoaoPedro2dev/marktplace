<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <title>Buscar CEP</title>
</head>
<body>
    <input type="hidden" id="id_usuario" value="<?=$_SESSION['id']?>">
    <input type="hidden" id="admin_usuario" value="<?=$_SESSION['admin']?>">
    <div id="container">
        <form id="formCep">
            <h2>Consultar CEP</h2>
            <p>
                <label for="">Cep</label>
                <input type="text" id="cep">
            </p>
    
            <span id="error">Erro</span>
    
            <input type="submit" id="cepBtn" value="Verificar CEP">

            <div id="aContainer">
                <a href="../index.php">Cancelar</a>
                <a href="">Não sei meu CEP</a>
            </div>
        </form>
    
        <form id="cepInfos">
            <h2>Informações</h2>

            <p>
                <label for="">Estado</label>
                    <input type="text" value="" class="inputInfo" readonly>
            </p>

            <p>
                <label for="">Cidade</label>
                    <input type="text" value="" id="cidadeInput" class="inputInfo" readonly>
            </p>

            <span id="errorCidade">Infelizmente ainda não atendemos fora da cidade de Jaú</span>

            <p>
                <label for="">Bairro</label>
                    <input type="text" value="" class="inputInfo" readonly>
            </p>

            <p>
                <label for="">Rua</label>
                    <input type="text" value="" class="inputInfo" readonly>
            </p>

            <p>
                <label for="">Número</label>
                <input type="text" value="0" id="numero">
                <span id="errorNumero"></span>
            </p>

            <input type="submit" id="cadastrarBtn" value="Cadastrar endereco">
        </form>

        <div id="cadastroMsgm">
            <h3>Cadastro Concluido com sucesso 🥳</h3>
        </div>
    </div>
</body>
</html>