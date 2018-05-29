
--
-- База данных: `archive`
--

-- --------------------------------------------------------

--
-- Структура таблицы `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id_activity` int(11) NOT NULL,
  `activity_name` varchar(256) NOT NULL,
  `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_activity`, `year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `id_teacher` int(11) NOT NULL,
  `passport` varchar(10) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `patronymic` varchar(45) DEFAULT NULL,
  `position` varchar(45) DEFAULT NULL,
  `degree` varchar(20) DEFAULT NULL,
  `rank` varchar(15) DEFAULT NULL,
  `mobile_phone` varchar(16) DEFAULT NULL,
  `work_phone` varchar(9) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_teacher`, `year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


--
-- Структура таблицы `teacher_activity`
--

CREATE TABLE IF NOT EXISTS `teacher_activity` (
  `id_teacher_activity` int(11) NOT NULL,
  `id_teacher` int(11) NOT NULL REFERENCES `teacher`(`id_teacher`),
  `id_activity` int(11) NOT NULL REFERENCES `activity`(`id_activity`),
  `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_teacher_activity`, `year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Структура таблицы `member_gak`
--

CREATE TABLE IF NOT EXISTS `member_SEC` (
  `id_member_SEC` int(11) NOT NULL,
  `passport` varchar(10) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `patronymic` varchar(45) NOT NULL,
  `mobile_phone` varchar(16) NOT NULL,
  `work_phone` varchar(9) NOT NULL,
  `email` varchar(45) NOT NULL,
  `address` varchar(150) NOT NULL,
  `role` varchar(64) NOT NULL,
  `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_member_SEC`, `year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Структура таблицы `direction`
--

CREATE TABLE IF NOT EXISTS `direction` (
  `id_direction` int(11) NOT NULL,
  `direction_code` varchar(10) DEFAULT NULL,
  `direction_name` varchar(100) DEFAULT NULL,
  `faculty` int(11) DEFAULT NULL,
  `ref_the_best_students` VARCHAR(100) DEFAULT NULL,
  `ref_report_head` VARCHAR(100) DEFAULT NULL,
  `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_direction`, `year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Структура таблицы `direction_member_SEC`
--

CREATE TABLE IF NOT EXISTS `direction_member_SEC` (
  `id_direction_member_SEC` int(11) NOT NULL,
  `id_member_SEC` int(11) NOT NULL REFERENCES `member_SEC`(`id_member_SEC`),
  `id_direction` int(11) NOT NULL REFERENCES `direction`(`id_direction`),
  `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_direction_member_SEC`, `year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Структура таблицы `direction_teacher`
--

CREATE TABLE IF NOT EXISTS `direction_teacher` (
  `id_direction_teacher` int(11) NOT NULL,
  `id_teacher` int(11) NOT NULL REFERENCES `teacher`(`id_teacher`),
  `id_direction` int(11) NOT NULL REFERENCES `direction`(`id_direction`),
  `role_teacher` VARCHAR(20) DEFAULT NULL,
  `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_direction_teacher`, `year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Структура таблицы `stud_group`
--

CREATE TABLE IF NOT EXISTS `stud_group` (
  `id_group` int(11) NOT NULL,
  `group_number` smallint(4) unsigned NOT NULL,
  `size` smallint(2) unsigned DEFAULT NULL,
  `creation_year` year(4) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `id_direction` int(11) DEFAULT NULL REFERENCES `direction`(`id_direction`),
  `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_group`, `year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Структура таблицы `group_teacher`
--

CREATE TABLE IF NOT EXISTS `group_teacher` (
  `id_group_teacher` int(11) NOT NULL,
  `id_teacher` int(11) NOT NULL REFERENCES `teacher`(`id_teacher`),
  `id_group` int(11) NOT NULL REFERENCES `stud_group`(`id_group`),
  `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_group_teacher`, `year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Структура таблицы `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id_student` int(11) NOT NULL,
  `passport` varchar(10) DEFAULT NULL,
  `record_book_number` mediumint(6) unsigned NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `patronymic` varchar(50) DEFAULT NULL,
  `id_group` int(11) DEFAULT NULL REFERENCES `stud_group`(`id_group`),
  `email` varchar(45) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL,
  `expel_date` date DEFAULT NULL,
  `sum_3` int(11) NOT NULL DEFAULT '0',
  `sum_4` int(11) NOT NULL DEFAULT '0',
  `sum_5` int(11) NOT NULL DEFAULT '0',
  `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_student`, `year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Структура таблицы `consultant_company`
--

CREATE TABLE IF NOT EXISTS `consultant_company` (
  `id_consultant_company` int(11) NOT NULL,
  `passport` varchar(12) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `patronymic` varchar(45) DEFAULT NULL,
  `company_name` varchar(45) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
    `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_consultant_company`, `year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Структура таблицы `consultant_student`
--

CREATE TABLE IF NOT EXISTS `consultant_student` (
  `id_consultant_student` int(11) NOT NULL,
  `id_consultant` int(11) NOT NULL REFERENCES `consultant_company`(`id_consultant_company`),
  `id_student` int(11) NOT NULL REFERENCES `student`(`id_student`),
  `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_consultant_student`, `year`),
      UNIQUE KEY `student` (`id_student`, `year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Структура таблицы `reviewer`
--

CREATE TABLE IF NOT EXISTS `reviewer` (
  `id_reviewer` int(11) NOT NULL,
  `passport` varchar(10) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `patronymic` varchar(45) NOT NULL,
  `degree` varchar(20) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_reviewer`, `year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Структура таблицы `reviewer_student`
--

CREATE TABLE IF NOT EXISTS `reviewer_student` (
  `id_reviewer_student` int(11) NOT NULL,
  `id_reviewer` int(11) NOT NULL REFERENCES `reviewer`(`id_reviewer`),
  `id_student` int(11) NOT NULL REFERENCES `student`(`id_student`),
  `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_reviewer_student`, `year`),
      UNIQUE KEY `student` (`id_student`, `year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Структура таблицы `additional_section`
--

CREATE TABLE IF NOT EXISTS `additional_section` (
  `id_additional_section` int(11) NOT NULL,
  `name_department` varchar(45) DEFAULT NULL,
  `name_section` varchar(45) DEFAULT NULL,
    `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_additional_section`, `year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


--
-- Структура таблицы `reviewer_student`
--

CREATE TABLE IF NOT EXISTS `student_additional_section` (
  `id_student_as` int(11) NOT NULL,
  `id_as` int(11) NOT NULL REFERENCES `additional_section`(`id_additional_section`),
  `id_student` int(11) NOT NULL REFERENCES `student`(`id_student`),
  `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_student_as`, `year`),
    UNIQUE KEY `student` (`id_student`, `id_as`, `year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Структура таблицы `consultant_as`
--

CREATE TABLE IF NOT EXISTS `consultant_as` (
  `id_consultant_as` int(11) NOT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `patronymic` varchar(45) DEFAULT NULL,
  `mobile_phone` varchar(16) DEFAULT NULL,
  `work_phone` varchar(9) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `id_additional_section` int(11) NOT NULL DEFAULT '0',
   `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_consultant_as`, `year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


--
-- Структура таблицы `annotation_diplom`
--

CREATE TABLE IF NOT EXISTS `annotation_diplom` (
  `id_annotation` int(11) NOT NULL,
  `id_diplom` int(11) NOT NULL REFERENCES `diplom`(`id_diplom`),
  `ref_annotation` VARCHAR(100) DEFAULT NULL,
  `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_annotation`, `year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Структура таблицы `diplom`
--

CREATE TABLE IF NOT EXISTS `diplom` (
  `id_diplom` int(11) NOT NULL,
  `diplom_name` varchar(256) NOT NULL,
  `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_diplom`, `year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Структура таблицы `teacher_student_diplom`
--

CREATE TABLE IF NOT EXISTS `teacher_student_diplom` (
  `id_teacher_student_diplom` int(11) NOT NULL,
  `id_teacher` int(11) NOT NULL REFERENCES `teacher`(`id_teacher`),
  `id_student` int(11) NOT NULL REFERENCES `student`(`id_student`),
  `id_theme` int(11) NOT NULL REFERENCES `diplom`(`id_diplom`),
  `date_protect` date DEFAULT NULL,
  `id_consultant_as` int(11) NOT NULL REFERENCES `consultant_as`(`id_consultant_as`),
  `teacher_evaluation` smallint(2) NOT NULL DEFAULT '0',
  `reviewer_evaluation` smallint(2) NOT NULL DEFAULT '0',
  `consultant_evaluation` smallint(2) NOT NULL DEFAULT '0',
  `final_evaluation` smallint(2) NOT NULL DEFAULT '0',
  `percent_originality` smallint(3) NOT NULL DEFAULT '0',
  `year` smallint(4) NOT NULL,
  PRIMARY KEY (`id_teacher_student_diplom`, `year`),
  UNIQUE KEY `student` (`id_student`, `year`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
