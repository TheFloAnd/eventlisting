$(document).ready(function() {
    var table = $(".dataTable_default").DataTable({
        responsive: true,
        displayLength: 10,
        autoWidth: false,
        stateSave: true,
        ordering: false,
        // orderable: false,
        columnDefs: [{
                targets: ["no-sort"],
                orderable: false,
            },
            {
                targets: ["date_time"],
                type: "date-eu",
            },
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
        ],
        order: [],
        initComplete: function() {
            var api = this.api();
            api.$(".table_search").click(function() {
                api.search($.trim(this.innerHTML)).draw();
            });
        },
        language: {
            url: "/resources/js/dataTables/German.json",
        },
    });

    $("a.toggle-vis").on("click", function(e) {
        e.preventDefault();

        // Get the column API object
        var column = table.column($(this).attr("data-column"));

        // Toggle the visibility
        column.visible(!column.visible());
    });

    $(".dataTable tbody").on("click", "tr", function() {
        if ($(this).hasClass("selected")) {
            $(this).removeClass("selected");
        } else {
            table.$("tr.selected").removeClass("selected");
            $(this).addClass("selected");
        }
    });
});

$(document).ready(function() {
    var table = $(".dataTable_group_active").DataTable({
        responsive: true,
        displayLength: 10,
        autoWidth: false,
        stateSave: true,
        ordering: true,
        orderable: true,
        columnDefs: [{
            targets: ["no-sort"],
            orderable: false,
        }, ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
        ],
        order: [],
        initComplete: function() {
            var api = this.api();
            api.$(".table_search").click(function() {
                api.search($.trim(this.innerHTML)).draw();
            });
        },

        language: {
            url: "/resources/js/dataTables/German.json",
        },
    });
    $("a.toggle-vis").on("click", function(e) {
        e.preventDefault();

        // Get the column API object
        var column = table.column($(this).attr("data-column"));

        // Toggle the visibility
        column.visible(!column.visible());
    });

    $(".dataTable_group_active tbody").on("click", "tr", function() {
        if ($(this).hasClass("selected")) {
            $(this).removeClass("selected");
        } else {
            table.$("tr.selected").removeClass("selected");
            $(this).addClass("selected");
        }
    });
});
$(document).ready(function() {
    var table = $(".dataTable_group_inactive").DataTable({
        responsive: true,
        displayLength: 10,
        autoWidth: false,
        stateSave: true,
        ordering: true,
        orderable: true,
        columnDefs: [{
            targets: ["no-sort"],
            orderable: false,
        }, ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
        ],
        order: [],
        initComplete: function() {
            var api = this.api();
            api.$(".table_search").click(function() {
                api.search($.trim(this.innerHTML)).draw();
            });
        },
        language: {
            url: "/resources/js/dataTables/German.json",
        },
    });
    $("a.toggle-vis").on("click", function(e) {
        e.preventDefault();

        // Get the column API object
        var column = table.column($(this).attr("data-column"));

        // Toggle the visibility
        column.visible(!column.visible());
    });

    $(".dataTable_group_inactive tbody").on("click", "tr", function() {
        if ($(this).hasClass("selected")) {
            $(this).removeClass("selected");
        } else {
            table.$("tr.selected").removeClass("selected");
            $(this).addClass("selected");
        }
    });
});