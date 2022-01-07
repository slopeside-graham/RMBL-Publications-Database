$ = jQuery;


$(function () {
    $(document).ready(function () {
        $("#library-list-view").kendoListView({
            dataSource: LibraryDataSource,
            template: kendo.template($("#library-listview-template").html()),
            pageable: true,
            dataBound: function (e) {
                if (this.dataSource.data().length == 0) {
                    //custom logic
                    $("#library-list-view").append(
                        "<h3 class='no-entries'>No entries found, please check your search.</h3>"
                    );
                };
               attachPager();
            }
        });
    });
});

function attachPager() {
    $("#pager").kendoPager({
        dataSource: LibraryDataSource
    });
};