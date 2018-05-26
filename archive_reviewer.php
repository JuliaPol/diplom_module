<?php

function archive_all_reviewers()
{
    return drupal_get_form('archive_all_reviewers_page');
}

function archive_reviewer()
{
    return drupal_get_form('archive_reviewer_page');
}

function archive_reviewer_page($form, &$form_state)
{
    if (empty($_GET['year']))
        $_GET['year'] = date('Y');
    if (empty($_GET['id']))
        $_GET['id'] = 1;
    $teacher = get_reviewer_by_id_archive($_GET['id'], $_GET['year']);

    // Личные данные
    $form['personal_data'] = array(
        '#type' => 'fieldset',
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
        '#title' => 'Личные данные',
    );

    $form['personal_data']['column_left'] = array(
        '#type' => 'container',
        '#attributes' => array(
            'class' => array('column-left'),
            'style' => array('float: left'),
        ),
    );

    $form['personal_data']['column_right'] = array(
        '#type' => 'container',
        '#attributes' => array(
            'class' => array('column-right'),
            'style' => array('float: right'),
        ),
    );

    $form['personal_data']['column_left']['surname'] = array(
        '#type' => 'textfield',
        '#title' => t('Фамилия'),
        '#size' => 30,
        '#default_value' => $teacher[0]->last_name,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_left']['first_name'] = array(
        '#type' => 'textfield',
        '#title' => t('Имя'),
        '#size' => 30,
        '#default_value' => $teacher[0]->first_name,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_left']['patronymic'] = array(
        '#type' => 'textfield',
        '#title' => t('Отчество'),
        '#size' => 30,
        '#default_value' => $teacher[0]->patronymic,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_right']['degree'] = array(
        '#type' => 'textfield',
        '#title' => t('Степень'),
        '#size' => 30,
        '#default_value' => $teacher[0]->degree,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_right']['email'] = array(
        '#type' => 'textfield',
        '#title' => t('Email'),
        '#size' => 20,
        '#default_value' => $teacher[0]->email,
        '#disabled' => TRUE,
    );

    return $form;
}

