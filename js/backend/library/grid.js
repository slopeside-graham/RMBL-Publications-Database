$ = jQuery;

var startYear;
var endYear;
var year;
var type;
var sortDirection;
var sortDirectionClass;
var sort;
var editortabs;

var libraryEditItem;
var libraryEditorValidator;

$(function () {
    $(document).ready(function () {
        var libraryGrid = $("#library-grid").kendoGrid({
            dataSource: LibraryDataSource,
            toolbar: ["create"],
            sortable: true,
            columns: [
                { field: "id", title: "ID", width: "60px" },
                {
                    field: "reftypeId",
                    title: "Type",
                    dataSource: reftypeDataSource,
                    dataTextField: "name",
                    dataValueField: "id",
                    width: "100px"
                },
                { field: "title", title: "Title", encoded: false },
                //{ field: "authors", title: "Authors" },
                { field: "year", title: "Year", width: "80px" },
                { command: ["edit"], title: "&nbsp;", width: "100px" }
            ],
            editable: {
                mode: "popup",
                window: {
                    title: "Edit Library Item",
                    width: 600,
                    position: {
                        top: 100
                    }
                },
                template: kendo.template($("#library-popup-editor").html())
            },
            edit: function (e) {
                libraryEditItem = e.model;

                let id = e.model.id === 0 ? -1 : e.model.id; // If we are adding a new record, set the ID to -1, so it wont find any records, 0 is nullish which returns all authors.

                authorDataSource.filter([{ field: "libraryId", value: id, operator: "eq" },]);
                buildEditorTabs();
                $('#libraryitemauthors').kendoAutoComplete({
                    dataSource: libraryPeopleDataSource,
                    dataTextField: "LastName",
                    dataValueField: "id",
                    valuePrimitive: true,
                    filter: "startswith",
                    placeholder: "Search by Last Name...",
                    template: function (dataItem) {
                        return `${dataItem.LastName}${dataItem.FirstName ? ", " + dataItem.FirstName : ""}${dataItem.Student == 1 ? "*" : ""}`
                    },
                    // value: e.model.authorIds,
                    noDataTemplate: kendo.template($("#no-author-template").html()),
                    //filtering: onAuthorFiltering,
                    //close: authorDDLclose,
                    //select: authorSelect
                    select: function (e) {
                        e.preventDefault();

                        console.log(e);
                        e.sender.value("")
                        authorDataSource.add({
                            peopleId: e.dataItem.id,
                            libraryId: libraryEditItem.id,
                            LastName: e.dataItem.LastName,
                            FirstName: e.dataItem.FirstName,
                            SuffixName: e.dataItem.SuffixName,
                            authornumber: 1,
                            student: 0
                        });
                        authorDataSource.sync().then(function () {
                            authorDataSource.read();
                        });
                        // Use the selected item or its text
                    },
                });
                var authorsGrid = $('#libraryitemauthorsgrid').kendoGrid({
                    dataSource: authorDataSource,
                    pageable: true,
                    sortable: true,
                    editable: "incell",
                    // navigatable: true,
                    cellClose: function (e) {
                        if (e.type === "save" && e.model.dirty) {
                            e.sender.dataSource.sync().then(function () {
                                console.log("Author Updated");
                                e.sender.dataSource.read();
                            });
                        }
                    },
                    columns: [
                        {
                            field: "authornumber",
                            title: "Order",
                            width: "80px"
                        },
                        {
                            field: "id",
                            title: "Name",
                            template: "#:LastName #, #:FirstName #"
                        },
                        {
                            field: "student",
                            title: "Student",
                            template: '#= student ? "Yes" : "No" #',
                            editor: function (container, options) {
                                // create an input element
                                var input = $("<input/>");
                                // set its name to the field to which the column is bound ('name' in this case)
                                input.attr("name", options.field);
                                // append it to the container
                                input.appendTo(container);
                                // initialize a Kendo UI AutoComplete
                                input.kendoDropDownList({
                                    dataTextField: "text",
                                    dataValueField: "value",
                                    valuePrimitive: true,
                                    dataSource: [
                                        { text: "Yes", value: 1 },
                                        { text: "No", value: 0 }
                                    ],
                                });
                            },
                            width: 110,
                            attributes: {
                                class: "k-text-center"
                            }
                        },
                        {
                            command: [
                                {
                                    name: "delete",
                                    text: "Delete",
                                    className: "btn-destroy",
                                    click: function (e) {
                                        this.dataSource.sync().then(function () {
                                            this.dataSource.read();
                                        })
                                    },
                                    width: "100px"
                                }
                            ]
                        }
                    ]
                }).data("kendoGrid");

                // authorsGrid.table.kendoSortable({
                //     filter: ">tbody >tr",
                //     hint: $.noop,
                //     cursor: "move",
                //     placeholder: function (element) {
                //         return element.clone().addClass("k-state-hover").css("opacity", 0.65);
                //     },
                //     container: "#grid tbody",
                //     change: function (e) {
                //         var skip = grid.dataSource.skip(),
                //             oldIndex = e.oldIndex + skip,
                //             newIndex = e.newIndex + skip,
                //             data = grid.dataSource.data(),
                //             dataItem = grid.dataSource.getByUid(e.item.data("uid"));

                //         grid.dataSource.remove(dataItem);
                //         grid.dataSource.insert(newIndex, dataItem);
                //     }
                // });

                $('#publisherId').kendoDropDownList({
                    dataSource: libraryPublisherDataSource,
                    dataTextField: "name",
                    dataValueField: "id",
                    valuePrimitive: true,
                    value: e.model.publisherId,
                    filter: "contains",
                    template: '#: name # - #:city_state #',
                    valueTemplate: '#: name # - #:city_state #',
                    noDataTemplate: kendo.template($("#no-publisher-template").html()),
                    // close: publisherDDLclose(),
                    // select: publisherSelect(),
                    // filtering: onPublisherFiltering()
                    // data-filtering="onPublisherFiltering" 
                    // data-close="publisherDDLclose" 
                    // data-select="publisherSelect" 
                    // data-value-template="publisher-template" 
                    // data-template="publisher-template" />
                });
                $('#libraryitemtags').kendoMultiSelect({
                    dataSource: tagDataSource,
                    dataTextField: "tag",
                    dataValueField: "id",
                    valuePrimitive: true,
                    value: e.model.tagIds,
                    template: '#: tag# (#: records#)',
                    noDataTemplate: kendo.template($("#no-tag-template").html()),
                });
                // modifyPageSizes();
            }
        });
        attachPager();
        attachFilter();
        buildEditorTabs();
    });
});


