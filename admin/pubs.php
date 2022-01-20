<?php

use PUBS\Utils;

function pubs_main()
{
    pubs_enqueue_backend_library()
?>
    <h1>Publications Database Integration</h1>
    <div id="tabstrip">
        <ul>
            <li class="k-state-active">Library</li>
            <li>Authors</li>
            <li>Publishers</li>
            <li>Reports</li>
            <li>Usage</li>
        </ul>
        <div>
            <div id="library-list">
                <div class="filter-sort">
                    <div class="filter">
                        <h4>Search By:</h4>
                        <form>
                            <div class="search-inputs">
                                <div><input id="title" placeholder="Title" /></div>
                                <div><input id="author" placeholder="Author" /></div>
                                <div><input id="keywords" placeholder="Keyword" /></div>
                                <div class="years-filter">
                                    <input id="yearStart" placeholder="Year Start" />
                                    <span class="year-seperator">&nbsp;-&nbsp;</span>
                                    <input id="yearEnd" placeholder="Year End" />
                                </div>
                            </div>
                            <button onclick="filterLibrary()">Search</button>
                        </form>
                        <hr />
                        <h4>Filter Items:</h4>
                        <div id="filter-types">
                            <div class="active search-item" id="show-all" onclick="filterTypes(this)">Show All<span class="type-total" id="show-all-total"></span></div>
                            <div class="search-item" id="article" onclick="filterTypes(this)">Article<span class="type-total" id="article-total"></span></div>
                            <div class="search-item" id="book" onclick="filterTypes(this)">Book<span class="type-total" id="book-total"></span></div>
                            <div class="search-item" id="chapter" onclick="filterTypes(this)">Chapter<span class="type-total" id="chapter-total"></span></div>
                            <div class="search-item" id="thesis" onclick="filterTypes(this)">Thesis<span class="type-total" id="thesis-total"></span></div>
                            <div class="search-item" id="other" onclick="filterTypes(this)">Other<span class="type-total" id="other-total"></span></div>
                            <div class="search-item" id="studentpaper" onclick="filterTypes(this)">Student Paper<span class="type-total" id="studentpaper-total"></span></div>
                        </div>
                    </div>
                    <hr />
                    <div id="sort">
                        <h4>Sort By:</h4>
                        <div id="sort-type">
                            <div class="active search-item" id="sort-year-type-author" data-sort="year-type-authors" onclick="sortLibrary(this)">Year, Type, Author</div>
                            <div class="search-item" id="sort-authors" data-sort="authors" onclick="sortLibrary(this)">Author</div>
                            <div class="search-item" id="sort-title" data-sort="title" onclick="sortLibrary(this)">Title</div>
                            <div class="search-item" id="sort-rt-name" data-sort="rt.name" onclick="sortLibrary(this)">Type</div>
                            <div class="search-item" id="sort-year" data-sort="year" onclick="sortLibrary(this)">Year</div>
                        </div>
                    </div>
                </div>
                <div>
                    <div id="library-grid"></div>
                    <div id="pager"></div>
                </div>
            </div>
        </div>
        <div>
            Tab 2 Text
        </div>
        <div>
            Tab 3 Text
        </div>
        <div>
            Tab 4 Text
        </div>
        <div>
            Tab 5 Text
        </div>
    </div>

<?php
}
