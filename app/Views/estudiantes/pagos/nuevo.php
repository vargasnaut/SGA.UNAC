<?= $this->extend('layout/main') ?>
<?= $this->section('contenido') ?>

<div class="row justify-content-center">
    <div class="col-md-7">

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-receipt me-1"></i>
                    Registrar Pago de Trámite
                </h5>
            </div>

            <div class="card-body">

                <div class="alert alert-info">
                    <strong>Trámite Nº:</strong> <?= esc($tramite['id']) ?><br>
                    <strong>Estado actual:</strong>
                    <span class="badge bg-warning text-dark">
                        <?= ucfirst($tramite['estado']) ?>
                    </span>
                </div>

                <form action="<?= base_url('estudiantes/pagos/guardar') ?>" method="post">
                    <?= csrf_field() ?>

                    <input type="hidden" name="tramite_id" value="<?= esc($tramite['id']) ?>">

                    <!-- MONTO -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-money-bill-wave me-1"></i>
                            Monto a Pagar (S/)
                        </label>
                        <input type="number"
                               step="0.01"
                               min="1"
                               name="monto"
                               class="form-control form-control-lg"
                               placeholder="Ej: 45.00"
                               required>
                    </div>

                    <!-- MÉTODO DE PAGO -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-credit-card me-1"></i>
                            Método de Pago
                        </label>
                        <select name="metodo_pago"
                                class="form-select form-select-lg"
                                required>
                            <option value="">Seleccione un método</option>
                            <option value="qr">Pago QR (Recomendado)</option>
                            <option value="yape">Yape</option>
                            <option value="plin">Plin</option>
                            <option value="transferencia">Transferencia Bancaria</option>
                            <option value="efectivo">Efectivo</option>
                        </select>
                    </div>

                    <!-- MENSAJE -->
                    <div class="alert alert-light border small">
                        <i class="fas fa-info-circle text-primary me-1"></i>
                        El pago será registrado como <strong>En proceso</strong> hasta su validación.
                    </div>

                    <!-- BOTONES -->
                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('estudiantes/pagos/' . $tramite['id']) ?>"
                           class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>

                        <button type="submit" class="btn btn-success px-4">
                            <i class="fas fa-check-circle"></i> Confirmar Pago
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
