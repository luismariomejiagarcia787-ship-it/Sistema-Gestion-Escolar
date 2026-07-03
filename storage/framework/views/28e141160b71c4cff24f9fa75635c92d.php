<?php $__env->startSection('title', 'Iniciar Sesión'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-card">
    <div class="auth-logo"><i class="bi bi-mortarboard-fill"></i></div>
    <h4 class="text-center fw-bold mb-1" style="color: var(--primary)">Sistema Gestión Escolar</h4>
    <p class="text-center text-muted mb-4" style="font-size:.85rem">Ingrese sus credenciales para continuar</p>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle-fill me-1"></i>
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <form action="<?php echo e(route('login.post')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label class="form-label fw-semibold">Correo Electrónico</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    value="<?php echo e(old('email')); ?>" placeholder="correo@ejemplo.com" required autofocus>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Contraseña</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
        </div>
        <div class="mb-4 d-flex align-items-center justify-content-between">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Recordarme</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
        </button>
    </form>

    <hr class="my-3">
    <p class="text-center text-muted small mb-0">
        ¿No tiene cuenta?
        <a href="<?php echo e(route('register')); ?>" class="text-decoration-none fw-semibold">Registrarse</a>
    </p>

    <div class="mt-3 p-2 rounded" style="background:#f8f9fa; font-size:.75rem">
        <strong>Demo:</strong><br>
        Admin: admin@colegio.com / 12345678<br>
        Profesor: profesor@colegio.com / 12345678<br>
        Estudiante: estudiante@colegio.com / 12345678
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC Lenovo\Downloads\SistemaGestionEscolar (1)\SistemaGestionEscolar\resources\views/auth/login.blade.php ENDPATH**/ ?>