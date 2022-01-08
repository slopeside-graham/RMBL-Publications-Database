$ = jQuery;

LibraryDataSource = new kendo.data.DataSource({
    transport: {
        read: function (options) {
            displayLoading($('body'));
            $.ajax({
                url: wpApiSettings.root + "rmbl-pubs/v1/library",
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
    serverPaging: true,
    serverFiltering: true,
    pageSize: 10,
    schema: {
        total: 'total',
        data: 'data',
        model: {
            id: "id",
            fields: {
                id: { type: "number" },
                reftypeId: { type: "string" },
                year: { type: "string" },
                title: { type: "string" },
                volume: { type: "string" },
                edition: { type: "string" },
                publisherId: { type: "string" },
                pages: { type: "string" },
                restofreference: { type: "string" },
                journalname: { type: "string" },
                journalissue: { type: "string" },
                catalognumber: { type: "string" },
                donatedby: { type: "string" },
                chaptertitle: { type: "string" },
                bookeditors: { type: "string" },
                degree: { type: "string" },
                institution: { type: "string" },
                keywords: { type: "string" },
                comments: { type: "string" },
                bn_url: { type: "string" },
                abstract_url: { type: "string" },
                fulltext_url: { type: "string" },
                pdf_url: { type: "string" },
                copyinlibrary: { type: "string" },
                RMBL: { type: "string" },
                pending: { type: "string" },
                email: { type: "string" },
                student: { type: "string" },
                authors: { type: "string" }
            }
        }
    }
});