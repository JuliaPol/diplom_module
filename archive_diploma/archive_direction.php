<?php

function get_all_directions_archive()
{
    db_set_active('archive_db');
    $query1 = db_select('direction', 'd');
    $query1->fields('d')
        ->groupBy('d.direction_code');
    $directions = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $directions;
}

function get_direction_archive_by_group($group_number, $year) {
    db_set_active('archive_db');
    $query1 = db_select('stud_group', 'g');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND g.`year` = d.`year`');
    $query1->fields('d')
        ->condition('g.group_number', $group_number)
        ->condition('d.year', $year);
    $directions = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $directions;
}

function get_direction_archive_by_id($dir_code, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('direction', 'd');
    $query1->fields('d')
        ->condition('d.direction_code', $dir_code)
        ->condition('d.year', $year);
    $directions = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $directions;
}

function get_all_directions_archive_by_year($year)
{
    db_set_active('archive_db');
    $query1 = db_select('direction', 'd');
    $query1->fields('d')
        ->groupBy('d.direction_code')
        ->condition('d.`year`', $year);
    $directions = $query1->execute()
        ->fetchAll();
    foreach ($directions as $nid => $direction) {
        $directions[$nid]->count_groups = get_count_group_archive_by_dir($direction->direction_code, $year);
        $directions[$nid]->count_studs = get_count_students_archive_by_dir($direction->direction_code, $year);
    }
    db_set_active();
    return $directions;
}

function get_count_group_archive_by_dir($dir, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('stud_group', 'g');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND g.`year` = d.`year`');
    $query1->fields('d')
        ->condition('d.direction_code', $dir)
        ->condition('g.`year`', $year);
    $directions = $query1->execute()->rowCount();
    db_set_active();
    return $directions;
}

function get_count_students_archive_by_dir($dir, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('student', 's');
    $query1->leftJoin('stud_group', 'g', 'g.id_group = s.id_group AND s.`year` = g.`year`');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND g.`year` = d.`year`');
    $query1->fields('d')
        ->condition('d.direction_code', $dir)
        ->condition('d.`year`', $year);
    $directions = $query1->execute()->rowCount();
    db_set_active();
    return $directions;
}

function get_count_students_archive_by_group($group, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('student', 's');
    $query1->leftJoin('stud_group', 'g', 'g.id_group = s.id_group AND s.`year` = g.`year`');
    $query1->fields('g')
        ->condition('g.group_number', $group)
        ->condition('g.`year`', $year);
    $groups = $query1->execute()->rowCount();
    db_set_active();
    return $groups;
}

function get_count_students_with_theme_archive_by_dir($dir, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('student', 's');
    $query1->leftJoin('stud_group', 'g', 'g.id_group = s.id_group AND s.`year` = g.`year`');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND g.`year` = d.`year`');
    $query1->innerJoin('teacher_student_diplom', 'dip', 'dip.id_student = s.id_student AND s.`year` = dip.`year`');
    $query1->fields('d')
        ->condition('d.direction_code', $dir)
        ->condition('d.`year`', $year);
    $directions = $query1->execute()->rowCount();
    db_set_active();
    return $directions;
}

function get_count_defended_students_archive_by_dir($dir, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('student', 's');
    $query1->leftJoin('stud_group', 'g', 'g.id_group = s.id_group AND s.`year` = g.`year`');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND g.`year` = d.`year`');
    $query1->innerJoin('teacher_student_diplom', 'dip', 'dip.id_student = s.id_student AND s.`year` = dip.`year`');
    $query1->fields('d')
        ->condition('d.direction_code', $dir)
        ->condition('dip.final_evaluation', 0, '>')
        ->condition('d.`year`', $year);
    $directions = $query1->execute()->rowCount();
    db_set_active();
    return $directions;
}

function get_count_students_archive_by_dir_and_eval($dir, $year, $evaluation)
{
    db_set_active('archive_db');
    $query1 = db_select('student', 's');
    $query1->leftJoin('stud_group', 'g', 'g.id_group = s.id_group AND s.`year` = g.`year`');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND g.`year` = d.`year`');
    $query1->innerJoin('teacher_student_diplom', 'dip', 'dip.id_student = s.id_student AND s.`year` = dip.`year`');
    $query1->fields('d')
        ->condition('d.direction_code', $dir)
        ->condition('dip.final_evaluation', $evaluation)
        ->condition('d.`year`', $year);
    $directions = $query1->execute()->rowCount();
    db_set_active();
    return $directions;
}

