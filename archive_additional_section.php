<?php

//include 'archive_all_students.php';

function archive_additional_sections()
{
    return drupal_get_form('archive_additional_sections_page');
}

//TODO: add years filter
function archive_additional_sections_page($form, &$form_state)
{
    $header = array(
        array('data' => t('Год'), 'field' => 'year'),
        array('data' => t('Дополнительный раздел'), 'field' => 'section'),
        array('data' => t('Кафедра'), 'field' => 'department'),
        array('data' => t('ФИО консультанта'), 'field' => 'name'),
        array('data' => t('Количество студентов'), 'field' => 'count'),
    );

//    $form['year'] = array(
//        '#type' => 'select',
//        '#title' => t('Год'),
//        '#options' => $array,
//        '#default_value' => 0,
//        '#ajax' => array(
//            'event' => 'change',
//            'callback' => 'archive_all_students_dropdown_callback',
//            'wrapper' => 'student-wrapper',
//            'method' => 'replace',
//            'effect' => 'fade',
//        ),
//    );
    $nodes = get_all_additional_sections_archive($header);

    $form['section_table'] = fill_table_sections($form, $nodes, $header);
    $form['pager']['#markup'] = theme('pager');
    $link = l(t("Скачать статистику за все года"), 'archive/download/statistics/additional_section');
    $form['download'] = array(
        '#markup' => $link,
    );
    return $form;
}

function fill_table_sections($form, $nodes, $header)
{
    $form['section_table'] = array(
        '#type' => 'container',
        '#theme' => 'section',
        '#header' => $header,
        '#prefix' => '<div id="section-wrapper">',
        '#suffix' => '</div>',
    );

    foreach ($nodes as $nid => $node) {
        $students = get_students_by_additional_section($node->year, $node->name_section, $node->name_department);
        $link = l(t($node->last_name . ' ' . $node->first_name . ' ' . $node->patronymic), 'archive/consultant_as', array('query' =>
            array('id' => $node->id_consultant_as, 'year' => $node->year)));

        $link_section = l(t($node->name_section), 'archive/download/additional_section', array('query' =>
            array('year' => $node->year, 'section' => $node->name_section, 'department' => $node->name_department)));

        $link_department = l(t($node->name_department), 'archive/download/department/additional_sections', array('query' =>
            array('year' => $node->year, 'department' => $node->name_department)));

        $form['section_table'][$nid]['year'] = array(
            '#markup' => $node->year,
        );
        $form['section_table'][$nid]['section'] = array(
            '#markup' => $link_section,
        );
        $form['section_table'][$nid]['department'] = array(
            '#markup' => $link_department,
        );
        $form['section_table'][$nid]['name'] = array(
            '#markup' => $link,
        );
        $form['section_table'][$nid]['count'] = array(
            '#markup' => count((array)$students),
        );
    }
    return $form['section_table'];
}

function get_additional_sections_archive($year)
{
    db_set_active('archive_db');
    $query1 = db_select('additional_section', 'a_s');
    $query1->leftJoin('consultant_as', 'c_a_s', 'c_a_s.id_additional_section = a_s.id_additional_section AND a_s.`year` = c_a_s.`year`');
    $query1->fields('a_s')
        ->fields('c_a_s')
        ->condition('a_s.`year`', $year);
    $section = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $section;
}

function get_additional_sections_by_department_archive($year, $department)
{
    db_set_active('archive_db');
    $query1 = db_select('additional_section', 'a_s');
    $query1->leftJoin('consultant_as', 'c_a_s', 'c_a_s.id_additional_section = a_s.id_additional_section AND a_s.`year` = c_a_s.`year`');
    $query1->fields('a_s')
        ->fields('c_a_s')
        ->condition('a_s.name_department', $department)
        ->condition('a_s.`year`', $year);
    $section = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $section;
}

function get_all_departments_archive()
{
    db_set_active('archive_db');
    $query1 = db_select('additional_section', 'a_s');
    $query1->fields('a_s')
        ->orderBy('a_s.year', 'DESC')
        ->groupBy('a_s.name_department');
    $departments = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $departments;
}

