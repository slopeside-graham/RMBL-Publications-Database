$ = jQuery;

$(function () {
    $(document).ready(function () {
        var peopleGrid = $("#people-grid").kendoGrid({
            dataSource: peopleDataSource,
            toolbar: ["create", "search"],
            sortable: true,
            columns: [
                { field: "id", title: "ID", width: "60px" },
                {
                    field: "LastName", title: "Last Name",
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
                {
                    field: "FirstName", title: "First Name (First and Middle Initial)",
                    editor: function (container, options) {
                        // create an input element
                        var input = $("<input/>");
                        // set its name to the field to which the column is bound ('name' in this case)
                        input.attr("name", options.field);
                        input.attr("required", "required");
                        input.attr("maximumlength", 5);
                        // append it to the container
                        input.appendTo(container).kendoTextBox();
                    }
                },
                {
                    field: "SuffixName", title: "Suffix",
                    editor: function (container, options) {
                        // create an input element
                        var input = $("<input/>");
                        // set its name to the field to which the column is bound ('name' in this case)
                        input.attr("name", options.field);
                        input.attr("required", "required");
                        input.attr("maximumlength", 10);
                        // append it to the container
                        input.appendTo(container).kendoTextBox();
                    }
                },
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
