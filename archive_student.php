<?php
function get_student_by_id_archive($id, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('student', 's');
    $query1->leftJoin('stud_group', 'g', 'g.id_group = s.id_group AND g.`year` = s.`year`');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND d.`year` = g.`year`');
    $query1->leftJoin('teacher_student_diplom', 'dip', 's.id_student = dip.id_student AND s.`year` =dip.`year`');
    $query1->leftJoin('annotation_diplom', 'a', 'a.id_diplom = dip.id_theme AND a.`year` = dip.`year`');
    $query1->leftJoin('diplom', 'th', 'th.id_diplom = dip.id_theme AND th.`year` = dip.`year`');
    $query1->leftJoin('student_additional_section', 'as_st', 'as_st.id_student = s.id_student AND as_st.`year` = s.`year`');
    $query1->leftJoin('additional_section', 'a_s', 'a_s.id_additional_section = as_st.id_as AND a_s.`year` = as_st.`year`');
    $query1->fields('s')
        ->fields('g', array('group_number'))
        ->fields('d', array('direction_code', 'direction_name'))
        ->fields('dip')
        ->fields('a')
        ->fields('th', array('diplom_name'))
        ->fields('a_s')
        ->condition('s.id_student', $id)
        ->condition('s.`year`', $year);
    $students = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $students;
}

function get_teacher_by_student_id($id, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('teacher', 't');
    $query1->leftJoin('teacher_student_diplom', 'dip', 't.id_teacher = dip.id_teacher AND t.`year` = dip.`year`');
    $query1->leftJoin('student', 's', 's.id_student = dip.id_student AND s.`year` = dip.`year`');
    $query1->fields('t')
        ->condition('s.id_student', $id)
        ->condition('s.`year`', $year);
    $students = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $students;
}

function get_reviewer_by_student_id($id, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('reviewer', 'r');
    $query1->leftJoin('reviewer_student', 'rev_st', 'rev_st.id_reviewer_student = r.id_reviewer AND rev_st.`year` = r.`year`');
    $query1->leftJoin('student', 's', 's.id_student = rev_st.id_student AND s.`year` = rev_st.`year`');
    $query1->fields('r')
        ->condition('s.id_student', $id)
        ->condition('s.`year`', $year);
    $students = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $students;
}

function get_consultant_from_company_by_student_id($id, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('consultant_company', 'c');
    $query1->leftJoin('consultant_student', 'c_s', 'c.id_consultant_company = c_s.id_consultant AND c_s.`year` = c.`year`');
    $query1->leftJoin('student', 's', 's.id_student = c_s.id_student AND s.`year` = c_s.`year`');
    $query1->fields('c')
        ->condition('s.id_student', $id)
        ->condition('s.`year`', $year);
    $students = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $students;
}

function archive_student()
{
    return drupal_get_form('archive_student_page');
}

