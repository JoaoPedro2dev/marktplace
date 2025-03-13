-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 06/03/2025 às 00:20
-- Versão do servidor: 9.1.0
-- Versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ecommerce`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrinhos`
--

DROP TABLE IF EXISTS `carrinhos`;
CREATE TABLE IF NOT EXISTS `carrinhos` (
  `id_carrinho` int NOT NULL AUTO_INCREMENT,
  `id_produto` int NOT NULL,
  `id_usuario` int NOT NULL,
  `quantidade` int NOT NULL,
  PRIMARY KEY (`id_carrinho`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `carrinhos`
--

INSERT INTO `carrinhos` (`id_carrinho`, `id_produto`, `id_usuario`, `quantidade`) VALUES
(3, 20, 0, 1),
(4, 36, 0, 3),
(45, 36, 3, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
CREATE TABLE IF NOT EXISTS `comentarios` (
  `id_comentario` int NOT NULL AUTO_INCREMENT,
  `id_produto` int NOT NULL,
  `id_usuario` int NOT NULL,
  `likes` int NOT NULL,
  `usuarios_likes` int NOT NULL,
  `texto_comentario` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
  `data_comentario` date NOT NULL,
  PRIMARY KEY (`id_comentario`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `comentarios`
--

INSERT INTO `comentarios` (`id_comentario`, `id_produto`, `id_usuario`, `likes`, `usuarios_likes`, `texto_comentario`, `data_comentario`) VALUES
(1, 29, 1, 3123, 0, 'muito legal', '2025-02-19'),
(2, 29, 82, 202, 0, 'Ótima qualidade! O produto chegou bem embalado e dentro do prazo. Atendeu todas as minhas expectativas e é exatamente como descrito. Recomendo!', '2025-02-21'),
(3, 29, 87, 23, 0, 'Produto excelente', '2025-02-28');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id_pedido` int NOT NULL AUTO_INCREMENT,
  `ids_produtos` varchar(10000) COLLATE utf8mb4_general_ci NOT NULL,
  `id_usuario` int NOT NULL,
  `data_pedido` date NOT NULL,
  `horario_pedido` time NOT NULL,
  `data_entrega` date NOT NULL,
  `horario_entrega` time NOT NULL,
  `endereco_de_entrega` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
  `Forma_de_envio` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `forma_de_pagamento` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `quantidades` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  `condicao` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `total` double(10,2) NOT NULL,
  `pagamento` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_pedido`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `ids_produtos`, `id_usuario`, `data_pedido`, `horario_pedido`, `data_entrega`, `horario_entrega`, `endereco_de_entrega`, `Forma_de_envio`, `forma_de_pagamento`, `quantidades`, `condicao`, `total`, `pagamento`) VALUES
(39, '22', 46, '2025-01-07', '14:01:03', '0000-00-00', '00:00:00', 'Avenida Alberto Masiero, 1292, Jardim Maria Luiza IV, Jaú - SP, 17213250', 'entrega', 'cartao', '1', 'cancelado_usuar', 1.00, 'pendente'),
(40, '23', 46, '2025-01-07', '14:02:53', '0000-00-00', '00:00:00', 'Avenida Alberto Masiero, 22, Jardim Maria Luiza IV, Jaú - SP, 17213250', 'entrega', 'cartao', '2', 'para_entrega', 4.00, 'pendente'),
(41, '32', 46, '2025-01-07', '14:27:18', '0000-00-00', '00:00:00', 'buscou no local', 'buscar', 'cartao', '1', 'para_entrega', 3.00, 'pendente');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_vendedor` int NOT NULL,
  `produto_nome` varchar(180) COLLATE utf8mb4_general_ci NOT NULL,
  `categoria` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cores_disponiveis` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  `tamanhos_disponiveis` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `frete` double(10,2) NOT NULL,
  `quantidade_vendas` int NOT NULL,
  `data_inicio_promocao` date NOT NULL,
  `data_final_promocao` date NOT NULL,
  `valor_promocao` decimal(10,2) NOT NULL,
  `prazo_entrega` int NOT NULL,
  `foto_1` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `foto_2` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `foto_3` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `id_vendedor`, `produto_nome`, `categoria`, `cores_disponiveis`, `tamanhos_disponiveis`, `descricao`, `preco`, `frete`, `quantidade_vendas`, `data_inicio_promocao`, `data_final_promocao`, `valor_promocao`, `prazo_entrega`, `foto_1`, `foto_2`, `foto_3`) VALUES
(27, 1, '3', 'Feminino', '', '', '3', 3.00, 22.00, 0, '2025-02-22', '0000-00-00', 1.00, 0, 'http://localhost/marketplace/fotoProdutos/676af46218cf9.png', 'http://localhost/marketplace/fotoProdutos/676af46218cf9.png', 'http://localhost/marketplace/fotoProdutos/676af46218cf9.png'),
(28, 1, '1', 'Feminino', '', '', '1', 1.00, 22.00, 0, '0000-00-00', '0000-00-00', 0.00, 0, 'http://localhost/marketplace/fotoProdutos/676c5f80d6c22.png', 'http://localhost/marketplace/fotoProdutos/676c5f80d6c22.png', 'http://localhost/marketplace/fotoProdutos/676c5f80d6c22.png'),
(15, 3, 'b', 'Acessorio', '', '', 'bolo', 22.90, 0.00, 0, '2025-02-22', '0000-00-00', 0.00, 0, 'fotoProdutos/67686b54cde1e.png', '', ''),
(18, 1, 'bolo de café 1', 'Masculino', '', '', 'bolo de café recheado com chantily', 12.53, 22.00, 0, '2025-02-22', '0000-00-00', 0.00, 0, 'fotoProdutos/67686bb867d46.png', '', ''),
(19, 1, 'Pão', 'Feminino', '', '', 'pão de 500g', 5.44, 22.00, 0, '0000-00-00', '0000-00-00', 2.00, 0, 'fotoProdutos/67686c82a63fc.png', '', ''),
(20, 3, 'Doce', 'Masculino', '', '', 'doce', 12.00, 22.00, 0, '2025-02-22', '0000-00-00', 0.00, 0, 'fotoProdutos/67686cb3972b6.png', '', ''),
(21, 1, 'Coca-cola', 'Acessorio', '', '', 'coca-cola 300ml', 3.00, 22.00, 0, '2025-02-22', '0000-00-00', 0.00, 0, 'fotoProdutos/67686ce475859.jpg', '', ''),
(22, 1, 'item 1', 'Infantil', '', '', '1', 1.00, 22.00, 0, '0000-00-00', '0000-00-00', 0.99, 0, 'fotoProdutos/676c5f80d6c22.png', '', ''),
(23, 1, 'item 2', 'Infantil', '', '', 'Descrição', 2.00, 22.00, 0, '0000-00-00', '0000-00-00', 1.00, 0, 'fotoProdutos/676c5f8906cb6.jpg', '', ''),
(24, 3, '3', 'Feminino', '', '', '3', 3.00, 22.00, 0, '0000-00-00', '0000-00-00', 0.50, 0, 'fotoProdutos/676c5f90b42de.png', '', ''),
(25, 1, '1', 'Acessorio', '', '', '1', 1.00, 22.00, 0, '2025-02-22', '0000-00-00', 0.00, 0, 'fotoProdutos/676c5fc74adce.png', '', ''),
(26, 1, '2', 'Feminino', '', '', '2', 2.00, 22.00, 0, '0000-00-00', '0000-00-00', 1.00, 0, 'fotoProdutos/676c5fce52a9f.png', '', ''),
(14, 3, 'Bolo', 'Infantil', '', '', '1kg de Bolo', 24.90, 22.00, 0, '0000-00-00', '0000-00-00', 0.00, 0, 'fotoProdutos/676af46218cf9.png', '', ''),
(29, 2, '2', 'Masculino', '', '', '2', 2.00, 22.00, 0, '0000-00-00', '0000-00-00', 0.00, 0, 'fotoProdutos/676c5ff32bdb6.png', '', ''),
(30, 1, '1', 'Infantil', '', '', '1', 1.00, 22.00, 0, '0000-00-00', '0000-00-00', 0.00, 0, 'fotoProdutos/676c600f8ad8c.png', '', ''),
(31, 2, '2', 'Calcado', '', '', '2', 2.00, 22.00, 0, '0000-00-00', '0000-00-00', 0.00, 0, 'fotoProdutos/676c602c8db04.png', '', ''),
(32, 1, '3', 'Infantil', '', '', '3', 3.00, 22.00, 0, '0000-00-00', '0000-00-00', 0.00, 0, 'fotoProdutos/676c603b58e3c.jpg', '', ''),
(33, 1, '1', 'Acessorio', '', '', '1', 1.00, 22.00, 0, '0000-00-00', '0000-00-00', 0.00, 0, 'fotoProdutos/676c6045ef27d.jpg', '', ''),
(34, 1, '2', 'Feminino', '', '', '2', 2.00, 22.00, 0, '0000-00-00', '0000-00-00', 0.00, 0, 'fotoProdutos/676c604d2c16f.jpg', '', ''),
(35, 1, '3', 'Masculino', '', '', '3', 3.00, 22.00, 0, '0000-00-00', '0000-00-00', 0.00, 0, 'fotoProdutos/676c6054da1d6.png', '', ''),
(36, 1, 'Produto de teste', 'Calcado', 'Vermelho,Azul,Verde,Amarelo,Preto,Branco', 'M,G,X', 'produto de teste', 244.40, 0.00, 12, '2025-02-22', '0000-00-00', 22.00, 2, 'http://localhost/marketplace/fotoProdutos/foto1.jpg', 'http://localhost/marketplace/fotoProdutos/foto2.jpg', 'http://localhost/marketplace/fotoProdutos/foto3.jpg'),
(48, 3, 'teste senha', 'roupas', 'azul', 'G', 'dasdsad', 32.00, 33.00, 0, '0000-00-00', '0000-00-00', 0.00, 22, 'sem foto', 'sem foto', 'sem foto'),
(49, 3, 'cor de teste', 'roupas', 'Preto,Azul,Branco,Verde', 'G', 'cor de teste', 22.00, 33.00, 0, '0000-00-00', '0000-00-00', 0.00, 22, 'sem foto', 'sem foto', 'sem foto'),
(51, 3, 'teste de tamanhos disponiveis', 'roupas', 'Preto,Azul,Vermelho,Roxo,Coral', 'P,G,XG,XXG', 'teste de tamanhos disponiveis', 12.00, 33.00, 0, '0000-00-00', '0000-00-00', 0.00, 22, 'sem foto', 'sem foto', 'sem foto');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cpf` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `admin` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_general_ci NOT NULL,
  `endereco` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `bairro` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `cidade` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `UF` varchar(2) COLLATE utf8mb4_general_ci NOT NULL,
  `CEP` varchar(9) COLLATE utf8mb4_general_ci NOT NULL,
  `num_residencia` int NOT NULL,
  `senha` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `telefone` varchar(12) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome_usuario`, `cpf`, `admin`, `email`, `endereco`, `bairro`, `cidade`, `UF`, `CEP`, `num_residencia`, `senha`, `telefone`, `foto`) VALUES
(1, 'joão pedro1', '', 'Não', 'joaopedrodesenvolvedordes@gmail.com', 'rua, 843 - bairro, jau - SP, 00000000', 'bairro', 'jau', 'SP', '00000000', 843, '123', 'não informad', 'http://localhost/marketplace/fotosUsuarios/imgPadrao.png'),
(82, 'joão pedro2', '12345678901', 'não', 'exemplo2@gmail.com', '', '', '', '', '', 0, 'Zxcvbnm1!', '11987654322', 'http://localhost/marketplace/fotosUsuarios/imgPadrao.png'),
(87, 'joão pedro5', '12345678905', 'nao', 'joaopedrodesenvolvedordes5@gmail.com', 'Rua Hugo Pascolat, 196 - Jardim Santa Terezinha, Jaú - SP, 17205-310', 'Jardim Santa Terezinha', 'Jaú', 'SP', '17205-310', 196, '$2y$10$/OuEoLl572hUVFJuziGxK.WWuz3zYBSujOmskEdefuicx243abKd.', '11987654325', 'http://localhost/marketplace/fotosUsuarios/imgPadrao.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendedores`
--

DROP TABLE IF EXISTS `vendedores`;
CREATE TABLE IF NOT EXISTS `vendedores` (
  `id_vendedor` int NOT NULL AUTO_INCREMENT,
  `nome_vendedor` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nome_url` varchar(185) COLLATE utf8mb4_general_ci NOT NULL,
  `cpf` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `admin` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `telefone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telefone_contato` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `foto` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `banner` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `itens_a_venda` int NOT NULL,
  `vendas` int NOT NULL,
  `apresentacao` varchar(220) COLLATE utf8mb4_general_ci NOT NULL,
  `abertura` time NOT NULL,
  `fechamento` time NOT NULL,
  `final_semana` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_vendedor`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vendedores`
--

INSERT INTO `vendedores` (`id_vendedor`, `nome_vendedor`, `nome_url`, `cpf`, `admin`, `email`, `senha`, `telefone`, `telefone_contato`, `foto`, `banner`, `itens_a_venda`, `vendas`, `apresentacao`, `abertura`, `fechamento`, `final_semana`) VALUES
(1, 'João Pedro', 'joao_pedro', '12345678909', 'sim', 'email@gmail.com', '$2y$10$YDmtOU9R0FGUfHTRlc/QmekgcaJdtCoYnLMwaIlaVTiS4azdvEyYS', '11987654321', '', 'http://localhost/e-commerce/img/675086c2708f2.png', '', 1, 0, '', '00:00:00', '00:00:00', ''),
(2, 'roupas LTDA.', 'roupas_ltda', '12345678955', 'sim', 'roupasLTDA@gmail.com', '$2y$10$vJu4.qwNbZIBfStTK2P5a.ZeiYZdL2.ccl6lxYIFGQkfUPx5vkETe', '11987654355', '', 'http://localhost/marketplace/fotosUsuarios/imgPadrao.png', '', 0, 0, '', '00:00:00', '00:00:00', ''),
(3, 'conta comercial', 'conta_comercial', '12345678900', 'sim', 'contaComercial@gmail.com', '$2y$10$YDmtOU9R0FGUfHTRlc/QmekgcaJdtCoYnLMwaIlaVTiS4azdvEyYS', '11987654323', '14991202191', 'http://localhost/marketplace/fotosUsuarios/fotoPerfil.jpg', 'http://localhost/marketplace/fotosUsuarios/banner.jpg', 4, 5, 'Aqui, cada detalhe é pensado para trazer mais sabor ao seu dia. Oferecemos uma variedade de produtos frescos e deliciosos, preparados com ingredientes selecionados e muito carinho. Seja para um café da manhã especial ou ', '12:00:00', '22:00:00', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
