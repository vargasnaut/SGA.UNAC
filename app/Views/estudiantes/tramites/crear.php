<?= $this->extend('layout/main') ?>
<?= $this->section('contenido') ?>

<h2 class="mb-4">Solicitud de Trámite</h2>

<form action="<?= base_url('estudiantes/tramites/guardar') ?>" method="POST" enctype="multipart/form-data">

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Datos del Estudiante
        </div>
        <div class="card-body row">

            <div class="col-md-4">
                <label>Código de Estudiante:</label>
                <input type="text" class="form-control" 
                       value="<?= esc($estudiante['codigo_estudiante']) ?>" readonly>
            </div>

            <div class="col-md-4">
                <label>Nombres:</label>
                <input type="text" class="form-control" 
                       value="<?= esc($estudiante['nombres']) ?>" readonly>
            </div>

            <div class="col-md-4">
                <label>Apellidos:</label>
                <input type="text" class="form-control" 
                       value="<?= esc($estudiante['apellidos']) ?>" readonly>
            </div>

            <div class="col-md-4 mt-3">
                <label>DNI:</label>
                <input type="text" class="form-control" 
                       value="<?= esc($estudiante['dni']) ?>" readonly>
            </div>

            <div class="col-md-4 mt-3">
                <label>Teléfono:</label>
                <input type="text" class="form-control" 
                       value="<?= esc($estudiante['telefono']) ?>" readonly>
            </div>

            <div class="col-md-4 mt-3">
                <label>Carrera:</label>
                <input type="text" class="form-control" 
                       value="<?= esc($estudiante['carrera']) ?>" readonly>
            </div>

        </div>
    </div>


    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            Datos del Trámite
        </div>
        <div class="card-body">

            <label>Tipo de Trámite:</label>
            <select name="tipo" class="form-control" required>
                <option value="">Seleccione...</option>
                <option value="Constancia de Estudios">Constancia de Estudios</option>
                <option value="Duplicado de Carnet">Duplicado de Carnet</option>
                <option value="Retiro de Curso">Retiro de Curso</option>
                <option value="Solicitud de Prórroga">Solicitud de Prórroga</option>
                <option value="Otro">Otro</option>
            </select>

             <label class="mt-3">Motivo:</label>
            <input type="text" name="motivo" class="form-control" 
                   placeholder="Ej: Necesito constancia para trámite..." required>

            <label class="mt-3">Descripción del Trámite:</label>
            <textarea name="descripcion" class="form-control" rows="4" required></textarea>

            <label class="mt-3">Tipo de Documento:</label>
            <select name="tipo_documento" class="form-control">
                <option value="PDF">PDF</option>
                <option value="JPG">JPG</option>
                <option value="PNG">PNG</option>
                <option value="DOCX">DOCX</option>
                <option value="Otro">Otro</option>
            </select>


            <label class="mt-3">Documento Adjunto (PDF, JPG, PNG):</label>
            <input type="file" name="documento" class="form-control">

        </div>
    </div>

    <button class="btn btn-success">Enviar Solicitud</button>

</form>

<?= $this->endSection() ?>