function attachTotals(result) {
    var totalTypesArray = result.totalTypes;
    var total = result.total;

    var filtercontainer = document.getElementById('filter-types');
    var filterinputs = filtercontainer.querySelectorAll('div');

    var librariestotal = 0;

    filterinputs.forEach((element) => {
        document.getElementById(element.id + '-total').innerHTML = 0;
        document.getElementById(element.id).style.display = 'none'

    });

    Object.entries(totalTypesArray).forEach(entry => {
        const [key, value] = entry;

        var itemType = value['Type'].toLowerCase() + '-total';
        element = document.getElementById(itemType)
        if (element) {
            document.getElementById(itemType).innerHTML = value['Total'];
            document.getElementById(value['Type'].toLowerCase()).style.display = 'block';
            librariestotal += parseInt(value['Total']);
        }
    })
    document.getElementById('show-all').style.display = 'block';
    document.getElementById('show-all-total').innerHTML = librariestotal;
}
function insertTotals() {

}

function attachPager() {
    $("#pager").kendoPager({
        dataSource: LibraryDataSource,
        pageSizes: [5, 10, 20, 50]
    });
};

function attachFilter() {
    $("#filter").kendoFilter({
        dataSource: LibraryDataSource,
        applyButton: false,
        fields: [
            { name: "title", type: "string", label: "Title" },
            { name: "authors", type: "string", label: "Author" },
            { name: "keywords", type: "string", label: "Keywords" }
        ],
        expression: {
            logic: "and",
            filters: [
                { field: "title", value: "", operator: "contains" },
                { field: "authors", value: "", operator: "contains" },
                { field: "keywords", value: "", operator: "contains" },
            ]
        }
    })
}

