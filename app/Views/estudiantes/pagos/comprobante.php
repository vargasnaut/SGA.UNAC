<?= $this->extend('layout/main') ?>
<?= $this->section('contenido') ?>

<style>
/* ------------------------------------------- */
/* Estilos ELEGANTES y Profesionales (UNAC Style) */
/* ------------------------------------------- */
:root {
    --unac-blue: #004d99;      /* Azul oscuro institucional */
    --unac-accent: #33aaff;    /* Azul claro de acento */
    --color-text: #333;
    --color-light: #f4f6f9;    /* Fondo muy claro */
    --color-border: #e9ecef;
}

/* 🔹 SOLO SE IMPRIME EL RECIBO */
@media print {
    body * {
        visibility: hidden;
    }
    #recibo-unac, #recibo-unac * {
        visibility: visible;
    }
    #recibo-unac {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none; /* Eliminar sombra en impresión */
        border: none !important;
    }
    .no-print {
        display: none !important;
    }
}

/* 🔹 ESTILO DEL RECIBO CONTENEDOR */
#recibo-unac {
    max-width: 700px;
    margin: 30px auto;
    padding: 30px;
    border: 1px solid var(--color-border);
    border-radius: 10px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08); /* Sombra elegante */
    background-color: #fff;
    font-family: 'Arial', sans-serif;
    color: var(--color-text);
}

/* Encabezado */
.header-unac {
    padding-bottom: 15px;
    margin-bottom: 25px;
    border-bottom: 3px solid var(--unac-blue); /* Línea gruesa institucional */
    text-align: center;
}
.header-unac h4 {
    color: var(--unac-blue);
    margin: 0;
    font-weight: 800;
    font-size: 20px;
}
.header-unac .subtitle {
    font-size: 14px;
    color: #6c757d;
    font-weight: 600;
    margin-top: 5px;
}
.header-unac .doc-type {
    font-size: 16px;
    color: var(--unac-accent);
    margin-top: 5px;
    font-weight: 700;
}

/* Detalles (Estudiante y Trámite) */
.details-section {
    margin-bottom: 20px;
    padding: 10px 0;
    line-height: 1.8;
}
.details-section strong {
    color: var(--unac-blue);
    font-weight: 700;
    min-width: 150px; /* Para alinear etiquetas */
    display: inline-block;
}
.details-row {
    display: flex;
    justify-content: space-between;
    padding: 5px 0;
    border-bottom: 1px dashed var(--color-border);
}
.details-row:last-child {
    border-bottom: none;
}

/* Tabla de Pago */
.tabla-pago {
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px;
}
.tabla-pago th, .tabla-pago td {
    padding: 12px;
    text-align: left;
    border: none;
}
.tabla-pago th {
    background-color: var(--unac-blue);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
}
.tabla-pago tr:nth-child(even) {
    background-color: var(--color-light); /* Zebra striping suave */
}
.tabla-pago .monto-cell {
    font-size: 16px;
    font-weight: 700;
    color: var(--unac-blue);
    text-align: right;
    border-left: 1px solid var(--color-border); /* Separador visual para el monto */
}
.tabla-pago .monto-label {
    font-weight: 700;
    text-align: right;
}

/* Pie de Página */
.footer-unac {
    text-align: center;
    margin-top: 40px;
    padding-top: 15px;
    border-top: 1px solid var(--color-border);
    color: #6c757d;
    font-size: 11px;
}
.status-badge {
    padding: 4px 8px;
    border-radius: 5px;
    font-weight: bold;
    font-size: 12px;
    display: inline-block;
}

</style>

<div class="no-print mb-3 text-center">
    <button onclick="window.print()" class="btn btn-lg" style="background-color: var(--unac-accent); color: white; border: none;">
        <i class="fas fa-file-pdf"></i> Generar / Imprimir Recibo
    </button>
</div>

<div id="recibo-unac">
    <div class="header-unac">
        <h4>UNIVERSIDAD NACIONAL DEL CALLAO</h4>
        <p class="subtitle">SISTEMA DE GESTIÓN ACADÉMICA (SGA)</p>
        <p class="doc-type">COMPROBANTE DE PAGO N° <?= $pago['id'] ?></p>
    </div>

    <div class="details-section">
        <h5 style="color: var(--unac-blue); font-size: 14px; margin-bottom: 10px; border-bottom: 1px solid var(--color-border);">DATOS DEL SOLICITANTE</h5>
        <div class="details-row">
            <div><strong>Estudiante:</strong> <?= esc($estudiante['nombres'].' '.$estudiante['apellidos']) ?></div>
            <div><strong>Código:</strong> <?= esc($estudiante['codigo_estudiante']) ?></div>
        </div>
    </div>

    <div class="details-section">
        <h5 style="color: var(--unac-blue); font-size: 14px; margin-bottom: 10px; border-bottom: 1px solid var(--color-border);">DETALLES DE LA TRANSACCIÓN</h5>
        
        <div class="details-row">
            <div><strong>Trámite:</strong> <?= esc($tramite['tipo']) ?></div>
            <div>
                <strong>Fecha de Pago:</strong> <?= date('d/m/Y', strtotime($pago['fecha_pago'])) ?>
            </div>
        </div>
        
        <div class="details-row">
            <div><strong>Método:</strong> <?= esc($pago['metodo_pago']) ?></div>
            <div>
                <strong>Estado del Trámite:</strong> 
                <?php 
                    $estado = esc($tramite['estado']);
                    $color = match ($estado) {
                        'aprobado' => '#28a745', 
                        'pagado', 'en proceso' => '#ffc107', 
                        'pendiente' => '#dc3545', 
                        default => '#6c757d',
                    };
                ?>
                <span class="status-badge" style="background-color: <?= $color ?>; color: white;">
                    <?= esc(ucfirst($estado)) ?>
                </span>
            </div>
        </div>
    </div>

    <table class="tabla-pago">
        <thead>
            <tr>
                <th colspan="3">Descripción del Pago</th>
                <th style="text-align: right;">Total S/</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3">Pago por concepto de <?= esc($tramite['tipo']) ?></td>
                <td class="monto-cell">S/ <?= number_format($pago['monto'], 2) ?></td>
            </tr>
            </tbody>
        <tfoot>
            <tr style="border-top: 2px solid var(--unac-blue);">
                <td colspan="3" class="monto-label">MONTO TOTAL RECIBIDO</td>
                <td class="monto-cell">S/ <?= number_format($pago['monto'], 2) ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer-unac">
        <p>Documento generado automáticamente por el Sistema de Gestión Académica (SGA) de la UNAC.</p>
        <p>Verifique la autenticidad con el código de pago N° <?= $pago['id'] ?> en la plataforma institucional. Conserve este comprobante.</p>
    </div>
</div>

<?= $this->endSection() ?>