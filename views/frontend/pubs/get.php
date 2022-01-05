<?php

use PUBS\PUBS_Base;
use PUBS\PUB;


function enqueue_get_pubs_scripts()
{
    pubs_enqueue_kendo();
    pubs_enqueue_common();
    pubs_enqueue_frontend_style();
    pubs_enqueue_frontend_get_pubs();
}

function pubs_get()
{
    enqueue_get_pubs_scripts();

    $output = '';

    $output .= '<div>';
    $output .= '</div>';

    return $output;
}
