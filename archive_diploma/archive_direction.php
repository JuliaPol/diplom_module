<?php

function get_all_directions_archive()
{
    db_set_active('archive_db');
    $query1 = db_select('direction', 'd');
    $query1->fields('d')
        ->groupBy('d.direction_code');
    $directions = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $directions;
}

function get_all_directions_archive_by_year($year)
{
    db_set_active('archive_db');
    $query1 = db_select('direction', 'd');
    $query1->fields('d')
        ->groupBy('d.direction_code')
        ->condition('d.`year`', $year);
    $directions = $query1->execute()
        ->fetchAll();
    foreach ($directions as $nid => $direction) {
        $directions[$nid]->count_groups = get_count_group_archive_by_dir($direction->direction_code, $year);
        $directions[$nid]->count_studs = get_count_students_archive_by_dir($direction->direction_code, $year);
    }
    db_set_active();
    return $directions;
}

function get_count_group_archive_by_dir($dir, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('stud_group', 'g');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND g.`year` = d.`year`');
    $query1->fields('d')
        ->condition('d.direction_code', $dir)
        ->condition('g.`year`', $year);
    $directions = $query1->execute()->rowCount();
    db_set_active();
    return $directions;
}

function get_count_students_archive_by_dir($dir, $year)
{
    db_set_active('archive_db');
    $query1 = db_select('student', 's');
    $query1->leftJoin('stud_group', 'g', 'g.id_group = s.id_group AND s.`year` = g.`year`');
    $query1->leftJoin('direction', 'd', 'g.id_direction = d.id_direction AND g.`year` = d.`year`');
    $query1->fields('d')
        ->condition('d.direction_code', $dir)
        ->condition('s.`year`', $year);
    $directions = $query1->execute()->rowCount();
    db_set_active();
    return $directions;
}


function archive_all_directions()
{
    return drupal_get_form('archive_all_directions_page');
}

function archive_all_directions_page($form, &$form_state)
{
    $years = get_years();
    $array = array();
    $i = 1;
    $array[0] = 'Все';
    foreach ($years as $value) {
        $array[$i++] = $value->year;
    }

    $form['selects'] = array(
        '#prefix' => '<div style=" display: flex; flex-direction: row; flex-wrap: wrap;">',
        '#suffix' => '</div>',
    );

    $form['selects']['year'] = array(
        '#type' => 'select',
        '#title' => t('Год'),
        '#options' => $array,
        '#default_value' => 0,
        '#prefix' => '<div style="padding: 10px; margin-right: 5px;">',
        '#suffix' => '</div>',
        '#ajax' => array(
            'event' => 'change',
            'callback' => 'archive_all_directions_dropdown_callback',
            'wrapper' => 'direction-wrapper',
            'method' => 'replace',
            'effect' => 'fade',
        ),
    );

    $header = array(
        array('data' => t('Год'), 'field' => 'year'),
        array('data' => t('Код направления'), 'field' => 'dir_code'),
        array('data' => t('Название направления'), 'field' => 'dir_name'),
        array('data' => t('Количество групп'), 'field' => 'count_groups'),
        array('data' => t('Количество студентов'), 'field' => 'count_studs'),
    );

    $directions = array();
    foreach ($years as $nid => $year1) {
        $directions[$nid] = get_all_directions_archive_by_year($year1->year);
    }

    $form['directions_table'] = fill_direction_table($form, $header, $directions);
    // Подключаем отображение пейджинатора.
    $form['pager']['#markup'] = theme('pager');
    return $form;
}

function archive_all_directions_dropdown_callback($form, $form_state)
{
    $year = $form_state['complete form']['selects']['year']['#options'][$_POST['year']];
    if ($year == 'Все') {
        $years = get_years();
        $directions = array();
        foreach ($years as $nid => $year1) {
            $directions[$nid] = get_all_directions_by_year($year1->year);
        }
    } else {
        $directions = get_all_directions_by_year($year);
    }
    $form['directions_table'] = fill_direction_table($form, $form['directions_table']['#header'], $directions);
    return $form['simple_table'];
}


function fill_direction_table($form, $header, $directions)
{
    $form['directions_table'] = array(
        '#type' => 'container',
        '#theme' => 'directions',
        '#header' => $header,
        '#prefix' => '<div id="direction-wrapper">',
        '#suffix' => '</div>',
    );

    foreach ($directions as $direction) {
        foreach ($direction as $nid => $node) {
            $link = l(t($node->direction_code), 'archive/direction', array('query' =>
                array('dir_code' => $node->direction_code, 'year' => $node->year)));

            $form['directions_table'][$nid]['year'] = array(
                '#markup' => $node->year,
            );
            $form['directions_table'][$nid]['dir_code'] = array(
                '#markup' => $link,
            );
            $form['directions_table'][$nid]['dir_name'] = array(
                '#markup' => $node->direction_name,
            );
            $form['directions_table'][$nid]['count_groups'] = array(
                '#markup' => $node->count_groups,
            );
            $form['directions_table'][$nid]['count_studs'] = array(
                '#markup' => $node->count_studs,
            );
        }
    }
    return $form['directions_table'];
}