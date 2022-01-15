$(".show_length").each(function(index, element) {
    var label = document.getElementById(element.id + "_label");
    label.innerHTML = element.value.length + "/" + element.maxLength;

    if (element.value.length >= (element.maxLength / 100) * 50) {
        label.style.color = "orange";
    }
    if (element.value.length >= (element.maxLength / 100) * 90) {
        label.style.color = "red";
    }
    if (element.value.length < (element.maxLength / 100) * 50) {
        label.style.color = "green";
    }

    element.addEventListener("input", input_change);

    function input_change(e) {
        label.innerHTML = e.target.value.length + "/" + element.maxLength;
        if (e.target.value.length >= (element.maxLength / 100) * 50) {
            label.style.color = "orange";
        }
        if (e.target.value.length >= (element.maxLength / 100) * 90) {
            label.style.color = "red";
        }
        if (e.target.value.length < (element.maxLength / 100) * 50) {
            label.style.color = "green";
        }
    }
});