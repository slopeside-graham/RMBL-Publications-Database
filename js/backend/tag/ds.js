$ = jQuery;

TagDataSource = new kendo.data.DataSource({
    transport: {
        read: function (options) {
            displayLoading($('body'));
            $.ajax({
                url: wpApiSettings.root + "rmbl-pubs/v1/admin/tag",
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
        },
        create: function (options) {
            displayLoading($('body'));
            $.ajax({
                url: wpApiSettings.root + "rmbl-pubs/v1/admin/tag",
                dataType: "json",
                method: "POST",
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
    schema: {
        data: 'data',
        total: function (response) {
            return response.data.length; // Calculate the total number of data items returned.
        },
        model: {
            id: "id",
            fields: {
                id: { type: "number" },
                tag: { type: "string", validation: { required: true } }
            }
        }
    }
});