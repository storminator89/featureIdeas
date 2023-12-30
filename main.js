(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

$(document).ready(function() {

    $('.summernote').summernote({
        height: 200,
        minHeight: null,
        maxHeight: null,
        focus: true
    });

    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".card").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $('#ideaForm').on('submit', function(e) {
        // Zeigen Sie das Modal an
        $('#dankesPopup').modal('show');

        // Verzögern Sie das tatsächliche Absenden des Formulars
        setTimeout(function() {
            // Lassen Sie das Formular absenden
            e.target.submit();
        }, 4000); // Verzögerung von 2 Sekunden

        // Verhindern Sie das sofortige Absenden des Formulars
        return false;
    });
});