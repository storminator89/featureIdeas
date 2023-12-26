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

    document.getElementById('sort-by-votes').addEventListener('change', function() {
        var cards = Array.from(document.querySelectorAll('.col-md-4.mb-3'));
        var container = document.querySelector('.row');

        if (this.value === 'most-voted') {
            cards.sort(function(a, b) {
                return parseInt(b.querySelector('.vote-badge').textContent) - parseInt(a.querySelector('.vote-badge').textContent);
            });
        } else {
            cards.sort(function(a, b) {
                return parseInt(a.querySelector('.vote-badge').textContent) - parseInt(b.querySelector('.vote-badge').textContent);
            });
        }

        // Leeren Sie den Container und fügen Sie die sortierten Karten hinzu
        container.innerHTML = '';
        cards.forEach(function(card) {
            container.appendChild(card);
        });
    });

    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".card").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
