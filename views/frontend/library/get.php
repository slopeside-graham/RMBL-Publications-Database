<?php

use PUBS\PUBS_Base;
use PUBS\PUB;

function library_get()
{
    pubs_enqueue_frontend_get_library();

    $output = '';

    $output .= '<div>';
    $output .= '    <div id="library-list-view"></div>';
    $output .= '    <div id="pager"></div>';

    $output .= '    <script type="text/x-kendo-template" id="library-listview-template">';
    $output .= '        <dl>';
    $output .= '            <dt>#:id# - #=title#</dt>';
    $output .= '        </dl>';
    $output .= '    </script>';
    $output .= '</div>';

    return $output;
}
