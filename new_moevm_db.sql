

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `moevmdb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_name` varchar(256) NOT NULL,
  PRIMARY KEY (`activity_id`),
  KEY `activity_name` (`activity_name`(255)),
  KEY `activity_name_2` (`activity_name`(255))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `activity`
--

INSERT INTO `activity` (`activity_id`, `activity_name`) VALUES
(1, 'Технологии виртуализации, системы хранения, cloud computing'),
(2, 'Интеллектуальные пространства и интеллектуальные системы'),
(3, 'Алгоритмы ориентирования автономных мобильных роботов (SLAM)'),
(4, 'Мягкие вычисления, проектирование информационных систем'),
(5, 'Распределенная обработка информации, сети ЭВМ, мониторинг вычислительных сетей'),
(6, 'Теория баз данных'),
(7, 'Разработка автоматизированных информационных систем'),
(8, 'Функциональное программирование'),
(11, 'Моделирование бизнес процессов');

-- --------------------------------------------------------

--
-- Структура таблицы `additional_section`
--

CREATE TABLE IF NOT EXISTS `additional_section` (
  `id_AS` int(11) NOT NULL AUTO_INCREMENT,
  `name_department` varchar(45) DEFAULT NULL,
  `name_AS` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_AS`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `additional_section`
--

INSERT INTO `additional_section` (`id_AS`, `name_department`, `name_AS`) VALUES
(1, 'БЖД', 'БЖД'),
(2, 'ПЭ', 'ТЭО');

-- --------------------------------------------------------

--
-- Структура таблицы `attend`
--

CREATE TABLE IF NOT EXISTS `attend` (
  `idAttend` int(11) NOT NULL AUTO_INCREMENT,
  `idMember` int(11) NOT NULL,
  `idDirection` int(11) NOT NULL,
  PRIMARY KEY (`idAttend`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `canteach`
--

CREATE TABLE IF NOT EXISTS `canteach` (
  `idCanTeach` int(11) NOT NULL AUTO_INCREMENT,
  `Discipline` int(11) DEFAULT NULL,
  `Teacher` int(11) DEFAULT NULL,
  `Lecture` tinyint(1) DEFAULT NULL,
  `Practic` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idCanTeach`),
  KEY `Discipline_idx` (`Discipline`),
  KEY `Teacher_idx` (`Teacher`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Дамп данных таблицы `canteach`
--

INSERT INTO `canteach` (`idCanTeach`, `Discipline`, `Teacher`, `Lecture`, `Practic`) VALUES
(24, 37, 150, NULL, NULL),
(25, 31, 150, NULL, NULL),
(26, 7, 112, NULL, NULL),
(27, 7, 111, NULL, NULL),
(28, 64, 99, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `chair`
--

CREATE TABLE IF NOT EXISTS `chair` (
  `idChair` int(11) NOT NULL AUTO_INCREMENT,
  `ChairNum` smallint(6) NOT NULL,
  `ChairShortName` varchar(20) DEFAULT NULL,
  `ChairFullName` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idChair`),
  UNIQUE KEY `ChairNum` (`ChairNum`),
  UNIQUE KEY `ChairShortName_UNIQUE` (`ChairShortName`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Дамп данных таблицы `chair`
--

INSERT INTO `chair` (`idChair`, `ChairNum`, `ChairShortName`, `ChairFullName`) VALUES
(1, 14, 'МО ЭВМ', 'Математического обеспечения и применения ЭВМ'),
(2, 9, 'ИнЯз', 'Иностранных языков'),
(3, 43, NULL, 'Философии'),
(4, 5, 'ВМ-2', 'Высшей математики № 2'),
(5, 40, NULL, 'Истории культуры, государства и права'),
(6, 44, NULL, 'Экономической теории'),
(7, 39, 'БЖД', 'Безопасности жизнедеятельности'),
(8, 33, NULL, 'Физического воспитания и спорта'),
(9, 30, NULL, 'Физики'),
(10, 19, NULL, 'Прикладной экономики'),
(11, 8, 'ИМ', 'Инновационного менеджмента'),
(12, 42, NULL, 'Социологии и политологии'),
(13, 58, 'ИБ', 'Информационная безопасность'),
(14, 15, NULL, 'Менеджмента и систем качества'),
(15, 41, 'РЯ', 'Русского языка'),
(16, 29, 'ТОЭ', 'Теоретических основ электротехники'),
(17, 24, 'САПР', 'Систем автоматизированного проектирования'),
(18, 190, NULL, 'Радиотехники'),
(24, 150, NULL, 'Физической Химии');

-- --------------------------------------------------------

--
-- Структура таблицы `consultant_as`
--

CREATE TABLE IF NOT EXISTS `consultant_as` (
  `id_consultant_AS` int(11) NOT NULL AUTO_INCREMENT,
  `surname_consultant_AS` varchar(45) DEFAULT NULL,
  `first_name_consultant_AS` varchar(20) DEFAULT NULL,
  `patronymic_consultant_AS` varchar(45) DEFAULT NULL,
  `mobile` varchar(16) DEFAULT NULL,
  `work_hone` varchar(9) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `id_additional_section` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_consultant_AS`),
  UNIQUE KEY `consultant_AS_UNIQUE` (`surname_consultant_AS`,`first_name_consultant_AS`,`patronymic_consultant_AS`,`id_additional_section`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `consultant_as`
--

INSERT INTO `consultant_as` (`id_consultant_AS`, `surname_consultant_AS`, `first_name_consultant_AS`, `patronymic_consultant_AS`, `mobile`, `work_hone`, `email`, `address`, `birth_date`, `id_additional_section`) VALUES
(1, 'Иванов', 'Петр', 'Михайлович', '', NULL, NULL, NULL, NULL, 2),
(2, 'Михайлова', 'Анастасия', 'Петровна', NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `consultant_company`
--

CREATE TABLE IF NOT EXISTS `consultant_company` (
  `id_consultant_company` int(11) NOT NULL AUTO_INCREMENT,
  `passport_consultant_company` varchar(12) DEFAULT NULL,
  `surname_consultant_company` varchar(45) DEFAULT NULL,
  `first_name_consultant_company` varchar(20) DEFAULT NULL,
  `patronymic_consultant_company` varchar(45) DEFAULT NULL,
  `name_company` varchar(45) DEFAULT NULL,
  `mobile` varchar(16) DEFAULT NULL,
  `work_hone` varchar(9) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  PRIMARY KEY (`id_consultant_company`),
  UNIQUE KEY `Passport_UNIQUE` (`passport_consultant_company`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `consultant_company`
--

INSERT INTO `consultant_company` (`id_consultant_company`, `passport_consultant_company`, `surname_consultant_company`, `first_name_consultant_company`, `patronymic_consultant_company`, `name_company`, `mobile`, `work_hone`, `email`, `address`, `birth_date`) VALUES
(1, '1990 20045', 'Михайлова', 'Т', 'А', 'Вектор', NULL, NULL, NULL, NULL, '1970-05-01'),
(2, '88888888', 'Меньшов', 'Василий', 'Михайлович', 'Океанприбор', '00000000', '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `curriculum`
--

CREATE TABLE IF NOT EXISTS `curriculum` (
  `idCurriculum` int(11) NOT NULL AUTO_INCREMENT,
  `CurriculumNum` varchar(15) DEFAULT NULL,
  `Direction` int(11) DEFAULT NULL,
  `Chair` int(11) NOT NULL,
  `Stage` tinyint(4) NOT NULL,
  PRIMARY KEY (`idCurriculum`),
  UNIQUE KEY `CurriculumNum_UNIQUE` (`CurriculumNum`),
  KEY `Direction_idx` (`Direction`),
  KEY `Chair` (`Chair`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Дамп данных таблицы `curriculum`
--

INSERT INTO `curriculum` (`idCurriculum`, `CurriculumNum`, `Direction`, `Chair`, `Stage`) VALUES
(1, '038', 1, 1, 1),
(12, '262', 3, 1, 2),
(16, '252-2015', 4, 1, 2),
(18, '032', 2, 1, 1),
(19, '315', 6, 18, 0),
(24, '880', 7, 24, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `curriculumdiscipline`
--

CREATE TABLE IF NOT EXISTS `curriculumdiscipline` (
  `idCurriculumDiscipline` int(11) NOT NULL AUTO_INCREMENT,
  `DisIndex` varchar(20) DEFAULT NULL,
  `Discipline` int(11) DEFAULT NULL,
  `Curriculum` int(11) DEFAULT NULL,
  `Exam` tinyint(1) DEFAULT '0',
  `CreditW/OGrade` tinyint(1) DEFAULT '0',
  `CreditWithGrade` tinyint(1) DEFAULT '0',
  `Lecture` tinyint(1) DEFAULT '0',
  `Lab` tinyint(1) DEFAULT '0',
  `Practice` tinyint(1) DEFAULT '0',
  `Solo` smallint(3) DEFAULT '0',
  `CourseProject` tinyint(1) DEFAULT '0',
  `CourseWork` tinyint(1) DEFAULT '0',
  `Zet` smallint(2) DEFAULT '0',
  `Total` smallint(4) DEFAULT '0',
  `Semester` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`idCurriculumDiscipline`),
  KEY `Discipline_idx` (`Discipline`),
  KEY `Curriculum_idx` (`Curriculum`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=181 ;

--
-- Дамп данных таблицы `curriculumdiscipline`
--

INSERT INTO `curriculumdiscipline` (`idCurriculumDiscipline`, `DisIndex`, `Discipline`, `Curriculum`, `Exam`, `CreditW/OGrade`, `CreditWithGrade`, `Lecture`, `Lab`, `Practice`, `Solo`, `CourseProject`, `CourseWork`, `Zet`, `Total`, `Semester`) VALUES
(1, 'Б1.Б.1', 1, 1, 0, 0, 1, 0, 0, 54, 90, 0, 0, 4, 144, 1),
(3, 'Б1.Б.2', 2, 1, 0, 1, 0, 18, 0, 36, 54, 0, 0, 3, 108, 1),
(4, 'Б1.Б.3', 3, 1, 1, 0, 0, 36, 0, 36, 72, 0, 0, 5, 180, 1),
(5, 'Б1.Б.4', 4, 1, 1, 0, 0, 36, 0, 36, 36, 0, 0, 4, 144, 1),
(6, 'Б1.Б.5', 5, 1, 1, 0, 0, 36, 18, 18, 36, 0, 0, 4, 144, 1),
(7, 'Б1.Б.6', 6, 1, 0, 0, 1, 36, 36, 0, 72, 0, 0, 4, 144, 1),
(8, 'Б1.Б.7', 7, 1, 1, 0, 0, 36, 36, 18, 54, 0, 1, 5, 180, 1),
(9, 'Б1.Б.8', 8, 1, 0, 0, 1, 18, 0, 36, 54, 0, 0, 3, 108, 2),
(10, 'Б1.Б.9', 9, 1, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 2),
(11, 'Б1.Б.10', 10, 1, 1, 0, 0, 36, 0, 36, 36, 0, 0, 4, 144, 2),
(12, 'Б1.Б.11', 11, 1, 1, 0, 0, 36, 0, 36, 72, 0, 0, 5, 180, 2),
(13, 'Б1.Б.12', 12, 1, 1, 0, 0, 36, 18, 18, 36, 0, 0, 4, 144, 2),
(14, 'Б1.Б.13', 13, 1, 1, 0, 0, 36, 18, 18, 108, 0, 1, 6, 216, 2),
(15, 'Б1.Б.28', 14, 1, 0, 1, 0, 0, 0, 18, 18, 0, 0, 1, 36, 1),
(16, 'Б1.В.ОД.1', 15, 1, 0, 0, 1, 36, 0, 36, 72, 0, 0, 4, 144, 2),
(17, '', 16, 1, 0, 0, 0, 0, 0, 72, 0, 0, 0, 0, 72, 1),
(18, '', 16, 1, 0, 1, 0, 0, 0, 90, 0, 0, 0, 0, 90, 2),
(19, 'Б1.Б.1', 1, 1, 0, 0, 1, 0, 0, 36, 72, 0, 0, 3, 108, 3),
(20, 'Б1.Б.1', 1, 1, 0, 0, 1, 0, 0, 36, 108, 0, 0, 5, 72, 4),
(21, 'Б1.Б.14', 17, 1, 0, 0, 1, 36, 0, 18, 54, 0, 0, 3, 108, 3),
(22, 'Б1.Б.15', 18, 1, 1, 0, 0, 36, 36, 0, 36, 0, 0, 4, 144, 3),
(23, 'Б1.Б.16', 19, 1, 1, 0, 0, 36, 18, 0, 18, 0, 0, 3, 108, 3),
(24, 'Б1.Б.17', 20, 1, 0, 0, 1, 36, 36, 0, 108, 0, 1, 5, 180, 3),
(25, 'Б1.Б.18', 21, 1, 1, 0, 0, 36, 0, 36, 36, 0, 0, 4, 144, 4),
(26, 'Б1.Б.19', 22, 1, 0, 0, 1, 18, 0, 36, 54, 0, 0, 3, 108, 4),
(27, 'Б1.Б.20', 23, 1, 1, 0, 0, 36, 36, 0, 36, 0, 0, 4, 144, 4),
(28, 'Б1.Б.28', 14, 1, 0, 1, 0, 0, 0, 18, 18, 0, 0, 1, 36, 4),
(29, 'Б1.В.ОД.2', 24, 1, 0, 0, 1, 18, 0, 36, 54, 0, 1, 3, 108, 3),
(30, 'Б1.В.ОД.3', 25, 1, 1, 0, 0, 36, 36, 0, 72, 0, 0, 5, 180, 3),
(31, 'Б1.В.ОД.4', 26, 1, 1, 0, 0, 36, 0, 36, 36, 0, 0, 4, 144, 3),
(32, 'Б1.В.ОД.5', 27, 1, 0, 0, 1, 18, 0, 36, 54, 0, 0, 3, 108, 4),
(33, 'Б1.В.ОД.6', 28, 1, 0, 0, 1, 36, 54, 18, 72, 0, 1, 5, 180, 4),
(34, 'Б1.В.ОД.7', 29, 1, 1, 0, 0, 36, 36, 18, 54, 1, 0, 5, 180, 4),
(35, '', 16, 1, 0, 1, 0, 0, 0, 90, 0, 0, 0, 0, 90, 3),
(36, '', 16, 1, 0, 0, 0, 0, 0, 76, 0, 0, 0, 0, 76, 4),
(37, 'Б1.Б.21', 30, 1, 0, 0, 1, 18, 18, 18, 54, 0, 0, 3, 108, 5),
(38, 'Б1.Б.22', 31, 1, 1, 0, 0, 36, 36, 0, 36, 0, 0, 4, 144, 5),
(39, 'Б1.Б.23', 32, 1, 1, 0, 0, 36, 18, 0, 54, 0, 0, 4, 144, 5),
(40, 'Б1.Б.24', 33, 1, 0, 0, 1, 18, 0, 36, 54, 0, 0, 3, 108, 6),
(41, 'Б1.Б.25', 34, 1, 0, 0, 1, 18, 0, 36, 54, 0, 1, 3, 108, 6),
(42, 'Б1.В.ОД.8', 35, 1, 0, 0, 1, 36, 0, 18, 54, 0, 0, 3, 108, 5),
(43, 'Б1.В.ОД.9', 36, 1, 0, 0, 1, 18, 36, 0, 90, 1, 0, 4, 144, 5),
(44, 'Б1.В.ОД.10', 37, 1, 1, 0, 0, 36, 36, 0, 72, 1, 0, 5, 180, 5),
(45, 'Б1.В.ОД.11', 38, 1, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 6),
(46, 'Б1.В.ОД.12', 39, 1, 0, 0, 1, 18, 18, 36, 36, 0, 0, 3, 108, 6),
(47, 'Б1.В.ОД.13', 40, 1, 0, 0, 1, 36, 36, 18, 54, 0, 0, 4, 144, 6),
(48, 'Б1.В.ДВ.1.1', 41, 1, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 5),
(49, 'Б1.В.ДВ.1.2', 42, 1, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 5),
(50, 'Б1.В.ДВ.1.3', 43, 1, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 5),
(51, 'Б1.В.ДВ.1.4', 44, 1, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 5),
(52, 'Б1.В.ДВ.1.5', 45, 1, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 5),
(53, 'Б1.В.ДВ.1.6', 46, 1, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 5),
(54, 'Б1.В.ДВ.1.7', 47, 1, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 5),
(55, 'Б1.В.ДВ.1.8', 48, 1, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 5),
(56, 'Б1.В.ДВ.2.1', 49, 1, 0, 0, 1, 18, 0, 18, 72, 0, 0, 3, 108, 6),
(57, 'Б1.В.ДВ.2.2', 50, 1, 0, 0, 1, 18, 0, 18, 72, 0, 0, 3, 108, 6),
(58, 'Б1.В.ДВ.2.3', 51, 1, 0, 0, 1, 18, 0, 18, 72, 0, 0, 3, 108, 6),
(59, 'Б1.В.ДВ.2.4', 52, 1, 0, 0, 1, 18, 0, 18, 72, 0, 0, 3, 108, 6),
(60, 'Б1.В.ДВ.2.5', 53, 1, 0, 0, 1, 18, 0, 18, 72, 0, 0, 3, 108, 6),
(61, 'Б1.В.ДВ.2.6', 54, 1, 0, 0, 1, 18, 0, 18, 72, 0, 0, 3, 108, 6),
(62, 'Б1.В.ДВ.2.7', 55, 1, 0, 0, 1, 18, 0, 18, 72, 0, 0, 3, 108, 6),
(63, 'Б1.В.ДВ.2.8', 56, 1, 0, 0, 1, 18, 0, 18, 72, 0, 0, 3, 108, 6),
(64, 'Б1.В.ДВ.2.9', 57, 1, 0, 0, 1, 18, 0, 18, 72, 0, 0, 3, 108, 6),
(65, 'Б1.В.ДВ.3.1', 58, 1, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 5),
(66, 'Б1.В.ДВ.3.2', 59, 1, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 5),
(67, 'Б1.В.ДВ.4.1', 60, 1, 1, 0, 0, 18, 18, 18, 18, 0, 0, 3, 108, 5),
(68, 'Б1.В.ДВ.4.2', 61, 1, 1, 0, 0, 18, 18, 18, 18, 0, 0, 3, 108, 5),
(69, 'Б1.В.ДВ.5.1', 62, 1, 0, 0, 1, 18, 18, 36, 36, 0, 0, 3, 108, 6),
(70, 'Б1.В.ДВ.5.2', 63, 1, 0, 0, 1, 18, 18, 36, 36, 0, 0, 3, 108, 6),
(71, 'Б1.В.ДВ.5.3', 64, 1, 0, 0, 1, 18, 18, 36, 36, 0, 0, 3, 108, 6),
(72, 'Б1.В.ДВ.8.1', 65, 1, 0, 0, 1, 18, 36, 18, 36, 0, 0, 3, 108, 6),
(73, 'Б1.В.ДВ.8.2', 66, 1, 0, 0, 1, 18, 36, 18, 36, 0, 0, 3, 108, 6),
(74, 'Б1.Б.26', 67, 1, 0, 0, 1, 18, 18, 18, 54, 0, 0, 3, 108, 7),
(75, 'Б1.Б.27', 68, 1, 1, 0, 0, 36, 0, 18, 18, 0, 0, 3, 108, 7),
(76, 'Б1.В.ОД.14', 69, 1, 1, 0, 0, 18, 36, 18, 72, 0, 0, 5, 180, 7),
(77, 'Б1.В.ОД.15', 70, 1, 0, 0, 1, 18, 18, 18, 54, 0, 0, 3, 108, 7),
(78, 'Б1.В.ОД.17', 71, 1, 0, 0, 1, 22, 33, 22, 31, 0, 0, 3, 108, 8),
(79, 'Б1.В.ОД.18', 72, 1, 0, 0, 1, 22, 33, 11, 78, 0, 1, 4, 144, 8),
(80, 'Б1.В.ДВ.6.1', 73, 1, 0, 0, 1, 18, 18, 18, 54, 0, 0, 3, 108, 7),
(81, 'Б1.В.ДВ.6.2', 74, 1, 0, 0, 1, 18, 18, 18, 54, 0, 0, 3, 108, 7),
(82, 'Б1.В.ДВ.7.1', 75, 1, 0, 0, 1, 18, 36, 0, 54, 0, 0, 3, 108, 7),
(83, 'Б1.В.ДВ.7.2', 76, 1, 0, 0, 1, 18, 36, 0, 54, 0, 0, 3, 108, 7),
(84, 'Б1.В.ДВ.9.1', 77, 1, 1, 0, 0, 18, 36, 18, 36, 0, 0, 4, 144, 7),
(85, 'Б1.В.ДВ.9.2', 78, 1, 1, 0, 0, 18, 36, 18, 36, 0, 0, 4, 144, 7),
(86, 'Б1.В.ДВ.10.1', 79, 1, 1, 0, 0, 18, 36, 18, 36, 0, 0, 4, 144, 7),
(87, 'Б1.В.ДВ.10.2', 80, 1, 1, 0, 0, 18, 36, 18, 36, 0, 0, 4, 144, 7),
(88, 'Б1.В.ДВ.11.1', 81, 1, 0, 0, 1, 22, 44, 11, 67, 0, 0, 4, 144, 8),
(89, 'Б1.В.ДВ.11.2', 82, 1, 0, 0, 1, 22, 44, 11, 67, 0, 0, 4, 144, 8),
(90, 'Б1.В.ДВ.12.1', 83, 1, 0, 0, 1, 22, 33, 22, 67, 0, 0, 4, 144, 8),
(91, 'Б1.В.ДВ.12.2', 84, 1, 0, 0, 1, 22, 33, 22, 67, 0, 0, 4, 144, 8),
(92, 'Б1.Б.1', 1, 18, 0, 0, 1, 0, 0, 54, 90, 0, 0, 4, 144, 1),
(93, 'Б1.Б.1', 1, 18, 0, 0, 1, 0, 0, 36, 126, 0, 0, 6, 72, 2),
(94, 'Б1.Б.2', 2, 18, 0, 0, 1, 18, 0, 36, 54, 0, 0, 3, 108, 1),
(95, 'Б1.Б.3', 3, 18, 1, 0, 0, 36, 0, 36, 72, 0, 0, 5, 180, 1),
(96, 'Б1.Б.4', 4, 18, 1, 0, 0, 36, 0, 36, 36, 0, 0, 4, 144, 1),
(97, 'Б1.Б.5', 6, 18, 0, 0, 1, 36, 36, 0, 72, 0, 0, 4, 144, 1),
(98, 'Б1.Б.6', 7, 18, 1, 0, 0, 36, 36, 18, 54, 0, 1, 5, 180, 1),
(99, 'Б1.Б.7', 8, 18, 0, 0, 1, 18, 0, 36, 54, 0, 0, 3, 108, 2),
(100, 'Б1.Б.8', 9, 18, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 2),
(101, 'Б1.Б.9', 10, 18, 1, 0, 0, 36, 0, 36, 36, 0, 0, 4, 144, 2),
(102, 'Б1.Б.10', 11, 18, 1, 0, 0, 36, 0, 36, 72, 0, 0, 5, 180, 2),
(103, 'Б1.Б.26', 14, 18, 0, 1, 0, 0, 0, 18, 18, 0, 0, 1, 36, 1),
(104, 'Б1.В.ОД.1', 5, 18, 1, 0, 0, 36, 18, 18, 36, 0, 0, 4, 144, 1),
(105, 'Б1.В.ОД.2', 12, 18, 1, 0, 0, 36, 18, 18, 36, 0, 0, 4, 144, 2),
(106, 'Б1.В.ОД.3', 15, 18, 0, 0, 1, 36, 0, 36, 72, 0, 0, 4, 144, 2),
(107, 'Б1.В.ОД.4', 13, 18, 1, 0, 0, 36, 18, 18, 108, 0, 1, 6, 216, 2),
(108, '', 16, 18, 0, 0, 0, 0, 0, 72, 0, 0, 0, 0, 72, 1),
(109, '', 16, 18, 0, 1, 0, 0, 0, 90, 0, 0, 0, 0, 90, 2),
(110, 'Б1.Б.1', 1, 18, 0, 0, 1, 0, 0, 36, 72, 0, 0, 3, 108, 3),
(111, 'Б1.Б.1', 1, 18, 0, 0, 1, 0, 0, 36, 108, 0, 0, 5, 72, 4),
(112, 'Б1.Б.11', 26, 18, 1, 0, 0, 36, 0, 36, 36, 0, 0, 4, 144, 3),
(113, 'Б1.Б.12', 18, 18, 1, 0, 0, 36, 36, 0, 36, 0, 0, 4, 144, 3),
(114, 'Б1.Б.13', 25, 18, 1, 0, 0, 36, 36, 0, 72, 0, 0, 5, 180, 3),
(115, 'Б1.Б.14', 21, 18, 1, 0, 0, 36, 0, 36, 36, 0, 0, 4, 144, 4),
(116, 'Б1.Б.15', 23, 18, 1, 0, 0, 36, 36, 0, 36, 0, 0, 4, 144, 4),
(117, 'Б1.Б.26', 14, 18, 0, 1, 0, 0, 0, 18, 18, 0, 0, 1, 36, 4),
(118, 'Б1.В.ОД.5', 24, 18, 0, 0, 1, 18, 0, 36, 54, 0, 1, 3, 108, 3),
(119, 'Б1.В.ОД.6', 17, 18, 0, 0, 1, 36, 0, 18, 54, 0, 0, 3, 108, 3),
(120, 'Б1.В.ОД.7', 19, 18, 1, 0, 0, 36, 18, 0, 18, 0, 0, 3, 108, 3),
(121, 'Б1.В.ОД.8', 20, 18, 0, 0, 1, 36, 36, 0, 108, 0, 1, 5, 180, 3),
(122, 'Б1.В.ОД.9', 27, 18, 0, 0, 1, 18, 0, 36, 54, 0, 0, 3, 108, 4),
(123, 'Б1.В.ОД.10', 28, 18, 0, 0, 1, 36, 54, 18, 72, 0, 1, 5, 180, 4),
(124, 'Б1.В.ОД.11', 29, 18, 1, 0, 0, 36, 36, 18, 54, 1, 0, 5, 180, 4),
(125, '', 16, 18, 0, 1, 0, 0, 0, 90, 0, 0, 0, 0, 90, 3),
(126, '', 16, 18, 0, 0, 0, 0, 0, 76, 0, 0, 0, 0, 76, 4),
(127, 'Б1.В.ДВ.3.1', 58, 18, 0, 0, 1, 18, 18, 18, 54, 0, 0, 3, 108, 4),
(128, 'Б1.В.ДВ.3.2', 39, 18, 0, 0, 1, 18, 18, 18, 54, 0, 0, 3, 108, 4),
(129, 'Б1.Б.16', 31, 18, 1, 0, 0, 36, 36, 0, 36, 0, 0, 4, 144, 5),
(130, 'Б1.Б.17', 32, 18, 1, 0, 0, 36, 18, 0, 54, 0, 0, 4, 144, 5),
(131, 'Б1.Б.18', 85, 18, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 5),
(132, 'Б1.Б.19', 86, 18, 0, 0, 1, 18, 36, 18, 36, 0, 0, 3, 108, 6),
(133, 'Б1.Б.20', 87, 18, 0, 0, 1, 36, 54, 36, 90, 1, 0, 6, 216, 6),
(134, 'Б1.В.ОД.12', 35, 18, 0, 0, 1, 36, 0, 18, 54, 0, 0, 3, 108, 5),
(135, 'Б1.В.ОД.13', 36, 18, 0, 0, 1, 18, 36, 0, 90, 1, 0, 4, 144, 5),
(136, 'Б1.В.ОД.14', 37, 18, 1, 0, 0, 36, 36, 0, 72, 1, 0, 5, 180, 5),
(137, 'Б1.В.ОД.15', 38, 18, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 6),
(138, 'Б1.В.ОД.16', 66, 18, 0, 0, 1, 18, 36, 0, 54, 1, 0, 3, 108, 6),
(139, 'Б1.В.ОД.17', 40, 18, 0, 0, 1, 36, 36, 18, 54, 0, 0, 4, 144, 6),
(140, 'Б1.В.ДВ.1.1', 41, 18, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 5),
(141, 'Б1.В.ДВ.1.2', 42, 18, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 5),
(142, 'Б1.В.ДВ.1.3', 43, 18, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 5),
(143, 'Б1.В.ДВ.1.4', 44, 18, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 5),
(144, 'Б1.В.ДВ.1.5', 45, 18, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 5),
(145, 'Б1.В.ДВ.1.6', 46, 18, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 5),
(146, 'Б1.В.ДВ.1.7', 47, 18, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 5),
(147, 'Б1.В.ДВ.1.8', 48, 18, 0, 0, 1, 18, 0, 18, 36, 0, 0, 2, 72, 5),
(148, 'Б1.В.ДВ.2.1', 49, 18, 0, 0, 1, 18, 0, 18, 72, 0, 0, 3, 108, 6),
(149, 'Б1.В.ДВ.2.2', 50, 18, 0, 0, 1, 18, 0, 18, 72, 0, 0, 3, 108, 6),
(150, 'Б1.В.ДВ.2.3', 51, 18, 0, 0, 1, 18, 0, 18, 72, 0, 0, 3, 108, 6),
(151, 'Б1.В.ДВ.2.4', 52, 18, 0, 0, 1, 18, 0, 18, 72, 0, 0, 3, 108, 6),
(152, 'Б1.В.ДВ.2.5', 53, 18, 0, 0, 1, 18, 0, 18, 72, 0, 0, 3, 108, 6),
(153, 'Б1.В.ДВ.2.6', 54, 18, 0, 0, 1, 18, 0, 18, 72, 0, 0, 3, 108, 6),
(154, 'Б1.В.ДВ.2.7', 55, 18, 0, 0, 1, 18, 0, 18, 72, 0, 0, 3, 108, 6),
(155, 'Б1.В.ДВ.2.8', 56, 18, 0, 0, 1, 18, 0, 18, 72, 0, 0, 3, 108, 6),
(156, 'Б1.В.ДВ.2.9', 57, 18, 0, 0, 1, 18, 0, 18, 72, 0, 0, 3, 108, 6),
(157, 'Б1.В.ДВ.4.1', 61, 18, 1, 0, 0, 18, 18, 18, 18, 0, 0, 3, 108, 5),
(158, 'Б1.В.ДВ.4.2', 60, 18, 1, 0, 0, 18, 18, 18, 18, 0, 0, 3, 108, 5),
(159, 'Б1.В.ДВ.5.1', 63, 18, 0, 0, 1, 18, 36, 18, 36, 0, 0, 3, 108, 6),
(160, 'Б1.В.ДВ.5.2', 64, 18, 0, 0, 1, 18, 36, 18, 36, 0, 0, 3, 108, 6),
(161, 'Б1.В.ДВ.8.1', 65, 18, 0, 0, 1, 18, 18, 18, 54, 0, 0, 3, 108, 5),
(162, 'Б1.В.ДВ.8.2', 88, 18, 0, 0, 1, 18, 18, 18, 54, 0, 0, 3, 108, 5),
(163, 'Б1.В.ДВ.8.3', 73, 18, 0, 0, 1, 18, 18, 18, 54, 0, 0, 3, 108, 5),
(164, 'Б1.Б.21', 67, 18, 0, 0, 1, 18, 18, 18, 54, 0, 0, 3, 108, 7),
(165, 'Б1.Б.22', 69, 18, 1, 0, 0, 18, 36, 18, 72, 0, 0, 5, 180, 7),
(166, 'Б1.Б.23', 89, 18, 0, 0, 1, 18, 36, 0, 54, 0, 0, 3, 108, 7),
(167, 'Б1.Б.24', 90, 18, 0, 0, 1, 18, 36, 0, 54, 0, 0, 3, 108, 7),
(168, 'Б1.Б.25', 91, 18, 1, 0, 0, 18, 18, 18, 18, 0, 0, 3, 108, 7),
(169, 'Б1.В.ОД.18', 70, 18, 0, 0, 1, 18, 18, 18, 54, 0, 0, 3, 108, 7),
(170, 'Б1.В.ОД.20', 92, 18, 0, 0, 1, 22, 22, 11, 53, 0, 0, 3, 108, 8),
(171, 'Б1.В.ДВ.6.1', 77, 18, 1, 0, 0, 18, 36, 18, 36, 0, 0, 4, 144, 7),
(172, 'Б1.В.ДВ.6.2', 78, 18, 1, 0, 0, 18, 36, 18, 36, 0, 0, 4, 144, 7),
(173, 'Б1.В.ДВ.7.1', 81, 18, 0, 0, 1, 22, 44, 11, 67, 0, 0, 4, 144, 8),
(174, 'Б1.В.ДВ.7.2', 82, 18, 0, 0, 1, 22, 44, 11, 67, 0, 0, 4, 144, 8),
(175, 'Б1.В.ДВ.9.1', 79, 18, 1, 0, 0, 18, 36, 18, 36, 0, 0, 4, 144, 7),
(176, 'Б1.В.ДВ.9.2', 80, 18, 1, 0, 0, 18, 36, 18, 36, 0, 0, 4, 144, 7),
(177, 'Б1.В.ДВ.10.1', 83, 18, 0, 0, 1, 22, 33, 22, 31, 0, 0, 3, 108, 8),
(178, 'Б1.В.ДВ.10.2', 84, 18, 0, 0, 1, 22, 33, 22, 31, 0, 0, 3, 108, 8),
(179, 'Б1.В.ДВ.11.1', 93, 18, 0, 0, 1, 22, 44, 11, 103, 1, 0, 5, 180, 8),
(180, 'Б1.В.ДВ.11.2', 94, 18, 0, 0, 1, 22, 44, 11, 103, 1, 0, 5, 180, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `demo_material_consultantion`
--

CREATE TABLE IF NOT EXISTS `demo_material_consultantion` (
  `id_demo_material_consultantion` int(11) NOT NULL AUTO_INCREMENT,
  `id_group` int(11) NOT NULL,
  `id_teacher` int(11) NOT NULL,
  PRIMARY KEY (`id_demo_material_consultantion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `diplom`
--

CREATE TABLE IF NOT EXISTS `diplom` (
  `diplom_id` int(11) NOT NULL AUTO_INCREMENT,
  `diplom_theme` varchar(256) NOT NULL,
  `id_teacher` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`diplom_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `diplom`
--

INSERT INTO `diplom` (`diplom_id`, `diplom_theme`, `id_teacher`) VALUES
(1, 'Разработка средств автоматизированного заполнения листов учета рабочего времени в матричной организации', 101),
(2, 'Автоматизация процесса управления материальными ценностями кафедры МО ЭВМ', 125),
(3, 'Программная система организации учебного процесса на кафедре физического воспитания и спорта', 125),
(4, 'Автоматизация поддержки научно-исследовательской деятельности кафедры МО ЭВМ', 125),
(5, 'Автоматизация процесса организации итоговой государственной аттестации на кафедре МО ЭВМ', 125),
(6, 'Реализация системы мониторинга и анализа упоминаний бренда в социальных медиа', 117),
(8, 'Система распознавания лиц в видеопотоках на основе метода Виолы-Джонса и локальных бинарных шаблонов', 0),
(12, 'Какая-то тема ВКР', 129),
(13, 'Тема ВКР', 119),
(14, 'Вычисление линейных скоростей объекта посредством сенсоров  движения на базе МЭМС', 129),
(15, 'Использование Unity для разработки сцен виртуальной реальности', 117),
(16, 'Разработка группового планировщика ввода-вывода блочных устройств для Linux', 132),
(17, 'Исследование работы X3DOM приложений с полномасштабными веб-серверами', 128);

-- --------------------------------------------------------

--
-- Структура таблицы `direction`
--

CREATE TABLE IF NOT EXISTS `direction` (
  `idDirection` int(11) NOT NULL AUTO_INCREMENT,
  `DirectionCode` varchar(8) DEFAULT NULL,
  `DirectionName` varchar(100) DEFAULT NULL,
  `Faculty` int(11) DEFAULT NULL,
  `ref_the_best_students` VARCHAR(100) DEFAULT NULL,
  `ref_report_head` VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (`idDirection`),
  UNIQUE KEY `DirectionCode_UNIQUE` (`DirectionCode`),
  KEY `Faculty_idx` (`Faculty`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `direction`
--

INSERT INTO `direction` (`idDirection`, `DirectionCode`, `DirectionName`, `Faculty`) VALUES
(1, '01.03.02', 'Прикладная математика и информатика', 1),
(2, '09.03.04', 'Программная инженерия', 1),
(3, '01.04.02', 'Прикладная математика и информатика', NULL),
(4, '09.04.04', 'Программная инженерия', NULL),
(6, '11.04.01', 'Радиотехника', 2),
(7, '23.45.67', 'Биотехнические системы и технологии', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `direction_member_gak`
--

CREATE TABLE IF NOT EXISTS `direction_member_gak` (
  `id_direction_mamber_gak` int(11) NOT NULL AUTO_INCREMENT,
  `id_member_gak` int(11) NOT NULL,
  `id_direction` int(11) NOT NULL,
  PRIMARY KEY (`id_direction_mamber_gak`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `direction_member_gak`
--

INSERT INTO `direction_member_gak` (`id_direction_mamber_gak`, `id_member_gak`, `id_direction`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(5, 7, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `discipline`
--

CREATE TABLE IF NOT EXISTS `discipline` (
  `idDiscipline` int(11) NOT NULL AUTO_INCREMENT,
  `DisShortName` varchar(20) DEFAULT NULL,
  `DisFullName` varchar(100) DEFAULT NULL,
  `Chair` int(11) DEFAULT NULL,
  PRIMARY KEY (`idDiscipline`),
  UNIQUE KEY `DisShortName_UNIQUE` (`DisShortName`),
  UNIQUE KEY `DisShortName_2` (`DisShortName`),
  KEY `Chair_idx` (`Chair`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=95 ;

--
-- Дамп данных таблицы `discipline`
--

INSERT INTO `discipline` (`idDiscipline`, `DisShortName`, `DisFullName`, `Chair`) VALUES
(1, NULL, 'Иностранный язык', 2),
(2, NULL, 'Философия', 3),
(3, NULL, 'Математический анализ', 4),
(4, NULL, 'Алгебра и геометрия', 4),
(5, NULL, 'Механика и термодинамика', 9),
(6, NULL, 'Информатика', 1),
(7, '', 'Программирование', 1),
(8, NULL, 'История', 5),
(9, NULL, 'Экономическая теория', 6),
(10, NULL, 'Алгебра и геометрия. Дополнительные главы', 4),
(11, NULL, 'Дискретная математика', 4),
(12, NULL, 'Электричество и магнетизм', 9),
(13, NULL, 'Программирование. Дополнительные главы', 1),
(14, NULL, 'Физическая культура', 8),
(15, NULL, 'Математический анализ. Дополнительные главы', 4),
(16, NULL, 'Элективные курсы по физической культуре', 8),
(17, NULL, 'Специальные разделы математического анализа', 4),
(18, NULL, 'Вычислительная математика', 1),
(19, NULL, 'Оптика и атомная физика', 9),
(20, NULL, 'Алгоритмы и структуры данных', 1),
(21, NULL, 'Теория вероятностей и математическая статистика', 4),
(22, NULL, 'Комплексный анализ', 4),
(23, NULL, 'Операционные системы', 1),
(24, NULL, 'Экономика организации', 10),
(25, NULL, 'Архитектура компьютера', 1),
(26, NULL, 'Математическая логика и теория алгоритмов', 4),
(27, NULL, 'Организация производства и управление предприятием', 11),
(28, NULL, 'Построение и анализ алгоритмов', 1),
(29, NULL, 'Объектно-ориентированное программирование', 1),
(30, NULL, 'Теория вероятностей и математическая статистика. Дополнительные главы', 4),
(31, NULL, 'Базы данных', 1),
(32, NULL, 'Архитектура распределенных вычислительных систем', 1),
(33, NULL, 'Элементы функционального анализа', 4),
(34, NULL, 'Дифференциальные уравнения', 4),
(35, NULL, 'Правоведение', 5),
(36, NULL, 'Компьютерная графика', 1),
(37, NULL, 'Web-технологии', 1),
(38, NULL, 'Социология', 12),
(39, NULL, 'Методы оптимизации', 1),
(40, NULL, 'Сети и телекоммуникации', 1),
(41, NULL, 'Мировая культура: история и современность', 5),
(42, NULL, 'Организационное поведение', 12),
(43, NULL, 'Психология личности. Теория и практика самопознания', 3),
(44, NULL, 'Профессиональная этика', 3),
(45, NULL, 'Основы обеспечения качества', 14),
(46, NULL, 'Маркетинг', 11),
(47, NULL, 'Управление личными финансами', 10),
(48, NULL, 'Основы бизнеса', 6),
(49, NULL, 'Межличностное общение', 12),
(50, NULL, 'Русский язык и культура речи', 15),
(51, NULL, 'Теория и практика аргументации', 3),
(52, NULL, 'Психология делового общения', 3),
(53, NULL, 'Управленческие решения', 14),
(54, NULL, 'Основы управления коллективом', 11),
(55, NULL, 'Бизнес-планирование', 10),
(56, NULL, 'Рынок ценных бумаг', 6),
(57, NULL, 'Коммерческое право', 14),
(58, NULL, 'Специальные разделы алгебры', 4),
(59, NULL, 'Математические пакеты', 4),
(60, NULL, 'Физические основы информационных технологий', 9),
(61, NULL, 'Математические основы электротехники', 16),
(62, NULL, 'Теория игр и исследование операций', 1),
(63, NULL, 'Теория вычислительной сложности', 1),
(64, NULL, 'Верификация программ', 1),
(65, NULL, 'Основы цифровой схемотехники', 17),
(66, NULL, 'Разработка прикладного программного обеспечения с графическим интерфейсом', 1),
(67, NULL, 'Безопасность жизнедеятельности', 7),
(68, NULL, 'Уравнения математической физики', 4),
(69, NULL, 'Теория автоматов и формальных языков', 1),
(70, NULL, 'Криптография и защита информации', 13),
(71, NULL, 'Технология разработки программных систем', 1),
(72, NULL, 'Статистические методы обработки экспериментальных данных', 1),
(73, NULL, 'Параллельные алгоритмы', 1),
(74, NULL, 'Численные методы линейной алгебры', 4),
(75, NULL, 'Базы знаний и экспертные системы', 1),
(76, NULL, 'Вычислительная физика', 9),
(77, NULL, 'Функциональное программирование', 1),
(78, NULL, 'Цифровая обработка сигналов', 1),
(79, NULL, 'Разработка программного обеспечения информационных систем', 1),
(80, NULL, 'Основы технологий хранения данных', 1),
(81, NULL, 'Распределенные алгоритмы', 1),
(82, NULL, 'Теория принятия решений', 1),
(83, NULL, 'Логическое программирование', 1),
(84, NULL, 'Цифровая обработка изображений', 1),
(85, NULL, 'Введение в программную инженерию', 1),
(86, NULL, 'Проектирование человеко-машинного интерфейса', 1),
(87, NULL, 'Спецификация, проектирование и архитектура программных систем', 1),
(88, NULL, 'Программирование на Ассемблере', 1),
(89, NULL, 'Конструирование программного обеспечения', 1),
(90, NULL, 'Тестирование программного обеспечения', 1),
(91, NULL, 'Управление разработкой и экономика программных проектов', 1),
(92, NULL, 'Качество и метрология программного обеспечения', 1),
(93, NULL, 'Разработка приложений для мобильных платформ', 1),
(94, NULL, 'Технологии программирования виртуальной реальности', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `extraload`
--

CREATE TABLE IF NOT EXISTS `extraload` (
  `idExtraLoad` int(11) NOT NULL AUTO_INCREMENT,
  `ExtraLoadKind` int(11) DEFAULT NULL,
  `Teacher` int(11) DEFAULT NULL,
  `Hour` smallint(5) unsigned DEFAULT NULL,
  `Semestr` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`idExtraLoad`),
  KEY `ExtraLoadKind_idx` (`ExtraLoadKind`),
  KEY `Teacher_idx` (`Teacher`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `extraloadkind`
--

CREATE TABLE IF NOT EXISTS `extraloadkind` (
  `idExtraLoadKind` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) DEFAULT NULL,
  `Standart` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idExtraLoadKind`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `extraloadkind`
--

INSERT INTO `extraloadkind` (`idExtraLoadKind`, `Name`, `Standart`) VALUES
(1, 'Руководство аспирантом', '50 ч в год'),
(2, 'Руководство стажером', '50 ч в год'),
(3, 'ВКР магистра', '50 ч в год'),
(4, 'ВКР бакалавра', '30 ч в год');

-- --------------------------------------------------------

--
-- Структура таблицы `faculty`
--

CREATE TABLE IF NOT EXISTS `faculty` (
  `idFaculty` int(11) NOT NULL AUTO_INCREMENT,
  `FacultyNum` tinyint(4) DEFAULT NULL,
  `FacultyShortName` varchar(20) DEFAULT NULL,
  `FacultyFullName` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idFaculty`),
  UNIQUE KEY `FucultyNum_UNIQUE` (`FacultyNum`),
  UNIQUE KEY `FacultyShortName_UNIQUE` (`FacultyShortName`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `faculty`
--

INSERT INTO `faculty` (`idFaculty`, `FacultyNum`, `FacultyShortName`, `FacultyFullName`) VALUES
(1, 3, 'ФКТИ', 'Факультет компьютерных технологий и информатики'),
(2, 1, 'ФРТ', 'Факультет радиотехники и телекоммуникаций'),
(3, 2, 'ФЭЛ', 'Факультет электроники'),
(4, 4, 'ФЭА', 'Факультет электротехники и автоматики'),
(5, 5, 'ФИБС', 'Факультет информационно-измерительных и биотехнических систем'),
(6, 6, 'ФЭМ', 'Факультет экономики и менеджмента'),
(7, 7, 'ГФ', 'Гуманитарный факультет');



-- --------------------------------------------------------

--
-- Структура таблицы `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `idGroup` int(11) NOT NULL AUTO_INCREMENT,
  `GroupNum` smallint(4) unsigned NOT NULL,
  `Size` tinyint(2) unsigned DEFAULT NULL,
  `CreationYear` year(4) DEFAULT NULL,
  `E-mail` varchar(45) DEFAULT NULL,
  `Curriculum` int(11) DEFAULT NULL,
  `Head` int(11) DEFAULT NULL,
  PRIMARY KEY (`idGroup`),
  UNIQUE KEY `GroupNum_UNIQUE` (`GroupNum`),
  KEY `Head_idx` (`Head`),
  KEY `Curriculum` (`Curriculum`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `group`
--

INSERT INTO `group` (`idGroup`, `GroupNum`, `Size`, `CreationYear`, `E-mail`, `Curriculum`, `Head`) VALUES
(1, 2382, 15, 2012, NULL, 1, NULL),
(2, 1382, NULL, 2011, NULL, 12, NULL),
(3, 1303, NULL, 2011, NULL, 16, NULL),
(5, 2304, NULL, 2012, NULL, NULL, NULL),
(6, 3304, NULL, 2013, NULL, NULL, NULL),
(7, 3381, 19, 2013, 'email', 1, 116),
(11, 3382, 18, 2013, 'email3382@mail.ru', 1, 63),
(12, 2101, 15, 2012, 'group2101@mail.ru', 19, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `hallload`
--

CREATE TABLE IF NOT EXISTS `hallload` (
  `idHallLoad` int(11) NOT NULL AUTO_INCREMENT,
  `Discipline` int(11) DEFAULT NULL,
  `Teacher` int(11) DEFAULT NULL,
  `Group` int(11) DEFAULT NULL,
  `Semestr` tinyint(3) unsigned DEFAULT NULL,
  `Lec` smallint(3) DEFAULT NULL,
  `Pract` smallint(3) DEFAULT NULL,
  `Lab` smallint(3) DEFAULT NULL,
  `CourseWork` smallint(3) DEFAULT NULL,
  `CourseProject` tinyint(1) DEFAULT NULL,
  `Exam` tinyint(1) DEFAULT NULL,
  `CreditWithGrade` tinyint(1) DEFAULT NULL,
  `CreditW/OGrade` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idHallLoad`),
  KEY `Discipline_idx` (`Discipline`),
  KEY `Teacher_idx` (`Teacher`),
  KEY `Group_idx` (`Group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `hallloadkind`
--

CREATE TABLE IF NOT EXISTS `hallloadkind` (
  `idHallLoadKind` int(11) NOT NULL AUTO_INCREMENT,
  `HallLoadName` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idHallLoadKind`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `individualplan`
--

CREATE TABLE IF NOT EXISTS `individualplan` (
  `idIndividualPlan` int(11) NOT NULL AUTO_INCREMENT,
  `WordFile` varchar(255) DEFAULT NULL,
  `ExcelFile` varchar(255) DEFAULT NULL,
  `WordCopy` varchar(255) DEFAULT NULL,
  `ExcelCopy` varchar(255) DEFAULT NULL,
  `Teacher` int(11) DEFAULT NULL,
  `AcademicYear` varchar(9) DEFAULT NULL,
  PRIMARY KEY (`idIndividualPlan`),
  UNIQUE KEY `WordFile_UNIQUE` (`WordFile`),
  UNIQUE KEY `ExcelFile_UNIQUE` (`ExcelFile`),
  KEY `Teacher_idx` (`Teacher`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `individualplan`
--

INSERT INTO `individualplan` (`idIndividualPlan`, `WordFile`, `ExcelFile`, `WordCopy`, `ExcelCopy`, `Teacher`, `AcademicYear`) VALUES
(4, 'public://documents/individual_plans/1/20160529222831.doc', 'public://documents/individual_plans/1/20160529222831.xls', 'public://documents/individual_plans/1/20160530122738_copy.doc', 'public://documents/individual_plans/1/20160530122738_copy.xls', NULL, '2016-2017'),
(5, 'public://documents/individual_plans/150/20160606100122.doc', 'public://documents/individual_plans/150/20160606100123.xls', 'public://documents/individual_plans/150/20160606100122_0.doc', 'public://documents/individual_plans/150/20160606100123_0.xls', 150, '2016-2017');

-- --------------------------------------------------------

--
-- Структура таблицы `magistercurriculum`
--

CREATE TABLE IF NOT EXISTS `magistercurriculum` (
  `idMagisterCurriculum` int(11) NOT NULL AUTO_INCREMENT,
  `Curriculum` int(11) DEFAULT NULL,
  `Program` int(11) DEFAULT NULL,
  PRIMARY KEY (`idMagisterCurriculum`),
  KEY `Curriculum_idx` (`Curriculum`),
  KEY `MagisterProgram_idx` (`Program`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `magisterprogram`
--

CREATE TABLE IF NOT EXISTS `magisterprogram` (
  `idMagisterProgram` int(11) NOT NULL AUTO_INCREMENT,
  `ProgramCode` varchar(11) DEFAULT NULL,
  `ProgramName` varchar(100) DEFAULT NULL,
  `Direction` int(11) DEFAULT NULL,
  PRIMARY KEY (`idMagisterProgram`),
  UNIQUE KEY `ProgramCode_UNIQUE` (`ProgramCode`),
  KEY `Direction_idx` (`Direction`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `member_gak`
--

CREATE TABLE IF NOT EXISTS `member_gak` (
  `id_member_gak` int(11) NOT NULL AUTO_INCREMENT,
  `passport_member_gak` varchar(10) NOT NULL,
  `surname_member_gak` varchar(45) NOT NULL,
  `first_name_member_gak` varchar(45) NOT NULL,
  `patronymic_member_gak` varchar(45) NOT NULL,
  `mobile` varchar(16) NOT NULL,
  `work_hone` varchar(9) NOT NULL,
  `email` varchar(45) NOT NULL,
  `address` varchar(150) NOT NULL,
  `who_is_in_gak` varchar(64) NOT NULL,
  `work` varchar(64) NOT NULL,
  PRIMARY KEY (`id_member_gak`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `member_gak`
--

INSERT INTO `member_gak` (`id_member_gak`, `passport_member_gak`, `surname_member_gak`, `first_name_member_gak`, `patronymic_member_gak`, `mobile`, `work_hone`, `email`, `address`, `who_is_in_gak`, `work`) VALUES
(1, '4000100333', 'Петров', 'Василий', 'Петрович', '', '', '', '', 'Председатель', ''),
(2, '4000100339', 'Михайлова', 'Анастасия', 'Львовна', '', '', '', '', 'Член комиссии', ''),
(3, '4000100343', 'Фомичёва', 'Татьяна', 'Генриховна', '', '', '', '', 'Секретарь ГЭК', ''),
(7, '3001234098', 'Шолохов', 'Евгений', 'Петрович', '', '', '', '', 'Член комиссии', '');

-- --------------------------------------------------------


--
-- Структура таблицы `reviewer`
--

CREATE TABLE IF NOT EXISTS `reviewer` (
  `idReviewer` int(11) NOT NULL AUTO_INCREMENT,
  `Passport` varchar(10) NOT NULL,
  `Surname` varchar(45) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `Patronymic` varchar(45) NOT NULL,
  `Initials` varchar(20) NOT NULL,
  `Degree` varchar(20) NOT NULL,
  `E-mail` varchar(20) NOT NULL,
  PRIMARY KEY (`idReviewer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Структура таблицы `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `idStudent` int(11) NOT NULL AUTO_INCREMENT,
  `Passport` varchar(10) DEFAULT NULL,
  `RecordBookNum` mediumint(6) unsigned NOT NULL,
  `Surname` varchar(50) DEFAULT NULL,
  `FirstName` varchar(30) DEFAULT NULL,
  `Patronymic` varchar(50) DEFAULT NULL,
  `Group` int(11) DEFAULT NULL,
  `E-mail` varchar(45) DEFAULT NULL,
  `Address` varchar(150) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `EnrollmentDate` date DEFAULT NULL,
  `ExpelDate` date DEFAULT NULL,
  `percent_3` int(11) NOT NULL DEFAULT '0',
  `percent_4` int(11) NOT NULL DEFAULT '0',
  `percent_5` int(11) NOT NULL DEFAULT '0',
  `percent_plagiat` int(11) NOT NULL DEFAULT '0',
  `id_AS` int(11) NOT NULL,
  PRIMARY KEY (`idStudent`),
  UNIQUE KEY `RecordBookNum_UNIQUE` (`RecordBookNum`),
  KEY `Group_idx` (`Group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=136 ;

--
-- Дамп данных таблицы `student`
--

INSERT INTO `student` (`idStudent`, `Passport`, `RecordBookNum`, `Surname`, `FirstName`, `Patronymic`, `Group`, `E-mail`, `Address`, `Phone`, `EnrollmentDate`, `ExpelDate`, `percent_3`, `percent_4`, `percent_5`, `percent_plagiat`, `id_AS`) VALUES
(2, '4909898274', 238204, 'Владимирова', 'Анна', 'Андреевна', 1, 'myemail@email.com', 'ул. Торжковская, д. 15', '+7-911-036-21-57', '2012-08-01', '2016-06-30', 0, 0, 0, 0, 0),
(60, NULL, 338213, 'Бакаев', 'Илья', 'Олегович', 11, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(61, NULL, 338231, 'Башкирев', 'Владислав', 'Сергеевич', 11, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(62, NULL, 338214, 'Борисов', 'Максим', 'Олегович', 11, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(63, NULL, 338204, 'Ваулина', 'Яна', 'Алексеевна', 11, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(64, NULL, 338216, 'Гриднева', 'Кристина', 'Николаевна', 11, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(65, NULL, 338220, 'Иванов', 'Ростислав', 'Арзуевич', 11, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(66, NULL, 338221, 'Калюжный', 'Александр', 'Вячеславович', 11, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(67, NULL, 338233, 'Коляков', 'Александр', 'Александрович', 11, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(68, NULL, 338205, 'Компанищенко', 'Никита', 'Вадимович', 11, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(69, NULL, 338222, 'Крень', 'Анастасия', 'Владимировна', 11, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(70, NULL, 338206, 'Левшин', 'Павел', 'Игоревич', 11, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(71, NULL, 338227, 'Ледяев', 'Иван', 'Сергеевич', 11, 'sefjslg@kfk.com', NULL, NULL, '1900-01-01', '1900-01-01', 0, 0, 0, 0, 0),
(72, NULL, 338223, 'Мельников', 'Никита', 'Алексеевич', 11, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(73, '', 338207, 'Ольчиков', 'Илья', 'Александрович', 11, 'ilyaolchikov@mail.ru', '', '', NULL, NULL, 0, 0, 0, 0, 1),
(74, NULL, 338208, 'Патрушев', 'Дмитрий', 'Леонидович', 11, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(75, NULL, 338209, 'Переверзев', 'Евгений', 'Александрович', 11, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(76, NULL, 338210, 'Смолина', 'Софья', 'Константиновна', 11, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(77, NULL, 338212, 'Фанифатьева', 'Алена', 'Дмитриевна', 11, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(116, NULL, 338107, 'Аббасова', 'Юлия', 'Исфандияровна', 7, 'juli@mail.ru', NULL, NULL, '2013-08-01', '1900-01-01', 0, 0, 0, 0, 0),
(117, NULL, 338103, 'Алаёров', 'Шохинджон', 'Шарифмуродович', 7, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(118, NULL, 338108, 'Божко', 'Дмитрий', 'Юрьевич', 7, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(119, NULL, 338109, 'Борисов', 'Александр', 'Сергеевич', 7, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(120, NULL, 338111, 'Герасимов', 'Александр', 'Николаевич', 7, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(121, NULL, 338112, 'Гороховик', 'Никита', 'Сергеевич', 7, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(122, NULL, 338113, 'Дугина', 'Александра', 'Владимировна', 7, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(124, NULL, 338104, 'Козей', 'Алексей', 'Вадимович', 7, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(125, NULL, 338128, 'Леончик', 'Александр', 'Викторович', 7, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(126, NULL, 338105, 'Лешкевич', 'Василий', 'Владимирович', 7, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(127, NULL, 338118, 'Мазелюк', 'Алексей', 'Николаевич', 7, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(128, NULL, 338119, 'Михнович', 'Анастасия', 'Георгиевна', 7, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(129, NULL, 338120, 'Нестеркова', 'Евгения', 'Петровна', 7, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(130, NULL, 338106, 'Семенчук', 'Денис', 'Викторович', 7, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(131, NULL, 338122, 'Ступак', 'Александр', 'Дмитриевич', 7, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(132, NULL, 338123, 'Сучков', 'Андрей', 'Игоревич', 7, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(133, NULL, 338124, 'Федоров', 'Андрей', 'Михайлович', 7, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(134, NULL, 338125, 'Ханукашвили', 'Валерия', 'Дмитриевна', 7, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(135, NULL, 338170, 'Иванов', 'Иван', 'Иванович', 7, 'ivanovivan@gmail.com', NULL, NULL, '2016-06-04', NULL, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `student_additional_section`
--

CREATE TABLE IF NOT EXISTS `student_additional_section` (
  `student_additional_section` int(11) NOT NULL AUTO_INCREMENT,
  `id_student` int(11) NOT NULL,
  `id_additional_section` int(11) NOT NULL,
  PRIMARY KEY (`student_additional_section`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `student_additional_section`
--

INSERT INTO `student_additional_section` (`student_additional_section`, `id_student`, `id_additional_section`) VALUES
(1, 72, 2),
(2, 73, 1),
(3, 63, 1),
(4, 69, 2),
(5, 116, 1),
(6, 63, 1),
(7, 63, 1),
(8, 116, 1),
(9, 116, 1),
(10, 116, 1),
(11, 116, 1),
(12, 116, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `student_consultant_as`
--

CREATE TABLE IF NOT EXISTS `student_consultant_as` (
  `id_student_consultant_AS` int(11) NOT NULL AUTO_INCREMENT,
  `id_student` int(11) DEFAULT NULL,
  `id_consultant_AS` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_student_consultant_AS`),
  UNIQUE KEY `id_student` (`id_student`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `student_consultant_as`
--

INSERT INTO `student_consultant_as` (`id_student_consultant_AS`, `id_student`, `id_consultant_AS`) VALUES
(1, 73, 2),
(2, 72, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `student_consultant_company`
--

CREATE TABLE IF NOT EXISTS `student_consultant_company` (
  `id_student_consultant_company` int(11) NOT NULL AUTO_INCREMENT,
  `id_student` int(10) DEFAULT NULL,
  `id_consultant_company` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_student_consultant_company`),
  UNIQUE KEY `Student_UNIQUE` (`id_student`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `student_consultant_company`
--

INSERT INTO `student_consultant_company` (`id_student_consultant_company`, `id_student`, `id_consultant_company`) VALUES
(1, 62, 1),
(2, 71, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `student_reviewer`
--

CREATE TABLE IF NOT EXISTS `student_reviewer` (
  `id_student_reviewer` int(11) NOT NULL AUTO_INCREMENT,
  `id_student` int(10) DEFAULT NULL,
  `id_reviewer` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_student_reviewer`),
  UNIQUE KEY `Student_UNIQUE` (`id_student`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------


--
-- Структура таблицы `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `idTeacher` int(11) NOT NULL AUTO_INCREMENT,
  `Passport` varchar(10) DEFAULT NULL,
  `Surname` varchar(45) DEFAULT NULL,
  `FirstName` varchar(20) DEFAULT NULL,
  `Patronymic` varchar(45) DEFAULT NULL,
  `Initials` varchar(20) DEFAULT NULL,
  `Position` varchar(45) DEFAULT NULL,
  `ShareRates` decimal(3,2) DEFAULT NULL,
  `Degree` varchar(20) DEFAULT NULL,
  `Rank` varchar(15) DEFAULT NULL,
  `HomePhone` varchar(9) DEFAULT NULL,
  `Mobile` varchar(16) DEFAULT NULL,
  `WorkPhone` varchar(9) DEFAULT NULL,
  `E-mail` varchar(45) DEFAULT NULL,
  `Address` varchar(150) DEFAULT NULL,
  `BirthDate` date DEFAULT NULL,
  `Contract` varchar(45) DEFAULT NULL,
  `ConclusionDate` date DEFAULT NULL,
  `TerminationDate` date DEFAULT NULL,
  `Condition` varchar(20) DEFAULT NULL,
  `EffectiveContract` tinyint(1) DEFAULT NULL,
  `Notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idTeacher`),
  UNIQUE KEY `Passport_UNIQUE` (`Passport`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=151 ;

--
-- Дамп данных таблицы `teacher`
--

INSERT INTO `teacher` (`idTeacher`, `Passport`, `Surname`, `FirstName`, `Patronymic`, `Initials`, `Position`, `ShareRates`, `Degree`, `Rank`, `HomePhone`, `Mobile`, `WorkPhone`, `E-mail`, `Address`, `BirthDate`, `Contract`, `ConclusionDate`, `TerminationDate`, `Condition`, `EffectiveContract`, `Notes`) VALUES
(99, NULL, 'Григорьев', 'Ю.', 'Д.', '', 'профессор', '1.00', ' д.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100, NULL, 'Кухарев', 'Г.', 'А.', '', 'профессор', '0.50', ' д.н.', '', NULL, NULL, NULL, '', NULL, NULL, '', '1900-01-01', '1900-01-01', '', 0, ''),
(101, NULL, 'Лисс', 'А.', 'Р.', '', 'профессор', '0.50', ' д.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(103, NULL, 'Экало', 'А.', 'В.', '', 'профессор', '0.50', ' д.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-09-01', '2016-06-01', NULL, NULL, NULL),
(104, NULL, 'Балтрашевич', 'В.', 'Э.', '', 'доцент', '0.75', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(105, NULL, 'Беляев', 'С.', 'А.', '', 'доцент', '0.50', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(106, NULL, 'Большев', 'А.', 'К.', '', 'доцент', '0.75', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(107, NULL, 'Варлинский', 'Н.', 'Н.', '', 'доцент', '0.50', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(108, NULL, 'Васькин', 'П.', 'И.', '', 'доцент', '0.25', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2013-09-06', '2016-10-06', NULL, NULL, NULL),
(109, NULL, 'Голубев', 'А.', 'Б.', '', 'доцент', '0.50', 'к.н. ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(110, NULL, 'Губкин', 'А.', 'Ф.', '', 'доцент', '0.50', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(111, NULL, 'Жукова', 'Н.', 'А.', '', 'доцент', '0.50', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(112, NULL, 'Карпов', 'Ю.', 'Г.', '', 'доцент', '0.50', ' д.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(113, NULL, 'Кафтасьев', 'В.', 'Н.', '', 'доцент', '0.75', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(114, NULL, 'Кирьянчиков', 'В.', 'А.', '', 'доцент', '1.00', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(115, NULL, 'Клионский', 'Д.', 'М.', '', 'доцент', '0.50', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(116, NULL, 'Кринкин', 'К.', 'В.', '', 'Зав.кафедрой', '1.00', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(117, NULL, 'Лисс', 'А.', 'А.', '', 'доцент', '1.00', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(118, NULL, 'Первицкий', 'А.', 'Ю.', '', 'доцент', '0.75', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(119, NULL, 'Романенко', 'С.', 'А.', '', 'доцент', '0.50', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(120, NULL, 'Романцев', 'В.', 'В.', '', 'доцент', '0.50', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(121, NULL, 'Самойленко', 'В.', 'П.', '', 'доцент', '0.50', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(122, NULL, 'Сидоров', 'Ю.', 'Н.', '', 'доцент', '1.00', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(123, NULL, 'Спицын', 'А.', 'В.', '', 'доцент', '0.50', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(124, NULL, 'Татаринов', 'Ю.', 'С.', '', 'доцент', '0.50', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(125, '', 'Фомичева', 'Т.', 'Г.', '', 'доцент', '1.00', 'к.н.', '', '', '78912352546', '', 'example@mail.com', '', '1900-01-01', 'пост.', '1900-01-01', '1900-01-01', '', 0, ''),
(126, NULL, 'Чебоксарова', 'Т.', 'Г.', '', 'доцент', '0.50', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(127, NULL, 'Чередниченко', 'А.', 'И.', '', 'доцент', '0.75', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(128, NULL, 'Щеголева', 'Н.', 'Л.', '', 'доцент', '0.75', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(129, NULL, 'Яновский', 'В.', 'В.', '', 'доцент', '1.00', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(130, NULL, 'Яценко', 'И.', 'В.', '', 'доцент', '0.75', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131, NULL, 'Мальцева', 'Н.', 'В.', '', 'доцент', '0.25', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(132, NULL, 'Герасимова', 'Т.', 'В.', '', 'ст.препод.', '1.00', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(133, NULL, 'Черниченко', 'Д.', 'А.', '', 'ассистент', '0.25', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(134, NULL, 'Лавров', 'А.', 'А.', '', 'ассистент', '0.50', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(135, NULL, 'Ходырев', 'И.', 'А.', '', 'ассистент', '0.50', 'к.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(136, NULL, 'Бушмакин', 'А.', 'Л.', '', 'ассистент', '0.25', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(137, NULL, 'Гладцын', 'В.', 'А.', '', 'ассистент', '0.25', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(138, NULL, 'Калишенко', 'Е.', 'Л.', '', 'ассистент', '0.50', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(140, NULL, 'Смирнов', 'Н.', 'А.', '', 'ассистент', '0.25', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(141, NULL, 'Фирсов', 'М.', 'А.', '', 'ассистент', '0.50', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(142, NULL, 'Чернокульский', 'В.', 'В.', '', 'ассистент', '0.25', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(147, NULL, 'Середа', NULL, NULL, 'А-.В.И.', 'профессор', '0.50', 'д.н.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(148, NULL, 'Кукс', NULL, NULL, 'А.А.', 'ассистент', '0.25', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(149, NULL, 'Шолохова', NULL, NULL, 'О.М.', 'ассистент', '0.50', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(150, '4909898274', 'Владимирова', 'Анна', 'Андреевна', 'А.А.', 'аспирант', '0.25', NULL, NULL, '', '89110362157', '', 'annafreia@mail.ru', '', '1986-02-02', NULL, '2015-09-01', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `teacher_activity`
--

CREATE TABLE IF NOT EXISTS `teacher_activity` (
  `teacher_activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  PRIMARY KEY (`teacher_activity_id`),
  UNIQUE KEY `teacher_id` (`teacher_id`,`activity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=122 ;

--
-- Дамп данных таблицы `teacher_activity`
--

INSERT INTO `teacher_activity` (`teacher_activity_id`, `teacher_id`, `activity_id`) VALUES
(1, 116, 1),
(3, 116, 3),
(2, 117, 2),
(4, 117, 4),
(5, 117, 5),
(120, 117, 6),
(121, 125, 3),
(119, 125, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `teacher_member_gak`
--

CREATE TABLE IF NOT EXISTS `teacher_member_gak` (
  `id_teacher_member_gak` int(11) NOT NULL AUTO_INCREMENT,
  `id_teacher` int(11) NOT NULL,
  `id_direction` int(11) NOT NULL,
  `role_teacher` VARCHAR(20) DEFAULT NULL,
  PRIMARY KEY (`id_teacher_member_gak`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `teacher_`
--

CREATE TABLE IF NOT EXISTS `teacher_student_diplom` (
  `teacher_student_diplom_id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `diplom_id` int(11) NOT NULL,
  `date_protect` date NOT NULL,
  `id_consultant_as` int(11) NOT NULL,
  `id_diplom_pz` int(11) NOT NULL DEFAULT '0',
  `id_diplom_statement1` int(11) NOT NULL DEFAULT '0',
  `id_diplom_ppt` int(11) NOT NULL DEFAULT '0',
  `id_diplom_statement2` int(11) NOT NULL DEFAULT '0',
  `id_diplom_statement3` int(11) NOT NULL DEFAULT '0',
  `teacher_evaluation` tinyint(2) NOT NULL DEFAULT '0',
  `reviewer_evaluation` tinyint(2) NOT NULL DEFAULT '0',
  `consultant_evaluation` tinyint(2) NOT NULL DEFAULT '0',
  `final_evaluation` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`teacher_student_diplom_id`),
  UNIQUE KEY `student_id` (`student_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Дамп данных таблицы `teacher_student_diplom`
--

INSERT INTO `teacher_student_diplom` (`teacher_student_diplom_id`, `teacher_id`, `student_id`, `diplom_id`, `date_protect`, `id_consultant_as`, `id_diplom_pz`, `id_diplom_statement1`, `id_diplom_ppt`, `id_diplom_statement2`, `id_diplom_statement3`) VALUES
(2, 125, 62, 2, '2017-05-10', 0, 0, 0, 0, 0, 0),
(22, 125, 72, 4, '2017-06-20', 0, 0, 0, 0, 0, 0),
(23, 125, 73, 5, '2017-06-22', 0, 0, 0, 0, 0, 0),
(24, 125, 69, 3, '2017-05-27', 0, 0, 0, 0, 0, 0),
(25, 117, 74, 6, '2017-06-14', 0, 0, 0, 0, 0, 0),
(32, 113, 63, 1, '2017-06-19', 0, 0, 0, 0, 0, 0),
(36, 141, 116, 6, '2017-06-22', 0, 0, 0, 0, 0, 0),
(41, 129, 0, 14, '0000-00-00', 0, 0, 0, 0, 0, 0),
(45, 128, 68, 17, '0000-00-00', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `workprogramversion`
--

CREATE TABLE IF NOT EXISTS `workprogramversion` (
  `idWorkProgramVersion` int(11) NOT NULL AUTO_INCREMENT,
  `FileName` varchar(255) DEFAULT NULL,
  `LastModificationDate` varchar(20) DEFAULT NULL,
  `CurrentVersion` tinyint(1) DEFAULT NULL,
  `CurriculumDiscipline` int(11) NOT NULL,
  PRIMARY KEY (`idWorkProgramVersion`),
  UNIQUE KEY `FileName_UNIQUE` (`FileName`),
  KEY `CurriculumDiscipline` (`CurriculumDiscipline`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `workprogramversion`
--

INSERT INTO `workprogramversion` (`idWorkProgramVersion`, `FileName`, `LastModificationDate`, `CurrentVersion`, `CurriculumDiscipline`) VALUES
(4, 'public://documents/work_programs/38/2016-06-06-10-26-33.docx', '2016-06-06-10-26-33', 1, 38),
(5, 'public://documents/work_programs/38/2016-06-06-10-26-51.docx', '2016-06-06-10-26-51', 0, 38);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

CREATE TABLE IF NOT EXISTS `annotation_diplom` (
  `id_annotation` int(11) NOT NULL AUTO_INCREMENT,
  `id_diplom` BIGINT REFERENCES `teacher_student_diplom`(teacher_student_diplom_id),
  `ref_annotation` VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (`id_annotation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Ограничения внешнего ключа таблицы `canteach`
--
ALTER TABLE `canteach`
  ADD CONSTRAINT `ct_Discipline` FOREIGN KEY (`Discipline`) REFERENCES `discipline` (`idDiscipline`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ct_Teacher` FOREIGN KEY (`Teacher`) REFERENCES `teacher` (`idTeacher`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `curriculum`
--
ALTER TABLE `curriculum`
  ADD CONSTRAINT `Chair-key` FOREIGN KEY (`Chair`) REFERENCES `chair` (`idChair`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Direction` FOREIGN KEY (`Direction`) REFERENCES `direction` (`idDirection`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `curriculumdiscipline`
--
ALTER TABLE `curriculumdiscipline`
  ADD CONSTRAINT `cd_Curriculum` FOREIGN KEY (`Curriculum`) REFERENCES `curriculum` (`idCurriculum`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cd_Discipline` FOREIGN KEY (`Discipline`) REFERENCES `discipline` (`idDiscipline`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `direction`
--
ALTER TABLE `direction`
  ADD CONSTRAINT `Faculty` FOREIGN KEY (`Faculty`) REFERENCES `faculty` (`idFaculty`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `discipline`
--
ALTER TABLE `discipline`
  ADD CONSTRAINT `Chair` FOREIGN KEY (`Chair`) REFERENCES `chair` (`idChair`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `extraload`
--
ALTER TABLE `extraload`
  ADD CONSTRAINT `ExtraLoadKind` FOREIGN KEY (`ExtraLoadKind`) REFERENCES `extraloadkind` (`idExtraLoadKind`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Teacher` FOREIGN KEY (`Teacher`) REFERENCES `teacher` (`idTeacher`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `group`
--
ALTER TABLE `group`
  ADD CONSTRAINT `Curriculum_fk` FOREIGN KEY (`Curriculum`) REFERENCES `curriculum` (`idCurriculum`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `Head` FOREIGN KEY (`Head`) REFERENCES `student` (`idStudent`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ограничения внешнего ключа таблицы `hallload`
--
ALTER TABLE `hallload`
  ADD CONSTRAINT `hl_Discipline` FOREIGN KEY (`Discipline`) REFERENCES `discipline` (`idDiscipline`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hl_Group` FOREIGN KEY (`Group`) REFERENCES `group` (`idGroup`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hl_Teacher` FOREIGN KEY (`Teacher`) REFERENCES `teacher` (`idTeacher`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `individualplan`
--
ALTER TABLE `individualplan`
  ADD CONSTRAINT `fk_Teacher` FOREIGN KEY (`Teacher`) REFERENCES `teacher` (`idTeacher`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ограничения внешнего ключа таблицы `magistercurriculum`
--
ALTER TABLE `magistercurriculum`
  ADD CONSTRAINT `mc_Curriculum` FOREIGN KEY (`Curriculum`) REFERENCES `curriculum` (`idCurriculum`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `mc_MagisterProgram` FOREIGN KEY (`Program`) REFERENCES `magisterprogram` (`idMagisterProgram`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `magisterprogram`
--
ALTER TABLE `magisterprogram`
  ADD CONSTRAINT `mp_Direction` FOREIGN KEY (`Direction`) REFERENCES `direction` (`idDirection`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `Group` FOREIGN KEY (`Group`) REFERENCES `group` (`idGroup`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `workprogramversion`
--
ALTER TABLE `workprogramversion`
  ADD CONSTRAINT `CurriculumDiscipline_fk` FOREIGN KEY (`CurriculumDiscipline`) REFERENCES `curriculumdiscipline` (`idCurriculumDiscipline`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
