$ = jQuery;

$(function () {
    $(document).ready(function () {
        var publishersGrid = $("#publisher-grid").kendoGrid({
            dataSource: publisherDataSource,
            toolbar: ["create", "search"],
            sortable: true,
            columns: [
                { field: "id", title: "ID", editable: false, width: "60px" },
                {
                    field: "name", title: "Name",
                    editor: function (container, options) {
                        // create an input element
                        var input = $("<input/>");
                        // set its name to the field to which the column is bound ('name' in this case)
                        input.attr("name", options.field);
                        input.attr("required", "required");
                        input.attr("maximumlength", 100);
                        // append it to the container
                        input.appendTo(container).kendoTextBox();
                    }
                },
                {
                    field: "city_state", title: "City State",
                    editor: function (container, options) {
                        // create an input element
                        var input = $("<input/>");
                        // set its name to the field to which the column is bound ('name' in this case)
                        input.attr("name", options.field);
                        input.attr("required", "required");
                        input.attr("maximumlength", 50);
                        // append it to the container
                        input.appendTo(container).kendoTextBox();
                    }
                },
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
