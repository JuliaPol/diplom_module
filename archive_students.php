<?php

function archive_all_students()
{
    return drupal_get_form('archive_all_students_form');
}

function archive_all_students_form()
{
    $form = array();
    $years = get_years();
    $array = array();
    $i = 0;
    foreach ($years as $value) {
        $array[$i++] = $value->year;
    }
    $form['year'] = array(
        '#type' => 'select',
        '#title' => t('Год'),
        '#options' => $array
    );
    $form['submit_button'] = array(
        '#type' => 'submit',
        '#value' => t('Создать архив'),
    );

//    $message = $form_state['values']['message'];
//    $form['message'] = array(
//        '#type' => 'fieldset',
//        '#value' => $message,
//    );
    return $form;
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

function get_student_by_year($year) {
    db_set_active('archive_db');

    $query = db_query("SELECT s.*, g.group_number AS group_number, d.direction_code AS direction_code,
 d.direction_name AS direction_name, dip.* FROM student AS s LEFT OUTER JOIN `group` AS g ON g.id_group = s.id_group 
 AND g.`year` =s.`year` LEFT OUTER JOIN direction AS d ON g.id_direction = d.id_direction AND d.`year` = g.`year`
INNER JOIN teacher_student_diplom AS dip ON s.id_student = dip.id_student AND s.`year` =dip.`year` WHERE s.`year` =$year;");
    $students = $query->fetchAll();

    db_set_active();
    return $students;
}