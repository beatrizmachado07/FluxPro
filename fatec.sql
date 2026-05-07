-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07/05/2026 às 13:58
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `fatec`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoa`
--

CREATE TABLE `pessoa` (
  `pesCodigo` int(11) NOT NULL,
  `pesNome` varchar(150) DEFAULT NULL,
  `pesTipo` char(1) DEFAULT 'F',
  `pesDocumento` char(14) DEFAULT NULL,
  `pesCEP` char(8) DEFAULT NULL,
  `pesRua` varchar(100) DEFAULT NULL,
  `pesNumero` int(11) DEFAULT NULL,
  `pesComplemento` varchar(50) DEFAULT NULL,
  `pesBairro` varchar(150) DEFAULT NULL,
  `pesCidade` varchar(150) DEFAULT NULL,
  `pesUF` char(2) DEFAULT NULL,
  `pesCliente` char(1) DEFAULT NULL,
  `pesFornecedor` char(1) DEFAULT NULL,
  `pesFunc` char(1) DEFAULT NULL,
  `pesTransp` char(1) DEFAULT NULL,
  `pesTelefone` varchar(20) DEFAULT NULL,
  `codUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pessoa`
--

INSERT INTO `pessoa` (`pesCodigo`, `pesNome`, `pesTipo`, `pesDocumento`, `pesCEP`, `pesRua`, `pesNumero`, `pesComplemento`, `pesBairro`, `pesCidade`, `pesUF`, `pesCliente`, `pesFornecedor`, `pesFunc`, `pesTransp`, `pesTelefone`, `codUsuario`) VALUES
(1, 'Beatriz', 'F', '123456789105', '13474700', 'Rua dos Ideais', 321, 'casa', 'Jardim da paz', 'Americana', 'SP', 'S', 'x', NULL, NULL, '19981587477', NULL),
(2, 'Isabella', 'F', '123456789101', '13474700', 'Analândia', 152, 'casa', 'São Joaquim', 'SBO', 'SP', NULL, 'x', NULL, NULL, '19981587464', NULL),
(11, NULL, 'F', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL),
(12, NULL, 'F', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL),
(13, NULL, 'F', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL),
(14, NULL, 'F', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', NULL, NULL, NULL, NULL, NULL),
(17, 'Zoe', 'F', '46551680801', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '19981587462', NULL),
(19, 'Andreia', 'F', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6666', NULL),
(20, 'Beatriz', 'F', '12345678999', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1234567899', NULL),
(21, 'Andreia', 'F', '12345678999', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1234567899', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `proCodigo` int(11) NOT NULL,
  `proDescricao` varchar(100) DEFAULT NULL,
  `proQuantidade` decimal(15,2) DEFAULT NULL,
  `proValor` decimal(15,2) DEFAULT NULL,
  `proSetor` int(11) DEFAULT NULL,
  `proStatus` char(1) DEFAULT NULL,
  `codUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`proCodigo`, `proDescricao`, `proQuantidade`, `proValor`, `proSetor`, `proStatus`, `codUsuario`) VALUES
(2, 'Coca', 1.00, 20.00, 1, 'I', NULL),
(3, 'Fanta', 3.00, 16.00, 555, 'A', NULL),
(5, 'Coca', 33.00, 55.00, 6, 'A', 46),
(6, 'Coca', 6.00, 5.00, 8, 'A', 47);

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos`
--

CREATE TABLE `servicos` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `descricao` text NOT NULL,
  `codUsuario` int(11) NOT NULL,
  `serStatus` char(1) NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `servicos`
--

INSERT INTO `servicos` (`codigo`, `nome`, `preco`, `descricao`, `codUsuario`, `serStatus`) VALUES
(1, 'Osvaldo', 5.00, 'Tecnologo', 1, ''),
(2, 'Jardineiro', 7.00, 'Plantação', 1, 'A'),
(3, 'Beatriz ', 5.00, 'Tecnologo', 1, 'A'),
(4, 'Jardineiro', 2000.00, 'Plantação', 1, 'A'),
(5, 'Analista', 10.00, 'Tecnologo', 1, 'A'),
(6, 'Analista', 6566.00, 'Tecnologo', 49, 'A');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `usuCodigo` int(11) NOT NULL,
  `usuEmail` varchar(80) DEFAULT NULL,
  `usuSenha` varchar(64) DEFAULT NULL,
  `usuNome` varchar(100) DEFAULT NULL,
  `usuCPF` varchar(14) DEFAULT NULL,
  `usuTelefone` varchar(20) DEFAULT NULL,
  `usuStatus` char(1) DEFAULT NULL,
  `usuCEP` varchar(10) DEFAULT NULL,
  `usuRua` varchar(100) DEFAULT NULL,
  `usuBairro` varchar(100) DEFAULT NULL,
  `usuCidade` varchar(100) DEFAULT NULL,
  `usuEstado` varchar(2) DEFAULT NULL,
  `usuNumero` varchar(10) DEFAULT NULL,
  `usuTipoResidencia` varchar(30) DEFAULT NULL,
  `usuBloco` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`usuCodigo`, `usuEmail`, `usuSenha`, `usuNome`, `usuCPF`, `usuTelefone`, `usuStatus`, `usuCEP`, `usuRua`, `usuBairro`, `usuCidade`, `usuEstado`, `usuNumero`, `usuTipoResidencia`, `usuBloco`) VALUES
(1, '@exemplo.com', '$2y$10$icI6RbFPYvzQOqTBjpC8hOordD9X27uFOp3ut50R2C6tQSJD7B6Gi', NULL, NULL, NULL, 'A', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '@exemplo.com', '$2y$10$0FkbLRRHjsyE.qzz50SAK.7DFRMnNpuomkrMZP9kh.YE8yJV94ld.', NULL, NULL, NULL, 'A', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '@exemplo.com', '$2y$10$CpmRSxQJw3iZszE4p7H8O.D9oelgruWkpq7HqnyIkcJMja86o9k9G', NULL, NULL, NULL, 'A', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '@exemplo.com', '$2y$10$1w9JShZPOtf9on37aybCY.m3XglGPsLkgxISgXa.4VxqdfNfLM0wy', NULL, NULL, NULL, 'A', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, NULL, '$2y$10$U5yPzjgo0in5O.YDvUqa/OzBnheB//yygCgoqLqI6GnIsb0ZbNfTu', 'Hélio', '123.415.218-55', '1235678912', NULL, '13420-264', 'Rua João Batista Campos Pinto', 'Jardim Abaeté', 'Piracicaba', 'SP', '123', 'Casa', '3 apto 01'),
(51, NULL, '$2y$10$Cn3Ns1Hig70JA95oAnWlWu1qp.KBB//FXuJgcBa0lx8HcPvE8WHZC', 'Antonia', '123.415.218', '1235678912', NULL, '13470-488', 'Rua dos Ideais', 'Jardim Paz', 'Americana', 'SP', '123', 'Casa', '');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `pessoa`
--
ALTER TABLE `pessoa`
  ADD PRIMARY KEY (`pesCodigo`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`proCodigo`);

--
-- Índices de tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_servicos_usuario` (`codUsuario`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuCodigo`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `pessoa`
--
ALTER TABLE `pessoa`
  MODIFY `pesCodigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `proCodigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuCodigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `servicos`
--
ALTER TABLE `servicos`
  ADD CONSTRAINT `fk_servicos_usuario` FOREIGN KEY (`codUsuario`) REFERENCES `usuario` (`usuCodigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `servicos_ibfk_1` FOREIGN KEY (`codUsuario`) REFERENCES `usuario` (`usuCodigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
