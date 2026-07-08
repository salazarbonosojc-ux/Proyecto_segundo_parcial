<?php

class PdfController {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Descargar Historial Clínico en PDF
     */
    public function descargarHistorial() {
        $id_historial = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id_historial <= 0) {
            die("Error: ID de historial inválido.");
        }

        try {
            // Obtener información del historial y paciente
            $query = "SELECT 
                        h.id, 
                        h.id_paciente, 
                        h.fecha_creacion,
                        p.cedula, 
                        p.nombre, 
                        p.apellido, 
                        p.fecha_nacimiento,
                        p.telefono,
                        p.email
                      FROM historiales_clinicos h
                      INNER JOIN pacientes p ON h.id_paciente = p.id
                      WHERE h.id = :id";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute([':id' => $id_historial]);
            $historial = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$historial) {
                die("Error: Historial no encontrado.");
            }

            // Obtener diagnósticos
            $queryDiag = "SELECT 
                            d.id,
                            d.fecha_diagnostico,
                            d.descripcion,
                            d.tratamiento,
                            d.dias_reposo,
                            CONCAT(m.nombre, ' ', m.apellido) AS medico
                          FROM diagnosticos d
                          INNER JOIN medicos m ON d.id_medico = m.id
                          WHERE d.id_historial = :id_historial
                          ORDER BY d.fecha_diagnostico DESC";
            
            $stmtDiag = $this->db->prepare($queryDiag);
            $stmtDiag->execute([':id_historial' => $id_historial]);
            $diagnosticos = $stmtDiag->fetchAll(PDO::FETCH_ASSOC);

            // Obtener últimas citas
            $queryCitas = "SELECT 
                            c.id,
                            c.fecha_hora,
                            c.motivo,
                            c.estado,
                            CONCAT(m.nombre, ' ', m.apellido) AS medico,
                            e.nombre AS especialidad
                          FROM citas_medicas c
                          INNER JOIN medicos m ON c.id_medico = m.id
                          INNER JOIN especialidades e ON m.id_especialidad = e.id
                          WHERE c.id_paciente = :id_paciente
                          ORDER BY c.fecha_hora DESC
                          LIMIT 5";
            
            $stmtCitas = $this->db->prepare($queryCitas);
            $stmtCitas->execute([':id_paciente' => $historial['id_paciente']]);
            $citas = $stmtCitas->fetchAll(PDO::FETCH_ASSOC);

            // Calcular edad
            $fecha_nac = new DateTime($historial['fecha_nacimiento']);
            $hoy = new DateTime();
            $edad = $hoy->diff($fecha_nac)->y;

            // Generar contenido HTML del PDF
            $html = $this->generarHTML($historial, $diagnosticos, $citas, $edad);

            // Descargar con PHPMailer o librería nativa
            $this->descargarPDF($html, $historial);

        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    /**
     * Enviar Historial por Correo
     */
    public function enviarCorreo() {
        $id_historial = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id_historial <= 0) {
            header('Location: index.php?url=historiales');
            exit();
        }

        try {
            // Obtener información del historial
            $query = "SELECT 
                        h.id, 
                        h.id_paciente, 
                        h.fecha_creacion,
                        p.cedula, 
                        p.nombre, 
                        p.apellido, 
                        p.fecha_nacimiento,
                        p.telefono,
                        p.email
                      FROM historiales_clinicos h
                      INNER JOIN pacientes p ON h.id_paciente = p.id
                      WHERE h.id = :id";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute([':id' => $id_historial]);
            $historial = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$historial || empty($historial['email'])) {
                $_SESSION['error_correo'] = "El paciente no tiene correo registrado en el sistema.";
                header('Location: index.php?url=historiales/ver&id=' . $id_historial);
                exit();
            }

            // Obtener diagnósticos
            $queryDiag = "SELECT 
                            d.id,
                            d.fecha_diagnostico,
                            d.descripcion,
                            d.tratamiento,
                            d.dias_reposo,
                            CONCAT(m.nombre, ' ', m.apellido) AS medico
                          FROM diagnosticos d
                          INNER JOIN medicos m ON d.id_medico = m.id
                          WHERE d.id_historial = :id_historial
                          ORDER BY d.fecha_diagnostico DESC";
            
            $stmtDiag = $this->db->prepare($queryDiag);
            $stmtDiag->execute([':id_historial' => $id_historial]);
            $diagnosticos = $stmtDiag->fetchAll(PDO::FETCH_ASSOC);

