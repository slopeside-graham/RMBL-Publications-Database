$ = jQuery;

$(function () {
    $(document).ready(function () {
        var publishersGrid = $("#publisher-grid").kendoGrid({
            dataSource: publisherDataSource,
            toolbar: ["create", "search"],
            sortable: true,
            columns: [
                { field: "id", title: "ID", editable: false, width: "60px" },
                { field: "name", title: "Name" },
                { field: "city_state", title: "City State" },
                { command: ["edit"], title: "&nbsp;", width: "100px" }
            ],
            editable: {
                mode: "popup",
                window: {
                    title: "Edit Publisher",
                    width: 600,
                    position: {
                        top: 100
                    }
                }
            },
            pageable: true,
            search: {
                fields: ["name"] // Or, specify multiple fields by adding them to the array, e.g ["name", "age"]
            },
            sortable: true
        });
    });
});
