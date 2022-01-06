<?php

use PUBS\PUBS_Base;
use PUBS\PUB;

function pubs_get()
{
    pubs_enqueue_frontend_get_pubs();

    $output = '';

    $output .= '<div>';
    $output .= '    <div id="pubs-list-view"></div>';

    $output .= '    <script type="text/x-kendo-template" id="pubs-listview-template">';
    $output .= '        <div class="publication">';
    $output .= '            <h3>#:id#</h3>';
    $output .= '        </div>';
    $output .= '    </script>';
    $output .= '</div>';

    return $output;
}