function get_groups_by_dir_archive($dir_code, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('stud_group', 'g');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND d.`year` = g.`year`');
    $query1->fields('g')
        ->condition('d.direction_code', $dir_code)
        ->condition('g.`year`', $year);
    $groups = $query1->execute()->fetchAll();
    foreach ($groups as $nid => $group) {
        $groups[$nid]->stud_count = get_count_students_archive_by_group($group->group_number, $group->year);
    }
    db_set_active();
    return $groups;
}

function get_best_diplomas($dir_code, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('diplom', 'th');
    $query1->innerJoin('teacher_student_diplom', 'dip', 'dip.id_theme = th.id_diplom AND th.`year` = dip.`year`');
    $query1->leftJoin('student', 's', 'dip.id_student = s.id_student AND s.`year` = dip.`year`');
    $query1->leftJoin('stud_group', 'g', 'g.id_group = s.id_group AND g.`year` = s.`year`');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND d.`year` = g.`year`');
    $query1->innerJoin('annotation_diplom', 'a', 'a.id_diplom = th.id_diplom AND a.`year` = th.`year`');
    $query1->fields('th')
        ->fields('dip')
        ->fields('a')
        ->condition('th.`year`', $year)
        ->condition('d.direction_code', $dir_code);
    $themes = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $themes;
}

function archive_all_directions()
{
    return drupal_get_form('archive_all_directions_page');
}

function archive_direction()
{
    return drupal_get_form('archive_direction_page');
}

function archive_direction_page($form, &$form_state)
{
    if (empty($_GET['year']))
        $_GET['year'] = date('Y');
    if (empty($_GET['dir_code']))
        $_GET['dir_code'] = 1;

    $direction = get_direction_archive_by_id($_GET['dir_code'], $_GET['year']);
    $form['direction'] = array(
        '#markup' => '<h3>' . $direction[0]->direction_code . ' - ' . $direction[0]->direction_name . '</h3>',
    );

    $form['year'] = array(
        '#markup' => '<h3>' . 'Год: ' . $_GET['year'] . '</h3>',
    );

    $link_stat = l(t('Загрузить статистику'), 'archive/download/statistics/direction', array('query' =>
        array('group' => $direction[0]->direction_code, 'year' => $direction[0]->year)));

    $link_report = l(t('Загрузить отчет председателя ГЭК'), $direction[0]->ref_report_head);

    $link_best_stud = l(t('Загрузить список лучших ВКР'), $direction[0]->ref_the_best_students);

    $form['statistic'] = array(
        '#markup' => $link_stat,
    );

    $form['report'] = array(
        '#markup' => '<p></p>' . $link_report,
    );

    $header = array(
        array('data' => t('Группа'), 'field' => 'group_number'),
        array('data' => t('Количество студентов'), 'field' => 'count_stud'),
        array('data' => t('Год создания'), 'field' => 'creation_year'),
        array('data' => t('Email'), 'field' => 'email'),
        array('data' => t('Список студентов'), 'field' => 'stud_list'),
        array('data' => t('Проверка на самостоятельность выполнения'), 'field' => 'originality'),
    );

    $form['group_table'] = array(
        '#type' => 'container',
        '#theme' => 'group',
        '#header' => $header
    );

    $groups = get_groups_by_dir_archive($direction[0]->direction_code, $_GET['year']);

    foreach ($groups as $nid => $group) {
        $link = l(t('Загрузить'), 'archive/download/group/stud_list', array('query' =>
            array('group' => $group->group_number, 'year' => $group->year)));
        $link_originality = l(t('Загрузить'), 'archive/download/originality', array('query' =>
            array('group' => $group->group_number, 'year' => $group->year)));
        $form['group_table'][$nid]['group_number'] = array(
            '#markup' => $group->group_number
        );
        $form['group_table'][$nid]['count_stud'] = array(
            '#markup' => $group->stud_count
        );
        $form['group_table'][$nid]['creation_year'] = array(
            '#markup' => $group->creation_year
        );
        $form['group_table'][$nid]['email'] = array(
            '#markup' => $group->email
        );
        $form['group_table'][$nid]['stud_list'] = array(
            '#markup' => $link
        );
        $form['group_table'][$nid]['originality'] = array(
            '#markup' => $link_originality
        );
    }

    $form['students'] = array(
        '#markup' => $link_best_stud,
    );

    $form['best_diplomas'] = array(
        '#type' => 'fieldset',
        '#collapsible' => TRUE,
        '#collapsed' => TRUE,
        '#title' => 'Лучшие работы',
    );

    $best_diplomas = get_best_diplomas($direction[0]->direction_code, $_GET['year']);

    foreach ($best_diplomas as $nid => $best_diploma) {
        $link_annotation = l(t($best_diploma->diplom_name), $best_diploma->ref_annotation);
        $form['best_diplomas'][$nid] = array(
            '#markup' => $link_annotation,
        );
    }

    return $form;
}

