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
    $output .= '        <div class="single-library-item #:reftypename#">';
    $output .= '            #if (authors) {# #:authors# #}#  #:year#. #=title#. #if (journalname) {# #:journalname#. #}# #if (volume || pages) {# #:volume#:#:pages#. #}#';
    $output .= '        </div>';
    $output .= '    </script>';
    $output .= '</div>';

    return $output;
}
