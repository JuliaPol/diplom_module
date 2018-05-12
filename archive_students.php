<?php

function archive_all_students()
{
    return drupal_get_form('archive_all_students_page');
}

function archive_all_students_page($form, &$form_state)
{
    $years = get_years();
    $array = array();
    $i = 0;
    foreach ($years as $value) {
        $array[$i++] = $value->year;
    }
    $form['year'] = array(
        '#type' => 'select',
        '#title' => t('Год'),
        '#options' => $array,
        '#default_value' => 0,
        '#ajax' => array(
            'event' => 'change',
            'callback' => 'archive_all_students_dropdown_callback',
            'wrapper' => 'student-wrapper',
            'method' => 'replace',
            'effect' => 'fade',
        ),
    );

    $header = array(
        array('data' => t('ФИО'), 'field' => 's.last_name'),
        array('data' => t('Группа'), 'field' => 'g.group_number'),
        array('data' => t('Направление'), 'field' => 'd.direction_name'),
        array('data' => t('Код направления'), 'field' => 'd.direction_code'),
        array('data' => t('Год выпуска'), 'field' => 'dip.date_protect'),
        array('data' => t('Итоговая оценка'), 'field' => 'dip.final_evaluation'),
    );

    $nodes = get_all_students($header);

    $form['simple_table'] = fill_table($form, $nodes, $header);
    // Подключаем отображение пейджинатора.
    $form['pager']['#markup'] = theme('pager');
    return $form;
}

function archive_all_students_dropdown_callback($form, $form_state)
{
    $year = $form_state['complete form']['year']['#options'][$form_state['values']['year']];

    $nodes = get_student_by_year($form['simple_table']['#header'], $year);

    $form['simple_table'] = fill_table($form, $nodes, $form['simple_table']['#header']);
    return $form['simple_table'];
}

function fill_table($form, $nodes, $header)
{
    $form['simple_table'] = array(
        '#type' => 'container',
        '#theme' => 'simple',
        '#header' => $header,
        '#prefix' => '<div id="student-wrapper">',
        '#suffix' => '</div>',
    );

    foreach ($nodes as $nid => $node) {
        $form['simple_table'][$nid]['last_name'] = array(
            '#type' => 'link',
            '#title' => t($node->last_name . ' ' . $node->first_name),
            '#href' => 'archive/student/' . $node->id_student,
        );
        $form['simple_table'][$nid]['group_number'] = array(
            '#markup' => $node->group_number,
        );
        $form['simple_table'][$nid]['direction_name'] = array(
            '#markup' => $node->direction_name,
        );
        $form['simple_table'][$nid]['direction_code'] = array(
            '#markup' => $node->direction_code,
        );
        $form['simple_table'][$nid]['date_protect'] = array(
            '#markup' => date('Y', strtotime($node->date_protect)),
        );
        $form['simple_table'][$nid]['final_evaluation'] = array(
            '#markup' => $node->final_evaluation,
        );
    }
    return $form['simple_table'];
}

function get_years()
{
    db_set_active('archive_db');
    $years = db_select('student', 's')
        ->fields('s', array('year'))
        ->groupBy('year')
        ->execute()
        ->fetchAll();
    db_set_active();
    return $years;
}

function get_student_by_year($header, $year)
{
    db_set_active('archive_db');

//    $query = db_query("SELECT s.*, g.group_number AS group_number, d.direction_code AS direction_code,
// d.direction_name AS direction_name, dip.* FROM student AS s LEFT OUTER JOIN `group` AS g ON g.id_group = s.id_group
// AND g.`year` =s.`year` LEFT OUTER JOIN direction AS d ON g.id_direction = d.id_direction AND d.`year` = g.`year`
//INNER JOIN teacher_student_diplom AS dip ON s.id_student = dip.id_student AND s.`year` =dip.`year` WHERE s.`year` =$year;");
    $query1 = db_select('student', 's')
        ->extend('PagerDefault')
        ->extend('TableSort');
    $query1->leftJoin('stud_group', 'g', 'g.id_group = s.id_group AND g.`year` = s.`year`');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND d.`year` = g.`year`');
    $query1->innerJoin('teacher_student_diplom', 'dip', 's.id_student = dip.id_student AND s.`year` =dip.`year`');
    $query1->fields('s')
        ->fields('g', array('group_number'))
        ->fields('d', array('direction_code', 'direction_name'))
        ->fields('dip', array('final_evaluation', 'date_protect'))
        ->condition('s.`year`', $year)
        ->limit(5)
        ->orderByHeader($header);
    $students = $query1->execute()
        ->fetchAll();

    db_set_active();
    return $students;
}

function get_all_students($header)
{
    db_set_active('archive_db');
    $query1 = db_select('student', 's')
        ->extend('PagerDefault')
        ->extend('TableSort');
    $query1->leftJoin('stud_group', 'g', 'g.id_group = s.id_group AND g.`year` = s.`year`');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND d.`year` = g.`year`');
    $query1->innerJoin('teacher_student_diplom', 'dip', 's.id_student = dip.id_student AND s.`year` =dip.`year`');
    $query1->fields('s')
        ->fields('g', array('group_number'))
        ->fields('d', array('direction_code', 'direction_name'))
        ->fields('dip', array('final_evaluation', 'date_protect'))
        ->limit(5)
        ->orderByHeader($header);
    $students = $query1->execute()
        ->fetchAll();

    db_set_active();
    return $students;
}