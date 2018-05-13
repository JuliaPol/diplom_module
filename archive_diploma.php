<?php

function archive_all_diplomas()
{
    return drupal_get_form('archive_all_diplomas_page');
}

function archive_all_diplomas_page($form, &$form_state)
{
    $header = array(
        array('data' => t('Группа'), 'field' => 'group_number'),
        array('data' => t('ФИО'), 'field' => 'stud_name'),
        array('data' => t('Тема ВКР'), 'field' => 'theme'),
        array('data' => t('Руководитель'), 'field' => 'teacher_name'),
    );

    $years = get_years();
    foreach ($years as $year) {
        $form[$year->year] = array(
            '#type' => 'fieldset',
            '#collapsible' => TRUE,
            '#collapsed' => FALSE,
            '#title' => $year->year,
        );
        $directions = get_all_directions_by_year($year->year);
        foreach ($directions as $nid => $direction) {
            if (isset($direction->direction_code)) {
                $form[$year->year][$nid] = array(
                    '#type' => 'fieldset',
                    '#collapsible' => TRUE,
                    '#collapsed' => FALSE,
                    '#title' => $direction->direction_code . ' - ' . $direction->direction_name,
                );
                $nodes = get_themes_by_year_and_direction($year->year, $direction->direction_code);
                $form[$year->year][$nid]['theme_table'] = fill_diploma_table($form, $nodes, $header);
                $form[$year->year][$nid]['pager']['#markup'] = theme('pager');
                $directions[$nid]->nodes = $nodes;
            }
        }
        create_doc_with_themes($year->year, $directions);
    }
//    $nodes = get_all_themes();
//
//    $form['theme_table'] = fill_diploma_table($form, $nodes, $header);
    return $form;
}

function fill_diploma_table($form, $nodes, $header)
{
    $form['theme_table'] = array(
        '#type' => 'container',
        '#theme' => 'diploma',
        '#header' => $header,
        '#prefix' => '<div id="student-wrapper">',
        '#suffix' => '</div>',
    );

    foreach ($nodes as $nid => $node) {
        if (isset($node->student[0]) && isset($node->teacher[0])) {
            $link = l(t($node->student[0]->last_name . ' ' . $node->student[0]->first_name), 'archive/student', array('query' =>
                array('id' => $node->id_student, 'year' => date('Y', strtotime($node->date_protect)))));
            $link_teacher = l(t($node->teacher[0]->last_name . ' ' . $node->teacher[0]->first_name . ' ' . $node->teacher[0]->patronymic),
                'archive/teacher', array('query' => array('id' => $node->id_teacher, 'year' => $node->year)));
            $form['theme_table'][$nid]['group_number'] = array(
                '#markup' => $node->student[0]->group_number,
            );
            $form['theme_table'][$nid]['stud_name'] = array(
                '#markup' => $link,
            );
            $form['theme_table'][$nid]['theme'] = array(
                '#markup' => $node->diplom_name,
            );
            $form['theme_table'][$nid]['teacher_name'] = array(
                '#markup' => $link_teacher
            );
        }
    }
    return $form['theme_table'];
}

function get_themes_by_year_and_direction($year, $direction)
{
    db_set_active('archive_db');
    $query1 = db_select('diplom', 'th')
        ->extend('PagerDefault')
        ->extend('TableSort');
    $query1->innerJoin('teacher_student_diplom', 'dip', 'dip.id_theme = th.id_diplom AND th.`year` = dip.`year`');
    $query1->leftJoin('student', 's', 'dip.id_student = s.id_student AND s.`year` = dip.`year`');
    $query1->leftJoin('stud_group', 'g', 'g.id_group = s.id_group AND g.`year` = s.`year`');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND d.`year` = g.`year`');
    $query1->fields('th')
        ->fields('dip')
        ->fields('d', array('direction_code', 'direction_name'))
        ->condition('th.`year`', $year)
        ->condition('d.direction_code', $direction)
        ->limit(10)
        ->orderBy('g.group_number', 'DESC');
    $themes = $query1->execute()
        ->fetchAll();
    foreach ($themes as $nid => $value) {
        $themes[$nid]->teacher = get_teacher_by_id_archive($value->id_teacher, $value->year);
        $themes[$nid]->student = get_student_by_id_archive($value->id_student, $value->year);
    }
    db_set_active();
    return $themes;
}

