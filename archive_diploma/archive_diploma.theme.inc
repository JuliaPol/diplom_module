<?php
function theme_simple($vars) {
    $form = $vars['form'];
    $rows = array();
    foreach (element_children($form) as $id) {
        if (isset($form[$id])) {
            $rows[] = array(
                'data' => array(
                    drupal_render($form[$id]['last_name']),
                    drupal_render($form[$id]['group_number']),
                    drupal_render($form[$id]['direction_name']),
                    drupal_render($form[$id]['direction_code']),
                    drupal_render($form[$id]['date_protect']),
                    drupal_render($form[$id]['final_evaluation']),
                ),
                'class' => array(),
            );
        }
    }

    $output = theme('table', array(
        'header' => $form['#header'],
        'rows'  => $rows,
        'empty' => t('Table is empty', array()),
    ));

    $output .= drupal_render_children($form);
    return $output;
}

function theme_diploma($vars) {
    $form = $vars['form'];
    $rows = array();
    foreach (element_children($form) as $id) {
        if (isset($form[$id])) {
            $rows[] = array(
                'data' => array(
                    drupal_render($form[$id]['group_number']),
                    drupal_render($form[$id]['stud_name']),
                    drupal_render($form[$id]['theme']),
                    drupal_render($form[$id]['teacher_name']),
                    drupal_render($form[$id]['consultant']),
                ),
                'class' => array(),
            );
        }
    }

    $output = theme('table', array(
        'header' => $form['#header'],
        'rows'  => $rows,
        'empty' => t('Table is empty', array()),
    ));

    $output .= drupal_render_children($form);
    return $output;
}

function theme_teachers($vars) {
    $form = $vars['form'];
    $rows = array();
    foreach (element_children($form) as $id) {
        if (isset($form[$id])) {
            $rows[] = array(
                'data' => array(
                    drupal_render($form[$id]['year']),
                    drupal_render($form[$id]['name']),
                    drupal_render($form[$id]['position']),
                    drupal_render($form[$id]['activity_name']),
                    drupal_render($form[$id]['count_themes']),
                    drupal_render($form[$id]['count_studs']),
                ),
                'class' => array(),
            );
        }
    }

    $output = theme('table', array(
        'header' => $form['#header'],
        'rows'  => $rows,
        'empty' => t('Table is empty', array()),
    ));

    $output .= drupal_render_children($form);
    return $output;
}


function theme_directions($vars) {
    $form = $vars['form'];
    $rows = array();
    foreach (element_children($form) as $id) {
        if (isset($form[$id])) {
            $rows[] = array(
                'data' => array(
                    drupal_render($form[$id]['year']),
                    drupal_render($form[$id]['dir_code']),
                    drupal_render($form[$id]['dir_name']),
                    drupal_render($form[$id]['count_groups']),
                    drupal_render($form[$id]['count_studs']),
                ),
                'class' => array(),
            );
        }
    }

    $output = theme('table', array(
        'header' => $form['#header'],
        'rows'  => $rows,
        'empty' => t('Table is empty', array()),
    ));

    $output .= drupal_render_children($form);
    return $output;
}

function theme_group($vars) {
    $form = $vars['form'];
    $rows = array();
    foreach (element_children($form) as $id) {
        if (isset($form[$id])) {
            $rows[] = array(
                'data' => array(
                    drupal_render($form[$id]['group_number']),
                    drupal_render($form[$id]['count_stud']),
                    drupal_render($form[$id]['creation_year']),
                    drupal_render($form[$id]['email']),
                    drupal_render($form[$id]['stud_list']),
                    drupal_render($form[$id]['originality']),
                ),
                'class' => array(),
            );
        }
    }

    $output = theme('table', array(
        'header' => $form['#header'],
        'rows'  => $rows,
        'empty' => t('Table is empty', array()),
    ));

    $output .= drupal_render_children($form);
    return $output;
}
