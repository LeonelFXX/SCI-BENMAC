var checkbox3 = document.getElementById('checkbox3');
var checkbox4 = document.getElementById('checkbox4');

checkbox3.addEventListener('change', function () {
    if (this.checked) {
        checkbox4.checked = false;
    }
});

checkbox4.addEventListener('change', function () {
    if (this.checked) {
        checkbox3.checked = false;
    }
});