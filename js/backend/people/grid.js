$ = jQuery;

$(function () {
    $(document).ready(function () {
        var peopleGrid = $("#people-grid").kendoGrid({
            dataSource: peopleDataSource,
            toolbar: ["create", "search"],
            sortable: true,
            columns: [
                { field: "id", title: "ID", width: "60px" },
                { field: "LastName", title: "Last Name" },
                { field: "FirstName", title: "First Name" },
                { field: "SuffixName", title: "Suffix" },
                { command: ["edit"], title: "&nbsp;", width: "100px" }
            ],
            editable: {
                mode: "popup",
                window: {
                    title: "Edit Author",
                    width: 600,
                    position: {
                        top: 100
                    }
                }
            },
            pageable: true,
            search: {
                fields: ["LastName", "FirstName"] // Or, specify multiple fields by adding them to the array, e.g ["name", "age"]
            },
            sortable: true
        });
    });
});
