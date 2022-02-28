$ = jQuery;

$(function () {
    $(document).ready(function () {
        $("#pubs-tabstrip").kendoTabStrip({
            animation: {
                open: {
                    effects: "fadeIn"
                }
            }
        });
    })
    $('#tag').kendoDropDownList({
        dataSource: tagDataSource,
        dataTextField: "tag",
        dataValueField: "id",
        valuePrimitive: true,
        filter: "contains",
        optionLabel: "Select a Tag",
        rounded: null
    })
})

function setPageSize(size, gridId) {
    $("#" + gridId).getKendoGrid().dataSource.pageSize(size);
}

function setPageSizes() {
    $("#people-grid").getKendoGrid().dataSource.pageSize($("#people-grid").getKendoGrid().dataSource.total());
    $("#publisher-grid").getKendoGrid().dataSource.pageSize($("#people-grid").getKendoGrid().dataSource.total());
}