            // Preparar contenido del correo
            $asunto = "Hospital Core - Historial Clínico de " . htmlspecialchars($historial['nombre'] . ' ' . $historial['apellido']);
            $cuerpo = $this->generarCuerpoCorreo($historial, $diagnosticos);

            // Enviar correo (configuración básica)
            $to = $historial['email'];
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
            $headers .= "From: no-reply@hospitalcore.local" . "\r\n";

            if (mail($to, $asunto, $cuerpo, $headers)) {
                $_SESSION['mensaje_correo'] = "✅ Historial enviado exitosamente a: " . htmlspecialchars($historial['email']);
            } else {
                $_SESSION['error_correo'] = "Error al enviar el correo. Intenta nuevamente.";
            }

            header('Location: index.php?url=historiales/ver&id=' . $id_historial);
            exit();

        } catch (Exception $e) {
            $_SESSION['error_correo'] = "Error: " . $e->getMessage();
            header('Location: index.php?url=historiales/ver&id=' . $id_historial);
            exit();
        }
    }

    /**
     * Generar HTML para PDF
     */
    private function generarHTML($historial, $diagnosticos, $citas, $edad) {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Historial Clínico</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; color: #333; }
                .header { text-align: center; border-bottom: 2px solid #00ff96; padding-bottom: 20px; margin-bottom: 20px; }
                .header h1 { color: #00aa66; margin: 0; }
                .section { margin: 20px 0; }
                .section h3 { color: #00aa66; border-bottom: 1px solid #ddd; padding-bottom: 10px; }
                table { width: 100%; border-collapse: collapse; margin: 10px 0; }
                table th { background: #f0f0f0; border: 1px solid #ddd; padding: 8px; text-align: left; }
                table td { border: 1px solid #ddd; padding: 8px; }
                .info-label { font-weight: bold; width: 30%; }
                .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin: 10px 0; }
                .info-item { padding: 10px; background: #f9f9f9; border-left: 3px solid #00aa66; }
                .reposo { background: #fff3cd; padding: 10px; border-radius: 4px; margin: 10px 0; border-left: 4px solid #ffc107; }
                .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #999; border-top: 1px solid #ddd; padding-top: 10px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>🏥 Hospital Core</h1>
                <p>Historial Clínico del Paciente</p>
            </div>

            <!-- INFORMACIÓN DEL PACIENTE -->
            <div class="section">
                <h3>📋 Información del Paciente</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Nombre:</span> <?= htmlspecialchars($historial['nombre'] . ' ' . $historial['apellido']); ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Cédula:</span> <?= htmlspecialchars($historial['cedula']); ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Edad:</span> <?= htmlspecialchars($edad); ?> años
                    </div>
                    <div class="info-item">
                        <span class="info-label">Teléfono:</span> <?= htmlspecialchars($historial['telefono'] ?? 'No registrado'); ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Fecha Nacimiento:</span> <?= htmlspecialchars($historial['fecha_nacimiento']); ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Historial Abierto:</span> <?= htmlspecialchars($historial['fecha_creacion']); ?>
                    </div>
                </div>
            </div>

            <!-- DIAGNÓSTICOS Y RECETAS -->
            <div class="section">
                <h3>💊 Diagnósticos y Recetas</h3>
                <?php if (!empty($diagnosticos)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Médico</th>
                                <th>Diagnóstico</th>
                                <th>Tratamiento</th>
                                <th>Reposo (días)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($diagnosticos as $diag): ?>
                                <tr>
                                    <td><?= htmlspecialchars($diag['fecha_diagnostico']); ?></td>
                                    <td><?= htmlspecialchars($diag['medico']); ?></td>
                                    <td><?= htmlspecialchars($diag['descripcion']); ?></td>
                                    <td><?= htmlspecialchars($diag['tratamiento']); ?></td>
                                    <td><?= htmlspecialchars($diag['dias_reposo'] ?? '0'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- CERTIFICADOS DE REPOSO -->
                    <?php foreach ($diagnosticos as $diag): ?>
                        <?php if ($diag['dias_reposo'] > 0): ?>
                            <div class="reposo">
                                <strong>📜 CERTIFICADO MÉDICO DE REPOSO</strong><br>
                                Se otorga <strong><?= htmlspecialchars($diag['dias_reposo']); ?> día(s) de reposo</strong> 
                                desde el <?= htmlspecialchars($diag['fecha_diagnostico']); ?> por <?= htmlspecialchars($diag['descripcion']); ?>.<br>
                                <em>Expedido por: Dr(a). <?= htmlspecialchars($diag['medico']); ?></em>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay diagnósticos registrados.</p>
                <?php endif; ?>
            </div>

            <!-- ÚLTIMAS CITAS -->
            <div class="section">
                <h3>📅 Últimas Citas Médicas</h3>
                <?php if (!empty($citas)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Fecha y Hora</th>
                                <th>Médico</th>
                                <th>Especialidad</th>
                                <th>Motivo</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($citas as $cita): ?>
                                <tr>
                                    <td><?= htmlspecialchars($cita['fecha_hora']); ?></td>
                                    <td><?= htmlspecialchars($cita['medico']); ?></td>
                                    <td><?= htmlspecialchars($cita['especialidad']); ?></td>
                                    <td><?= htmlspecialchars($cita['motivo']); ?></td>
                                    <td><?= htmlspecialchars($cita['estado']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay citas registradas.</p>
                <?php endif; ?>
            </div>

            <div class="footer">
                <p>Hospital Core - Sistema de Gestión Hospitalaria</p>
                <p>Documento generado: <?= date('d/m/Y H:i:s'); ?></p>
            </div>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }

    /**
     * Generar cuerpo del correo HTML
     */
    private function generarCuerpoCorreo($historial, $diagnosticos) {
        $edad = (new DateTime())->diff(new DateTime($historial['fecha_nacimiento']))->y;

        $html = "
        <html>
        <body style='font-family: Arial, sans-serif; color: #333;'>
            <div style='background: #f9f9f9; padding: 20px; border-radius: 8px;'>
                <h2 style='color: #00aa66;'>🏥 Hospital Core - Historial Clínico</h2>
                
                <p>Estimado/a <strong>" . htmlspecialchars($historial['nombre']) . "</strong>,</p>
                
                <p>Adjunto encontrará su historial clínico completo con toda la información de sus diagnósticos, tratamientos y citas registradas en nuestro sistema.</p>
                
                <div style='background: white; padding: 15px; border-radius: 4px; margin: 20px 0;'>
                    <h3>📋 Resumen de Información</h3>
                    <p><strong>Cédula:</strong> " . htmlspecialchars($historial['cedula']) . "</p>
                    <p><strong>Edad:</strong> " . $edad . " años</p>
                    <p><strong>Teléfono:</strong> " . htmlspecialchars($historial['telefono'] ?? 'No registrado') . "</p>
                    <p><strong>Historial Abierto:</strong> " . htmlspecialchars($historial['fecha_creacion']) . "</p>
                </div>

                <div style='background: white; padding: 15px; border-radius: 4px; margin: 20px 0;'>
                    <h3>💊 Diagnósticos Activos</h3>";

                    if (!empty($diagnosticos)) {
                        $html .= "<ul>";
                        foreach ($diagnosticos as $diag) {
                            $html .= "<li><strong>" . htmlspecialchars($diag['descripcion']) . "</strong> - " . htmlspecialchars($diag['tratamiento']) . "</li>";
                            if ($diag['dias_reposo'] > 0) {
                                $html .= "<p style='background: #fff3cd; padding: 10px; border-radius: 4px;'><strong>Reposo Médico:</strong> " . htmlspecialchars($diag['dias_reposo']) . " día(s)</p>";
                            }
                        }
                        $html .= "</ul>";
                    } else {
                        $html .= "<p>No hay diagnósticos registrados actualmente.</p>";
                    }

                $html .= "
                </div>

                <div style='background: #e3f2fd; padding: 15px; border-radius: 4px; border-left: 4px solid #2196F3; margin: 20px 0;'>
                    <p>Si tiene preguntas sobre su historial o tratamientos, no dude en contactarse con nuestro centro.</p>
                    <p><strong>Teléfono:</strong> +593 (XXX) XXXX-XXXX</p>
                </div>

                <p style='color: #999; font-size: 12px;'>Correo generado automáticamente - No responda a este mensaje</p>
            </div>
        </body>
        </html>";

        return $html;
    }

    /**
     * Descargar PDF generado
     */
    private function descargarPDF($html, $historial) {
        // Configurar headers para descarga
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Historial_' . $historial['cedula'] . '.pdf"');
        
        // Usar HTML2PDF si está disponible o enviar como HTML
        // Para esta implementación simple, convertimos a PDF básico
        
        // Opción 1: Usar librería externa (TCPDF/DOMPDF) - si no está, mostrar como HTML
        echo $html; // Solución temporal
    }
}