function get_all_additional_sections_archive()
{
    db_set_active('archive_db');
    $query1 = db_select('additional_section', 'a_s');
    $query1->leftJoin('consultant_as', 'c_a_s', 'c_a_s.id_additional_section = a_s.id_additional_section AND a_s.`year` = c_a_s.`year`');
    $query1->fields('a_s')
        ->fields('c_a_s')
        ->orderBy('a_s.year', 'DESC');
    $sections = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $sections;
}

function get_all_additional_sections_sorted_archive()
{
    db_set_active('archive_db');
    $query1 = db_select('additional_section', 'a_s');
    $query1->fields('a_s')
        ->orderBy('a_s.name_department')
        ->orderBy('a_s.name_section')
        ->orderBy('a_s.year', 'DESC');
    $sections = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $sections;
}

function download_list_students_with_additional_sections_on_department()
{
    create_doc_with_additional_sections_on_department($_GET['year'], $_GET['department']);
}

function download_list_students_with_additional_section()
{
    create_doc_with_additional_section($_GET['year'], $_GET['section'], $_GET['department']);
}

function create_doc_with_additional_sections_on_department($year, $department)
{
    create_archive_folder($year);
    $add_sections = get_additional_sections_by_department_archive($year, $department);
    require_once '/sites/all/libraries/Classes/PHPWord.php';
    $PHPWord = new PHPWord();
    $PHPWord->setDefaultFontName('Times New Roman');
    $PHPWord->addFontStyle('rStyle', array('bold' => true, 'size' => 16));
    $PHPWord->addFontStyle('contentStyle', array('size' => 12));
    $PHPWord->addParagraphStyle('Center', array('align' => 'center'));
    $PHPWord->addParagraphStyle('Justify', array('align' => 'both'));
    $styleTable1 = array('borderSize' => 6, 'borderColor' => '0f0', 'cellMargin' => 80);
    $styleCell = array('valign' => 'center');
    $fontStyle = array('align' => 'center');
    $PHPWord->addTableStyle('myOwnTableStyle', $styleTable1);
    $section = $PHPWord->createSection();
    $section->addText('Кафедра ' . $department, 'rStyle', 'Center');
    $section->addText('Год ' . $year . 'г.', 'rStyle', 'Center');

    foreach ($add_sections as $add_section) {
        $section->addText('Дополнительный раздел: ' . $add_section->name_section, 'contentStyle', 'Justify');
        $section->addText('Консультант: ' . $add_section->last_name . ' ' . $add_section->first_name . ' ' .
            $add_section->patronymic, 'contentStyle', 'Justify');
        $table = $section->addTable('myOwnTableStyle');
        $table->addRow(900);
        $table->addCell(2500, $styleCell)->addText('Направление', $fontStyle);
        $table->addCell(500, $styleCell)->addText('№ Группа', $fontStyle);
        $table->addCell(2000, $styleCell)->addText('Фамилия, имя, отчество', $fontStyle);
        $students = get_students_by_additional_section($year, $add_section->name_section, $department);
        foreach ($students as $node) {
            $table->addRow(900);
            $table->addCell(2500, $styleCell)->addText($node->direction_code . ' - ' . $node->direction_name, $fontStyle);
            $table->addCell(500, $styleCell)->addText($node->group_number, $fontStyle);
            $table->addCell(2000, $styleCell)->addText($node->last_name . ' '
                . $node->first_name . ' ' . $node->patronymic, $fontStyle);
        }
    }

    $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
    $file = 'archive/' . $year . '/department_' . $department . '_' . $year . '.docx';
    $objWriter->save($file);
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=department_"
        . $department . "_" . $year . ".docx");
    header("Content-Type: application/zip; charset=UTF-8");
    header("Content-Transfer-Encoding: binary");
    readfile($file);
}

