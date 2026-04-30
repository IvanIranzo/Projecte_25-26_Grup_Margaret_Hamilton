<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta de Profesor - Sistema Académico</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; padding: 20px; }
        .card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 450px; }
        h2 { color: #2c3e50; text-align: center; margin-bottom: 20px; }
        label { display: block; margin-top: 10px; font-weight: bold; color: #34495e; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #dcdde1; border-radius: 5px; box-sizing: border-box; }
        .btn { background: #8e44ad; color: white; border: none; padding: 12px; width: 100%; border-radius: 5px; cursor: pointer; margin-top: 20px; font-size: 16px; }
        .btn:hover { background: #732d91; }
        .back { display: block; text-align: center; margin-top: 15px; color: #7f8c8d; text-decoration: none; font-size: 14px; }
        .back:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Registro de Profesor</h2>
        <form action="guardar_profesor.php" method="POST">
            <label>ID Persona (DNI/NIE):</label>
            <input type="number" name="id_persona" required>

            <label>Nombre:</label>
            <input type="text" name="nombre" required>

            <label>Primer Apellido:</label>
            <input type="text" name="apellido1" required>

            <label>Segundo Apellido:</label>
            <input type="text" name="apellido2">

            <label>Correo Electrónico:</label>
            <input type="email" name="correo" required>

            <label>Título Académico:</label>
            <input type="text" name="titulo_academico" placeholder="Ej: Doctor en Informática" required>

            <label>Estado de Cuenta:</label>
            <select name="estado_cuenta">
                <option value="Activo">Activo</option>
                <option value="Pendiente">Pendiente</option>
                <option value="Inactivo">Inactivo</option>
            </select>

            <button type="submit" class="btn">Guardar Profesor</button>
        </form>
        <a href="index.php" class="back">← Volver al panel</a>
    </div>
</body>
</html>