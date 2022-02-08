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
})

function setPageSize(size, gridId) {
    $("#" + gridId).getKendoGrid().dataSource.pageSize(size);
}

function setPageSizes() {
    $("#people-grid").getKendoGrid().dataSource.pageSize($("#people-grid").getKendoGrid().dataSource.total());
    $("#publisher-grid").getKendoGrid().dataSource.pageSize($("#people-grid").getKendoGrid().dataSource.total());
}