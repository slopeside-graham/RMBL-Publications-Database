$ = jQuery;

var startYear;
var endYear;
var year;
var type;
var sortDirection;
var sortDirectionClass;
var sort;

$(function () {
    $(document).ready(function () {
        var libraryGrid = $("#library-grid").kendoGrid({
            dataSource: LibraryDataSource,
            toolbar: ["create"],
            sortable: true,
            columns: [
                { field: "id", title: "ID", width: "60px" },
                { field: "reftypeId", title: "Type", template: "#=reftypename#", width: "100px" },
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
                    },
                    close: function (e) {
                        $('#library-grid').data('kendoGrid').dataSource.read();
                    }
                },
                template: kendo.template($("#library-popup-editor").html())
            },
            edit: function (e) {
                $("#library-editor-tabstrip").kendoTabStrip({
                    animation: {
                        open: {
                            effects: "fadeIn"
                        }
                    }
                });
                $('#libraryitemauthors').kendoMultiSelect({
                    dataSource: peopleDataSource,
                    dataTextField: "FirstName",
                    dataValueField: "id",
                    valuePrimitive: true,
                    itemTemplate: '#: LastName #, #: FirstName#',
                    tagTemplate: '#: LastName #, #: FirstName#',
                    value: e.model.authorIds
                })
            }
        });
        attachPager();
        attachFilter();
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

    LibraryDataSource.filter(
        [
            { field: "title", value: title, operator: "LIKE" },
            { field: "authors", value: author, operator: "LIKE" },
            { field: "keywords", value: keywords, operator: "LIKE" },
            { field: "year", value: startYear, operator: ">=" },
            { field: "year", value: endYear, operator: "<=" },
            { field: "rt.name", value: type, operator: "eq" }
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

var closePublisherDDL = true;

function addNewPublisher(widgetId, value) {
    event.preventDefault();
    var widget = $("#" + widgetId).getKendoDropDownList();
    var dataSource = widget.dataSource;
    var cityState = $('#newPublisherCityState').val();
    var publisherName = $('#newPublisherName').val();

    if (publisherName && cityState) {
        if (confirm("Are you sure?")) {
            dataSource.add({
                name: publisherName,
                city_state: cityState
            });
        }

        dataSource.one("sync", function () {
            var newPublisher = dataSource.data().length - 1; // Get the new item index
            var newPublisherId = dataSource.data()[newPublisher].id; // Get the id of the new item
            widget.value(newPublisherId); // Set the value of the widget to the new ID. We set it here because we are using data-bind:value
            widget.trigger("change"); // Tell the editor there has been a change
            closePublisherDDL = true; // Allow dropdown to close
            widget.close(); // Close the DoprDown Widget
        });

        dataSource.sync();
    } else {
        alert("Publisher Name and City and State are Required.");
    }
};

function closePublisherDL() {
    var ddl = $('#publisherId').data('kendoDropDownList');
    closePublisherDDL = true;
    ddl.filterInput.val(null);
    $('#newPublisherName').val(null);
    $('#newPublisherCityState').val(null);
    ddl.close();
}

function onPublisherFiltering(e) {
    var id = e.sender.element[0].id;
    setTimeout(function () {
        if ($('#' + id + ' .k-nodata').css('display') != 'none') {
            closePublisherDDL = false;
        } else {
            closePublisherDDL = true;
        };

        $('#newPublisherName').click(function () {
            $('#newPublisherName').focus();
        })

        $('#newPublisherCityState').click(function () {
            $('#newPublisherCityState').focus();
        })
    }, 0)
}

function publisherDDLclose(e) {
    if ($('#publisher-section').css('display') != 'none') {
        if (closePublisherDDL == false) {
            e.preventDefault();
        }
    }
}

function publisherSelect(e) {
    closePublisherDDL = true;
}