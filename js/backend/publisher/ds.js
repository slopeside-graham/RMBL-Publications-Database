$ = jQuery;

publisherDataSource = new kendo.data.DataSource({
    transport: {
        read: function (options) {
            displayLoading($('body'));
            $.ajax({
                url: wpApiSettings.root + "rmbl-pubs/v1/admin/publisher",
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
                url: wpApiSettings.root + "rmbl-pubs/v1/admin/publisher",
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
        update: function (options) {
            displayLoading($('body'));
            $.ajax({
                url: wpApiSettings.root + "rmbl-pubs/v1/admin/publisher",
                dataType: "json",
                method: "PUT",
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
    pageSize: 10,
    schema: {
        data: 'data',
        total: function (response) {
            return response.data.length; // Calculate the total number of data items returned.
        },
        model: {
            id: "id",
            fields: {
                id: { type: "number", editable: false, nullable: false },
                name: {
                    type: "string", editable: true, nullable: false,
                    validation: {
                        required: true,
                        publisherNameValidation: function (input) {
                            if (input.is("[name='name']") && input.val() != "") {
                                input.attr("data-publishernamevalidation-msg", "Publisher Name should start with capital letter");
                                return /^[A-Z]/.test(input.val());
                            }

                            return true;
                        },
                        maxlength: function (input) {
                            if (input.is("[name='name']") && input.val() != "") {
                                if (input.val().length > 100) {
                                    input.attr("data-maxlength-msg", "Max length is 100");
                                    return false;
                                }
                                return true;
                            }
                            return true;
                        }
                    }
                },
                city_state: {
                    type: "string", ediatble: true, nullable: true,
                    validation: {
                        maxlength: function (input) {
                            if (input.is("[name='name']") && input.val() != "") {
                                if (input.val().length > 50) {
                                    input.attr("data-maxlength-msg", "Max length is 50");
                                    return false;
                                }
                                return true;
                            }
                            return true;
                        }
                    }
                }
            }
        }
    }
});