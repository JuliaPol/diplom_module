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

        $form['section_table'][$nid]['year'] = array(
            '#markup' => $node->year,
        );
        $form['section_table'][$nid]['section'] = array(
            '#markup' => $node->name_section,
        );
        $form['section_table'][$nid]['department'] = array(
            '#markup' => $node->name_department,
        );
        $form['section_table'][$nid]['name'] = array(
            '#markup' => $link,
        );
        $form['section_table'][$nid]['count'] = array(
            '#markup' => count(array($students)),
        );
    }
    return $form['section_table'];
}

function get_additional_sections_archive($year) {
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

function get_all_additional_sections_archive() {
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