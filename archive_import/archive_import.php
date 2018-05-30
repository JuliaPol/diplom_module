<?php

function archive_create()
{
    return drupal_get_form('archive_import_form');
}

function archive_import_form($form, $form_state)
{
    $form = array();
    $form['year'] = array(
        '#type' => 'textfield',
        '#title' => t('Год'),
        '#size' => 20,
        '#default_value' => date('Y'),
        '#required' => TRUE,
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

function archive_import_form_validate($form, &$form_state)
{
    $year = $form_state['values']['year'];
    if ($year > date('Y') || $year < 1990) {
        form_set_error('year', t('Введите корректный год'));
    }
}

function archive_import_form_submit($form, &$form_state)
{
    $year = $form_state['values']['year'];

    $activity = get_object_from_table('activity');
    $additional_section = get_object_from_table('additional_section');
    $teacher = get_object_from_table('teacher');
    $teacher_activity = get_object_from_table('teacher_activity');
    $member_SEC = get_object_from_table('member_gak');
    $direction = get_object_from_table('direction');
    $direction_member_SEC = get_object_from_table('direction_member_gak');
    $direction_teacher = get_object_from_table('teacher_member_gak');

    $query = db_query('SELECT a.*, u.Direction FROM `group` AS a LEFT OUTER JOIN curriculum AS u 
                              ON a.Curriculum = u.idCurriculum WHERE (a.CreationYear = ' . ($year - 4) . ' 
                               OR a.CreationYear = ' . ($year - 6) . ');');
    $group = $query->fetchAll();

    $group_teacher = get_object_from_table('demo_material_consultantion');

    $student = db_query('SELECT a.* FROM student AS a LEFT OUTER JOIN `group` AS u 
                              ON a.Group = u.idGroup WHERE (u.CreationYear = ' . ($year - 4) . ' 
                               OR u.CreationYear = ' . ($year - 6) . ' OR YEAR(a.ExpelDate) = ' . $year . ');');

    $consultant_company = get_object_from_table('consultant_company');
    $consultant_student = get_object_from_table('student_consultant_company');
    $reviewer = get_object_from_table('reviewer');
    $reviewer_student = get_object_from_table('student_reviewer');
    $student_additional_section = get_object_from_table('student_additional_section');
    $consultant_as = get_object_from_table('consultant_as');
    $annotation_diplom = get_object_from_table('annotation_diplom');
    $diplom = get_object_from_table('diplom');

    $query = db_select('teacher_student_diplom', 'a');
    $query->leftJoin('student', 'u', 'a.student_id = u.idStudent');
    $query->fields('a');
    $query->fields('u', array('percent_plagiat'));
    $teacher_student_diplom = $query->execute()->fetchAll();

    db_set_active('archive_db');

    $archive_exists = db_select('student', 'a')
        ->fields('a')
        ->condition('`year`', $year)
        ->execute()
        ->fetchAll();

    if (count($archive_exists) > 0) {
//        form_set_error(t('Архив за ' . $year . ' год уже существует!'));
    } else {
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
                    'first_name' => $value->FirstName,
                    'patronymic' => $value->Patronymic,
                    'position' => $value->Position,
                    'degree' => $value->Degree,
                    'rank' => $value->Rank,
                    'mobile_phone' => $value->Mobile,
                    'work_phone' => $value->WorkPhone,
                    'email' => $value->{"E-mail"},
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

        foreach ($member_SEC as $value) {
            db_insert('member_SEC')
                ->fields(array(
                    'id_member_SEC' => $value->id_member_gak,
                    'passport' => $value->passport_member_gak,
                    'last_name' => $value->surname_member_gak,
                    'first_name' => $value->first_name_member_gak,
                    'patronymic' => $value->patronymic_member_gak,
                    'role' => $value->who_is_in_gak,
                    'mobile_phone' => $value->mobile,
                    'work_phone' => $value->work_hone,
                    'email' => $value->email,
                    'address' => $value->address,
                    'year' => $year,
                ))
                ->execute();
        }

        foreach ($direction as $value) {
            db_insert('direction')
                ->fields(array(
                    'id_direction' => $value->idDirection,
                    'direction_code' => $value->DirectionCode,
                    'direction_name' => $value->DirectionName,
                    'faculty' => $value->Faculty,
                    'ref_the_best_students' => $value->ref_the_best_students,
                    'ref_report_head' => $value->ref_report_head,
                    'year' => $year,
                ))
                ->execute();
        }

        foreach ($direction_member_SEC as $value) {
            db_insert('direction_member_SEC')
                ->fields(array(
                    'id_direction_member_SEC' => $value->id_direction_mamber_gak,
                    'id_member_SEC' => $value->id_member_gak,
                    'id_direction' => $value->id_direction,
                    'year' => $year,
                ))
                ->execute();
        }

        foreach ($direction_teacher as $value) {
            db_insert('direction_teacher')
                ->fields(array(
                    'id_direction_teacher' => $value->id_teacher_member_gak,
                    'id_teacher' => $value->id_teacher,
                    'id_direction' => $value->id_direction,
                    'role_teacher' => $value->role_teacher,
                    'year' => $year,
                ))
                ->execute();
        }

        foreach ($group as $value) {
            db_insert('stud_group')
                ->fields(array(
                    'id_group' => $value->idGroup,
                    'group_number' => $value->GroupNum,
                    'size' => $value->Size,
                    'creation_year' => $value->CreationYear,
                    'email' => $value->{"E-mail"},
                    'id_direction' => $value->Direction,
                    'year' => $year,
                ))
                ->execute();
        }

        foreach ($group_teacher as $value) {
            db_insert('group_teacher')
                ->fields(array(
                    'id_group_teacher' => $value->id_demo_material_consultantion,
                    'id_teacher' => $value->id_teacher,
                    'id_group' => $value->id_group,
                    'year' => $year,
                ))
                ->execute();
        }


        foreach ($student as $value) {
            db_insert('student')
                ->fields(array(
                    'id_student' => $value->idStudent,
                    'passport' => $value->Passport,
                    'last_name' => $value->Surname,
                    'first_name' => $value->FirstName,
                    'patronymic' => $value->Patronymic,
                    'record_book_number' => $value->RecordBookNum,
                    'phone' => $value->Phone,
                    'id_group' => $value->Group,
                    'email' => $value->{"E-mail"},
                    'enrollment_date' => $value->EnrollmentDate,
                    'expel_date' => $value->ExpelDate,
                    'sum_3' => $value->percent_3,
                    'sum_4' => $value->percent_4,
                    'sum_5' => $value->percent_5,
                    'year' => $year,
                ))
                ->execute();
        }

        foreach ($consultant_company as $value) {
            db_insert('consultant_company')
                ->fields(array(
                    'id_consultant_company' => $value->id_consultant_company,
                    'passport' => $value->passport_consultant_company,
                    'last_name' => $value->surname_consultant_company,
                    'first_name' => $value->first_name_consultant_company,
                    'patronymic' => $value->patronymic_consultant_company,
                    'company_name' => $value->name_company,
                    'phone' => $value->mobile,
                    'email' => $value->email,
                    'year' => $year,
                ))
                ->execute();
        }

        foreach ($consultant_student as $value) {
            db_insert('consultant_student')
                ->fields(array(
                    'id_consultant_student' => $value->id_student_consultant_company,
                    'id_consultant' => $value->id_consultant_company,
                    'id_student' => $value->id_student,
                    'year' => $year,
                ))
                ->execute();
        }

        foreach ($reviewer as $value) {
            db_insert('reviewer')
                ->fields(array(
                    'id_reviewer' => $value->idReviewer,
                    'passport' => $value->Passport,
                    'last_name' => $value->Surname,
                    'first_name' => $value->FirstName,
                    'patronymic' => $value->Patronymic,
                    'degree' => $value->Degree,
                    'email' => $value->{"E-mail"},
                    'year' => $year,
                ))
                ->execute();
        }

        foreach ($reviewer_student as $value) {
            db_insert('reviewer_student')
                ->fields(array(
                    'id_reviewer_student' => $value->id_student_reviewer,
                    'id_reviewer' => $value->id_reviewer,
                    'id_student' => $value->id_student,
                    'year' => $year,
                ))
                ->execute();
        }

        foreach ($student_additional_section as $value) {
            db_insert('student_additional_section')
                ->fields(array(
                    'id_student_as' => $value->student_additional_section,
                    'id_as' => $value->id_additional_section,
                    'id_student' => $value->id_student,
                    'year' => $year,
                ))
                ->execute();
        }

        foreach ($consultant_as as $value) {
            db_insert('consultant_as')
                ->fields(array(
                    'id_consultant_as' => $value->id_consultant_AS,
                    'last_name' => $value->surname_consultant_AS,
                    'first_name' => $value->first_name_consultant_AS,
                    'patronymic' => $value->patronymic_consultant_AS,
                    'work_phone' => $value->work_hone,
                    'mobile_phone' => $value->mobile,
                    'email' => $value->email,
                    'id_additional_section' => $value->id_additional_section,
                    'year' => $year,
                ))
                ->execute();
        }

        foreach ($annotation_diplom as $value) {
            db_insert('annotation_diplom')
                ->fields(array(
                    'id_annotation' => $value->id_annotation,
                    'id_diplom' => $value->id_diplom,
                    'ref_annotation' => $value->ref_annotation,
                    'year' => $year,
                ))
                ->execute();
        }

        foreach ($diplom as $value) {
            db_insert('diplom')
                ->fields(array(
                    'id_diplom' => $value->diplom_id,
                    'diplom_name' => $value->diplom_theme,
                    'id_teacher' => $value->id_teacher,
                    'year' => $year,
                ))
                ->execute();
        }

        foreach ($teacher_student_diplom as $value) {

            db_insert('teacher_student_diplom')
                ->fields(array(
                    'id_teacher_student_diplom' => $value->teacher_student_diplom_id,
                    'id_teacher' => $value->teacher_id,
                    'id_student' => $value->student_id,
                    'id_theme' => $value->diplom_id,
                    'date_protect' => $value->date_protect,
                    'id_consultant_as' => $value->id_consultant_as,
                    'teacher_evaluation' => $value->teacher_evaluation,
                    'reviewer_evaluation' => $value->reviewer_evaluation,
                    'consultant_evaluation' => $value->consultant_evaluation,
                    'final_evaluation' => $value->final_evaluation,
                    'percent_originality' => $value->percent_plagiat,
                    'year' => $year,
                ))
                ->execute();
        }
        db_set_active();

//        $form_state['values']['message'] = 'Архив за ' . $year . ' год успешно создан';
    }
}

function get_object_from_table($table_name)
{
    return db_select($table_name, 'a')
        ->fields('a')
        ->execute()
        ->fetchAll();
}