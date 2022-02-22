let rows = [{
    cells: [
        // The first cell.
        { value: "OrderID" },
        // The second cell.
        { value: "Freight" },
        // The third cell.
        { value: "ShipName" },
        // The fourth cell.
        { value: "OrderDate" },
        // The fifth cell.
        { value: "ShipCity" }
    ]
}];

// Use fetch so that you can process the data when the request is successfully completed.
exportResults = function () {
    LibraryDataSource.fetch(function () {
        var data = this.data();
        for (var i = 0; i < data.length; i++) {
            // Push single row for every record.
            rows.push({
                cells: [
                    { value: data[i].OrderID },
                    { value: data[i].Freight },
                    { value: data[i].ShipName },
                    { value: data[i].OrderDate },
                    { value: data[i].ShipCity }
                ]
            })
        }
        var workbook = new kendo.ooxml.Workbook({
            sheets: [
                {
                    columns: [
                        // Column settings (width).
                        { autoWidth: true },
                        { autoWidth: true },
                        { autoWidth: true },
                        { autoWidth: true },
                        { autoWidth: true }
                    ],
                    // The title of the sheet.
                    title: "Orders",
                    // The rows of the sheet.
                    rows: rows
                }
            ]
        });
        // Save the file as an Excel file with the xlsx extension.
        kendo.saveAs({ dataURI: workbook.toDataURL(), fileName: "Test.xlsx" });
    });
}