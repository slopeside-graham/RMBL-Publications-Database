$ = jQuery;


$(function () {
    $(document).ready(function () {
        $("#pubs-list-view").kendoListView({
            dataSource: PubsDataSource,
            template: kendo.template($("#pubs-listview-template").html()),
            dataBound: function (e) {
                if (this.dataSource.data().length == 0) {
                    //custom logic
                    $("#pubs-list-view").append(
                        "<h3 class='no-entries'>No entries found, please check your search.</h3>"
                    );
                };
                // attachPager();
            }
        });
    });
});

function attachPager() {
    $("#pager").kendoPager({
        dataSource: PubsDataSource
    });
};