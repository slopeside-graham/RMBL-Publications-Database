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
                        input.attr("maximumlength", 10);
                        // append it to the container
                        input.appendTo(container).kendoTextBox();
                    }
                },
                // {
                //     field: "Student",
                //     title: "Student",
                //     // template: '# if (Student) {# <input type="checkbox" #= Student ? \'checked="checked"\' : "" # class="chkbx k-checkbox k-checkbox-md k-rounded-md" disabled="disabled" /> # } else { # <input tye="checkbox" />',
                //     template: function (dataItem) {
                //         if (dataItem.Student) {
                //             return `<input type='checkbox' ${dataItem.Student === '1' || dataItem.Student === true ? 'checked="checked"' : ''} disabled="disabled" class="chkbx k-checkbox k-checkbox-md k-rounded-md" />`;
                //         } else {
                //             return '';
                //         }
                //     },
                //     width: 110,
                //     attributes: {
                //         class: "k-text-center"
                //     },
                //     editor: function (container, options) {
                //         // create an input element
                //         var input = $(`<input type="checkbox" #= Student ? \'checked="checked"\' : "" # class="chkbx k-checkbox k-checkbox-md k-rounded-md" />`);
                //         // set its name to the field to which the column is bound ('name' in this case)
                //         input.attr("name", options.field);
                //         // append it to the container
                //         input.appendTo(container)
                //     }
                // },
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
