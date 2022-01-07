<?php

use PUBS\PUBS_Base;
use PUBS\PUB;

function pubs_get()
{
    pubs_enqueue_frontend_get_pubs();

    $output = '';

    $output .= '<div>';
    $output .= '    <div id="pubs-list-view"></div>';
    $output .= '    <div id="pager"></div>';

    $output .= '    <script type="text/x-kendo-template" id="pubs-listview-template">';
    $output .= '        <dl>';
    $output .= '            <dt>#:id# - #=title#</dt>';
    $output .= '        </dl>';
    $output .= '    </script>';
    $output .= '</div>';

    return $output;
}
