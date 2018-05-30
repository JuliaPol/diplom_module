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
            'callback' => 'archive_all_teachers_dropdown_callback',
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
            'callback' => 'archive_all_teachers_dropdown_callback',
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
    $activity = $form_state['complete form']['selects']['direction']['#options'][$_POST['direction']];
    if ($activity == 'Все') {
        $activity = 99;
    }
    $nodes = get_teachers_archive($form['simple_table']['#header'], $year, $activity);
    $form['simple_table'] = fill_teacher_table($form, $nodes, $form['simple_table']['#header']);
    return $form['simple_table'];
}

function fill_teacher_table($form, $nodes, $header)
{
    $form['simple_table'] = array(
        '#type' => 'container',
        '#theme' => 'teachers',
        '#header' => $header,
        '#prefix' => '<div id="teacher-wrapper">',
        '#suffix' => '</div>',
    );

    foreach ($nodes as $nid => $node) {
        $link = l(t($node->last_name . ' ' . $node->first_name . ' ' . $node->patronymic), 'archive/teacher', array('query' =>
            array('id' => $node->id_teacher, 'year' => $node->year)));
        $activities = '';
        foreach ($node->activity as $activity_name) {
            $activities .= $activity_name->activity_name . '; ';
        }

        $form['simple_table'][$nid]['year'] = array(
            '#markup' => $node->year,
        );
        $form['simple_table'][$nid]['name'] = array(
            '#markup' => $link,
        );
        $form['simple_table'][$nid]['position'] = array(
            '#markup' => $node->position,
        );
        $form['simple_table'][$nid]['activity_name'] = array(
            '#markup' => $activities,
        );
        $form['simple_table'][$nid]['count_themes'] = array(
            '#markup' => $node->count_themes,
        );
        $form['simple_table'][$nid]['count_studs'] = array(
            '#markup' => $node->count_stud,
        );
    }
    return $form['simple_table'];
}


function get_all_activities()
{
    db_set_active('archive_db');
    $query1 = db_select('activity', 'a');
    $query1->fields('a')
        ->orderBy('a.activity_name')
        ->groupBy('a.activity_name');
    $activities = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $activities;
}

function get_all_activities_by_teacher($teacher_id, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('teacher', 't');
    $query1->leftJoin('teacher_activity', 't_a', 't.id_teacher = t_a.id_teacher AND t.`year` = t_a.`year`');
    $query1->leftJoin('activity', 'a', 'a.id_activity = t_a.id_activity AND a.`year` = t_a.`year`');
    $query1->fields('a')
        ->condition('a.`year`', $year)
        ->condition('t.id_teacher', $teacher_id)
        ->orderBy('a.activity_name');
    $activities = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $activities;
}


function get_teachers_archive($header, $year, $teacher_activity)
{
    db_set_active('archive_db');
    $query1 = db_select('teacher', 't')
        ->extend('PagerDefault')
        ->extend('TableSort');
    $query1->leftJoin('teacher_activity', 't_a', 't.id_teacher = t_a.id_teacher AND t.`year` = t_a.`year`');
    $query1->leftJoin('activity', 'a', 'a.id_activity = t_a.id_activity AND a.`year` = t_a.`year`');
    $query1->fields('t');
    if ($year !== 0 && $year !== 99) {
        $query1->condition('t.`year`', $year);
        $query1->groupBy('t.id_teacher');
    }
//    else {
//        $query1->groupBy('t.id_teacher');
//        $query1->groupBy('t.year');
//    }
    if ($teacher_activity !== 0 && $teacher_activity !== 99) {
        $query1->condition('a.activity_name', $teacher_activity);
    }
    $query1->groupBy('t.id_teacher');
    $query1->groupBy('t.year')
        ->limit(10)
        ->orderByHeader($header);
    $teachers = $query1->execute()
        ->fetchAll();
    foreach ($teachers as $nid => $value) {
        $teachers[$nid]->activity = get_all_activities_by_teacher($value->id_teacher, $value->year);
        $teachers[$nid]->count_themes = count((array)get_themes_by_id_teacher($value->id_teacher, $value->year, false));
        $teachers[$nid]->count_stud = count((array)get_students_by_teacher($header, $value->year, $value->id_teacher));
    }
    db_set_active();
    return $teachers;
}
