const maxFiles = 5;
const maxSizeMB = 15000000;
let uploadedFiles = [];
let uploadedFilesExisting = [];
let totalFileCount = 0;
let selected_id_attachment_ticket = [];

function initialize_upload() {
    // Agregar los elementos
    add_file_upload_elements();

    // Configurar tabla inicial
    initialize_table();

    // Configurar carga de archivos
    setup_file_upload();
    
    handle_table_actions();
}

// Función para agregar el HTML dinámicamente
function add_file_upload_elements() {
    const container = document.getElementById("custom-btn-upload-table");

    if (container) {
        container.innerHTML = `
            <span class="btn btn-light w-100" for="file-upload">Seleccionar archivo</span>
            <input type="file" id="input-document" name="document" multiple="" style="display: none;">
        `;
    } else {
        console.error("El contenedor con el ID especificado no existe.");
    }
}

function initialize_table() {
    const noFilesRow = document.createElement("tr");
    noFilesRow.id = "no-files-row";
    noFilesRow.innerHTML = '<td colspan="3" class="text-center text-muted">Ningún archivo seleccionado.</td>';
    document.querySelector("#table-handler tbody").appendChild(noFilesRow);
}

function setup_file_upload() {
    const inputElement = document.querySelector("#input-document");
    const triggerElement = document.querySelector("span[for='file-upload']");

    // Configurar el evento de clic en el span para disparar el input de archivo
    triggerElement.addEventListener("click", function () {
        inputElement.click(); // Activar el input de tipo file
    });

    inputElement.addEventListener("change", function () {
        const tableBody = document.querySelector("#table-handler tbody");
        const noFilesRow = document.getElementById("no-files-row");
        const files = Array.from(inputElement.files);

        if (uploadedFiles.length + files.length > maxFiles) {
            showMessage("warning", "Solo se permiten un máximo de " + maxFiles + " archivos.");
            inputElement.value = ""; // Limpiar input
            return;
        }

        files.forEach((file) => {
            if (file.size > maxSizeMB) {
                showMessage("warning", `El archivo ${file.name} excede el tamaño máximo de 15 MB.`);
            } else {
                if (tableBody.contains(noFilesRow)) {
                    noFilesRow.remove();
                }

                uploadedFiles.push(file);
                totalFileCount++;

                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${totalFileCount}</td>
                    <td>${file.name}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-file" data-index="${totalFileCount - 1}">
                            Eliminar
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            }
        });

        inputElement.value = ""; // Limpiar input después de procesar
    });
}

function load_existing_attachments(attachments) {
    const tableBody = document.querySelector("#table-handler tbody");
    const noFilesRow = document.getElementById("no-files-row");
    
    totalFileCount = 0;

    if (attachments.length > 0) {
        
        tableBody.innerHTML = "";

        if (noFilesRow) {
            noFilesRow.remove();
        }

        attachments.forEach(function (attachment, index) {
            uploadedFilesExisting.push(attachment);
            totalFileCount++;
            const row = document.createElement("tr");
    
            row.innerHTML = `
                <td>${totalFileCount}</td>
                <td>${attachment.name_attachment_ticket}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm js-remove-existing" data-id="${attachment.id_attachment_ticket}">
                        Eliminar
                    </button>
                </td>
            `;
    
            tableBody.appendChild(row);
        });
    }
    
}

function handle_table_actions() {
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-file")) {
            const index = parseInt(event.target.getAttribute("data-index"));
            uploadedFiles.splice(index, 1);
            refresh_table();
        }
        if (event.target.classList.contains("js-remove-existing")) {
            const idAttachment = event.target.getAttribute("data-id");
            selected_id_attachment_ticket.push(idAttachment);
            uploadedFilesExisting = uploadedFilesExisting.filter(attachment => attachment.id_attachment_ticket !== Number(idAttachment));
            refresh_table();
        }
    });
}

function refresh_table() {
    const tableBody = document.querySelector("#table-handler tbody");
    tableBody.innerHTML = "";
    totalFileCount = 0;

    // Recorrer los archivos existentes
    uploadedFilesExisting.forEach(function (attachment, index) {
        totalFileCount++;
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${totalFileCount}</td>
            <td>${attachment.name_attachment_ticket}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm js-remove-existing" data-id="${attachment.id_attachment_ticket}">
                    Eliminar
                </button>
            </td>
        `;
        tableBody.appendChild(row);
    });

    // Recorrer los nuevos archivos
    uploadedFiles.forEach(function (file, index) {
        totalFileCount++;
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${totalFileCount}</td>
            <td>${file.name}</td>
            <td>
                <button class="btn btn-danger btn-sm remove-file" data-index="${index}">
                    Eliminar
                </button>
            </td>
        `;
        tableBody.appendChild(row);
    });

    // Comprobar si la tabla está vacía
    check_empty_table();
}

function clear_uploaded_files() {
    uploadedFiles = [];
    uploadedFilesExisting = [];
    selected_id_attachment_ticket = []
    refresh_table();
}

function result_data(form_data) {
    
    uploadedFiles.forEach(function (file, index) {
        form_data.append('document[' + index + ']', file);
    });

    const selectedAttachmentIDs = selected_id_attachment_ticket;
    selectedAttachmentIDs.forEach((id, index) => {
        form_data.append(`delete_attachments[${index}]`, id);
    });

    return form_data;
}


function check_empty_table() {
    const tableBody = document.querySelector("#table-handler tbody");
    if (!tableBody.hasChildNodes()) {
        initialize_table();
    }
}
