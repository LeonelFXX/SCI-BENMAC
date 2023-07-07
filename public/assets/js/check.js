var checkbox1 = document.getElementById('checkbox1');
var checkbox2 = document.getElementById('checkbox2');

checkbox1.addEventListener('change', function () {
    if (this.checked) {
        checkbox2.checked = false;
    }
});

checkbox2.addEventListener('change', function () {
    if (this.checked) {
        checkbox1.checked = false;
    }
});
