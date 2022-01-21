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