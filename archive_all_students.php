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

    $nodes = get_students_by_year($form['simple_table']['#header'], $year);

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
        $link = l( t($node->last_name . ' ' . $node->first_name), 'archive/student', array('query' =>
            array('id' =>  $node->id_student, 'year' => date('Y', strtotime($node->date_protect)))));

        $form['simple_table'][$nid]['last_name'] = array(
            '#markup' => $link,
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
        ->orderBy('s.year', 'DESC')
        ->execute()
        ->fetchAll();
    db_set_active();
    return $years;
}

function get_students_by_evaluation($header, $year, $evaluation, $dir_code) {
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
        ->fields('dip')
        ->condition('d.direction_code', $dir_code)
        ->condition('dip.final_evaluation', $evaluation)
        ->condition('s.`year`', $year)
        ->limit(10)
        ->orderByHeader($header);
    $students = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $students;
}

function get_students_by_teacher($header, $year, $teacher_id)
{
    db_set_active('archive_db');
    $query1 = db_select('student', 's')
        ->extend('PagerDefault')
        ->extend('TableSort');
    $query1->innerJoin('teacher_student_diplom', 'dip', 's.id_student = dip.id_student AND s.`year` =dip.`year`');
    $query1->leftJoin('teacher', 't', 't.id_teacher = dip.id_teacher AND t.`year` =dip.`year`');
    $query1->leftJoin('stud_group', 'g', 'g.id_group = s.id_group AND g.`year` = s.`year`');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND d.`year` = g.`year`');
    $query1->fields('s')
        ->fields('g', array('group_number'))
        ->fields('d', array('direction_code', 'direction_name'))
        ->fields('dip')
        ->condition('t.id_teacher', $teacher_id)
        ->condition('s.`year`', $year)
        ->limit(10)
        ->orderByHeader($header);
    $students = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $students;
}

function get_students_by_teacher_activity($header, $year, $teacher_activity)
{
    db_set_active('archive_db');
    $query1 = db_select('student', 's')
        ->extend('PagerDefault')
        ->extend('TableSort');
    $query1->innerJoin('teacher_student_diplom', 'dip', 's.id_student = dip.id_student AND s.`year` =dip.`year`');
    $query1->leftJoin('teacher', 't', 't.id_teacher = dip.id_teacher AND t.`year` =dip.`year`');
    $query1->leftJoin('stud_group', 'g', 'g.id_group = s.id_group AND g.`year` = s.`year`');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND d.`year` = g.`year`');
    $query1->leftJoin('teacher_activity','t_a', 't.id_teacher = t_a.id_teacher AND t.`year` = t_a.`year`');
    $query1->leftJoin('activity', 'a', 'a.id_activity = t_a.id_activity AND a.`year` = t_a.`year`');
    $query1->fields('s')
        ->fields('g', array('group_number'))
        ->fields('d', array('direction_code', 'direction_name'))
        ->fields('dip')
        ->condition('a.activity_name', $teacher_activity)
        ->condition('s.`year`', $year)
        ->limit(10)
        ->orderByHeader($header);
    $students = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $students;
}

function get_students_by_year($header, $year)
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
        ->condition('s.`year`', $year)
        ->limit(10)
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
        ->limit(10)
        ->orderByHeader($header);
    $students = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $students;
}