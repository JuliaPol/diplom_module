<?php

function theme_reviewers($vars) {
    $form = $vars['form'];
    $rows = array();
    foreach (element_children($form) as $id) {
        if (isset($form[$id])) {
            $rows[] = array(
                'data' => array(
                    drupal_render($form[$id]['year']),
                    drupal_render($form[$id]['direction_name']),
                    drupal_render($form[$id]['direction_code']),
                    drupal_render($form[$id]['reviewer']),
                    drupal_render($form[$id]['count']),
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

function theme_section($vars) {
    $form = $vars['form'];
    $rows = array();
    foreach (element_children($form) as $id) {
        if (isset($form[$id])) {
            $rows[] = array(
                'data' => array(
                    drupal_render($form[$id]['year']),
                    drupal_render($form[$id]['section']),
                    drupal_render($form[$id]['department']),
                    drupal_render($form[$id]['name']),
                    drupal_render($form[$id]['count'])
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

function theme_consultants($vars) {
    $form = $vars['form'];
    $rows = array();
    foreach (element_children($form) as $id) {
        if (isset($form[$id])) {
            $rows[] = array(
                'data' => array(
                    //TODO: choose field
                    drupal_render($form[$id]['year']),
                    drupal_render($form[$id]['direction_name']),
                    drupal_render($form[$id]['direction_code']),
                    drupal_render($form[$id]['reviewer']),
                    drupal_render($form[$id]['count']),
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

function theme_students_by_consultant($vars) {
    $form = $vars['form'];
    $rows = array();
    foreach (element_children($form) as $id) {
        if (isset($form[$id])) {
            $rows[] = array(
                'data' => array(
                    drupal_render($form[$id]['direction']),
                    drupal_render($form[$id]['group']),
                    drupal_render($form[$id]['student']),
                    drupal_render($form[$id]['theme']),
                    drupal_render($form[$id]['evaluation']),
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