function sortLibrary(clickedItem) {
    var sortcontainer = document.getElementById('sort-type');
    var sortinputs = sortcontainer.querySelectorAll('div');

    sortinputs.forEach(element => element.classList.remove('active'));
    sortinputs.forEach(element => element.classList.remove('sort-ascending'));
    sortinputs.forEach(element => element.classList.remove('sort-decending'));

    if (sort != clickedItem.dataset.sort) {
        sortDirection = '';
    }

    sort = clickedItem.dataset.sort;

    if (!sortDirection) {
        sortDirection = "asc";
        sortDirectionClass = "sort-ascending";
    } else if (sortDirection == "asc") {
        sortDirection = "desc";
        sortDirectionClass = "sort-decending";
    } else if (sortDirection == "desc") {
        sortDirection = "asc";
        sortDirectionClass = "sort-ascending";
    };

    if (sort == 'year-type-authors') {
        LibraryDataSource.sort(
            [
                { field: 'year', dir: "desc" },
                { field: 'rt.name', dir: "asc" },
                { field: 'authors', dir: "asc" }
            ]
        );
        sortDirectionClass = "";
    } else {
        LibraryDataSource.sort(
            [
                { field: sort, dir: sortDirection }
            ]
        );
    }

    var element = document.getElementById(clickedItem.id);
    element.classList.add("active");
    //element.classList.remove("sort-decending");
    //element.classList.remove("sort-ascending");
    element.classList.add(sortDirectionClass);
}

function filterLibrary() {
    event.preventDefault();

    title = document.getElementById('title').value;
    author = document.getElementById('author').value;
    keywords = document.getElementById('keywords').value;
    startYear = document.getElementById('yearStart').value;
    endYear = document.getElementById('yearEnd').value;
    tag = document.getElementById('tag').value;

    LibraryDataSource.filter(
        [
            { field: "title", value: title, operator: "LIKE" },
            { field: "authors", value: author, operator: "LIKE" },
            { field: "keywords", value: keywords, operator: "LIKE" },
            { field: "year", value: startYear, operator: ">=" },
            { field: "year", value: endYear, operator: "<=" },
            { field: "rt.name", value: type, operator: "eq" },
            { field: "lht.tag_id", value: tag, operator: "eq" }
        ]
    )
}

function filterTypes(clickedItem) {
    var typescontainer = document.getElementById('filter-types');
    var typeinputs = typescontainer.querySelectorAll('div');

    typeinputs.forEach(element => element.classList.remove('active'));

    type = clickedItem.id;
    if (type == 'show-all') {
        type = '';
    }

    filterLibrary();

    var element = document.getElementById(clickedItem.id);
    element.classList.add("active");
}

function buildAuthors(authors) {
    console.log(authors);
    var authorNamesAray = [];

}

function openAddAuthorWindow(widgetId) {
    event.preventDefault;
    console.log(widgetId);

    var addAuthorWindow = $("#author-add-window");

    addAuthorWindow.kendoWindow({
        width: "600px",
        title: "Add New Author",
        visible: false
    }).data("kendoWindow").center().open();
}

function openAddPublisherWindow(widgetId) {
    event.preventDefault;
    console.log(widgetId);

    var addPublisherWindow = $("#publisher-add-window");

    addPublisherWindow.kendoWindow({
        width: "600px",
        title: "Add New Publisher",
        visible: false
    }).data("kendoWindow").center().open();
}

