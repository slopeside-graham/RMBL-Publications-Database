<?php

use PUBS\PUBS_Base;
use PUBS\PUB;

function library_get()
{
    pubs_enqueue_frontend_get_library();

    $output = '';

    $output .= '<div id="library-list">';
    $output .= '    <div class="filter-sort">';
    //$output .= '        <div id="filter"></div>';
    $output .= '        <div class="filter">';
    $output .= '            <h3>Search:</h3>';
    $output .= '            <div><input id="title" placeholder="Title" /></div>';
    $output .= '            <div><input id="author" placeholder="Author"/></div>';
    $output .= '            <div><input id="keywords" placeholder="Keyword"/></div>';
    $output .= '            <div class="years-filter">';
    $output .= '                <input id="yearStart" placeholder="Year Start" />';
    $output .= '                <input id="yearEnd" placeholder="Year End" />';
    $output .= '            </div>';
    $output .= '            <button onclick="filterLibrary()">Search</button>';
    $output .= '            <div id="filter-types">';
    $output .= '            <h3>Filter Types:</h3>';
    $output .= '                <div class="active" id="show-all" onclick="filterTypes(this)">Show All</div>';
    $output .= '                <div id="article" onclick="filterTypes(this)">Article</div>';
    $output .= '                <div id="book" onclick="filterTypes(this)">Book</div>';
    $output .= '                <div id="chapter" onclick="filterTypes(this)">Chapter</div>';
    $output .= '                <div id="thesis" onclick="filterTypes(this)">Thesis</div>';
    $output .= '                <div id="other" onclick="filterTypes(this)">Other</div>';
    $output .= '                <div id="studentpaper" onclick="filterTypes(this)">Student Paper</div>';
    $output .= '            </div>';
    $output .= '        </div>';
    $output .= '        <div id="sort">';
    $output .= '            <h3>Sort:</h3>';
    $output .= '            <button onclick="sortLibrary(this)" data-type="title">Title</button>';
    $output .= '        </div>';
    $output .= '    </div>';
    $output .= '    <div>';
    $output .= '        <div id="library-list-view"></div>';
    $output .= '        <div id="pager"></div>';
    $output .= '    </div>';
    $output .= '    <script type="text/x-kendo-template" id="library-listview-template">';
    $output .= '        <div class="single-library-item #:reftypename#">';
    $output .= '            <div class="library-item-type">#:reftypename#</div>';
    $output .= '            <div>';
    $output .= '                #if (authors) {# #:authors# #}#  #:year#. #=title#. #if (journalname) {# #:journalname#. #}# #if (volume || pages) {# #:volume#:#:pages#. #}# #if (pdf_url) {# <a href="#:pdf_url#" target="_blank">pdf</a> #}# #if (abstract_url) {# <a href="#:abstract_url#" target="_blank">abstract</a> #}#';
    $output .= '            </div>';
    $output .= '        </div>';
    $output .= '    </script>';
    $output .= '</div>';

    return $output;
}
