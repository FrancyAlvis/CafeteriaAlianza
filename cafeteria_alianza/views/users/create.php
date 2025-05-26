<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../layout/nav.php'; ?>

<h2>Crear usuario</h2>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?controller=user&action=store"> 
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="name" class="form-control"
               value="<?= $oldData['name'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control"
               value="<?= $oldData['email'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
               <!--value="<?= $oldData['password'] ?? '' ?>" required> -->
    </div>
    <div class="mb-3">
    <label class="form-label">Role</label>
    <select name="role" class="form-control" required>
        <option value="user" <?= (isset($oldData['role']) && $oldData['role'] === 'user') ? 'selected' : '' ?>>Usuario</option>
        <option value="admin" <?= (isset($oldData['role']) && $oldData['role'] === 'admin') ? 'selected' : '' ?>>Administrador</option>
    </select>
</div>

    <button class="btn btn-primary">Guardar</button>
</form>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
