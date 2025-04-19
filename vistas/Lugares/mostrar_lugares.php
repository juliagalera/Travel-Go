<div class="sitios-container">
    <?php if (!empty($lugares)): ?>
        <?php foreach ($lugares as $lugar): ?>
            <div class="sitio">
                <h3><?= htmlspecialchars($lugar['nombre']); ?></h3>
                <p><?= htmlspecialchars($lugar['detalle']); ?></p>
                <img src="<?= htmlspecialchars($lugar['imagen']); ?>" alt="<?= htmlspecialchars($lugar['nombre']); ?>" />
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No se encontraron lugares para las categorías seleccionadas.</p>
    <?php endif; ?>
</div>