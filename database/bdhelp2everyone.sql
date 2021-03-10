-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 12-Mar-2019 às 14:43
-- Versão do servidor: 10.1.36-MariaDB
-- versão do PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bdhelp2everyone`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbladmin`
--

CREATE TABLE `tbladmin` (
  `Id` int(11) NOT NULL,
  `Foto` varchar(200) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Apelido` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Telemovel` int(12) NOT NULL,
  `CodPostal` varchar(8) NOT NULL,
  `Pais` varchar(70) NOT NULL,
  `Distrito` varchar(50) NOT NULL,
  `Morada` varchar(300) NOT NULL,
  `Concelho` varchar(50) NOT NULL,
  `Password` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tbladmin`
--

INSERT INTO `tbladmin` (`Id`, `Foto`, `Nome`, `Apelido`, `Email`, `Telemovel`, `CodPostal`, `Pais`, `Distrito`, `Morada`, `Concelho`, `Password`) VALUES
(5, 'Admin1550183974.jpg', 'GonÃ§alo', ' Silva', 'admin@gmail.com', 939865201, '3670-000', 'Portugal', 'Viseu', 'Carvalhais', 'S. Pedro do Sul', 'b20b0f63ce2ed361e8845d6bf2e59811aaa06ec96bcdb92f9bc0c5a25e83c9a6');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbladminnoticiacomentario`
--

CREATE TABLE `tbladminnoticiacomentario` (
  `Id` int(11) NOT NULL,
  `IdAdmin` int(11) NOT NULL,
  `IdComentario` int(11) NOT NULL,
  `Descricao` varchar(500) NOT NULL,
  `DataHora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tbladminnoticiacomentario`
--

INSERT INTO `tbladminnoticiacomentario` (`Id`, `IdAdmin`, `IdComentario`, `Descricao`, `DataHora`) VALUES
(5, 5, 11, 'obrigado', '2019-02-15 22:07:00'),
(6, 5, 15, 'Obrigado pela opiniao', '2019-03-01 18:42:00'),
(7, 5, 14, 'Obrigado pela sua opinÃ£o e talvez tambÃ©m queira ver as nossas vÃ¡rias notÃ­cias para aprender mais um pouco do nosso site', '2019-03-10 20:49:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblareaatuacao`
--

CREATE TABLE `tblareaatuacao` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `IdOrganizacao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tblareaatuacao`
--

INSERT INTO `tblareaatuacao` (`Id`, `Nome`, `IdOrganizacao`) VALUES
(1, 'Ambiente', 7),
(11, 'Cidadania e Direitos', 7),
(12, 'Cidadania e Direitos', 9),
(21, 'Cultura e Artes', 9),
(22, 'Solidariedade Social', 9),
(23, 'EducaÃ§Ã£o', 9),
(24, 'SaÃºde', 9),
(25, 'Ambiente', 10),
(26, 'Cidadania e Direitos', 10),
(27, 'Ambiente', 14),
(28, 'Cultura e Artes', 14),
(29, 'EducaÃ§Ã£o', 14);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblareaatucaoevento`
--

CREATE TABLE `tblareaatucaoevento` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `IdEvento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tblareaatucaoevento`
--

INSERT INTO `tblareaatucaoevento` (`Id`, `Nome`, `IdEvento`) VALUES
(1, 'Ambiente', 7),
(2, 'Ambiente', 19),
(3, 'Ambiente', 21),
(4, 'Cidadania e Direitos', 21),
(5, 'Solidariedade Social', 21),
(6, 'Ambiente', 22),
(7, 'Cultura e Artes', 22),
(8, 'Cidadania e Direitos', 23),
(9, 'Cultura e Artes', 23),
(10, 'Novas Tecnologias', 23),
(11, 'Solidariedade Social', 23),
(12, 'Ambiente', 24),
(13, 'Cidadania e Direitos', 24),
(14, 'EducaÃ§Ã£o', 24);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblcontato`
--

CREATE TABLE `tblcontato` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `Mensagem` varchar(1000) NOT NULL,
  `DataHora` datetime NOT NULL,
  `Vista` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tblcontato`
--

INSERT INTO `tblcontato` (`Id`, `Nome`, `Email`, `Mensagem`, `DataHora`, `Vista`) VALUES
(1, 'GonÃ§alo Silva', 'Here4you@gmail.com', 'Gostei muito do site, o meu preferido na area\r\n\r\n', '2019-02-05 09:00:00', 1),
(2, 'Ruben MendonÃ§a', 'rub20@gmail.com', 'Gostei do Site e desejava doar para a causa, onde Ã© que posso realizar essa aÃ§Ã£o?', '2019-02-05 20:06:00', 1),
(3, 'Francisco Almeida', 'FRA@gmail.com', 'O Site estÃ¡ intuitivo e fÃ¡cil de usar, continuem com o bom Trabalho :)', '2019-02-05 20:10:00', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblevento`
--

CREATE TABLE `tblevento` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `FotoLocal` varchar(100) NOT NULL,
  `Pais` varchar(100) NOT NULL,
  `Morada` varchar(200) NOT NULL,
  `CodPostal` varchar(8) NOT NULL,
  `Distrito` varchar(50) NOT NULL,
  `Concelho` varchar(50) NOT NULL,
  `Freguesia` varchar(50) NOT NULL,
  `FuncaoVoluntario` varchar(500) NOT NULL,
  `BreveDesc` varchar(90) NOT NULL,
  `Descricao` varchar(1000) NOT NULL,
  `NumVagas` int(11) NOT NULL,
  `DataInicio` date NOT NULL,
  `DataTermino` date NOT NULL,
  `Duracao` int(11) NOT NULL,
  `Idioma` varchar(70) NOT NULL,
  `Compromisso` varchar(15) NOT NULL,
  `GrupoAlvo` varchar(50) NOT NULL,
  `Quant_Helps` int(11) NOT NULL,
  `IdOrganizacao` int(11) NOT NULL,
  `Inativo` int(11) NOT NULL,
  `Reconhecido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tblevento`
--

INSERT INTO `tblevento` (`Id`, `Nome`, `FotoLocal`, `Pais`, `Morada`, `CodPostal`, `Distrito`, `Concelho`, `Freguesia`, `FuncaoVoluntario`, `BreveDesc`, `Descricao`, `NumVagas`, `DataInicio`, `DataTermino`, `Duracao`, `Idioma`, `Compromisso`, `GrupoAlvo`, `Quant_Helps`, `IdOrganizacao`, `Inativo`, `Reconhecido`) VALUES
(5, 'Ajudar Pessoas', 'default.png', 'Portugal', 'Rua Travessa de Baixo', '3800-000', 'Viseu', 'Oliveira de Frades', 'Pinheiro de Lafoes', 'Encorajar pessoas desmotivadas com a sociedade', 'Ajudar Pessoas lorem ipsum', 'Saude para todas as pessoas acompanhar lorem ipsum', 20, '2019-02-03', '2019-03-04', 48, 'Portugues', 'Regular', 'Jovens', 140, 7, 0, 1),
(7, 'Assitencia', 'default.png', 'Portugal', 'Rua Travessa de Cima', '3600-000', 'Aveiro', 'Agueda', 'Aguada de Cima', 'Prover boleia', 'Prover boleia para jovens necessitados', 'Prover boleia para jovens necessitados, desde a Rua da Travessa, para o destino, cerca de 10km de distancia', 10, '2019-01-28', '2019-01-30', 24, 'Portugues', 'Regular', 'Jovens', 180, 7, 0, 1),
(19, 'Help people', 'selfie.jpg', 'Portugal', 'Carvalhais, rua da travessa', '3680-000', 'Viseu', 'S.Pedro do Sul', 'Carvalhais', 'assist old people who need help', 'Help old people who need someone to talk to', 'Help old people who need someone to talk to', 5, '2019-02-11', '2019-02-13', 52, 'InglÃªs', 'Regular', 'Idosos', 200, 7, 0, 1),
(20, 'Acompanhar Idosos', '91550567983.png', 'Portugal', 'Rua Da Costa de Cima', '3600-000', 'Viseu', 'Oliveira de Frades', 'Pinheiro de Lafoes', 'Os voluntarios precisam de ajudar a acompanhar pessoas Idosas, na sua saida do lar', 'Os Voluntarios precisam de saber cuidar de Idosos e gostar deles', 'Os Voluntarios precisam de saber cuidar de Idosos e gostar deles, para andarem com eles na carrinha', 3, '2019-03-03', '2019-03-04', 24, 'Portugues', 'Regular', 'Idosos', 200, 9, 0, 0),
(21, 'Equipa apoio de rua', '91551744812.jpg', 'Portugal', 'Rua Manuel de Freitas', '3700-000', 'Viseu', 'S.Pedro do Sul', 'Carvalhais', 'Apoiar Ã  realizaÃ§Ã£o de uma equipa de rua ', 'Motivar pessoas em depressÃ£o, que vivem nas ruas', 'Ajudar a iniciar uma equipa de rua, cuja a funÃ§Ã£o Ã© motivar as pessoas com depressÃ£o e outros problemas a recuperar a forÃ§a e sair das ruas', 5, '2019-03-10', '2019-03-16', 20, 'PortuguÃªs', 'Regular', 'Adultos', 170, 9, 0, 0),
(22, 'Precisa-se de voluntÃ¡rios', '91551745532.jpg', 'Portugal', 'Rua da Travessa', '3700-000', 'Viseu', 'S.Pedro do Sul', 'Carvalhais', 'Plantar vÃ¡rias plantas autÃ³ctones', 'Plantar vÃ¡rios tipos de plantas/Ã¡rvores autÃ³ctones', 'Devido aos incÃªndios na regiÃ£o, irÃ¡ ser realizado um evento para plantar vÃ¡rias espÃ©cies de plantas da RegiÃ£o.\r\nVem e adere!!!\r\nEsperamos por ti!!!', 20, '2019-03-16', '2019-03-17', 14, 'PortuguÃªs', 'Regular', 'Jovens', 119, 9, 0, 0),
(23, 'Professor de MultimÃ©dia', '101551746696.jpg', 'Portugal', 'Rua Manuel de Freitas', '3700-000', 'Viseu', 'Oliveira de Frades', 'Remolha', 'Ensinar a alunos carenciados', 'O voluntÃ¡rio terÃ¡ de ensinar os bÃ¡sicos da MultimÃ©dia aos alunos', 'Como se diz, &quot;uma imagem pode valer mais de mil palavras&quot;, por isso, o voluntÃ¡rio terÃ¡ de ensinar a alunos carenciados os bÃ¡sicos da multimÃ©dia, como editar fotos e fazer cartazes.', 1, '2019-03-18', '2019-03-22', 35, 'PortuguÃªs', 'Regular', 'Jovens', 298, 10, 0, 1),
(24, 'Ajudar na Limpeza', '141552091787.jpg', 'Portugal', 'Rua da liberdade', '1000-000', 'Lisboa', 'Amadora', 'Carnaxide', 'Ajudar na limpeza das ruas', 'Como tÃªm constatado as ruas da cidade andam bastante sujas', 'Como tÃªm constatado as ruas da cidade andam bastante sujas, por isso decidimos, em parceria com a cÃ¢mara e outras OrganizaÃ§Ãµes, criar um evento para ajudar a limpar as ruas, sendo que este trabalho vai ajudar principalmente os Jovens que se querem deslocar todos os dias para a escola', 15, '2019-03-18', '2019-03-20', 10, 'PortuguÃªs', 'Regular', 'Jovens', 85, 14, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbleventocomentario`
--

CREATE TABLE `tbleventocomentario` (
  `Id` int(11) NOT NULL,
  `IdVoluntario` int(11) NOT NULL,
  `IdEvento` int(11) NOT NULL,
  `Descricao` varchar(500) NOT NULL,
  `DataHora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tbleventocomentario`
--

INSERT INTO `tbleventocomentario` (`Id`, `IdVoluntario`, `IdEvento`, `Descricao`, `DataHora`) VALUES
(1, 11, 7, 'Ja trabalhaei com a empresa e organizaram bem o evento', '2019-01-29 14:15:16'),
(3, 11, 7, 'Gosteii', '2019-01-29 00:00:00'),
(7, 11, 7, 'nao prestas', '2019-01-30 15:14:00'),
(8, 11, 7, 'amo\r\n', '2019-01-30 15:22:00'),
(10, 11, 5, 'gosto do evento\r\n', '2019-01-31 22:27:00'),
(11, 11, 19, 'gostei do evento', '2019-02-03 21:16:00'),
(12, 12, 19, 'Aderi ao evento', '2019-02-13 10:17:00'),
(13, 11, 20, 'r3refdfd', '2019-02-22 14:43:00'),
(14, 14, 20, 'Ã‰ preciso levar alguma coisa?', '2019-03-01 18:28:00'),
(15, 17, 23, 'Pessoas fantÃ¡sticas e evento espetacular, recomendo!!!', '2019-03-07 21:01:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbleventorating`
--

CREATE TABLE `tbleventorating` (
  `Id` int(11) NOT NULL,
  `IdVoluntario` int(11) NOT NULL,
  `IdEvento` int(11) NOT NULL,
  `Rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tbleventorating`
--

INSERT INTO `tbleventorating` (`Id`, `IdVoluntario`, `IdEvento`, `Rating`) VALUES
(5, 11, 7, 5),
(10, 11, 5, 5),
(11, 11, 19, 5),
(44, 14, 5, 5),
(45, 11, 20, 5),
(48, 14, 20, 3),
(49, 17, 23, 5),
(50, 17, 24, 5),
(51, 14, 24, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblgostocomentario`
--

CREATE TABLE `tblgostocomentario` (
  `Id` int(11) NOT NULL,
  `IdComentario` int(11) NOT NULL,
  `IdVoluntario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tblgostocomentario`
--

INSERT INTO `tblgostocomentario` (`Id`, `IdComentario`, `IdVoluntario`) VALUES
(1, 1, 11),
(3, 3, 11),
(5, 7, 11),
(7, 10, 11),
(8, 11, 11),
(9, 8, 11),
(10, 12, 12),
(11, 13, 11),
(16, 14, 14),
(17, 13, 14),
(18, 13, 13),
(19, 15, 17);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblgostoorgcomentario`
--

CREATE TABLE `tblgostoorgcomentario` (
  `Id` int(11) NOT NULL,
  `IdOrgComentario` int(11) NOT NULL,
  `IdVoluntario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tblgostoorgcomentario`
--

INSERT INTO `tblgostoorgcomentario` (`Id`, `IdOrgComentario`, `IdVoluntario`) VALUES
(1, 1, 14),
(2, 2, 17);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbllogs`
--

CREATE TABLE `tbllogs` (
  `Id` int(11) NOT NULL,
  `Id_Admin` int(11) NOT NULL,
  `DataHora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tbllogs`
--

INSERT INTO `tbllogs` (`Id`, `Id_Admin`, `DataHora`) VALUES
(1, 1, '2019-02-07 00:01:00'),
(2, 1, '2019-02-07 00:44:00'),
(3, 1, '2019-02-07 13:33:00'),
(4, 1, '2019-02-15 09:10:00'),
(5, 1, '2019-02-15 13:51:00'),
(6, 5, '2019-02-15 14:00:00'),
(7, 5, '2019-02-15 20:05:00'),
(8, 1, '2019-02-16 22:09:00'),
(9, 1, '2019-02-18 09:56:00'),
(10, 5, '2019-02-21 13:48:00'),
(11, 5, '2019-02-21 13:52:00'),
(12, 5, '2019-02-21 22:05:00'),
(13, 5, '2019-02-21 22:42:00'),
(14, 5, '2019-02-22 14:37:00'),
(15, 5, '2019-02-26 13:48:00'),
(16, 5, '2019-02-27 09:12:00'),
(17, 5, '2019-02-27 13:02:00'),
(18, 5, '2019-02-27 13:29:00'),
(19, 5, '2019-02-27 15:14:00'),
(20, 5, '2019-02-28 11:40:00'),
(21, 5, '2019-02-28 14:32:00'),
(22, 5, '2019-02-28 16:20:00'),
(23, 5, '2019-02-28 17:28:00'),
(24, 5, '2019-02-28 17:38:00'),
(25, 5, '2019-02-28 22:22:00'),
(26, 5, '2019-03-01 18:36:00'),
(27, 5, '2019-03-01 21:26:00'),
(28, 5, '2019-03-03 22:59:00'),
(29, 5, '2019-03-08 23:56:00'),
(30, 5, '2019-03-09 12:23:00'),
(31, 5, '2019-03-09 15:08:00'),
(32, 5, '2019-03-09 15:22:00'),
(33, 5, '2019-03-10 11:03:00'),
(34, 5, '2019-03-10 12:14:00'),
(35, 5, '2019-03-10 12:44:00'),
(36, 5, '2019-03-10 20:20:00'),
(37, 5, '2019-03-12 11:59:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblnoticias`
--

CREATE TABLE `tblnoticias` (
  `Id` int(11) NOT NULL,
  `Titulo` varchar(60) NOT NULL,
  `Data` date NOT NULL,
  `BreveDesc` varchar(110) NOT NULL,
  `Descricao` varchar(3000) NOT NULL,
  `Subtitulo` varchar(100) NOT NULL,
  `DescricaoSubtitulo` varchar(1500) NOT NULL,
  `Foto` varchar(100) NOT NULL,
  `Foto_extra` varchar(100) NOT NULL,
  `Foto_extra_extra` varchar(100) NOT NULL,
  `Facebook` varchar(300) NOT NULL,
  `Instagram` varchar(300) NOT NULL,
  `Twitter` varchar(300) NOT NULL,
  `Linkedin` varchar(300) NOT NULL,
  `Tags` varchar(100) NOT NULL,
  `Categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tblnoticias`
--

INSERT INTO `tblnoticias` (`Id`, `Titulo`, `Data`, `BreveDesc`, `Descricao`, `Subtitulo`, `DescricaoSubtitulo`, `Foto`, `Foto_extra`, `Foto_extra_extra`, `Facebook`, `Instagram`, `Twitter`, `Linkedin`, `Tags`, `Categoria`) VALUES
(1, 'H2E lidera no ranking de empresas sem fins lucrativos', '2019-02-01', 'O nosso website e o apoio dos voluntarios tornou o premio possivel', 'O nosso website, H2E permitiu e a ajuda dos nossos voluntarios permitiu este premios', 'Uma maior ajuda', 'A H2E tornou-se o maior site mundial para a ajuda de voluntarios e so conseguiria ter sido possivel pelos nossos voluntarios que se esforcam bastante para tornar este sonho realidade', '111550243100.jpg', '121550243100.jpg', '131550243100.jpg', 'https://www.facebook.com/', 'https://www.instagram.com/', 'https://twitter.com/', 'https://pt.linkedin.com/', 'Educacao, Ajuda, Apoio', 1),
(2, 'Voluntarios do H2E ajudam pessoas necessitadas a recuperarem', '2019-01-31', 'Os Voluntarios do H2E ajudaram pessoas', 'Os nossos voluntarios ajudaram pessoas fragilizadas a recuperarem', 'O maior website de ajuda', 'A H2E tornou-se o maior site mundial para a ajuda de voluntarios e so conseguiria ter sido possivel pelos nossos voluntarios que se esforcam bastante para tornar este sonho realidade', 'Foto2.png', 'Foto5.jpg', 'Foto7.jpg', 'https://www.facebook.com/', 'https://www.instagram.com/', 'https://twitter.com/', 'https://pt.linkedin.com/', 'Educação, Ajuda, Apoio', 2),
(3, 'NÃºmero de VoluntÃ¡rios triplica', '2019-03-10', 'O nÃºmero de VolunÃ¡rios associados ao site Help2Everyone triplica', '   Ã‰ com muito prazer que anunciamos que o nÃºmero de voluntÃ¡rios associados ao nosso site triplicou, assim com mais VoluntÃ¡rios dispostos, conseguimos apoiar mais eventos que nunca!!!\r\n   Toda a equipa de administraÃ§Ã£o do site desejavos parabÃ©ns pelo vosso trabalho, esforÃ§o e motivaÃ§Ã£o exemplar.', 'Mas PorquÃª?', '   De acordo com as nossas estatÃ­sticas, a preferÃªncia pela nossa plataforma Ã© evidente.\r\n   Com um layout intuitivo e simples de usar, muitos VoluntÃ¡rios atÃ© dizem que muitas vezes o que lhes motiva a participar num evento, Ã© a forma como ele Ã© apresentado.', '011552220562.jpg', '021552220562.jpg', '031552220562.jpg', 'https://www.facebook.com/', 'https://www.instagram.com/', 'https://twitter.com/', 'https://pt.linkedin.com/', 'VoluntÃ¡rios, Apoio, Bem-estar', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblorganizacao`
--

CREATE TABLE `tblorganizacao` (
  `Id` int(11) NOT NULL,
  `Foto` varchar(100) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Telefone` varchar(12) NOT NULL,
  `Website` varchar(200) NOT NULL,
  `DataFundacao` date NOT NULL,
  `PagFacebook` varchar(200) NOT NULL,
  `PagInstagram` varchar(200) NOT NULL,
  `PagTwitter` varchar(200) NOT NULL,
  `Missao` varchar(500) NOT NULL,
  `Info` text NOT NULL,
  `Morada` varchar(200) NOT NULL,
  `CodPostal` varchar(8) NOT NULL,
  `Distrito` varchar(50) NOT NULL,
  `Concelho` varchar(50) NOT NULL,
  `Pais` varchar(100) NOT NULL,
  `Freguesia` varchar(50) NOT NULL,
  `DataReg` date NOT NULL,
  `Password` varchar(300) NOT NULL,
  `Aprovada` int(11) NOT NULL,
  `Comprovativo` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tblorganizacao`
--

INSERT INTO `tblorganizacao` (`Id`, `Foto`, `Nome`, `Email`, `Telefone`, `Website`, `DataFundacao`, `PagFacebook`, `PagInstagram`, `PagTwitter`, `Missao`, `Info`, `Morada`, `CodPostal`, `Distrito`, `Concelho`, `Pais`, `Freguesia`, `DataReg`, `Password`, `Aprovada`, `Comprovativo`) VALUES
(7, 'GLS1549030480.png', 'GLS', 'goncalo.silva@gmail.com', '232765984', 'https://www.google.pt/', '2000-01-01', 'https://www.facebook.com/', 'https://www.instagram.com/?hl=pt', 'https://twitter.com/', 'textotextoex totextotexto textotextoext otextotextotextotextoextotextotextot extotextoexto textotextote totextoextotextotextot extotextoexto textotextote xtotextoextotextotextotextotextoextotextotexto', 'ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola\r\nola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola\r\nola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola\r\nola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola ola', 'Rua Costa de Baixo', '3800-000', 'Viseu', 'Oliveira de Frades', 'Portugal', 'Pinheiro de Lafoes', '2019-01-08', 'f60023ff30681bb36a42ca5ad9cbeab268dc65a90a8551f81f5b300176f9b223', 1, ''),
(9, '91550357776.png', 'Cps Carvalhais', 'cps@gmail.com', '2328659475', 'http://epc.epcarvalhais.org/', '1990-01-01', 'https://www.facebook.com/', 'https://www.instagram.com/?hl=pt', 'https://twitter.com/', 'Unir as pessoas para formar um mundo melhora', 'Estamos Ã¡ 25 anos a servir a comunidade, junta-te a nÃ³s', 'Rua Padre JosÃ© Rodrigues de Barro', '3600-000', 'Viseu', 'S. Pedro do Sul', 'Portugal', 'Carvalhais', '2019-02-16', '86e9c492e544e4e80d9faf672beb29158015fa53687e79bc34a7efb9343bc89e', 1, ''),
(10, '101550756346.png', 'Escola Profissional de Carvalhais', 'epc@gmail.com', '2328659475', 'http://epc.epcarvalhais.org/', '1999-01-01', 'https://www.facebook.com/', 'https://www.instagram.com/?hl=pt', 'https://twitter.com/', 'O Lorem Ipsum Ã© um texto modelo da indÃºstria tipogrÃ¡fica e de impressÃ£o. O Lorem Ipsum tem vindo a ser o texto padrÃ£o usado por estas indÃºstrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espÃ©cime de livro. Este texto nÃ£o sÃ³ sobreviveu 5 sÃ©culos, mas tambÃ©m o salto para a tipografia electrÃ³nica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a disponibilizaÃ§Ã£o das folhas de Letraset, que continham passagens com Lorem Ip', 'O Lorem Ipsum Ã© um texto modelo da indÃºstria tipogrÃ¡fica e de impressÃ£o. O Lorem Ipsum tem vindo a ser o texto padrÃ£o usado por estas indÃºstrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espÃ©cime de livro. Este texto nÃ£o sÃ³ sobreviveu 5 sÃ©culos, mas tambÃ©m o salto para a tipografia electrÃ³nica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a disponibilizaÃ§Ã£o das folhas de Letraset, que continham passagens com Lorem Ipsum, e mais recentemente com os programas de publicaÃ§Ã£o como o Aldus PageMaker que incluem versÃµes do Lorem Ipsum.', 'Rua Padre JosÃ© Rodrigues de Barro', '3600-000', 'Viseu', 'SÃ£o Pedro do Sul', 'Portugal', 'Carvalhais', '2019-02-21', 'e8cf181a093ad1090a61daf74cbdff891b6f97785c64b59f98f34cfaa86a327d', 1, ''),
(12, '121551275655.jpg', 'Lourizela', 'goncalo.lslv@gmail.com', '2328659475', 'https://www.google.pt/', '2014-01-01', 'https://www.facebook.com/', 'https://www.instagram.com/?hl=pt', 'https://twitter.com/', 'awrgerwgtae', 'sgRQEW', 'Rua Costa de Baixo', '3800-000', 'Viseu', 'Oliveira de Frades', 'Portugal', 'Pinheiro de Lafoes', '2019-02-27', 'c20a7cc70378247649ca446557be4e7ba5cb04ccdae0ea4eddc2cde71cb04f95', 0, 'Comp1551274865.txt'),
(14, '141552086521.png', 'Greenpeace', 'goncalo.lslv.silva@gmail.com', '2328659251', 'http://www.greenpeace.org/', '1971-01-01', 'https://www.facebook.com/greenpeace.international/', 'https://www.instagram.com/?hl=pt', 'https://twitter.com/', '   A Greenpeace Ã© uma organizaÃ§Ã£o mundial cujo objectivo Ã© mudar atitudes e comportamentos, para defender o meio ambiente e promover a paz.', '   A Greenpeace existe porque este frÃ¡gil planeta merece ter uma voz, precisa de soluÃ§Ãµes e de mudanÃ§as.', 'Avenida Fontes Pereira de Melo', '1000-000', 'Lisboa', 'Amadora', 'Portugal', 'Carnaxide', '2019-03-08', '7d9204025d2b329804f35df7930bc2ff033ccaef44945fceeea5ab3307b21600', 1, 'Comp1552075468.txt');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblorgcomentario`
--

CREATE TABLE `tblorgcomentario` (
  `Id` int(11) NOT NULL,
  `IdOrganizacao` int(11) NOT NULL,
  `IdComentario` int(11) NOT NULL,
  `Descricao` varchar(500) NOT NULL,
  `DataHora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tblorgcomentario`
--

INSERT INTO `tblorgcomentario` (`Id`, `IdOrganizacao`, `IdComentario`, `Descricao`, `DataHora`) VALUES
(1, 9, 13, 'obrigado!!!', '2019-02-25 11:54:00'),
(2, 9, 15, 'Obrigado pela sua OpiniÃ£o!!!', '2019-03-07 21:02:00'),
(3, 14, 15, 'Agradecemos a sua opiniÃ£o e tomaremos nota!!!', '2019-03-09 01:24:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblorgevento`
--

CREATE TABLE `tblorgevento` (
  `Id` int(11) NOT NULL,
  `IdEvento` int(11) NOT NULL,
  `IdOrganizacao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tblorgevento`
--

INSERT INTO `tblorgevento` (`Id`, `IdEvento`, `IdOrganizacao`) VALUES
(19, 19, 7),
(22, 20, 9),
(26, 19, 9),
(27, 21, 9),
(28, 22, 9),
(29, 21, 10),
(30, 23, 10),
(31, 23, 9),
(32, 24, 14),
(33, 21, 14),
(34, 24, 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblorgrating`
--

CREATE TABLE `tblorgrating` (
  `Id` int(11) NOT NULL,
  `IdOrganizacao` int(11) NOT NULL,
  `IdVoluntarioreviewer` int(11) NOT NULL,
  `Stars` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tblorgrating`
--

INSERT INTO `tblorgrating` (`Id`, `IdOrganizacao`, `IdVoluntarioreviewer`, `Stars`) VALUES
(1, 7, 11, 5),
(2, 10, 14, 4),
(3, 9, 14, 5),
(4, 9, 17, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblpedidos`
--

CREATE TABLE `tblpedidos` (
  `Id` int(11) NOT NULL,
  `IdOrgPediu` int(11) NOT NULL,
  `IdOrgPedida` int(11) NOT NULL,
  `IdEvento` int(11) NOT NULL,
  `Visto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tblpedidos`
--

INSERT INTO `tblpedidos` (`Id`, `IdOrgPediu`, `IdOrgPedida`, `IdEvento`, `Visto`) VALUES
(3, 9, 10, 22, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblrecuperarorg`
--

CREATE TABLE `tblrecuperarorg` (
  `Id` int(11) NOT NULL,
  `Token` varchar(300) NOT NULL,
  `IdOrganizacao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblrecuperarvol`
--

CREATE TABLE `tblrecuperarvol` (
  `Id` int(11) NOT NULL,
  `Token` varchar(300) NOT NULL,
  `IdVoluntario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblreportorg`
--

CREATE TABLE `tblreportorg` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Email` varchar(300) NOT NULL,
  `Descricao` varchar(1000) NOT NULL,
  `Tipo` int(11) NOT NULL,
  `DataHora` datetime NOT NULL,
  `Id_Organizacao` int(11) NOT NULL,
  `Visto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tblreportorg`
--

INSERT INTO `tblreportorg` (`Id`, `Nome`, `Email`, `Descricao`, `Tipo`, `DataHora`, `Id_Organizacao`, `Visto`) VALUES
(3, 'GonÃ§alo', 'gls@gmail.com', 'ConteÃºdo extremista no perfil', 2, '2019-02-16 23:25:00', 7, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblreports`
--

CREATE TABLE `tblreports` (
  `Id` int(11) NOT NULL,
  `Descricao` varchar(1000) NOT NULL,
  `Tipo` int(11) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Email` varchar(300) NOT NULL,
  `DataHora` datetime NOT NULL,
  `Visto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tblreports`
--

INSERT INTO `tblreports` (`Id`, `Descricao`, `Tipo`, `Nome`, `Email`, `DataHora`, `Visto`) VALUES
(10, 'Esta na pÃ¡gina Index e o site todo desconfigurou', 4, 'GonÃ§alo', 'gls@gmail.com', '2019-02-12 20:04:00', 0),
(11, 'A pÃ¡gina contacto deixou de funcionar', 4, 'Ruben', 'rub@gmail.com', '2019-02-12 23:03:00', 0),
(12, 'O site deixou de dar', 1, 'Marcolino', 'm@gmail', '2019-02-12 23:05:00', 0),
(13, 'Aparefce um erro de sem ligaÃ§Ã£o com a base de dados', 4, 'felismino', 'f@gmail.com', '2019-02-12 23:06:00', 0),
(14, 'A pÃ¡gina lagou', 4, 'Hugo', 'h@gmail.com', '2019-03-01 18:27:00', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblreportvol`
--

CREATE TABLE `tblreportvol` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Email` varchar(300) NOT NULL,
  `Descricao` varchar(1000) NOT NULL,
  `Tipo` int(11) NOT NULL,
  `DataHora` datetime NOT NULL,
  `Id_Voluntario` int(11) NOT NULL,
  `Visto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblskills`
--

CREATE TABLE `tblskills` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `IdVoluntario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tblskills`
--

INSERT INTO `tblskills` (`Id`, `Nome`, `IdVoluntario`) VALUES
(159, 'Ambiente', 11),
(215, 'Cidadania e Direitos', 11),
(216, 'Ambiente', 12),
(217, 'Cidadania e Direitos', 12),
(218, 'Cultura e Artes', 12),
(219, 'Ambiente', 13),
(222, 'Cidadania e Direitos', 13),
(223, 'Ambiente', 14),
(225, 'Solidariedade Social', 14),
(226, 'Novas Tecnologias', 14),
(227, 'Cidadania e Direitos', 14),
(228, 'Ambiente', 17),
(229, 'Novas Tecnologias', 17),
(230, 'Solidariedade Social', 17);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblvolevento`
--

CREATE TABLE `tblvolevento` (
  `Id` int(11) NOT NULL,
  `IdEvento` int(11) NOT NULL,
  `IdVoluntario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tblvolevento`
--

INSERT INTO `tblvolevento` (`Id`, `IdEvento`, `IdVoluntario`) VALUES
(13, 7, 11),
(15, 5, 11),
(16, 5, 11),
(57, 20, 11),
(58, 20, 14),
(59, 23, 17),
(60, 24, 17),
(61, 24, 14);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblvolnoticiacomentario`
--

CREATE TABLE `tblvolnoticiacomentario` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Email` varchar(300) NOT NULL,
  `IdNoticia` int(11) NOT NULL,
  `Descricao` varchar(500) NOT NULL,
  `DataHora` datetime NOT NULL,
  `Visto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tblvolnoticiacomentario`
--

INSERT INTO `tblvolnoticiacomentario` (`Id`, `Nome`, `Email`, `IdNoticia`, `Descricao`, `DataHora`, `Visto`) VALUES
(10, 'tiago', 't@gmail.com', 1, 'Ola!!!', '2019-02-11 13:45:00', 0),
(11, 'Cristina', 'cristina@gmail.com', 1, 'Gostei', '2019-02-12 19:17:00', 0),
(13, 'marco', 'm@gmail.com', 1, 'gostei da noticia', '2019-02-22 14:19:00', 0),
(14, 'bia', 'bia@gmail.com', 1, 'gostei', '2019-02-26 13:47:00', 1),
(15, 'Hugo', 'hugix@gmail.com', 2, 'Amei o artigo', '2019-03-01 18:15:00', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblvolrating`
--

CREATE TABLE `tblvolrating` (
  `Id` int(11) NOT NULL,
  `Stars` int(11) NOT NULL,
  `IdVoluntario` int(11) NOT NULL,
  `IdOrganizacao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tblvolrating`
--

INSERT INTO `tblvolrating` (`Id`, `Stars`, `IdVoluntario`, `IdOrganizacao`) VALUES
(2, 5, 11, 7),
(3, 4, 11, 7),
(4, 3, 12, 9),
(5, 4, 13, 9),
(6, 4, 17, 14);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tblvoluntario`
--

CREATE TABLE `tblvoluntario` (
  `Id` int(11) NOT NULL,
  `Foto` varchar(100) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Apelido` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Telemovel` varchar(12) NOT NULL,
  `Pais` varchar(70) NOT NULL,
  `Morada` varchar(200) NOT NULL,
  `CodPostal` varchar(8) NOT NULL,
  `Distrito` varchar(50) NOT NULL,
  `Concelho` varchar(50) NOT NULL,
  `Freguesia` varchar(50) NOT NULL,
  `DataNasc` date NOT NULL,
  `Habilitacoes` varchar(50) NOT NULL,
  `SituacaoProfissional` varchar(50) NOT NULL,
  `Profissao` varchar(50) NOT NULL,
  `Facebook` varchar(300) NOT NULL,
  `Twitter` varchar(300) NOT NULL,
  `Instagram` varchar(300) NOT NULL,
  `Info` varchar(1000) NOT NULL,
  `Utilizador` varchar(100) NOT NULL,
  `Password` varchar(300) NOT NULL,
  `Registo` date NOT NULL,
  `Problema` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tblvoluntario`
--

INSERT INTO `tblvoluntario` (`Id`, `Foto`, `Nome`, `Apelido`, `Email`, `Telemovel`, `Pais`, `Morada`, `CodPostal`, `Distrito`, `Concelho`, `Freguesia`, `DataNasc`, `Habilitacoes`, `SituacaoProfissional`, `Profissao`, `Facebook`, `Twitter`, `Instagram`, `Info`, `Utilizador`, `Password`, `Registo`, `Problema`) VALUES
(11, 'rub21549030337.png', 'RUBEN', 'MENDONÃ‡A', 'rub2@gmail.com', '939865231', 'Portugal', 'Rua Costa do Forno', '3800-000', 'Viseu', 'Oliveira de Frades', 'Pinheiro de Lafoes', '2019-01-18', 'Ensino', 'Empregado', 'NegÃ³cios', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.instagram.com/?hl=pt', 'wrtq35fq3', 'rub2', '6ffb7961c48545303c67a33d9411cdd0b00f0eaa55b8213d46aadff5dabd2cd0', '2019-01-22', 0),
(12, 'gl1550068475.jpg', 'GonÃ§alo', 'Silva', 'gls@gmail.com', '919683521', 'Portugal', 'Rua Costa de Baixo', '3600-000', 'Viseu', 'Oliveira de Frades', 'Pinheiro de Lafoes', '1999-01-01', 'Ensino', 'Empregado', 'GestÃ£o', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.instagram.com/?hl=pt', 'Gosto de me voluntariar', 'gl', '6ffb7961c48545303c67a33d9411cdd0b00f0eaa55b8213d46aadff5dabd2cd0', '2019-02-13', 1),
(13, '131550845659.png', 'Marco', 'Silva', 'marco@gmail.com', '939865231', 'Portugal', 'Rua Costa de Baixo', '3800-000', 'Viseu', 'Oliveira de Frades', 'Pinheiro de Lafoes', '2019-02-20', 'Ensino SecundÃ¡rio - Ensino Recorrente', 'Empregado', 'AdministraÃ§Ã£o PÃºblica', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.instagram.com/?hl=pt', 'qualquer coisa', 'marco', 'd54be1d87c456fe90edaf5e2906b00ff4eaaf811fa4a04e0c2634b4b6d02e941', '2019-02-22', 0),
(14, '141551464735.jpg', 'Hugo', 'Amaral', 'hugooamaral@gmail.com', '939685120', 'Portugal', 'Rua Costa de Baixo', '3800-000', 'Viseu', 'Oliveira de Frades', 'Oliveira de Frades', '2017-12-31', 'Ensino Superior UniversitÃ¡rio - Licenciaturas', 'Empregado', 'Engenharia da ComputaÃ§Ã£o', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.instagram.com/?hl=pt', 'Gosto de me voluntariar', 'hugix', '2ed2a5c3e1ed8c8b31f892df9ec8c5c6ab7327b624cbc47d958bd85777d1e8fb', '2019-03-01', 0),
(17, '171551915440.jpg', 'GonÃ§alo', 'Silva', 'goncalo.lslv.silva@gmail.com', '939583531', 'Portugal', 'Rua Costa do Forno', '3680-000', 'Viseu', 'Oliveira de Frades', 'Pinheiro de Lafoes', '2001-09-07', 'Ensino SecundÃ¡rio - Cursos Profissionais', 'Empregado', 'Tecnologias da InformaÃ§Ã£o', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.instagram.com/?hl=pt', 'Gosto de me voluntariar e ajudar as pessoas, ajuda-me a crescer', 'GoncaloGLS', '4cab30006704c46ac539bb0ebbfd0facf059f2e0b3d85fb667eb9aa58c1eefcf', '2019-03-06', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbladminnoticiacomentario`
--
ALTER TABLE `tbladminnoticiacomentario`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdAdmin` (`IdAdmin`),
  ADD KEY `IdComentario` (`IdComentario`);

--
-- Indexes for table `tblareaatuacao`
--
ALTER TABLE `tblareaatuacao`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdOrganizacao` (`IdOrganizacao`);

--
-- Indexes for table `tblareaatucaoevento`
--
ALTER TABLE `tblareaatucaoevento`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdEvento` (`IdEvento`);

--
-- Indexes for table `tblcontato`
--
ALTER TABLE `tblcontato`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblevento`
--
ALTER TABLE `tblevento`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdOrganizacao` (`IdOrganizacao`);

--
-- Indexes for table `tbleventocomentario`
--
ALTER TABLE `tbleventocomentario`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdVoluntario` (`IdVoluntario`),
  ADD KEY `IdEvento` (`IdEvento`);

--
-- Indexes for table `tbleventorating`
--
ALTER TABLE `tbleventorating`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdEvento` (`IdEvento`),
  ADD KEY `IdVoluntario` (`IdVoluntario`);

--
-- Indexes for table `tblgostocomentario`
--
ALTER TABLE `tblgostocomentario`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdComentario` (`IdComentario`),
  ADD KEY `IdVoluntario` (`IdVoluntario`);

--
-- Indexes for table `tblgostoorgcomentario`
--
ALTER TABLE `tblgostoorgcomentario`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdOrgComentario` (`IdOrgComentario`),
  ADD KEY `IdVoluntario` (`IdVoluntario`);

--
-- Indexes for table `tbllogs`
--
ALTER TABLE `tbllogs`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblnoticias`
--
ALTER TABLE `tblnoticias`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblorganizacao`
--
ALTER TABLE `tblorganizacao`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblorgcomentario`
--
ALTER TABLE `tblorgcomentario`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdComentario` (`IdComentario`),
  ADD KEY `IdOrganizacao` (`IdOrganizacao`);

--
-- Indexes for table `tblorgevento`
--
ALTER TABLE `tblorgevento`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdEvento` (`IdEvento`),
  ADD KEY `IdOrganizacao` (`IdOrganizacao`);

--
-- Indexes for table `tblorgrating`
--
ALTER TABLE `tblorgrating`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdOrganizacao` (`IdOrganizacao`),
  ADD KEY `IdVoluntarioreviewer` (`IdVoluntarioreviewer`);

--
-- Indexes for table `tblpedidos`
--
ALTER TABLE `tblpedidos`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdOrgPedida` (`IdOrgPedida`),
  ADD KEY `IdOrgPediu` (`IdOrgPediu`),
  ADD KEY `IdEvento` (`IdEvento`);

--
-- Indexes for table `tblrecuperarorg`
--
ALTER TABLE `tblrecuperarorg`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdOrganizacao` (`IdOrganizacao`);

--
-- Indexes for table `tblrecuperarvol`
--
ALTER TABLE `tblrecuperarvol`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdVoluntario` (`IdVoluntario`);

--
-- Indexes for table `tblreportorg`
--
ALTER TABLE `tblreportorg`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_Organizacao` (`Id_Organizacao`);

--
-- Indexes for table `tblreports`
--
ALTER TABLE `tblreports`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblreportvol`
--
ALTER TABLE `tblreportvol`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_Voluntario` (`Id_Voluntario`);

--
-- Indexes for table `tblskills`
--
ALTER TABLE `tblskills`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdVoluntario` (`IdVoluntario`);

--
-- Indexes for table `tblvolevento`
--
ALTER TABLE `tblvolevento`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdEvento` (`IdEvento`),
  ADD KEY `IdVoluntario` (`IdVoluntario`);

--
-- Indexes for table `tblvolnoticiacomentario`
--
ALTER TABLE `tblvolnoticiacomentario`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdNoticia` (`IdNoticia`);

--
-- Indexes for table `tblvolrating`
--
ALTER TABLE `tblvolrating`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdVoluntario` (`IdVoluntario`),
  ADD KEY `IdOrganizacao` (`IdOrganizacao`);

--
-- Indexes for table `tblvoluntario`
--
ALTER TABLE `tblvoluntario`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbladminnoticiacomentario`
--
ALTER TABLE `tbladminnoticiacomentario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblareaatuacao`
--
ALTER TABLE `tblareaatuacao`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tblareaatucaoevento`
--
ALTER TABLE `tblareaatucaoevento`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tblcontato`
--
ALTER TABLE `tblcontato`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblevento`
--
ALTER TABLE `tblevento`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbleventocomentario`
--
ALTER TABLE `tbleventocomentario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbleventorating`
--
ALTER TABLE `tbleventorating`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `tblgostocomentario`
--
ALTER TABLE `tblgostocomentario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tblgostoorgcomentario`
--
ALTER TABLE `tblgostoorgcomentario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbllogs`
--
ALTER TABLE `tbllogs`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tblnoticias`
--
ALTER TABLE `tblnoticias`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblorganizacao`
--
ALTER TABLE `tblorganizacao`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tblorgcomentario`
--
ALTER TABLE `tblorgcomentario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblorgevento`
--
ALTER TABLE `tblorgevento`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tblorgrating`
--
ALTER TABLE `tblorgrating`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblpedidos`
--
ALTER TABLE `tblpedidos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblrecuperarorg`
--
ALTER TABLE `tblrecuperarorg`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblrecuperarvol`
--
ALTER TABLE `tblrecuperarvol`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblreportorg`
--
ALTER TABLE `tblreportorg`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblreports`
--
ALTER TABLE `tblreports`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tblreportvol`
--
ALTER TABLE `tblreportvol`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblskills`
--
ALTER TABLE `tblskills`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT for table `tblvolevento`
--
ALTER TABLE `tblvolevento`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `tblvolnoticiacomentario`
--
ALTER TABLE `tblvolnoticiacomentario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tblvolrating`
--
ALTER TABLE `tblvolrating`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblvoluntario`
--
ALTER TABLE `tblvoluntario`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `tbladminnoticiacomentario`
--
ALTER TABLE `tbladminnoticiacomentario`
  ADD CONSTRAINT `tbladminnoticiacomentario_ibfk_1` FOREIGN KEY (`IdAdmin`) REFERENCES `tbladmin` (`Id`),
  ADD CONSTRAINT `tbladminnoticiacomentario_ibfk_2` FOREIGN KEY (`IdComentario`) REFERENCES `tblvolnoticiacomentario` (`Id`);

--
-- Limitadores para a tabela `tblareaatuacao`
--
ALTER TABLE `tblareaatuacao`
  ADD CONSTRAINT `tblareaatuacao_ibfk_1` FOREIGN KEY (`IdOrganizacao`) REFERENCES `tblorganizacao` (`Id`);

--
-- Limitadores para a tabela `tblareaatucaoevento`
--
ALTER TABLE `tblareaatucaoevento`
  ADD CONSTRAINT `tblareaatucaoevento_ibfk_1` FOREIGN KEY (`IdEvento`) REFERENCES `tblevento` (`Id`);

--
-- Limitadores para a tabela `tblevento`
--
ALTER TABLE `tblevento`
  ADD CONSTRAINT `tblevento_ibfk_1` FOREIGN KEY (`IdOrganizacao`) REFERENCES `tblorganizacao` (`Id`);

--
-- Limitadores para a tabela `tbleventocomentario`
--
ALTER TABLE `tbleventocomentario`
  ADD CONSTRAINT `tbleventocomentario_ibfk_1` FOREIGN KEY (`IdVoluntario`) REFERENCES `tblvoluntario` (`Id`),
  ADD CONSTRAINT `tbleventocomentario_ibfk_2` FOREIGN KEY (`IdEvento`) REFERENCES `tblevento` (`Id`);

--
-- Limitadores para a tabela `tbleventorating`
--
ALTER TABLE `tbleventorating`
  ADD CONSTRAINT `tbleventorating_ibfk_1` FOREIGN KEY (`IdEvento`) REFERENCES `tblevento` (`Id`),
  ADD CONSTRAINT `tbleventorating_ibfk_2` FOREIGN KEY (`IdVoluntario`) REFERENCES `tblvoluntario` (`Id`);

--
-- Limitadores para a tabela `tblgostocomentario`
--
ALTER TABLE `tblgostocomentario`
  ADD CONSTRAINT `tblgostocomentario_ibfk_1` FOREIGN KEY (`IdComentario`) REFERENCES `tbleventocomentario` (`Id`),
  ADD CONSTRAINT `tblgostocomentario_ibfk_2` FOREIGN KEY (`IdVoluntario`) REFERENCES `tblvoluntario` (`Id`);

--
-- Limitadores para a tabela `tblgostoorgcomentario`
--
ALTER TABLE `tblgostoorgcomentario`
  ADD CONSTRAINT `tblgostoorgcomentario_ibfk_1` FOREIGN KEY (`IdOrgComentario`) REFERENCES `tblorgcomentario` (`Id`),
  ADD CONSTRAINT `tblgostoorgcomentario_ibfk_2` FOREIGN KEY (`IdVoluntario`) REFERENCES `tblvoluntario` (`Id`);

--
-- Limitadores para a tabela `tblorgcomentario`
--
ALTER TABLE `tblorgcomentario`
  ADD CONSTRAINT `tblorgcomentario_ibfk_1` FOREIGN KEY (`IdComentario`) REFERENCES `tbleventocomentario` (`Id`),
  ADD CONSTRAINT `tblorgcomentario_ibfk_2` FOREIGN KEY (`IdOrganizacao`) REFERENCES `tblorganizacao` (`Id`);

--
-- Limitadores para a tabela `tblorgevento`
--
ALTER TABLE `tblorgevento`
  ADD CONSTRAINT `tblorgevento_ibfk_1` FOREIGN KEY (`IdEvento`) REFERENCES `tblevento` (`Id`),
  ADD CONSTRAINT `tblorgevento_ibfk_2` FOREIGN KEY (`IdOrganizacao`) REFERENCES `tblorganizacao` (`Id`);

--
-- Limitadores para a tabela `tblorgrating`
--
ALTER TABLE `tblorgrating`
  ADD CONSTRAINT `tblorgrating_ibfk_1` FOREIGN KEY (`IdOrganizacao`) REFERENCES `tblorganizacao` (`Id`),
  ADD CONSTRAINT `tblorgrating_ibfk_2` FOREIGN KEY (`IdVoluntarioreviewer`) REFERENCES `tblvoluntario` (`Id`);

--
-- Limitadores para a tabela `tblpedidos`
--
ALTER TABLE `tblpedidos`
  ADD CONSTRAINT `tblpedidos_ibfk_1` FOREIGN KEY (`IdOrgPedida`) REFERENCES `tblorganizacao` (`Id`),
  ADD CONSTRAINT `tblpedidos_ibfk_2` FOREIGN KEY (`IdOrgPediu`) REFERENCES `tblorganizacao` (`Id`),
  ADD CONSTRAINT `tblpedidos_ibfk_3` FOREIGN KEY (`IdEvento`) REFERENCES `tblevento` (`Id`);

--
-- Limitadores para a tabela `tblrecuperarorg`
--
ALTER TABLE `tblrecuperarorg`
  ADD CONSTRAINT `tblrecuperarorg_ibfk_1` FOREIGN KEY (`IdOrganizacao`) REFERENCES `tblorganizacao` (`Id`);

--
-- Limitadores para a tabela `tblrecuperarvol`
--
ALTER TABLE `tblrecuperarvol`
  ADD CONSTRAINT `tblrecuperarvol_ibfk_1` FOREIGN KEY (`IdVoluntario`) REFERENCES `tblvoluntario` (`Id`);

--
-- Limitadores para a tabela `tblreportorg`
--
ALTER TABLE `tblreportorg`
  ADD CONSTRAINT `tblreportorg_ibfk_1` FOREIGN KEY (`Id_Organizacao`) REFERENCES `tblorganizacao` (`Id`);

--
-- Limitadores para a tabela `tblreportvol`
--
ALTER TABLE `tblreportvol`
  ADD CONSTRAINT `tblreportvol_ibfk_1` FOREIGN KEY (`Id_Voluntario`) REFERENCES `tblvoluntario` (`Id`);

--
-- Limitadores para a tabela `tblskills`
--
ALTER TABLE `tblskills`
  ADD CONSTRAINT `tblskills_ibfk_1` FOREIGN KEY (`IdVoluntario`) REFERENCES `tblvoluntario` (`Id`);

--
-- Limitadores para a tabela `tblvolevento`
--
ALTER TABLE `tblvolevento`
  ADD CONSTRAINT `tblvolevento_ibfk_1` FOREIGN KEY (`IdEvento`) REFERENCES `tblevento` (`Id`),
  ADD CONSTRAINT `tblvolevento_ibfk_2` FOREIGN KEY (`IdVoluntario`) REFERENCES `tblvoluntario` (`Id`);

--
-- Limitadores para a tabela `tblvolnoticiacomentario`
--
ALTER TABLE `tblvolnoticiacomentario`
  ADD CONSTRAINT `tblvolnoticiacomentario_ibfk_2` FOREIGN KEY (`IdNoticia`) REFERENCES `tblnoticias` (`Id`);

--
-- Limitadores para a tabela `tblvolrating`
--
ALTER TABLE `tblvolrating`
  ADD CONSTRAINT `tblvolrating_ibfk_1` FOREIGN KEY (`IdVoluntario`) REFERENCES `tblvoluntario` (`Id`),
  ADD CONSTRAINT `tblvolrating_ibfk_2` FOREIGN KEY (`IdOrganizacao`) REFERENCES `tblorganizacao` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
