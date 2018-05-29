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

function get_consultant_company_by_id_archive($id, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('consultant_company', 'c');
    $query1->fields('c')
        ->condition('c.id_consultant_company', $id)
        ->condition('c.`year`', $year);
    $teacher = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $teacher;
}

function archive_all_consultants_company()
{
    return drupal_get_form('archive_all_company_consultants_page');
}

function archive_consultant_company()
{
    return drupal_get_form('archive_consultant_company_page');
}

function archive_consultant_company_page($form, &$form_state)
{
    if (empty($_GET['year']))
        $_GET['year'] = date('Y');
    if (empty($_GET['id']))
        $_GET['id'] = 1;
    $consultant = get_consultant_company_by_id_archive($_GET['id'], $_GET['year']);

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
        '#default_value' => $consultant[0]->last_name,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_left']['first_name'] = array(
        '#type' => 'textfield',
        '#title' => t('Имя'),
        '#size' => 30,
        '#default_value' => $consultant[0]->first_name,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_left']['patronymic'] = array(
        '#type' => 'textfield',
        '#title' => t('Отчество'),
        '#size' => 30,
        '#default_value' => $consultant[0]->patronymic,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_left']['passport'] = array(
        '#type' => 'textfield',
        '#title' => t('Паспорт'),
        '#size' => 30,
        '#default_value' => $consultant[0]->passport,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_right']['work'] = array(
        '#type' => 'textfield',
        '#title' => t('Место работы'),
        '#size' => 30,
        '#default_value' => $consultant[0]->company_name,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_right']['email'] = array(
        '#type' => 'textfield',
        '#title' => t('Email'),
        '#size' => 20,
        '#default_value' => $consultant[0]->email,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_right']['phone'] = array(
        '#type' => 'textfield',
        '#title' => t('Телефон'),
        '#size' => 20,
        '#default_value' => $consultant[0]->phone,
        '#disabled' => TRUE,
    );

    $form['students'] = array(
        '#type' => 'fieldset',
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
        '#title' => 'Студенты',
    );

    $header = array(
        array('data' => t('Направление'), 'field' => 'direction'),
        array('data' => t('Группа'), 'field' => 'group'),
        array('data' => t('ФИО студента'), 'field' => 'student'),
        array('data' => t('Тема ВКР'), 'field' => 'theme'),
        array('data' => t('Оценка от консультанта'), 'field' => 'evaluation')
    );

    $form['students']['consultants_table'] = array(
        '#type' => 'container',
        '#theme' => 'students_by_consultant',
        '#header' => $header,
        '#prefix' => '<div id="consultants-wrapper">',
        '#suffix' => '</div>',
    );

    $nodes = get_students_by_consultant($_GET['year'], $_GET['id']);

    foreach ($nodes as $nid => $node) {
        $link = l(t($node->last_name . ' ' . $node->first_name . ' ' . $node->patronymic), 'archive/student', array('query' =>
            array('id' => $node->id_student, 'year' => $node->year)));

        $form['students']['consultants_table'][$nid]['direction'] = array(
            '#markup' => $node->direction_code . ' - ' . $node->direction_name,
        );
        $form['students']['consultants_table'][$nid]['group'] = array(
            '#markup' => $node->group_number,
        );
        $form['students']['consultants_table'][$nid]['student'] = array(
            '#markup' => $link,
        );
        $form['students']['consultants_table'][$nid]['theme'] = array(
            '#markup' => $node->diplom_name,
        );
        $form['students']['consultants_table'][$nid]['evaluation'] = array(
            '#markup' => $node->consultant_evaluation,
        );
    }

    return $form;
}


//TODO: add years filter
function archive_all_company_consultants_page($form, &$form_state)
{
    $header = array(
        array('data' => t('Год'), 'field' => 'year'),
        array('data' => t('Направление'), 'field' => 'direction_name'),
        array('data' => t('Код направления'), 'field' => 'direction_code'),
        array('data' => t('ФИО консультанта'), 'field' => 'reviewer'),
        array('data' => t('Количество студентов'), 'field' => 'count')
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
    $nodes = get_all_consultants_archive($header);

    $form['consultants_table'] = fill_table_consultants($form, $nodes, $header);
    $form['pager']['#markup'] = theme('pager');
    $link = l(t("Скачать статистику за все года"), 'archive/download/statistics/consultants');
    $form['download'] = array(
        '#markup' => $link,
    );
    return $form;
}

function fill_table_consultants($form, $nodes, $header)
{
    $form['consultants_table'] = array(
        '#type' => 'container',
        '#theme' => 'consultants',
        '#header' => $header,
        '#prefix' => '<div id="consultants-wrapper">',
        '#suffix' => '</div>',
    );

    foreach ($nodes as $nid => $node) {
        $link = l(t($node->last_name . ' ' . $node->first_name . ' ' . $node->patronymic), 'archive/reviewer', array('query' =>
            array('id' => $node->id_reviewer, 'year' => $node->year)));

        $count_review = get_count_reviews_by_id($node->id_reviewer, $node->year);

        $form['reviewers_table'][$nid]['year'] = array(
            '#markup' => $node->year,
        );
        $form['reviewers_table'][$nid]['direction_name'] = array(
            '#markup' => $node->direction_name,
        );
        $form['reviewers_table'][$nid]['direction_code'] = array(
            '#markup' => $node->direction_code,
        );
        $form['reviewers_table'][$nid]['reviewer'] = array(
            '#markup' => $link,
        );
        $form['reviewers_table'][$nid]['count'] = array(
            '#markup' => $count_review,
        );
    }
    return $form['reviewers_table'];
}
