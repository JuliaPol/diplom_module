<?php

function archive_all_teachers()
{
    return drupal_get_form('archive_all_teachers_page');
}

function archive_all_teachers_page($form, &$form_state)
{
    $years = get_years();
    $activities = get_all_activities();
    $array = array();
    $array_dir = array();
    $i = 1;
    $array[0] = 'Все';
    foreach ($years as $value) {
        $array[$i++] = $value->year;
    }
    $array_dir[0] = 'Все';
    $i = 1;
    foreach ($activities as $value) {
        $array_dir[$i++] = $value->activity_name;
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
            'callback' => 'archive_all_teacher_dropdown_callback',
            'wrapper' => 'teacher-wrapper',
            'method' => 'replace',
            'effect' => 'fade',
        ),
    );

    $form['selects']['direction'] = array(
        '#type' => 'select',
        '#title' => t('Направление деятельности'),
        '#options' => $array_dir,
        '#default_value' => 0,
        '#prefix' => '<div style="padding: 10px; margin-right: 5px;">',
        '#suffix' => '</div>',
        '#ajax' => array(
            'event' => 'change',
            'callback' => 'archive_all_teacher_dropdown_callback',
            'wrapper' => 'teacher-wrapper',
            'method' => 'replace',
            'effect' => 'fade',
        ),
    );
    $header = array(
        array('data' => t('Год'), 'field' => 'year'),
        array('data' => t('ФИО'), 'field' => 'name'),
        array('data' => t('Должность'), 'field' => 'position'),
        array('data' => t('Направление деятельности'), 'field' => 'activity_name'),
        array('data' => t('Количество предлагаемых тем ВКР'), 'field' => 'count_themes'),
        array('data' => t('Количество студентов'), 'field' => 'count_studs'),
    );

    $nodes = get_teachers_archive($header, 99, 99);

    $form['simple_table'] = fill_teacher_table($form, $nodes, $header);
    // Подключаем отображение пейджинатора.
    $form['pager']['#markup'] = theme('pager');
    return $form;
}


function archive_all_teachers_dropdown_callback($form, $form_state)
{
    $year = $form_state['complete form']['selects']['year']['#options'][$_POST['year']];
    if ($year == 'Все') {
        $year = 99;
    }
    $direction = $form_state['complete form']['selects']['direction']['#options'][$_POST['direction']];
    if ($direction == 'Все') {
        $direction = 99;
    }
    $eval = $form_state['complete form']['selects']['eval']['#options'][$_POST['eval']];
    if ($eval == 'Все') {
        $eval = 99;
    }
//    global $year_changed, $dir_changed, $eval_changed;
//    $GLOBALS['year_changed'] = $year;
    $nodes = get_students_archive($form['simple_table']['#header'], $year, $direction, $eval);
    $form['simple_table'] = fill_table($form, $nodes, $form['simple_table']['#header']);
    return $form['simple_table'];
}

function fill_teacher_table($form, $nodes, $header)
{
    $form['simple_table'] = array(
        '#type' => 'container',
        '#theme' => 'simple',
        '#header' => $header,
        '#prefix' => '<div id="student-wrapper">',
        '#suffix' => '</div>',
    );

    foreach ($nodes as $nid => $node) {
        $link = l(t($node->last_name . ' ' . $node->first_name), 'archive/student', array('query' =>
            array('id' => $node->id_student, 'year' => date('Y', strtotime($node->date_protect)))));

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


function get_all_activities()
{
    db_set_active('archive_db');
    $query1 = db_select('activity', 'a');
    $query1->fields('a')
        ->condition('a.`year`', $year)
        ->orderBy('a.activity_name')
        ->groupBy('a.activity_name');
    $activities = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $activities;
}

function get_teachers_archive($header, $year, $direction) {

}

function get_students_by_teacher($header, $year, $teacher_activity)
{
    db_set_active('archive_db');
    $query1 = db_select('teacher', 't')
        ->extend('PagerDefault')
        ->extend('TableSort');
    $query1->leftJoin('teacher_activity', 't_a', 't.id_teacher = t_a.id_teacher AND t.`year` = t_a.`year`');
    $query1->leftJoin('activity', 'a', 'a.id_activity = t_a.id_activity AND a.`year` = t_a.`year`');
    $query1->fields('t')
        ->condition('a.activity_name', $teacher_activity)
        ->condition('t.`year`', $year)
        ->limit(10)
        ->orderByHeader($header);
    $students = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $students;
}