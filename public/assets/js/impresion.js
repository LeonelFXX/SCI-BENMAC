function imprimirArchivo() {
    var fileInput = document.getElementById('archivoImprimir');
    var file = fileInput.files[0];

    // Validamos que se haya seleccionado un archivo y sea de tipo PDF
    if (file && file.type === 'application/pdf' || file.type === 'image/jpg' || file.type === 'image/jpeg' || file.type === 'image/png') {
        var fileURL = URL.createObjectURL(file);

        // Abrimos una nueva ventana de impresión con el contenido del PDF
        var printWindow = window.open(fileURL, '_blank');

        printWindow.onload = function () {
            printWindow.print();

            // Liberamos la URL del archivo
            URL.revokeObjectURL(fileURL);
        };
    }
}
