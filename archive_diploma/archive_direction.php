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

function archive_all_directions()
{
    return drupal_get_form('archive_all_directions_page');
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