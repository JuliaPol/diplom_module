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

    $nodes = get_all_themes();

    $form['theme_table'] = fill_diploma_table($form, $nodes, $header);
    // Подключаем отображение пейджинатора.
    $form['pager']['#markup'] = theme('pager');
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
            $link_teacher = l(t($node->teacher[0]->last_name . ' ' . $node->teacher[0]->first_name.' '.$node->teacher[0]->patronymic),
                'archive/teacher', array('query' => array('id' => $node->id_teacher, 'year' => date('Y', strtotime($node->year)))));
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
    $query1 = db_select('diplom', 'd')
        ->extend('PagerDefault')
        ->extend('TableSort');
    $query1->innerJoin('teacher_student_diplom', 'dip', 'dip.id_theme = d.id_diplom AND d.`year` = dip.`year`');
    $query1->leftJoin('student', 's', 'dip.id_student = s.id_student AND s.`year` = dip.`year`');
    $query1->leftJoin('stud_group', 'g', 'g.id_group = s.id_group AND g.`year` = s.`year`');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND d.`year` = g.`year`');
    $query1->fields('d')
        ->fields('dip')
        ->fields('d', array('direction_code', 'direction_name'))
        ->condition('d.`year`', $year)
        ->condition('d.direction_code', $direction)
        ->orderBy('d.`year`', 'DESC')
        ->limit(10);
    $themes = $query1->execute()
        ->fetchAll();
    foreach ($themes as $nid => $value) {
        $themes[$nid]->teacher = get_teacher_by_id_archive($value->id_teacher, $value->year);
        $themes[$nid]->student = get_student_by_id_archive($value->id_student, $value->year);
    }
    db_set_active();
    return $themes;
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