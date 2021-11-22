var el_nav = document.getElementById("menu");
var sortable_nav = Sortable.create(el_nav, {
    handle: ".sort_nav_move",
    filter: "#sort_nav_home",
    direction: 'vertical',
    multiDrag: true, // Enable multi-drag
    selectedClass: 'selected', // The class applied to the selected items
    fallbackTolerance: 3,
    scroll: true,
    scrollSensitivity: 30,
    scrollSpeed: 15,
    bubbleScroll: true,
    scrollFn: function (
        offsetX,
        offsetY,
        originalEvent,
        touchEvt,
        hoverTargetEl
    ) {},
    group: "sort_nav-position",
    store: {
        get: function (sortable) {
            var order = localStorage.getItem(sortable.options.group.name);
            return order ? order.split("|") : [];
        },

        set: function (sortable) {
            var order = sortable.toArray();
            localStorage.setItem(sortable.options.group.name, order.join("|"));
        },
    },
});

var el_home = document.getElementById("sort_home");
var sortable_home = Sortable.create(el_home, {
    handle: ".home_move_handel",
    scroll: true,
    selectedClass: 'selected', // The class applied to the selected items
    fallbackTolerance: 3,
    scrollSensitivity: 30,
    scrollSpeed: 15,
    bubbleScroll: true,
    scrollFn: function (
        offsetX,
        offsetY,
        originalEvent,
        touchEvt,
        hoverTargetEl
    ) {},
    group: "sort_home-position",
    store: {
        get: function (sortable) {
            var order = localStorage.getItem(sortable.options.group.name);
            return order ? order.split("|") : [];
        },

        set: function (sortable) {
            var order = sortable.toArray();
            localStorage.setItem(sortable.options.group.name, order.join("|"));
        },
    },
});
