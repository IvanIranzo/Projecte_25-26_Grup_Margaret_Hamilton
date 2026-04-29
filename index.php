<?php require 'db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Gestión - Sistema Académico</title>
    <style>
        body { font-family: sans-serif; padding: 30px; background: #f0f2f5; }
        h1 { color: #2c3e50; }

        /* Tabs */
        .tabs { display: flex; gap: 5px; margin-bottom: 0; }
        .tab-btn {
            padding: 10px 24px; border: none; border-radius: 8px 8px 0 0;
            cursor: pointer; font-size: 15px; font-weight: bold;
            background: #dce1e7; color: #555; transition: background 0.2s;
        }
        .tab-btn.active-alumno   { background: #3498db; color: white; }
        .tab-btn.active-profesor { background: #8e44ad; color: white; }
        .tab-btn.active-admin    { background: #e67e22; color: white; }
        .tab-btn:hover           { filter: brightness(1.08); }

        /* Panels */
        .tab-panel { display: none; background: white; border-radius: 0 8px 8px 8px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .tab-panel.active { display: block; }

        /* Table */
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 13px 15px; border-bottom: 1px solid #eee; text-align: left; }
        th { color: white; }
        .th-alumno   { background: #3498db; }
        .th-profesor { background: #8e44ad; }
        .th-admin    { background: #e67e22; }
        tr:hover { background: #f9f9f9; }

        .status-badge { padding: 4px 10px; border-radius: 15px; font-size: 12px; color: white; }
        .badge-activo   { background: #2ecc71; }
        .badge-pendiente { background: #f39c12; }
        .badge-inactivo  { background: #e74c3c; }

        /* Add buttons */
        .actions { margin-bottom: 15px; display: flex; gap: 10px; flex-wrap: wrap; }
        .btn-add {
            color: white; padding: 9px 18px; text-decoration: none;
            border-radius: 5px; display: inline-block; font-weight: bold;
        }
        .btn-alumno   { background: #3498db; }
        .btn-alumno:hover { background: #2980b9; }
        .btn-profesor { background: #8e44ad; }
        .btn-profesor:hover { background: #732d91; }
        .btn-admin    { background: #e67e22; }
        .btn-admin:hover { background: #ca6f1e; }

        .msg-ok { color: #27ae60; font-weight: bold; margin-bottom: 15px; }
    </style>
</head>
<body>
    <h1>Panel de Gestión Académica</h1>

    <?php
    // Success message with the type of record saved
    if (isset($_GET['status']) && $_GET['status'] === 'success') {
        $tipo_label = match($_GET['tipo'] ?? '') {
            'profesor'      => 'Profesor',
            'administrador' => 'Administrador',
            default         => 'Alumno',
        };
        echo "<p class='msg-ok'>✔ $tipo_label registrado correctamente</p>";
    }

    // Which tab is active (default: alumno)
    $tab = $_GET['tab'] ?? ($_GET['tipo'] ?? 'alumno');
    ?>

    <div class="tabs">
        <button class="tab-btn <?= $tab === 'alumno'        ? 'active-alumno'   : '' ?>" onclick="switchTab('alumno')">�‍‍🎓 Alumnos</button>
        <button class="tab-btn <?= $tab === 'profesor'      ? 'active-profesor' : '' ?>" onclick="switchTab('profesor')">👨‍🏫 Profesores</button>
        <button class="tab-btn <?= $tab === 'administrador' ? 'active-admin'    : '' ?>" onclick="switchTab('administrador')">🛠️ Administradores</button>
    </div>

    <!-- ── ALUMNOS ── -->
    <div id="panel-alumno" class="tab-panel <?= $tab === 'alumno' ? 'active' : '' ?>">
        <div class="actions">
            <a href="alta_alumno.php" class="btn-add btn-alumno">+ Registrar Alumno</a>
        </div>
        <table>
            <thead>
                <tr class="th-alumno">
                    <th>ID</th><th>Nombre Completo</th><th>Correo</th><th>Fecha Inscripción</th><th>Estado</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT p.ID_persona, p.Nombre, p.Apellido1, p.Apellido2, p.correo, p.estado_cuenta, a.fecha_inscripcion
                    FROM Persona p
                    INNER JOIN Alumno a ON p.ID_persona = a.ID_alumno";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $badge = strtolower($row['estado_cuenta']);
                    echo "<tr>
                            <td>{$row['ID_persona']}</td>
                            <td>{$row['Nombre']} {$row['Apellido1']} {$row['Apellido2']}</td>
                            <td>{$row['correo']}</td>
                            <td>{$row['fecha_inscripcion']}</td>
                            <td><span class='status-badge badge-{$badge}'>{$row['estado_cuenta']}</span></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center;color:#999;'>No hay alumnos registrados</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- ── PROFESORES ── -->
    <div id="panel-profesor" class="tab-panel <?= $tab === 'profesor' ? 'active' : '' ?>">
        <div class="actions">
            <a href="alta_profesor.php" class="btn-add btn-profesor">+ Registrar Profesor</a>
        </div>
        <table>
            <thead>
                <tr class="th-profesor">
                    <th>ID</th><th>Nombre Completo</th><th>Correo</th><th>Título Académico</th><th>Estado</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT p.ID_persona, p.Nombre, p.Apellido1, p.Apellido2, p.correo, p.estado_cuenta, pr.titulo_academico
                    FROM Persona p
                    INNER JOIN Profesor pr ON p.ID_persona = pr.ID_profesor";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $badge = strtolower($row['estado_cuenta']);
                    echo "<tr>
                            <td>{$row['ID_persona']}</td>
                            <td>{$row['Nombre']} {$row['Apellido1']} {$row['Apellido2']}</td>
                            <td>{$row['correo']}</td>
                            <td>{$row['titulo_academico']}</td>
                            <td><span class='status-badge badge-{$badge}'>{$row['estado_cuenta']}</span></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center;color:#999;'>No hay profesores registrados</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- ── ADMINISTRADORES ── -->
    <div id="panel-administrador" class="tab-panel <?= $tab === 'administrador' ? 'active' : '' ?>">
        <div class="actions">
            <a href="alta_administrador.php" class="btn-add btn-admin">+ Registrar Administrador</a>
        </div>
        <table>
            <thead>
                <tr class="th-admin">
                    <th>ID</th><th>Nombre Completo</th><th>Correo</th><th>Permisos Especiales</th><th>Estado</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT p.ID_persona, p.Nombre, p.Apellido1, p.Apellido2, p.correo, p.estado_cuenta, ad.Permisos_especiales
                    FROM Persona p
                    INNER JOIN Administrador ad ON p.ID_persona = ad.ID_administrador";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $badge = strtolower($row['estado_cuenta']);
                    echo "<tr>
                            <td>{$row['ID_persona']}</td>
                            <td>{$row['Nombre']} {$row['Apellido1']} {$row['Apellido2']}</td>
                            <td>{$row['correo']}</td>
                            <td>{$row['Permisos_especiales']}</td>
                            <td><span class='status-badge badge-{$badge}'>{$row['estado_cuenta']}</span></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center;color:#999;'>No hay administradores registrados</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <script>
    function switchTab(name) {
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(b => b.className = 'tab-btn');
        document.getElementById('panel-' + name).classList.add('active');
        const colorMap = { alumno: 'active-alumno', profesor: 'active-profesor', administrador: 'active-admin' };
        document.querySelectorAll('.tab-btn')[['alumno','profesor','administrador'].indexOf(name)].classList.add(colorMap[name]);
    }
    </script>
</body>
</html>