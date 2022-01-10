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
        applyButton: true,
        fields: [
            { name: "title", type: "string", label: "Title" },
            { name: "year", type: "string", label: "Year" },
            { name: "authors", type: "string", label: "Author" }
        ],
        expression: {
            logic: "and",
            filters: [
                { field: "title", value: "", operator: "contains" },
                { field: "year", value: "", operator: "eq" },
                { field: "authors", value: "", operator: "contains" }
            ]
        }
    })
}

var sortDirection = "asc";

function sortLibrary(clickedItem) {
    console.log(clickedItem.dataset.type);
    var sortBy = clickedItem.dataset.type;

    if (sortDirection == "desc") {
        LibraryDataSource.sort({ field: sortBy, dir: "asc" });
        sortDirection = "asc";
    } else if (sortDirection == "asc") {
        LibraryDataSource.sort({ field: sortBy, dir: "desc" });
        sortDirection = "desc";
    }
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