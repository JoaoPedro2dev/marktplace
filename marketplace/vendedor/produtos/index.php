<?php 
    session_start();

    if(!isset($_SESSION['admin']) || $_SESSION['admin'] !== 'sim'){
        die(header('location: ../../login/'));
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Roupas</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="container">
        <h2>Cadastro de Produtos</h2>
        <form id="formulario">
            <div class="infosContainer">
                <p>
                    <label for="nome">Nome do Produto:</label>
                    <input type="text" id="nome" name="nome" class="avisoErro">
                </p>
                
                <p>
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao" class="avisoErro"></textarea>
                </p>     

                <div class="group">
                    <p>     
                        <label for="categoria">Categoria:</label>
                        <select id="categoria" name="categoria">
                            <option value="roupas" selected>Roupas</option>
                            <option value="roupas_intimas">Roupas Íntimas</option>
                            <option value="colares">Colar</option>
                            <option value="aneis">Anéis</option>
                            <option value="oculos">Óculos</option>
                            <option value="relogios">Relógios</option>
                            <option value="pulseiras">Pulseiras</option>
                            <option value="bolsas">Bolsas</option>
                            <option value="calcados">Calçados</option>
                            <option value="roupas_infantis">Roupas Infantis</option>
                        </select>
                    </p>

                    <p>
                        <label for="genero">Gênero:</label>
                        <select id="genero" name="genero">
                            <option value="masculino">Masculino</option>
                            <option value="feminino">Feminino</option>
                            <option value="unissex">Unissex</option>
                        </select>
                    </p>
                </div>
                
                <p>
                    <label>Tamanhos Disponíveis:</label>
                    <div class="opcoes-container" id="tamanhos-container" class="avisoErro">
                        <div class="opcao"><input type="checkbox" name="tamanhos" value="Preto">Preto</div>
                        <div class="opcao"><input type="checkbox" name="tamanhos" value="Azul">Azul</div>
                        <div class="opcao"><input type="checkbox" name="tamanhos" value="Vermelho">Vermelho</div>
                    </div>
                </p>
                
                <p>
                    <label>Cores Disponíveis:</label>
                    <div class="opcoes-container" id="cores-container">
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Preto">Preto</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Azul">Azul</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Vermelho">Vermelho</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Branco">Branco</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Cinza">Cinza</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Verde">Verde</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Amarelo">Amarelo</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Rosa">Rosa</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Bege">Bege</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Laranja">Laranja</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Roxo">Roxo</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Marrom">Marrom</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Turquesa">Turquesa</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Ouro">Ouro</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Prata">Prata</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Coral">Coral</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Lilás">Lilás</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Azeite">Azeite</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Caramelo">Caramelo</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Menta">Menta</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Creme">Creme</div>
                        <div class="opcao" class="avisoErro"><input type="checkbox" name="cores" value="Esmeralda">Esmeralda</div>
                    </div>
                </p>             
                
                <div class="group">
                    <p>
                        <label for="valor">Valor do Produto (R$):</label>
                        <input type="number" id="valor" class="avisoErro" name="valor" step="0.01" min="0">
                    </p>
                    
                    <p>
                        <label for="condicao">Condição do Produto:</label>
                        <select id="condicao" name="condicao">
                            <option value="novo">Novo</option>
                            <option value="seminovo">Seminovo</option>
                            <option value="usado">Usado</option>
                        </select>
                    </p>
                </div>

                <div class="group">
                    <p>
                        <label for="frete">Valor do Frete (R$):</label>
                        <input type="number" id="frete" class="avisoErro" name="frete" step="0.01" min="0">
                    </p>    
                    
                    <p>
                        <label for="dataMaxima">prazo máximo de entrega (Dias):</label>
                        <input type="number" id="data" class="avisoErro" name="dataMaxima">
                    </p>
                </div>   
            </div>

            <div class="image-preview">
                <div class="imageContainer">
                    <p>imagem 1</p>
                    <input type="file" name="imagem-principal" id="imagem-principal" class="image-input" accept="image/*" onchange="previewImage(event, 'preview')">
                    <label for="imagem-principal"><img id="preview" class="imgAviso" src="imgPadrao.png" alt="Imagem Principal"></label>
                </div>
                
                <div class="imageContainer">
                    <p>imagem 2</p>
                    <input type="file" name="imagem-secundaria-1" id="imagem-secundaria-1" class="image-input" accept="image/*" onchange="previewImage(event, 'preview1')">
                    <label for="imagem-secundaria-1"><img id="preview1" class="imgAviso" src="imgPadrao.png" alt="Imagem Secundária 1"></label>
                </div>

                <div class="imageContainer">
                    <p>imagem 3</p>
                    <input type="file" name="imagem-secundaria-2" id="imagem-secundaria-2" class="image-input" accept="image/*" onchange="previewImage(event, 'preview2')">
                    <label for="imagem-secundaria-2"><img id="preview2" class="imgAviso" src="imgPadrao.png" alt="Imagem Secundária 2"></label>
                </div>
            </div>

            <span id="erroMsg">Erro</span>

            <div class="groupButton">
                <button type="button" onclick="window.location.href='../index?nome=<?=$_SESSION['url']?>'">Cancelar</button>
                <button type="submit">Cadastrar Produto</button>
            </div>
        </form>
    </div>

    <div id="cadastroAviso" class="hidden">
        <h3>Produto cadastrado</h3>
    </div>
</body>
</html>
