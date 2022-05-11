$ = jQuery;

authorDataSource = new kendo.data.DataSource({
    transport: {
        read: function (options) {
            displayLoading($('body'));
            $.ajax({
                url: wpApiSettings.root + "rmbl-pubs/v1/admin/author",
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
                url: wpApiSettings.root + "rmbl-pubs/v1/admin/author",
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
        },
        destroy: function (options) {
            displayLoading($('body'));
            $.ajax({
                url: wpApiSettings.root + "rmbl-pubs/v1/admin/author",
                dataType: "json",
                method: "DELETE",
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
    },
    pageSize: 10,
    serverFiltering: true,
    schema: {
        data: 'data',
        total: function (response) {
            return response.data.length; // Calculate the total number of data items returned.
        },
        model: {
            id: "id",
            fields: {
                id: { type: "number", editable: false, nullable: false },
                peopleId: {
                    type: "number", validation: {
                        required: true
                    }
                },
                authornumber: {
                    type: "number", editable: false,
                },
                libraryId: {
                    type: "number", editable: false,
                    validation: {
                        required: true
                    }
                },
                FirstName: {
                    type: "string", editable: false,
                    validation: {
                        required: false
                    }
                },
                LastName: {
                    type: "string", editable: false,
                },
                SuffixName: {
                    type: "string", editable: false,
                }
            }
        }
    }
});