
document.addEventListener("DOMContentLoaded", function() {

    // Select2
    $(".select2").each(function() {
        $(this)
            .wrap("<div class=\"position-relative\"></div>")
            .select2({
                placeholder: "Select value",
                dropdownParent: $(this).parent()
            });
    })
});