function archive_all_directions_page($form, &$form_state)
{
    $years = get_years();
    $array = array();
    $i = 1;
    $array[0] = 'Все';
    foreach ($years as $value) {
        $array[$i++] = $value->year;
    }

    $form['selects'] = array(
        '#prefix' => '<div style=" display: flex; flex-direction: row; flex-wrap: wrap;">',
        '#suffix' => '</div>',
    );

    $form['selects']['year'] = array(
        '#type' => 'select',
        '#title' => t('Год'),
        '#options' => $array,
        '#default_value' => 0,
        '#prefix' => '<div style="padding: 10px; margin-right: 5px;">',
        '#suffix' => '</div>',
        '#ajax' => array(
            'event' => 'change',
            'callback' => 'archive_all_directions_dropdown_callback',
            'wrapper' => 'direction-wrapper',
            'method' => 'replace',
            'effect' => 'fade',
        ),
    );

    $header = array(
        array('data' => t('Год'), 'field' => 'year'),
        array('data' => t('Код направления'), 'field' => 'dir_code'),
        array('data' => t('Название направления'), 'field' => 'dir_name'),
        array('data' => t('Количество групп'), 'field' => 'count_groups'),
        array('data' => t('Количество студентов'), 'field' => 'count_studs'),
    );

    $directions = array();
    foreach ($years as $nid => $year1) {
        $directions[$nid] = get_all_directions_archive_by_year($year1->year);
    }

    $form['directions_table'] = fill_direction_table($form, $header, $directions);
    // Подключаем отображение пейджинатора.
    $form['pager']['#markup'] = theme('pager');
    $link = l(t("Скачать статистику за все года"), 'archive/download/statistics/directions');
    $form['download'] = array(
        '#markup' => $link,
    );
    return $form;
}

function archive_all_directions_dropdown_callback($form, $form_state)
{
    $year = $form_state['complete form']['selects']['year']['#options'][$_POST['year']];
    if ($year == 'Все') {
        $years = get_years();
        $directions = array();
        foreach ($years as $nid => $year1) {
            $directions[$nid] = get_all_directions_archive_by_year($year1->year);
        }
    } else {
        $directions[0] = get_all_directions_archive_by_year($year);
    }
    $form['directions_table'] = fill_direction_table($form, $form['directions_table']['#header'], $directions);
    return $form['directions_table'];
}


function fill_direction_table($form, $header, $directions)
{
    $form['directions_table'] = array(
        '#type' => 'container',
        '#theme' => 'directions',
        '#header' => $header,
        '#prefix' => '<div id="direction-wrapper">',
        '#suffix' => '</div>',
    );

    foreach ($directions as $direction) {
        foreach ($direction as $nid => $node) {
            $link = l(t($node->direction_code), 'archive/direction', array('query' =>
                array('dir_code' => $node->direction_code, 'year' => $node->year)));

            $form['directions_table'][$node->year . '-' . $nid]['year'] = array(
                '#markup' => $node->year,
            );
            $form['directions_table'][$node->year . '-' . $nid]['dir_code'] = array(
                '#markup' => $link,
            );
            $form['directions_table'][$node->year . '-' . $nid]['dir_name'] = array(
                '#markup' => $node->direction_name,
            );
            $form['directions_table'][$node->year . '-' . $nid]['count_groups'] = array(
                '#markup' => $node->count_groups,
            );
            $form['directions_table'][$node->year . '-' . $nid]['count_studs'] = array(
                '#markup' => $node->count_studs,
            );
        }
    }
    return $form['directions_table'];
}

