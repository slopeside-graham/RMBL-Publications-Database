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
    $output .= '                <span class="year-seperator">&nbsp;-&nbsp;</span>';
    $output .= '                <input id="yearEnd" placeholder="Year End" />';
    $output .= '            </div>';
    $output .= '            <button onclick="filterLibrary()">Search</button>';
    $output .= '            <h3>Filter Types:</h3>';
    $output .= '            <div id="filter-types">';
    $output .= '                <div class="active search-item" id="show-all" onclick="filterTypes(this)">Show All</div>';
    $output .= '                <div class="search-item" id="article" onclick="filterTypes(this)">Article</div>';
    $output .= '                <div class="search-item" id="book" onclick="filterTypes(this)">Book</div>';
    $output .= '                <div class="search-item" id="chapter" onclick="filterTypes(this)">Chapter</div>';
    $output .= '                <div class="search-item" id="thesis" onclick="filterTypes(this)">Thesis</div>';
    $output .= '                <div class="search-item" id="other" onclick="filterTypes(this)">Other</div>';
    $output .= '                <div class="search-item" id="studentpaper" onclick="filterTypes(this)">Student Paper</div>';
    $output .= '            </div>';
    $output .= '        </div>';
    $output .= '        <div id="sort">';
    $output .= '            <h3>Sort:</h3>';
    $output .= '            <div id="sort-type">';
    $output .= '                <div class="active search-item" id="sort-year-type-author" data-sort="year-type-authors" onclick="sortLibrary(this)">Year, Type, Author</div>';
    $output .= '                <div class="search-item" id="sort-authors" data-sort="authors" onclick="sortLibrary(this)">Author</div>';
    $output .= '                <div class="search-item" id="sort-title" data-sort="title"onclick="sortLibrary(this)">Title</div>';
    $output .= '                <div class="search-item" id="sort-rt-name" data-sort="rt.name" onclick="sortLibrary(this)">Type</div>';
    $output .= '                <div class="search-item" id="sort-year" data-sort="year" onclick="sortLibrary(this)">Year</div>';
    $output .= '        </div>';
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