function addNewAuthor() {
    event.preventDefault();
    var widget = $("#libraryitemauthors").getKendoAutoComplete();
    var dataSource = widget.dataSource;
    var authorFirstName = $('#newAuthorFirstName').val();
    var authorLastName = $('#newAuthorLastName').val();
    var authorSuffix = $('#newAuthorSuffix').val();
    var authorStudent = $('#newAuthorStudent').val()

    if (authorLastName) {
        if (confirm("Are you sure you want to add a new Author?")) {
            dataSource.add({
                FirstName: authorFirstName,
                LastName: authorLastName,
                SuffixName: authorSuffix,
                Student: authorStudent,
                LibraryId: libraryEditItem.id,
                peopleIds: libraryEditItem.authorIds
            });
        }

        dataSource.one("sync", function () {
            dataSource.read().then(function () {
                var newAuthor = dataSource.data()[dataSource.data().length - 1]; // Get the new item
                var addAuthorWindow = $("#author-add-window");

                // widget.value(newAuthorId);

                addAuthorWindow.data("kendoWindow").close();
                // widget.trigger("change"); // Tell the editor there has been a change

                authorDataSource.add({
                    peopleId: newAuthor.id,
                    libraryId: libraryEditItem.id,
                    LastName: newAuthor.LastName,
                    FirstName: newAuthor.FirstName,
                    SuffixName: newAuthor.SuffixName,
                    authornumber: 1
                });
                authorDataSource.sync();

                $('#newAuthorFirstName').val('');
                $('#newAuthorLastName').val('');
                $('#newAuthorSuffix').val('');
                $('#newAuthorStudent').val('');
            });
        });
        widget.value("");
        dataSource.sync();
    } else {
        alert("Author Last Name is Required.");
    }
};


function addNewPublisher() {
    event.preventDefault();
    var widget = $("#publisherId").getKendoDropDownList();
    var dataSource = widget.dataSource;
    var publisherName = $('#newPublisherName').val();
    var publisherCityState = $('#newPublisherCityState').val();

    if (publisherName && publisherCityState) {
        if (confirm("Are you sure you want to add a new Publisher?")) {
            dataSource.add({
                name: publisherName,
                city_state: publisherCityState
            });
        }

        dataSource.one("sync", function () {
            dataSource.read().then(function () {
                var newPublisher = dataSource.data().length - 1; // Get the new item index
                var newPublisherId = parseInt(dataSource.data()[newPublisher].id); // Get the id of the new item
                var addPublisherWindow = $("#publisher-add-window");

                widget.value(newPublisherId);

                addPublisherWindow.data("kendoWindow").close();
                widget.trigger("change"); // Tell the editor there has been a change

                $('#newPublisherName').val('');
                $('#newPublisherCityState').val('');
            });
        });

        dataSource.sync();
    } else {
        alert("Publisher name and City State are Required.");
    }
};

function closeAuthorAddWindow() {
    var addAuthorWindow = $("#author-add-window");

    $('#newAuthorFirstName').val('');
    $('#newAuthorLastName').val('');
    $('#newAuthorSuffix').val('');

    addAuthorWindow.data("kendoWindow").close();
}

function closePublisherAddWindow() {
    var addPublisherWindow = $("#publisher-add-window");

    $('#newPublisherName').val('');
    $('#newPublisherCityState').val('');

    addPublisherWindow.data("kendoWindow").close();
}

var authorswidget;
var publisherwidget;

var authorwidgetpagesize;
var publisherwidgetpagesize;

function modifyPageSizes() {
    authorswidget = $("#libraryitemauthors").getKendoMultiSelect();
    publisherwidget = $("#publisherId").getKendoDropDownList();

    authorwidgetpagesize = authorswidget.dataSource.pageSize();
    publisherwidgetpagesize = publisherwidget.dataSource.pageSize();

    authorswidget.dataSource.pageSize(authorswidget.dataSource.total());
    publisherwidget.dataSource.pageSize(publisherwidget.dataSource.total());
}

function resetPageSizes() {
    authorswidget.dataSource.pageSize(authorwidgetpagesize);
    publisherwidget.dataSource.pageSize(publisherwidgetpagesize);
}

function buildEditorTabs() {
    var ebitortabs = $("#library-editor-tabstrip").kendoTabStrip({
        animation: {
            open: {
                effects: "fadeIn"
            }
        }
    });
}

function addNewTag(widgetId, value) {
    var widget = $("#" + widgetId).getKendoMultiSelect();
    var dataSource = widget.dataSource;
    if (confirm("Are you sure?")) {
        dataSource.add({
            tag: value,
            records: 0
        });

        dataSource.one("sync", function () {
            dataSource.read().then(function () {
                var newTag = dataSource.data().find(tag => tag.tag === value); // Get the new item index
                widget.value(widget.value().concat([newTag.id]));
                widget.trigger("change"); // Tell the editor there has been a change
            });
        });


        dataSource.sync();
    }
}