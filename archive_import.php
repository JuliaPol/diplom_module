<?php

function archive_create()
{

    $form['submit_button'] = array(
        '#type' => 'submit',
        '#value' => t('Click Here!'),
    );

    $year = date('Y');
    $activity = get_object_from_table('activity');
    $additional_section = get_object_from_table('additional_section');
    $teacher = get_object_from_table('teacher');
    $teacher_activity = get_object_from_table('teacher_activity');
    $teacher = get_object_from_table('teacher');
    $member_SEC = get_object_from_table('member_SEC');

    db_set_active('archive_db');

    foreach ($activity as $value) {
        db_insert('activity')
            ->fields(array(
                'id_activity' => $value->activity_id,
                'activity_name' => $value->activity_name,
                'year' => $year,
            ))
            ->execute();
    }

    foreach ($additional_section as $value) {
        db_insert('additional_section')
            ->fields(array(
                'id_additional_section' => $value->id_AS,
                'name_department' => $value->name_department,
                'name_section' => $value->name_AS,
                'year' => $year,
            ))
            ->execute();
    }

    foreach ($teacher as $value) {
        db_insert('teacher')
            ->fields(array(
                'id_teacher' => $value->idTeacher,
                'passport' => $value->Passport,
                'last_name' => $value->Surname,
                'first_name' => $value->FirstNam,
                'patronymic' => $value->Patronymic,
                'position' => $value->Position,
                'degree' => $value->Degree,
                'rank' => $value->Rank,
                'mobile_phone' => $value->Mobile,
                'work_phone' => $value->WorkPhone,
                'email' => $value->E-mail,
                'address' => $value->Address,
                'year' => $year,
            ))
            ->execute();
    }

    foreach ($teacher_activity as $value) {
        db_insert('teacher_activity')
            ->fields(array(
                'id_teacher_activity' => $value->teacher_activity_id,
                'id_teacher' => $value->teacher_id,
                'id_activity' => $value->activity_id,
                'year' => $year,
            ))
            ->execute();
    }
    db_set_active();

    return $form;
}

function get_object_from_table($table_name)
{
    return db_select($table_name, 'a')
        ->fields('a')
        ->execute()
        ->fetchAll();
}