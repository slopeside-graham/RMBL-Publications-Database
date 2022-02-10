$ = jQuery;

reportDataSource = new kendo.data.DataSource({
    transport: {
        read: function (options) {
            displayLoading($('body'));
            $.ajax({
                url: wpApiSettings.root + "rmbl-pubs/v1/admin/report",
                dataType: "json",
                method: "GET",
                data: options.data,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("X-WP-Nonce", wpApiSettings.nonce);
                },
                success: function (result) {
                    options.success(result);
                    hideLoading($('body'));
                },
                error: function (result) {
                    options.error(result);
                    alert(result.responseText);
                    hideLoading($('body'));
                }
            });
        }
    },
    serverFiltering: true,
    schema: {
        data: 'data',
        total: function (response) {
            return response.data.length; // Calculate the total number of data items returned.
        },
        model: {
            id: "RefType",
            fields: {
                RefType: { type: "string" },
                Total: { type: "number" },
                Student: { type: "number" }
            }
        }
    },
    aggregate: [ 
        { field: "Total", aggregate: "sum" },
        { field: "Student", aggregate: "sum" }
     ]
});

reportYearDataSource = new kendo.data.DataSource({
    transport: {
        read: function (options) {
            displayLoading($('body'));
            $.ajax({
                url: wpApiSettings.root + "rmbl-pubs/v1/admin/report",
                dataType: "json",
                method: "GET",
                data: { type: 'year' },
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("X-WP-Nonce", wpApiSettings.nonce);
                },
                success: function (result) {
                    options.success(result);
                    hideLoading($('body'));
                },
                error: function (result) {
                    options.error(result);
                    alert(result.responseText);
                    hideLoading($('body'));
                }
            });
        }
    },
    schema: {
        data: 'data',
        total: function (response) {
            return response.data.length; // Calculate the total number of data items returned.
        },
        model: {
            id: "year",
            fields: {
                year: { type: "string" }
            }
        }
    }
});