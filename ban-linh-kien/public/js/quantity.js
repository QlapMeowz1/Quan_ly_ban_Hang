
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-qty-plus').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var input = this.parentNode.querySelector('.qty-input');
            input.value = parseInt(input.value) + 1;
        });
    });
    document.querySelectorAll('.btn-qty-minus').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var input = this.parentNode.querySelector('.qty-input');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        });
    });
});

