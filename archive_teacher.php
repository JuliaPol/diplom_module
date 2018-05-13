<?php
function get_teacher_by_id_archive($id, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('teacher', 't');
   $query1->fields('t')
        ->condition('t.id_teacher', $id)
        ->condition('t.`year`', $year);
    $teacher = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $teacher;
}

function get_activities_by_id_teacher($id, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('activity', 'a');
    $query1->leftJoin('teacher_activity','t_a', 'a.id_activity = t_a.id_activity AND a.`year` = t_a.`year`');
    $query1->leftJoin('teacher', 't', 't.id_teacher = t_a.id_teacher AND t.`year` = t_a.`year`');
    $query1->fields('a', array('activity_name'))
        ->condition('t.id_teacher', $id)
        ->condition('t.`year`', $year);
    $activity = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $activity;
}

function get_themes_by_id_teacher($id, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('diplom', 'th');
    $query1->leftJoin('teacher_student_diplom', 'dip','th.id_diplom = dip.id_theme AND th.`year` = dip.`year`');
    $query1->leftJoin('teacher', 't', 't.id_teacher = dip.id_teacher AND t.`year` = dip.`year`');
    $query1->fields('th', array('diplom_name'))
        ->fields('dip')
        ->condition('t.id_teacher', $id)
        ->condition('t.`year`', $year);
    $activity = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $activity;
}

function archive_teacher()
{
    return drupal_get_form('archive_teacher_page');
}

function archive_teacher_page($form, &$form_state)
{
    if (empty($_GET['year']))
        $_GET['year'] = date('Y');
    if (empty($_GET['id']))
        $_GET['id'] = 1;
    $teacher = get_teacher_by_id_archive($_GET['id'], $_GET['year']);
    $activities = get_activities_by_id_teacher($_GET['id'], $_GET['year']);
    $themes = get_themes_by_id_teacher($_GET['id'], $_GET['year']);

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
        '#default_value' => $teacher[0]->last_name,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_left']['first_name'] = array(
        '#type' => 'textfield',
        '#title' => t('Имя'),
        '#size' => 30,
        '#default_value' => $teacher[0]->first_name,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_left']['patronymic'] = array(
        '#type' => 'textfield',
        '#title' => t('Отчество'),
        '#size' => 30,
        '#default_value' => $teacher[0]->patronymic,
        '#disabled' => TRUE,
    );


    $form['personal_data']['column_left']['position'] = array(
        '#type' => 'textfield',
        '#title' => t('Должность'),
        '#size' => 30,
        '#default_value' => $teacher[0]->position,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_left']['degree'] = array(
        '#type' => 'textfield',
        '#title' => t('Степень'),
        '#size' => 30,
        '#default_value' => $teacher[0]->degree,
        '#disabled' => TRUE,
    );


    $form['personal_data']['column_left']['rank'] = array(
        '#type' => 'textfield',
        '#title' => t('Звание'),
        '#size' => 30,
        '#default_value' => $teacher[0]->rank,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_right']['passport_number'] = array(
        '#type' => 'textfield',
        '#title' => t('Номер паспорта'),
        '#size' => 20,
        '#default_value' => $teacher[0]->passport,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_right']['mobile_phone'] = array(
        '#type' => 'textfield',
        '#title' => t('Мобильный телефона'),
        '#size' => 20,
        '#default_value' => $teacher[0]->mobile_phone,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_right']['work_phone'] = array(
        '#type' => 'textfield',
        '#title' => t('Рабочий телефон'),
        '#size' => 20,
        '#default_value' => $teacher[0]->work_phone,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_right']['email'] = array(
        '#type' => 'textfield',
        '#title' => t('Email'),
        '#size' => 20,
        '#default_value' => $teacher[0]->email,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_right']['address'] = array(
        '#type' => 'textfield',
        '#title' => t('Адрес'),
        '#size' => 40,
        '#default_value' => $teacher[0]->address,
        '#disabled' => TRUE,
    );

    $form['activity'] = array(
        '#type' => 'fieldset',
        '#collapsible' => TRUE,
        '#collapsed' => TRUE,
        '#title' => 'Направление деятельности',
    );

    foreach ($activities as $nid => $activity) {
        $form['activity'][$nid]['activity_name'] = array(
            '#markup' => '<p>'.$activity->activity_name.'</p>',
        );
    }

    $form['themes'] = array(
        '#type' => 'fieldset',
        '#collapsible' => TRUE,
        '#collapsed' => TRUE,
        '#title' => 'Темы ВКР',
    );

    foreach ($themes as $nid => $theme) {
        $form['themes'][$nid]['theme_name'] = array(
            '#markup' =>'<p>'. $theme->diplom_name.'</p>',
        );
    }

    return $form;
}