function create_excel_report_for_directions()
{
    require_once '/sites/all/libraries/Classes/PHPExcel.php';
    require_once('/sites/all/libraries/Classes/PHPExcel/Writer/Excel5.php');
    $PHPExcel = new PHPExcel();
    $PHPExcel->setActiveSheetIndex(0);
    $sheet = $PHPExcel->getActiveSheet();
    $sheet->setTitle('Направления');

    $years = get_years();
    $directions = get_all_directions_archive();

    $count_year = count((array)$years);
    $sheet->setCellValueByColumnAndRow(1, 1, 'Количество студентов');
    $sheet->mergeCellsByColumnAndRow(1, 1, $count_year, 1);
    $sheet->getStyleByColumnAndRow(1, 1)->getAlignment()->setHorizontal(
        PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValueByColumnAndRow($count_year + 1, 1, 'Количество студентов с темой ВКР');
    $sheet->mergeCellsByColumnAndRow($count_year + 1, 1, 2 * $count_year, 1);
    $sheet->getStyleByColumnAndRow($count_year + 1, 1)->getAlignment()->setHorizontal(
        PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValueByColumnAndRow(2 * $count_year + 1, 1, 'Количество защитившихся студентов');
    $sheet->mergeCellsByColumnAndRow(2 * $count_year + 1, 1, 3 * $count_year, 1);
    $sheet->getStyleByColumnAndRow(2 * $count_year + 1, 1)->getAlignment()->setHorizontal(
        PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValueByColumnAndRow(3 * $count_year + 1, 1, 'Количество студентов с оценкой 3');
    $sheet->mergeCellsByColumnAndRow(3 * $count_year + 1, 1, 4 * $count_year, 1);
    $sheet->getStyleByColumnAndRow(3 * $count_year + 1, 1)->getAlignment()->setHorizontal(
        PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValueByColumnAndRow(4 * $count_year + 1, 1, 'Количество студентов с оценкой 4');
    $sheet->mergeCellsByColumnAndRow(4 * $count_year + 1, 1, 5 * $count_year, 1);
    $sheet->getStyleByColumnAndRow(4 * $count_year + 1, 1)->getAlignment()->setHorizontal(
        PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValueByColumnAndRow(5 * $count_year + 1, 1, 'Количество студентов с оценкой 5');
    $sheet->mergeCellsByColumnAndRow(5 * $count_year + 1, 1, 6 * $count_year, 1);
    $sheet->getStyleByColumnAndRow(5 * $count_year + 1, 1)->getAlignment()->setHorizontal(
        PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $sheet->getColumnDimension('A')->setAutoSize(true);
    for ($i = 0; $i <= 6 * $count_year; $i++) {
        $sheet->getColumnDimensionByColumn($i)->setWidth(20);
    }

    $i = 1;
    for ($x = 0; $x < 6; $x++) {
        foreach ($years as $year) {
            $sheet->setCellValueByColumnAndRow($i, 2, $year->year);
            $i++;
        }
    }
    $i = 3;
    foreach ($directions as $direction) {
        $sheet->setCellValueByColumnAndRow(0, $i, $direction->direction_code . ' - ' . $direction->direction_name);
        $j = 1;
        foreach ($years as $year) {
            $count_studs = get_count_students_archive_by_dir($direction->direction_code, $year->year);
            $sheet->setCellValueByColumnAndRow($j, $i, $count_studs);
            $count_with_theme = get_count_students_with_theme_archive_by_dir($direction->direction_code, $year->year);
            $sheet->setCellValueByColumnAndRow($j + $count_year, $i, $count_with_theme);
            $count_defended = get_count_defended_students_archive_by_dir($direction->direction_code, $year->year);
            $sheet->setCellValueByColumnAndRow($j + 2 * $count_year, $i, $count_defended);
            $count_3 = get_count_students_archive_by_dir_and_eval($direction->direction_code, $year->year, 3);
            $sheet->setCellValueByColumnAndRow($j + 3 * $count_year, $i, $count_3);
            $count_4 = get_count_students_archive_by_dir_and_eval($direction->direction_code, $year->year, 4);
            $sheet->setCellValueByColumnAndRow($j + 4 * $count_year, $i, $count_4);
            $count_5 = get_count_students_archive_by_dir_and_eval($direction->direction_code, $year->year, 5);
            $sheet->setCellValueByColumnAndRow($j + 5 * $count_year, $i, $count_5);
            $j++;
        }
        $i++;
    }

    // Выводим HTTP-заголовки
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=directions.xls");

    $objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
    $file = 'archive/directions.xls';
    $objWriter->save($file);

}

function download_archive_stud_list_by_group()
{
    require_once '/sites/all/libraries/Classes/PHPWord.php';
    $PHPWord = new PHPWord();
    $PHPWord->setDefaultFontName('Times New Roman');
    $section = $PHPWord->createSection();

    if (empty($_GET['year']))
        $_GET['year'] = date('Y');
    if (empty($_GET['group']))
        $_GET['group'] = 1;
    $direction = get_direction_archive_by_group($_GET['group'], $_GET['year']);

    $PHPWord->addFontStyle('TitleStyle', array('bold' => true, 'align' => 'center', 'size' => 14));

    $section->addText('Темы ВКР и научные руководители, ' . ($_GET['year'] - 1) . ' - ' . $_GET['year']
        . ' уч. год ' . $direction[0]->direction_code . ' - ' . $direction[0]->direction_name . ', гр '.$_GET['group'], 'TitleStyle');


    $styleTable = array('borderSize' => 6, 'borderColor' => '000', 'cellMargin' => 80);
    $fontStyle = array('bold' => true, 'align' => 'center');
    $PHPWord->addTableStyle('myOwnTableStyle', $styleTable);
    $table = $section->addTable('myOwnTableStyle');

    $table->addRow(900);

    $table->addCell(500, $styleCell)->addText('№', $fontStyle);
    $table->addCell(1500, $styleCell)->addText('Фамилия, имя, отчество', $fontStyle);
    $table->addCell(1500, $styleCell)->addText('Тема ВКР', $fontStyle);
    $table->addCell(1500, $styleCell)->addText('Руководитель', $fontStyle);
    $table->addCell(1500, $styleCell)->addText('Консультант', $fontStyle);
    $table->addCell(1500, $styleCell)->addText('Доп. раздел', $fontStyle);
    $table->addCell(1500, $styleCell)->addText('Дата защиты', $fontStyle);

    $group = get_themes_by_year_and_group($_GET['year'], $_GET['group']);

    $i = 1;
    foreach ($group as $node) {
        $table->addRow(900);
        $table->addCell(1000, $styleCell)->addText($i, $fontStyle);
        $table->addCell(1000, $styleCell)->addText($node->student[0]->last_name . ' '
            . $node->student[0]->first_name . ' ' . $node->student[0]->patronymic, $fontStyle);
        $table->addCell(1000, $styleCell)->addText($node->diplom_name, $fontStyle);
        $table->addCell(1000, $styleCell)->addText($node->teacher[0]->last_name
            . ' ' . $node->teacher[0]->first_name . ' ' . $node->teacher[0]->patronymic, $fontStyle);
        $table->addCell(1000, $styleCell)->addText($node->consultant[0]->last_name
            . ' ' . $node->consultant[0]->first_name . ' ' . $node->consultant[0]->patronymic, $fontStyle);
        $table->addCell(1000, $styleCell)->addText($node->student[0]->name_section, $fontStyle);
        $table->addCell(1000, $styleCell)->addText($node->date_protect, $fontStyle);
        $i++;
    }
    $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
    $file = 'archive/' . $year . '/list_themes_group_' . $_GET['group'] . '_' . $year . '.docx';
    $objWriter->save($file);
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=list_themes_group_"
        . $_GET['group'] . "_" . $year . ".docx");
    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: binary");
    readfile($file);
}
