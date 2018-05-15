<?php

function get_member_sec_by_id_archive($id, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('member_sec', 'm');
    $query1->fields('m')
        ->condition('m.id_member_SEC', $id)
        ->condition('m.`year`', $year);
    $member = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $member;
}

function get_member_sec_by_passport_archive($passport)
{
    db_set_active('archive_db');
    $query1 = db_select('member_sec', 'm');
    $query1->leftJoin('direction_member_sec', 'd_m', 'm.id_member_SEC = d_m.id_member_SEC AND m.`year` = d_m.`year`');
    $query1->leftJoin('direction', 'd', 'd.id_direction = d_m.id_direction AND d.`year` = d_m.`year`');
    $query1->fields('m')
        ->fields('d', array('direction_code', 'direction_name'))
        ->condition('m.passport', $passport);
    $member = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $member;
}

function get_years_participation_in_SEC_archive($passport)
{
    db_set_active('archive_db');
    $query1 = db_select('member_sec', 'm');
    $query1->groupBy('m.year')
        ->fields('m', array('year'))
        ->condition('m.passport', $passport);
    $years = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $years;
}

function archive_member_sec()
{
    return drupal_get_form('archive_member_sec_page');
}

function archive_member_sec_page($form, &$form_state)
{
    if (empty($_GET['year']))
        $_GET['year'] = date('Y');
    if (empty($_GET['id']))
        $_GET['id'] = 1;
    if (empty($_GET['isTeacher']))
        $_GET['isTeacher'] = 0;
    if ($_GET['isTeacher'] == 0) {
        $member_SEC_passport = get_member_sec_by_id_archive($_GET['id'], $_GET['year']);
        $member_SEC = get_member_sec_by_passport_archive($member_SEC_passport[0]->passport);
    } else {
        $member_SEC_passport = get_teacher_by_id_archive($_GET['id'], $_GET['year']);
        $member_SEC = get_teacher_by_passport_archive($member_SEC_passport[0]->passport);
    }

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
        '#default_value' => $member_SEC[0]->last_name,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_left']['first_name'] = array(
        '#type' => 'textfield',
        '#title' => t('Имя'),
        '#size' => 30,
        '#default_value' => $member_SEC[0]->first_name,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_left']['patronymic'] = array(
        '#type' => 'textfield',
        '#title' => t('Отчество'),
        '#size' => 30,
        '#default_value' => $member_SEC[0]->patronymic,
        '#disabled' => TRUE,
    );


    $form['personal_data']['column_left']['passport'] = array(
        '#type' => 'textfield',
        '#title' => t('Номер паспорта:'),
        '#size' => 30,
        '#default_value' => $member_SEC[0]->passport,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_right']['mobile_phone'] = array(
        '#type' => 'textfield',
        '#title' => t('Мобильный телефона'),
        '#size' => 20,
        '#default_value' => $member_SEC[0]->mobile_phone,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_right']['work_phone'] = array(
        '#type' => 'textfield',
        '#title' => t('Рабочий телефон'),
        '#size' => 20,
        '#default_value' => $member_SEC[0]->work_phone,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_right']['email'] = array(
        '#type' => 'textfield',
        '#title' => t('Email'),
        '#size' => 20,
        '#default_value' => $member_SEC[0]->email,
        '#disabled' => TRUE,
    );

    $form['personal_data']['column_right']['address'] = array(
        '#type' => 'textfield',
        '#title' => t('Адрес'),
        '#size' => 40,
        '#default_value' => $member_SEC[0]->address,
        '#disabled' => TRUE,
    );

    $years = get_years_participation_in_SEC_archive($member_SEC_passport[0]->passport);
    foreach ($years as $year) {
        $form[$year->year] = array(
            '#type' => 'fieldset',
            '#collapsible' => TRUE,
            '#collapsed' => FALSE,
            '#title' => $year->year,
        );

        $form[$year->year]['column_left'] = array(
            '#type' => 'container',
            '#attributes' => array(
                'class' => array('column-left'),
                'style' => array('float: left'),
            ),
        );

        $form[$year->year]['column_right'] = array(
            '#type' => 'container',
            '#attributes' => array(
                'class' => array('column-right'),
                'style' => array('float: right'),
            ),
        );
        $form[$year->year]['column_left']['direction'] = array(
            '#markup' => '<b>Направление</b><p></p>',
        );
        $form[$year->year]['column_right']['role'] = array(
            '#markup' => '<b>Должность в ГЭК</b><p></p>',
        );
        foreach ($member_SEC as $nid => $item) {
            if ($year->year == $item->year) {
                $form[$year->year]['column_left'][$nid]['direction'] = array(
                    '#markup' => '<p>' . $item->direction_code . ' - ' . $item->direction_name . '</p>',
                );
                $form[$year->year]['column_right'][$nid]['role'] = array(
                    '#markup' => '<p>' . $item->role . '</p>',
                );
            }
        }
    }

    return $form;
}