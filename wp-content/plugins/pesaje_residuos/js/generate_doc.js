function generateForm(form) {
    /* recuerdar agregar esto
    <!-- jQuery library -->
<script src="js/jquery.min.js"></script>

<!-- jsPDF library -->
<script src="js/jsPDF/dist/jspdf.min.js"></script>*/
    var doc = new jsPDF({
        orientation: 'landscape'
    });
    doc.setFont("courier");
    doc.setFontType("normal");
    doc.text(20, 30, 'Esto es courier normal.');

    doc.text(20, 20, 'Hola mundo');
    // agregar cmpos del pdf

    form.preguntas.array.forEach(element => {
        doc.text(20, 30, 'Esto es courier normal.');
    });


    // Add new page
    doc.addPage();
    doc.text(20, 20, 'Visita programacion.net');

    // Save the PDF
    doc.save('documento.pdf');
}