<?php

use PUBS\Utils;

function pubs_main()
{
    pubs_enqueue_backend_library()
?>
    <h1>Publications Database Integration</h1>
    <div id="pubs-tabstrip">
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
    echo "<script id='library-popup-editor' type='text/x-kendo-template'>";
    ?>
    <div id="library-editor-tabstrip">
        <ul>
            <li class="k-state-active">Library</li>
            <li>Meta</li>
            <li>URL's</li>
            <li>Authors</li>
            <li>Publishers</li>
        </ul>
        <div class="editor-section">
            <div id="reftypeeditor" class="editor-row">
                <label>RefType:<br />
                    <input name="reftypeId" data-bind="value:reftypeId" data-value-field="id" data-text-field="name" data-source="reftypeDataSource" data-role="dropdownlist" />
                </label>
                <label>Year:<input name="year" /></label>
            </div>
            <div class="editor-row">
                <label>Title:<input name="title" /></label>
            </div>
            <div class="editor-row">
                <label>Chapter Title:<input name="chaptertitle" /></label>
                <label>Journal Name:<input name="journalname" /></label>
            </div>
            <div class="editor-row">
                <label>Volume:<input name="volume" /></label>
                <label>Pages:<input name="pages" /></label>
                <label>Catalog Number:<input name="catalognumber" /></label>
                <label>Journal Issue:<input name="journalissue" /></label>
            </div>
            <div class="editor-row">
                <label>Book Editors:<input name="bookeditors" /></label>
                <label>Degree:<input name="degree" /></label>
                <label>Edition:<input name="edition" /></label>
            </div>
            <div class="editor-row">
                <label>Rest of Reference:<input name="restofreference" /></label>
                <label>Institution:<input name="institution" /></label>
            </div>
        </div>
        <div class="editor-section">
            <div class="editor-row">
                <label>RMBL:<input name="RMBL" /></label>
                <label>Pending:<input name="pending" /></label>
            </div>
            <div class="editor-row">
                <label>Student:<input name="student" /></label>
                <label>Copy in Library:<input name="copyinlibrary" /></label>
            </div>
            <div class="editor-row">
                <label>Keywords:<input name="keywords" /></label>
            </div>
            <div class="editor-row">
                <label>Comments:<input name="comments" /></label>
                <label>Donated By:<input name="donatedby" /></label>
            </div>
        </div>
        <div class="editor-section">
            <div class="editor-row">
                <label>PDF URL:<input name="pdf_url" /></label>
            </div>
            <div class="editor-row">
                <label>Abstract URL:<input name="abstract_url" /></label>
            </div>
            <div class="editor-row">
                <label>Fulltext URL:<input name="fulltext_url" /></label>
            </div>
            <div class="editor-row">
                <label>BN URL:<input name="bn_url" /></label>
            </div>
        </div>
        <div class="editor-section">
            <div class="editor-row">
                <label>Select Authors:<input name="authors" /></label>
            </div>
        </div>
        <div class="editor-section">
            <div class="editor-row">
                <label>Choose a Publisher:<input name="publisherId" /></label>
            </div>
        </div>
    </div>
    </div>
    <?php
    echo "</script>";
    ?>
<?php
}
