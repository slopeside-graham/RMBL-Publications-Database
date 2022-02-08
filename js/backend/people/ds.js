$ = jQuery;

peopleDataSource = new kendo.data.DataSource({
    transport: {
        read: function (options) {
            displayLoading($('body'));
            $.ajax({
                url: wpApiSettings.root + "rmbl-pubs/v1/admin/people",
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
                url: wpApiSettings.root + "rmbl-pubs/v1/admin/people",
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
                FirstName: {
                    type: "string", validation: {
                        required: true, length
                    }
                },
                LastName: { type: "string" },
                SuffixName: { type: "string" }
            }
        }
    }
});

function length(input) {
    var maxlength = input.attr("maximumlength");
    var minlength = input.attr("minimumlength");
    if (maxlength && input.val() != "") {

        if (input.val().length > maxlength) {
            input.attr("data-length-msg", "Maximum length is " + maxlength);
            return false;
        }

        if (input.val().length < minlength) {
            input.attr("data-length-msg", "Minimum length is " + minlength);
            return false;
        }

        return true;
    }
    return true;
}