function get_all_directions_by_year($year)
{
    db_set_active('archive_db');
    $query1 = db_select('diplom', 'th')
        ->extend('PagerDefault')
        ->extend('TableSort');
    $query1->innerJoin('teacher_student_diplom', 'dip', 'dip.id_theme = th.id_diplom AND th.`year` = dip.`year`');
    $query1->leftJoin('student', 's', 'dip.id_student = s.id_student AND s.`year` = dip.`year`');
    $query1->leftJoin('stud_group', 'g', 'g.id_group = s.id_group AND g.`year` = s.`year`');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND d.`year` = g.`year`');
    $query1->fields('d', array('direction_code', 'direction_name'))
        ->groupBy('d.direction_code')
        ->condition('th.`year`', $year);
    $directions = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $directions;
}

function get_all_themes()
{
    db_set_active('archive_db');
    $query1 = db_select('diplom', 'd')
        ->extend('PagerDefault')
        ->extend('TableSort');
    $query1->innerJoin('teacher_student_diplom', 'dip', 'dip.id_theme = d.id_diplom AND d.`year` = dip.`year`');
    $query1->fields('d')
        ->fields('dip')
        ->orderBy('d.`year`', 'DESC')
//        ->groupBy('d.`year`')
        ->limit(10);
//        ->orderByHeader($header);
    $themes = $query1->execute()
        ->fetchAll();
    foreach ($themes as $nid => $value) {
        $themes[$nid]->teacher = get_teacher_by_id_archive($value->id_teacher, $value->year);
        $themes[$nid]->student = get_student_by_id_archive($value->id_student, $value->year);
    }
    db_set_active();
    return $themes;
}

function create_doc_with_themes($year, $directions)
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
    $section->addText('Темы ВКР ' . $year . 'г.', 'rStyle', 'Center');
    foreach ($directions as $direction) {
        if (isset($direction->nodes)) {
            $section->addText('Направление: ' . $direction->direction_code . ' - ' . $direction->direction_name, 'contentStyle', 'Justify');
            $table = $section->addTable('myOwnTableStyle');
            $table->addRow(900);
            $table->addCell(500, $styleCell)->addText('№ Группа', $fontStyle);
            $table->addCell(2000, $styleCell)->addText('Фамилия, имя, отчество', $fontStyle);
            $table->addCell(3500, $styleCell)->addText('Тема ВКР', $fontStyle);
            $table->addCell(2000, $styleCell)->addText('Руководитель', $fontStyle);
            foreach ($direction->nodes as $node) {
                $table->addRow(900);
                $table->addCell(500, $styleCell)->addText($node->student[0]->group_number, $fontStyle);
                $table->addCell(2000, $styleCell)->addText($node->student[0]->last_name . ' '
                    . $node->student[0]->first_name . ' ' . $node->student[0]->patronymic, $fontStyle);
                $table->addCell(3500, $styleCell)->addText($node->diplom_name, $fontStyle);
                $table->addCell(2000, $styleCell)->addText($node->teacher[0]->last_name
                    . ' ' . $node->teacher[0]->first_name . ' ' . $node->teacher[0]->patronymic, $fontStyle);
            }
        }
    }
    $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
    $objWriter->save('archive/' . $year . '/list_themes_' . $year . '.docx');
}

function create_archive_folder($year)
{
    if (!file_exists('archive'))
        mkdir('archive', 777, true);
    if (!file_exists('archive/' . $year))
        mkdir('archive/' . $year, 777, true);
}