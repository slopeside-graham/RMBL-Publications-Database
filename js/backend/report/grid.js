$ = jQuery;

$(function () {
    $(document).ready(function () {
        var reportGrid = $("#report-grid").kendoGrid({
            dataSource: reportDataSource,
            sortable: true,
            columns: [
                { field: "RefType", title: "Reference Type" },
                { field: "Total", title: "Total Citations", footerTemplate: "#=sum#" },
                { field: "Student", title: "Student Citations", footerTemplate: "#=sum#" }
            ],
            editable: false,
            sortable: true
        });

        $("#reportYear").kendoDropDownList({
            dataTextField: "year",
            dataValueField: "year",
            optionLabel: "Select a year...",
            dataSource: reportYearDataSource,
            select: function (e) {
                var item = e.item;
                var text = item.text();
                if (text == 'Select a year...') {
                    text = null;
                }
                reportDataSource.filter({ field: "year", operator: "equals", value: text });
            }
        })
    });
});
