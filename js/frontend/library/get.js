$ = jQuery;


$(function () {
    $(document).ready(function () {
        $("#library-list-view").kendoListView({
            dataSource: LibraryDataSource,
            template: kendo.template($("#library-listview-template").html()),
            pageable: true,
        });
        attachPager();
        attachFilter();
    });
});

function attachPager() {
    $("#pager").kendoPager({
        dataSource: LibraryDataSource
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

var sortDirection = "asc";

function sortLibrary(clickedItem) {
    console.log(clickedItem.dataset.type);
    var sortBy = clickedItem.dataset.type;

    if (sortDirection == "desc") {
        LibraryDataSource.sort(
            [
                { field: "authors", dir: "asc" },
                { field: sortBy, dir: "asc" }
            ]
        );
        sortDirection = "asc";
    } else if (sortDirection == "asc") {
        LibraryDataSource.sort(
            [
                { field: "autors", dir: "asc" },
                { field: sortBy, dir: "asc" }
            ]
        );
        sortDirection = "desc";
    }
}

var startYear;
var endYear;
var year;

function filterYears() {
    startYear = document.getElementById('yearStart').value;
    endYear = document.getElementById('yearEnd').value;

    if (startYear || endYear) {
        if (startYear && !endYear) {
            endYear = startYear;
        } else if (!startYear && endYear) {
            startYear = endYear;
        }
        //console.log(startYear + " - " + endYear);
        LibraryDataSource.filter(
            [
                { field: "year", value: startYear + " AND " + endYear, operator: "between" }
            ]
        )
    }
}
var type;
function filterLibrary() {
    title = document.getElementById('title').value;
    author = document.getElementById('author').value;
    keywords = document.getElementById('keywords').value;
    startYear = document.getElementById('yearStart').value;
    endYear = document.getElementById('yearEnd').value;
    // year = "";
/*
    if (startYear || endYear) {
        if (startYear && !endYear) {
            endYear = startYear;
        } else if (!startYear && endYear) {
            startYear = endYear;
        }
        //console.log(startYear + " - " + endYear);
    }
    */
    LibraryDataSource.filter(
        [
            { field: "title", value: title, operator: "LIKE" },
            { field: "authors", value: author, operator: "LIKE" },
            { field: "keywords", value: keywords, operator: "LIKE" },
            // { field: "year", value: year, operator: "between" },
            { field: "year", value: startYear, operator: ">=" },
            { field: "year", value: endYear, operator: "<=" },
            { field: "rt.name", value: type, operator: "eq" }
        ]
    )
}

function filterTypes(clickedItem) {
    var container = document.getElementById('filter-types');
    var typeinputs = container.querySelectorAll('div');

    typeinputs.forEach(element => element.classList.remove('active'));

    type = clickedItem.id;
    if (type == 'show-all') {
        type = '';
    }

    filterLibrary();

    var element  = document.getElementById(type);
    element.classList.add("active");
}

//TODO : Finish sort and filter.
// Sort by folowing items: 
// - Year, Type Author (Default)
// - Author
// - Title
// - Type
// - Year

//FIlter by folowing items:
// - Type (Show Totals)
// - - Show All
// - - Article
// - - Thesis
// - - Other
// - - Student Paper
// - Years Range