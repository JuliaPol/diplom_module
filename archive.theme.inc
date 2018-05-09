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