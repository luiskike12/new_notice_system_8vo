const editToolBar = () =>{

    const removeElement = (elemID) =>{
        let element = document.getElementById(elemID);
        element.parentNode.removeChild(element);
    }
    /* Ocultar herramientas en el PDF-viewer */

    //barra primaria
    removeElement('presentationMode')// Modo presentación
    removeElement('openFile')// Abrir archivo
    removeElement('print')// imprimir
    removeElement('download')// descargar
    removeElement('viewBookmark')// Etiquetas de marcado

    //barra secundaria (responsivo)
    removeElement('secondaryPresentationMode')// Modo presentación
    removeElement('secondaryOpenFile')// Abrir archivo
    removeElement('secondaryPrint')// imprimir
    removeElement('secondaryDownload')// descargar
    removeElement('secondaryViewBookmark')// Etiquetas de marcado

    //barra izquierda desplegable de las paginas del PDF
    removeElement('viewOutline')//resumen del documento en Lineas
    // removeElement('document_outline_label')//Label
    removeElement('viewAttachments')//abrir archivos
    // removeElement('attachments_label')//Label
    removeElement('viewLayers')//Mostrar capas
    // removeElement('layers_label')//Label
}

window.onload = editToolBar;