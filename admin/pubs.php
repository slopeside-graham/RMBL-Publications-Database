<?php

use PUBS\Utils;

function pubs_main()
{
    pubs_enqueue_backend_library();
    pubs_enqueue_backend_people();
?>
    <div>
        <h1>Publications Database Integration</h1>
        <div id="pubs-tabstrip">
            <ul>
                <li class="k-state-active">Library</li>
                <li>Authors</li>
                <li>Publishers</li>
                <li>Reports</li>
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
                    <div id="author-add-window">
                        <div class="editor-section">
                            <div class="editor-row">
                                <label>Last Name: <input type="text" data-role="textbox" id="newAuthorLastName" required /></label>
                                <label>First and Middle Initial: <input type="text" data-role="textbox" id="newAuthorFirstName" /></label>
                            </div>
                            <div class="editor-row">
                                <label>Suffix: <input type="text" data-role="textbox" id="newAuthorSuffix" /></label><br />
                            </div>
                            <button type="submit" class="k-button k-button-solid-base k-button-solid k-button-rectangle k-button-md k-rounded-md" onclick="addNewAuthor()">Add new Author</button>
                            <button class="k-button" onclick="closeAuthorAddWindow()">Close</button>
                        </div>
                    </div>

                    <div id="publisher-add-window">
                        <div class="editor-section">
                            <div class="editor-row">
                                <label>Publisher Name: <input type="text" data-role="textbox" id="newPublisherName" /></label>
                                <label>City & State: <input type="text" data-role="textbox" id="newPublisherCityState" /></label>
                            </div>
                            <button type="submit" class="k-button k-button-solid-base k-button-solid k-button-rectangle k-button-md k-rounded-md" onclick="addNewPublisher()">Add new Publisher</button>
                            <button class="k-button" onclick="closeAuthorAddWindow()">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div id="people-grid"></div>
            </div>
            <div>
                <div id="publisher-grid"></div>
            </div>
            <div>
                <div class="year-filter">
                    <input id="reportYear" />
                </div>
                <div id="report-grid"></div>
            </div>
        </div>

        <script id='library-popup-editor' type='text/html'>
            <div id="library-editor">
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
                            <label>RefType:
                                <input required name="reftypeId" data-bind="value:reftypeId" data-value-field="id" data-text-field="name" data-source="reftypeDataSource" data-role="dropdownlist" />
                            </label>
                            <div>
                                <label for="year">Year:</label>
                                <input type="text" data-role="textbox" required maximumlength="4" minimumlength="4" name="year" />
                            </div>
                        </div>
                        <div class="editor-row">
                            <label>Title:<input type="text" data-role="textbox" required maximumlength="254" name="title" /></label>
                        </div>
                        <div class="editor-row">
                            <label>Chapter Title:<input type="text" data-role="textbox" maximumlength="255" name="chaptertitle" /></label>
                            <label>Journal Name:<input type="text" data-role="textbox" maximumlength="255" name="journalname" /></label>
                        </div>
                        <div class="editor-row">
                            <label>Volume:<input type="text" data-role="textbox" maximumlength="12" name="volume" /></label>
                            <label>Pages:<input type="text" data-role="textbox" maximumlength="12" name="pages" /></label>
                            <label>Catalog Number:<input type="text" data-role="textbox" maximumlength="30" name="catalognumber" /></label>
                            <label>Journal Issue:<input type="text" data-role="textbox" maximumlength="10" name="journalissue" /></label>
                        </div>
                        <div class="editor-row">
                            <label>Book Editors:<input type="text" data-role="textbox" maximumlength="150" name="bookeditors" /></label>
                            <label>Degree:<input type="text" data-role="textbox" maximumlength="50" name="degree" /></label>
                            <label>Edition:<input type="text" data-role="textbox" maximumlength="50" name="edition" /></label>
                        </div>
                        <div class="editor-row">
                            <label>Rest of Reference:<input type="text" data-role="textbox" maximumlength="255" name="restofreference" /></label>
                            <label>Institution:<input type="text" data-role="textbox" maximumlength="150" name="institution" /></label>
                        </div>
                    </div>
                    <div class="editor-section">
                        <div class="editor-row">
                            <label>RMBL:<input name="RMBL" data-role="dropdownlist" data-bind="value:RMBL" data-value-field="id" data-text-field="name" data-source="[ {id: 'T', name: 'True'}, {id: 'F', name: 'False'} ]" /></label>
                            <label>Pending:<input name="pending" data-role="dropdownlist" data-bind="value:pending" data-value-field="id" data-text-field="name" data-source="[ {id: 'T', name: 'True'}, {id: 'F', name: 'False'} ]" /></label>
                        </div>
                        <div class="editor-row">
                            <label>Student:<input name="student" data-role="dropdownlist" data-bind="value:student" data-value-field="id" data-text-field="name" data-source="[ {id: 'T', name: 'True'}, {id: 'F', name: 'False'} ]" /></label>
                            <label>Copy in Library:<input name="copyinlibrary" data-role="dropdownlist" data-bind="value:copyinlibrary" data-value-field="id" data-text-field="name" data-source="[ {id: 'T', name: 'True'}, {id: 'F', name: 'False'} ]" /></label>
                        </div>
                        <div class="editor-row">
                            <label>Tags:<input name="tagIds" id="libraryitemtags" /></label>
                        </div>
                        <div class="editor-row">
                            <label>Keywords:<input type="text" data-role="textbox" maximumlength="200" name="keywords" /></label>
                        </div>
                        <div class="editor-row">
                            <label>Comments:<input type="text" data-role="textbox" maximumlength="255" name="comments" /></label>
                            <label>Donated By:<input type="text" data-role="textbox" maximumlength="150" name="donatedby" /></label>
                        </div>
                    </div>
                    <div class="editor-section">
                        <div class="editor-row">
                            <label>PDF URL:<input type="text" data-role="textbox" maximumlength="255" name="pdf_url" /></label>
                            <button onclick="openMediaUploader('pdf_url')">Select/Upload</button>
                        </div>
                        <div class="editor-row">
                            <label>Abstract URL:<input type="text" data-role="textbox" maximumlength="255" name="abstract_url" /></label>
                            <button onclick="openMediaUploader('abstract_url')">Select/Upload</button>
                        </div>
                        <div class="editor-row">
                            <label>Fulltext URL:<input type="text" data-role="textbox" maximumlength="255" name="fulltext_url" /></label>
                            <button onclick="openMediaUploader('fulltext_url')">Select/Upload</button>
                        </div>
                        <div class="editor-row">
                            <label>BN URL:<input type="text" data-role="textbox" maximumlength="255" name="bn_url" /></label>
                            <button onclick="openMediaUploader('bn_url')">Select/Upload</button>
                        </div>
                    </div>
                    <div id="author-section" class="editor-section">
                        <div class="editor-row">
                            <label>Select Authors:
                                <input name="authorIds" id="libraryitemauthors" />
                            </label>
                        </div>
                    </div>
                    <div id="publisher-section" class="editor-section">
                        <div class="editor-row">
                            <label>Choose a Publisher:
                                <input name="publisherId" id="publisherId">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </script>

        <!-- Kendo Templates below -->
        <script type="text/html" id="no-publisher-template">
            # var id = instance.element[0].id; #
            <div>
                No data found. Do you want to add new publisher?
            </div>
            <div>
                <button class="k-button k-button-solid-base k-button-solid k-button-rectangle k-button-md k-rounded-md" onclick="openAddPublisherWindow('# instance.element[0].id #')">Add New Publisher</button>
            </div>
        </script>

        <script type="text/html" id="no-author-template">
            # var value = instance.input.val(); #
            # var id = instance.element[0].id; #
            <div>
                No data found. Do you want to add new author?
            </div>
            <div>
                <button class="k-button k-button-solid-base k-button-solid k-button-rectangle k-button-md k-rounded-md" onclick="openAddAuthorWindow('# instance.element[0].id #')">Add New Author</button>
            </div>
        </script>
    </div>
<?php
}
