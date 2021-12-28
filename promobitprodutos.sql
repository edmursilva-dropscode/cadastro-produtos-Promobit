-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28-Dez-2021 às 13:14
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `promobitprodutos`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin_usuarios`
--

CREATE TABLE `tb_admin_usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_admin_usuarios`
--

INSERT INTO `tb_admin_usuarios` (`id`, `usuario`, `senha`, `img`, `nome`, `id_perfil`, `order_id`) VALUES
(8, 'contato@dropscode.com.br', 'admin', '612e69c3552e1.jpg', 'Drops.code', 1, 1),
(9, 'edmurgsjr@hotmail.com', 'admin', '612e677b7de10.jpg', 'Edmur G Silva Jr', 2, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_site_categorias`
--

CREATE TABLE `tb_site_categorias` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_site_categorias`
--

INSERT INTO `tb_site_categorias` (`id`, `descricao`, `order_id`) VALUES
(2, 'Cervejas', 3),
(3, 'Refrigerantes', 2),
(4, 'Energético', 4),
(5, 'Sucos', 5),
(6, 'Drinks', 6),
(7, 'Vinhos', 7),
(8, 'Chopes', 8),
(9, 'Porções', 9),
(10, 'Lanches', 10),
(11, 'Salgados', 11);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_site_perfis`
--

CREATE TABLE `tb_site_perfis` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_site_perfis`
--

INSERT INTO `tb_site_perfis` (`id`, `descricao`) VALUES
(1, 'Administrador'),
(2, 'Usuário');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_site_produtos`
--

CREATE TABLE `tb_site_produtos` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `preco` varchar(255) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_site_produtos`
--

INSERT INTO `tb_site_produtos` (`id`, `descricao`, `id_categoria`, `img`, `preco`, `order_id`) VALUES
(1, 'Original 600ml', 2, '612adca032b31.jpg', '12,60', 3),
(2, 'Brahma 600ml', 2, '612aeb93305a8.jpg', '10,50', 4),
(3, 'Coca-Cola 2L', 3, '612aed6eac763.jpg', '7,85', 1),
(5, 'Guaraná 2L', 3, '612afad56b6fb.jpg', '8,15', 2),
(6, 'X-Salada', 11, '61c5d1fa3506d.jpg', '159.0', 5),
(7, 'X-Bacon', 11, '612c188c4efb1.jpg', '16,40', 6),
(8, 'Volta ao Mundo', 10, '612c19e4f0c47.jpg', '50,30', 7),
(9, 'Sion K Etano', 10, '612c1d1b6a1e6.jpg', '60,45', 8),
(10, 'Copo com laranja', 5, '612c252bb7092.jpg', '7,50', 9),
(11, 'Copo com uva', 5, '612c25eb563fe.jpg', '6,50', 10),
(15, 'Copo com maçã', 5, '612c28ed18766.jpg', '7,40', 11);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_site_produtos_tags`
--

CREATE TABLE `tb_site_produtos_tags` (
  `id` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL,
  `data` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_site_produtos_tags`
--

INSERT INTO `tb_site_produtos_tags` (`id`, `id_produto`, `id_tag`, `data`) VALUES
(1, 3, 1, '24-12-21 10:32:35'),
(2, 5, 1, '24-12-21 10:33:02'),
(3, 6, 3, '24-12-21 10:54:27'),
(4, 7, 3, '24-12-21 10:55:15'),
(5, 2, 8, '24-12-21 10:55:26'),
(7, 1, 8, '24-12-21 14:06:43');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_site_tags`
--

CREATE TABLE `tb_site_tags` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_site_tags`
--

INSERT INTO `tb_site_tags` (`id`, `descricao`, `order_id`) VALUES
(1, 'Bebida sem álcool', 1),
(2, 'Bebida natural', 3),
(3, 'Comida com gordura', 4),
(8, 'Bebida com álcool', 2),
(9, 'Comida sem gordura', 5);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_admin_usuarios`
--
ALTER TABLE `tb_admin_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_site_categorias`
--
ALTER TABLE `tb_site_categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_site_perfis`
--
ALTER TABLE `tb_site_perfis`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_site_produtos`
--
ALTER TABLE `tb_site_produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_site_produtos_tags`
--
ALTER TABLE `tb_site_produtos_tags`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_site_tags`
--
ALTER TABLE `tb_site_tags`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_admin_usuarios`
--
ALTER TABLE `tb_admin_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `tb_site_categorias`
--
ALTER TABLE `tb_site_categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `tb_site_perfis`
--
ALTER TABLE `tb_site_perfis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tb_site_produtos`
--
ALTER TABLE `tb_site_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `tb_site_produtos_tags`
--
ALTER TABLE `tb_site_produtos_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tb_site_tags`
--
ALTER TABLE `tb_site_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
