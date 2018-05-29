<?php
function get_students_by_teacher($header, $year, $teacher_activity)
{
    db_set_active('archive_db');
    $query1 = db_select('teacher', 't')
        ->extend('PagerDefault')
        ->extend('TableSort');
    $query1->leftJoin('teacher_activity','t_a', 't.id_teacher = t_a.id_teacher AND t.`year` = t_a.`year`');
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