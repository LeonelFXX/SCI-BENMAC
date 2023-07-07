function imprimirArchivo() {
    var fileInput = document.getElementById('archivoImprimir');
    var file = fileInput.files[0];

    if (file && file.type === 'application/pdf' || file.type === 'image/jpg' || file.type === 'image/jpeg' || file.type === 'image/png') {
        var fileURL = URL.createObjectURL(file);

        var printWindow = window.open(fileURL, '_blank');

        printWindow.onload = function () {
            printWindow.print();

            URL.revokeObjectURL(fileURL);
        };
    }
}
