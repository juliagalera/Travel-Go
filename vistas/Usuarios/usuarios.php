<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de usuarios</title>
</head>
<body>
    <h1>Usuarios registrados</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
        </tr>
        <?php foreach ($usuarios as $us){?>
            <tr>
                <td><?php echo $us['id']?></td>
                <td><?php echo $us['nombre']?></td>
                <td><?php echo $us['email']?></td>
            </tr>
       <?php }?>
    </table>
</body>
</html>