function archive_student_page($form, &$form_state)
{
    if (empty($_GET['year']))
        $_GET['year'] = date('Y');
    if (empty($_GET['id']))
        $_GET['id'] = 1;
    $student = get_student_by_id_archive($_GET['id'], $_GET['year']);
    $teacher = get_teacher_by_student_id($_GET['id'], $_GET['year']);
    $consultant = get_consultant_from_company_by_student_id($_GET['id'], $_GET['year']);
    $reviewer = get_reviewer_by_student_id($_GET['id'], $_GET['year']);

    // Личные данные
    $form['personal_data'] = array(
        '#type' => 'fieldset',
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
        '#title' => 'Личные данные',
    );

    $form['personal_data']['column_left'] = array(
        '#type' => 'container',
        '#attributes' => array(
            'class' => array('column-left'),
            'style' => array('float: left'),
        ),
    );

    $form['personal_data']['column_right'] = array(
        '#type' => 'container',
        '#attributes' => array(
            'class' => array('column-right'),
            'style' => array('float: right'),
        ),
    );

    $form['personal_data']['column_left']['surname'] = array(
        '#type' => 'textfield',
        '#title' => t('Фамилия'),
        '#size' => 30,
        '#default_value' => $student[0]->last_name,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_left']['first_name'] = array(
        '#type' => 'textfield',
        '#title' => t('Имя'),
        '#size' => 30,
        '#default_value' => $student[0]->first_name,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_left']['patronymic'] = array(
        '#type' => 'textfield',
        '#title' => t('Отчество'),
        '#size' => 30,
        '#default_value' => $student[0]->patronymic,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_right']['passport_number'] = array(
        '#type' => 'textfield',
        '#title' => t('Номер паспорта'),
        '#size' => 20,
        '#default_value' => $student[0]->passport,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_right']['phone'] = array(
        '#type' => 'textfield',
        '#title' => t('Номер телефона'),
        '#size' => 20,
        '#default_value' => $student[0]->phone,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_right']['email'] = array(
        '#type' => 'textfield',
        '#title' => t('Email'),
        '#size' => 20,
        '#default_value' => $student[0]->email,
        '#disabled' => TRUE,
    );

    $form['stud_data'] = array(
        '#type' => 'fieldset',
        '#collapsible' => TRUE,
        '#collapsed' => TRUE,
        '#title' => 'Обучение',
    );

    $form['stud_data']['column_left'] = array(
        '#type' => 'container',
        '#attributes' => array(
            'class' => array('column-left'),
            'style' => array('float: left'),
        ),
    );

    $form['stud_data']['column_right'] = array(
        '#type' => 'container',
        '#attributes' => array(
            'class' => array('column-right'),
            'style' => array('float: right'),
        ),
    );

    $form['stud_data']['column_right']['record_book'] = array(
        '#type' => 'textfield',
        '#title' => t('Номер студ. билета'),
        '#size' => 25,
        '#default_value' => $student[0]->record_book_number,
        '#disabled' => TRUE,
    );

    $form['stud_data']['column_left']['direction'] = array(
        '#type' => 'textfield',
        '#title' => t('Направление/Специальность'),
        '#size' => 50,
        '#default_value' => $student[0]->direction_code . ' - ' . $student[0]->direction_name,
        '#disabled' => TRUE,
    );

    $form['stud_data']['column_left']['group'] = array(
        '#type' => 'textfield',
        '#title' => t('Номер группы'),
        '#size' => 25,
        '#default_value' => $student[0]->group_number,
        '#disabled' => TRUE,
    );

    $form['stud_data']['column_left']['enroll_date'] = array(
        '#type' => 'textfield',
        '#title' => t('Начало обучения'),
        '#size' => 25,
        '#default_value' => $student[0]->enrollment_date,
        '#disabled' => TRUE,
    );

    $form['stud_data']['column_left']['expel_date'] = array(
        '#type' => 'textfield',
        '#title' => t('Конец обучения'),
        '#size' => 25,
        '#default_value' => $student[0]->expel_date,
        '#disabled' => TRUE,
    );

    $form['stud_data']['column_right']['sum3'] = array(
        '#type' => 'textfield',
        '#title' => t('Количество оценки 3'),
        '#size' => 25,
        '#default_value' => $student[0]->sum_3,
        '#disabled' => TRUE,
    );

    $form['stud_data']['column_right']['sum4'] = array(
        '#type' => 'textfield',
        '#title' => t('Количество оценки 4'),
        '#size' => 25,
        '#default_value' => $student[0]->sum_4,
        '#disabled' => TRUE,
    );

    $form['stud_data']['column_right']['sum5'] = array(
        '#type' => 'textfield',
        '#title' => t('Количество оценки 5'),
        '#size' => 25,
        '#default_value' => $student[0]->sum_5,
        '#disabled' => TRUE,
    );

    $form['diplom'] = array(
        '#type' => 'fieldset',
        '#collapsible' => TRUE,
        '#collapsed' => TRUE,
        '#title' => 'ВКР',
    );

    $form['diplom']['theme'] = array(
        '#type' => 'textarea',
        '#rows' => 3,
        '#title' => t('Тема ВКР'),
        '#size' => 50,
        '#default_value' => $student[0]->diplom_name,
        '#disabled' => TRUE,
    );

    $form['diplom']['column_left'] = array(
        '#type' => 'container',
        '#attributes' => array(
            'class' => array('column-left'),
            'style' => array('float: left'),
        ),
    );

    $form['diplom']['column_right'] = array(
        '#type' => 'container',
        '#attributes' => array(
            'class' => array('column-right'),
            'style' => array('float: right'),
        ),
    );

    $form['diplom']['column_left']['add_section'] = array(
        '#type' => 'textfield',
        '#title' => t('Дополнительный раздел'),
        '#size' => 40,
        '#disabled' => TRUE,
        '#default_value' => $student[0]->name_section,
    );

    $form['diplom']['column_right']['date'] = array(
        '#type' => 'textfield',
        '#title' => t('Дата защиты'),
        '#size' => 20,
        '#default_value' => $student[0]->date_protect,
        '#disabled' => TRUE,
    );

    $form['diplom']['column_left']['teacher'] = array(
        '#type' => 'textfield',
        '#title' => t('Научный руководитель'),
        '#size' => 40,
        '#disabled' => TRUE,
        '#href' => 'archive/teacher?id=' . $teacher[0]->id_teacher . '&year=' . date('Y', strtotime($student[0]->year)),
        '#default_value' => $teacher[0]->last_name . ' ' . $teacher[0]->first_name . ' ' . $teacher[0]->patronymic,
    );

    $form['diplom']['column_right']['eval_teacher'] = array(
        '#type' => 'textfield',
        '#title' => t('Оценка от руководителя'),
        '#size' => 20,
        '#disabled' => TRUE,
        '#default_value' => $student[0]->teacher_evaluation,
    );

    //TODO: Добавить ссылку на преподавателя
    if (isset($consultant[0])) {
        $form['diplom']['column_left']['consult'] = array(
            '#type' => 'textfield',
            '#title' => t('Консультант с предприятия'),
            '#size' => 40,
            '#disabled' => TRUE,
            '#href' => 'archive/consultant?id=' . $consultant[0]->id_consultant_company . '&year=' . date('Y', strtotime($student[0]->year)),
            '#default_value' => $consultant[0]->last_name . ' ' . $consultant[0]->first_name . ' ' . $consultant[0]->patronymic,
        );

        $form['diplom']['column_right']['eval_consultant'] = array(
            '#type' => 'textfield',
            '#title' => t('Оценка от консультанта'),
            '#size' => 20,
            '#disabled' => TRUE,
            '#default_value' => $student[0]->consultant_evaluation,
        );

    }
    if (isset($reviewer[0])) {
        $form['diplom']['column_left']['reviewer'] = array(
            '#type' => 'textfield',
            '#title' => t('Рецензент'),
            '#size' => 40,
            '#disabled' => TRUE,
            '#href' => 'archive/reviewer?id=' . $reviewer[0]->id_reviewer . '&year=' . date('Y', strtotime($student[0]->year)),
            '#default_value' => $reviewer[0]->last_name . ' ' . $reviewer[0]->first_name . ' ' . $reviewer[0]->patronymic,
        );

        $form['diplom']['column_right']['eval_reviewer'] = array(
            '#type' => 'textfield',
            '#title' => t('Оценка от рецензента'),
            '#size' => 20,
            '#disabled' => TRUE,
            '#default_value' => $student[0]->reviewer_evaluation,
        );
    }


    $form['diplom']['column_right']['persent'] = array(
        '#type' => 'textfield',
        '#title' => t('Процент оригинальности'),
        '#size' => 20,
        '#disabled' => TRUE,
        '#default_value' => $student[0]->percent_originality,
    );

    $form['diplom']['column_left']['final_eval'] = array(
        '#type' => 'textfield',
        '#title' => t('Итоговая оценка'),
        '#size' => 20,
        '#disabled' => TRUE,
        '#default_value' => $student[0]->final_evaluation,
    );

    if (isset($student[0]->ref_annotation)) {
        $form['diplom']['column_right']['annotation'] = array(
            '#type' => 'link',
            '#title' => t('Аннотация к работе'),
            '#size' => 40,
            '#href' => $student[0]->ref_annotation,
        );
    }

    return $form;
}