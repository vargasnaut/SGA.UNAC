<?= $this->extend('layout/main') ?>
<?= $this->section('contenido') ?>

<div class="container mt-4">

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white py-3 rounded-top-4">
            <h4 class="mb-0">
                <i class="fas fa-edit"></i> Editar Trámite
            </h4>
        </div>

        <div class="card-body p-4">

            <form action="<?= base_url('estudiantes/tramites/actualizar/' . $tramite['id']) ?>" 
                  method="POST" enctype="multipart/form-data">

                <!-- Grupo 1 -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tipo de Trámite</label>
                        <select name="tipo" class="form-select" required>
                            <option value="Constancia de Estudios" <?= $tramite['tipo'] == 'Constancia de Estudios' ? 'selected' : '' ?>>Constancia de Estudios</option>
                            <option value="Duplicado de Carnet" <?= $tramite['tipo'] == 'Duplicado de Carnet' ? 'selected' : '' ?>>Duplicado de Carnet</option>
                            <option value="Retiro de Curso" <?= $tramite['tipo'] == 'Retiro de Curso' ? 'selected' : '' ?>>Retiro de Curso</option>
                            <option value="Solicitud de Prórroga" <?= $tramite['tipo'] == 'Solicitud de Prórroga' ? 'selected' : '' ?>>Solicitud de Prórroga</option>
                            <option value="Otro" <?= $tramite['tipo'] == 'Otro' ? 'selected' : '' ?>>Otro</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tipo de Documento</label>
                        <select name="tipo_documento" class="form-select">
                            <option value="">Seleccione...</option>
                            <option value="pdf" <?= ($tramite['tipo_documento'] ?? '') == 'pdf' ? 'selected' : '' ?>>PDF</option>
                            <option value="imagen" <?= ($tramite['tipo_documento'] ?? '') == 'imagen' ? 'selected' : '' ?>>Imagen (JPG/PNG)</option>
                            <option value="otros" <?= ($tramite['tipo_documento'] ?? '') == 'otros' ? 'selected' : '' ?>>Otros</option>
                        </select>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Descripción</label>
                    <textarea name="descripcion" class="form-control shadow-sm" rows="3" required><?= esc($tramite['descripcion']) ?></textarea>
                </div>

                <!-- Motivo -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Motivo</label>
                    <textarea name="motivo" class="form-control shadow-sm" rows="2"><?= esc($tramite['motivo'] ?? '') ?></textarea>
                </div>

                <!-- Documento adjunto -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Documento Adjunto</label><br>

                    <?php if (!empty($tramite['documento'])): ?>
                        <a href="<?= base_url('estudiantes/tramites/ver-pdf/' . $tramite['id']) ?>" 
                           target="_blank" class="btn btn-outline-primary btn-sm mb-2">
                            <i class="fas fa-file"></i> Ver archivo actual
                        </a>
                        <br>
                    <?php endif; ?>

                    <input type="file" name="documento" class="form-control shadow-sm">
                    <small class="text-muted">Si subes un archivo nuevo, reemplazará al anterior.</small>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="<?= base_url('estudiantes/tramites') ?>" class="btn btn-secondary px-4">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save"></i> Actualizar Trámite
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
