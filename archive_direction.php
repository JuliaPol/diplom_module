<?php

function get_all_directions_archive()
{
    db_set_active('archive_db');
    $query1 = db_select('direction', 'd');
    $query1->fields('d')
        ->groupBy('d.direction_code');
    $reviewer = $query1->execute()
        ->fetchAll();
    db_set_active();
    return $reviewer;
}