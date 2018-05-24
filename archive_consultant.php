<?php
function get_consultant_by_additional_sections_archive($year, $add_section, $department)
{
    db_set_active('archive_db');
    $query1 = db_select('additional_section', 'a_s');
    $query1->leftJoin('consultant_as', 'c_a_s', 'c_a_s.id_additional_section = a_s.id_additional_section AND a_s.`year` = c_a_s.`year`');
    $query1->fields('a_s')
        ->fields('c_a_s')
        ->condition('a_s.name_section', $add_section)
        ->condition('a_s.name_department', $department)
        ->condition('a_s.`year`', $year);
    $section = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $section;
}