//TODO: add years filter
function archive_all_reviewers_page($form, &$form_state)
{
    $header = array(
        array('data' => t('Год'), 'field' => 'year'),
        array('data' => t('Направление'), 'field' => 'direction_name'),
        array('data' => t('Код направления'), 'field' => 'direction_code'),
        array('data' => t('ФИО рецензента'), 'field' => 'reviewer'),
        array('data' => t('Количество рецензий'), 'field' => 'count')
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
    $nodes = get_all_reviewers_archive($header);

    $form['reviewers_table'] = fill_table_reviewers($form, $nodes, $header);
    $form['pager']['#markup'] = theme('pager');
    $link = l(t("Скачать статистику за все года"), 'archive/download/statistics/reviewers');
    $form['download'] = array(
        '#markup' => $link,
    );
    return $form;
}

function fill_table_reviewers($form, $nodes, $header)
{
    $form['reviewers_table'] = array(
        '#type' => 'container',
        '#theme' => 'reviewers',
        '#header' => $header,
        '#prefix' => '<div id="reviewers-wrapper">',
        '#suffix' => '</div>',
    );

    foreach ($nodes as $nid => $node) {
        $link = l(t($node->last_name . ' ' . $node->first_name . ' ' . $node->patronymic), 'archive/reviewer', array('query' =>
            array('id' => $node->id_reviewer, 'year' => $node->year)));

        $count_review = get_count_reviews_by_id($node->id_reviewer, $node->year);

        $form['reviewers_table'][$nid]['year'] = array(
            '#markup' => $node->year,
        );
        $form['reviewers_table'][$nid]['direction_name'] = array(
            '#markup' => $node->direction_name,
        );
        $form['reviewers_table'][$nid]['direction_code'] = array(
            '#markup' => $node->direction_code,
        );
        $form['reviewers_table'][$nid]['reviewer'] = array(
            '#markup' => $link,
        );
        $form['reviewers_table'][$nid]['count'] = array(
            '#markup' => $count_review,
        );
    }
    return $form['reviewers_table'];
}

function get_reviewer_by_id_archive($id, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('reviewer', 'r');
    $query1->fields('r')
        ->condition('r.id_reviewer', $id)
        ->condition('r.`year`', $year);
    $reviewer = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $reviewer;
}

function get_reviewer_by_direction_archive($direction, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('reviewer', 'r');
    $query1->leftJoin('reviewer_student', 'r_s', 'r.id_reviewer = r_s.id_reviewer AND r.`year` = r_s.`year`');
    $query1->leftJoin('student', 's', 's.id_student = r_s.id_student AND s.`year` = r_s.`year`');
    $query1->leftJoin('stud_group', 'g', 'g.id_group = s.id_group AND g.`year` = s.`year`');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND d.`year` = g.`year`');
    $query1->fields('r')
        ->fields('d', array('direction_name', 'direction_code'))
        ->condition('d.direction_code', $direction)
        ->condition('r.`year`', $year);
    $reviewer = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $reviewer;
}

function get_years_with_reviewer_archive()
{
    db_set_active('archive_db');
    $query1 = db_select('reviewer', 'r');
    $query1->innerJoin('reviewer_student', 'r_s', 'r.id_reviewer = r_s.id_reviewer AND r.`year` = r_s.`year`');
    $query1->innerJoin('student', 's', 's.id_student = r_s.id_student AND s.`year` = r_s.`year`');
    $query1->leftJoin('stud_group', 'g', 'g.id_group = s.id_group AND g.`year` = s.`year`');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND d.`year` = g.`year`');
    $query1->fields('r')
        ->groupBy('r.year');
    $reviewer = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $reviewer;
}

function get_all_reviewers_archive()
{
    db_set_active('archive_db');
    $query1 = db_select('reviewer', 'r');
    $query1->innerJoin('reviewer_student', 'r_s', 'r.id_reviewer = r_s.id_reviewer AND r.`year` = r_s.`year`');
    $query1->innerJoin('student', 's', 's.id_student = r_s.id_student AND s.`year` = r_s.`year`');
    $query1->leftJoin('stud_group', 'g', 'g.id_group = s.id_group AND g.`year` = s.`year`');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND d.`year` = g.`year`');
    $query1->fields('r')
        ->fields('d', array('direction_name', 'direction_code'))
        ->orderBy('r.year', 'DESC');
    $reviewer = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $reviewer;
}

function get_count_reviews_by_id($id, $year)
{
    db_set_active('archive_db');
    $query2 = db_select('student', 's');
    $query2->leftJoin('reviewer_student', 'r_s', 's.id_student = r_s.id_student AND s.`year` = r_s.`year`');
    $query2->leftJoin('reviewer', 'r', 'r.id_reviewer = r_s.id_reviewer AND r.`year` = r_s.`year`');
    $query2->fields('r')
        ->condition('r.id_reviewer', $id)
        ->condition('r.`year`', $year)
        ->execute();
    $num_of_results = $query2->execute()->rowCount();
    db_set_active();
    return $num_of_results;
}

function create_excel_report_for_reviewers()
{
    require_once '/sites/all/libraries/Classes/PHPExcel.php';
    require_once('/sites/all/libraries/Classes/PHPExcel/Writer/Excel5.php');
    $PHPExcel = new PHPExcel();
    $PHPExcel->setActiveSheetIndex(0);
    $sheet = $PHPExcel->getActiveSheet();
    $sheet->setTitle('Рецензенты');

    $years = get_years();
    $directions = get_all_directions_archive();

    $count_year = count((array)$years);
    $sheet->setCellValueByColumnAndRow(1, 1, 'Количество рецензентов');
    $sheet->mergeCellsByColumnAndRow(1, 1, $count_year, 1);
    $sheet->getStyleByColumnAndRow(1, 1)->getAlignment()->setHorizontal(
        PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValueByColumnAndRow($count_year + 1, 1, 'Количество рецензий');
    $sheet->mergeCellsByColumnAndRow($count_year + 1, 1, 2 * $count_year, 1);
    $sheet->getStyleByColumnAndRow($count_year + 1, 1)->getAlignment()->setHorizontal(
        PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $sheet->getColumnDimension('A')->setAutoSize(true);
    for ($i = 0; $i <= 2*$count_year; $i++) {
        $sheet->getColumnDimensionByColumn($i)->setWidth(30);
    }

    $i = 1;
    for ($x = 0; $x < 2; $x++) {
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
            $reviewers = get_reviewer_by_direction_archive($direction->direction_code, $year->year);
            $sheet->setCellValueByColumnAndRow($j, $i, count((array)$reviewers));
            $count_review = 0;
            foreach ($reviewers as $reviewer) {
                $count_review += get_count_reviews_by_id($reviewer->id_reviewer, $year->year);
            }
            $sheet->setCellValueByColumnAndRow($j + $count_year, $i, count((array)$reviewers));
            $j++;
        }
        $i++;
    }


    // Выводим HTTP-заголовки
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=reviewers.xls");

    $objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
    $file = 'archive/reviewers.xls';
    $objWriter->save($file);


}