function create_doc_with_additional_section($year, $add_section, $department)
{
    create_archive_folder($year);
    require_once '/sites/all/libraries/Classes/PHPWord.php';
    $PHPWord = new PHPWord();
    $PHPWord->setDefaultFontName('Times New Roman');
    $PHPWord->addFontStyle('rStyle', array('bold' => true, 'size' => 16));
    $PHPWord->addFontStyle('contentStyle', array('size' => 12));
    $PHPWord->addParagraphStyle('Center', array('align' => 'center'));
    $PHPWord->addParagraphStyle('Justify', array('align' => 'both'));
    $styleTable1 = array('borderSize' => 6, 'borderColor' => '0f0', 'cellMargin' => 80);
    $styleCell = array('valign' => 'center');
    $fontStyle = array('align' => 'center');
    $PHPWord->addTableStyle('myOwnTableStyle', $styleTable1);
    $section = $PHPWord->createSection();
    $section->addText('Кафедра ' . $department, 'rStyle', 'Center');
    $section->addText('Год ' . $year . 'г.', 'rStyle', 'Center');

    $consultant = get_consultant_by_additional_sections_archive($year, $add_section, $department);
    $section->addText('Дополнительный раздел: ' . $consultant[0]->name_section, 'contentStyle', 'Justify');
    $section->addText('Консультант: ' . $consultant[0]->last_name . ' ' . $consultant[0]->first_name . ' ' .
        $consultant[0]->patronymic, 'contentStyle', 'Justify');
    $table = $section->addTable('myOwnTableStyle');
    $table->addRow(900);
    $table->addCell(2500, $styleCell)->addText('Направление', $fontStyle);
    $table->addCell(500, $styleCell)->addText('№ Группа', $fontStyle);
    $table->addCell(2000, $styleCell)->addText('Фамилия, имя, отчество', $fontStyle);
    $students = get_students_by_additional_section($year, $add_section, $department);
    foreach ($students as $node) {
        $table->addRow(900);
        $table->addCell(2500, $styleCell)->addText($node->direction_code . ' - ' . $node->direction_name, $fontStyle);
        $table->addCell(500, $styleCell)->addText($node->group_number, $fontStyle);
        $table->addCell(2000, $styleCell)->addText($node->last_name . ' '
            . $node->first_name . ' ' . $node->patronymic, $fontStyle);
    }


    $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
    $file = 'archive/' . $year . '/additional_section_' . $add_section . '_' . $year . '.docx';
    $objWriter->save($file);
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=additional_section_"
        . $add_section . "_" . $year . ".docx");
    header("Content-Type: application/zip; charset=UTF-8");
    header("Content-Transfer-Encoding: binary");
    readfile($file);
}

function create_excel_report()
{
    require_once '/sites/all/libraries/Classes/PHPExcel.php';
    require_once('/sites/all/libraries/Classes/PHPExcel/Writer/Excel5.php');
    $PHPExcel = new PHPExcel();
    $PHPExcel->setActiveSheetIndex(0);
    $sheet = $PHPExcel->getActiveSheet();
    $sheet->setTitle('Дополнительные разделы');

    $years = get_years();
    $sections = get_all_additional_sections_sorted_archive();

    $i = 2;
    foreach ($years as $year) {
        $sheet->setCellValueByColumnAndRow($i, 1, $year->year);
        $i++;
    }

    $j = 1;
    $department = "";
    $section_old = "";
    foreach ($sections as $section) {
        if ($section_old != $section->name_section) {
            $j++;
            $section_old = $section->name_section;
            $sheet->setCellValueByColumnAndRow(1, $j, $section_old);
        }
        if ($section->name_department != $department) {
            $department = $section->name_department;
            $sheet->setCellValueByColumnAndRow(0, $j, $department);
        }
        $year_cell = 2;
        foreach ($years as $year) {
            $students = get_students_by_additional_section($year->year, $section->name_section, $section->name_department);
            $sheet->setCellValueByColumnAndRow($year_cell, $j, count((array)$students));
            $year_cell++;
        }
    }

//// Выравнивание текста
//    $sheet->getStyle('A1')->getAlignment()->setHorizontal(
//        PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//    $objWriter->save($file);
//    header("Cache-Control: public");
//    header("Content-Description: File Transfer");
//    header("Content-Disposition: attachment; filename=additional_sections.xls");
//    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
//    header("Content-Transfer-Encoding: binary");
//    readfile($file);

    // Выводим HTTP-заголовки
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=additional_sections.xls");

    $objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
    $file = 'archive/additional_sections.xls';
    $objWriter->save($file);


}