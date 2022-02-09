$ = jQuery;

$(function () {
    $(document).ready(function () {
        var reportGrid = $("#report-grid").kendoGrid({
            dataSource: reportDataSource,
            sortable: true,
            columns: [
                { field: "RefType", title: "Reference Type" },
                { field: "Total", title: "Total" },
                { field: "Student", title: "Student" }
            ],
            editable: false,
            pageable: true,
            sortable: true
        });
    });
});
