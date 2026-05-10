<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .register-wrap {
        max-width: 1040px;
        margin: 0 auto;
        padding: 0.5rem 0;
    }

    .register-card {
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid var(--border);
        background: rgba(255, 255, 255, 0.52);
        box-shadow: var(--shadow);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
    }

    html[data-theme="dark"] .register-card {
        background: rgba(20, 26, 36, 0.58);
    }

    .register-aside {
        min-height: 100%;
        background: linear-gradient(145deg, rgba(106, 159, 143, 0.82), rgba(173, 109, 61, 0.78));
        color: #fff;
        padding: 2.2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .register-aside h2 {
        font-size: clamp(1.6rem, 3vw, 2.3rem);
    }

    .register-aside p {
        margin: 0.65rem 0 0;
        opacity: 0.92;
    }

    .register-form {
        padding: clamp(1.25rem, 3vw, 2.2rem);
    }

    .register-form h3 {
        margin-bottom: 0.2rem;
    }

    .register-note {
        color: var(--muted);
        margin-bottom: 1.2rem;
    }

    .auth-link {
        color: var(--accent);
        font-weight: 600;
    }

    @media (max-width: 767.98px) {
        .register-aside {
            min-height: auto;
            padding: 1.4rem;
        }
    }
</style>

<div class="register-wrap">
    <div class="register-card">
        <div class="row g-0">
            <div class="col-md-5">
                <div class="register-aside">
                    <h2>Create your account</h2>
                    <p>Get a smoother way to browse products, manage your cart, and track orders with a modern user experience.</p>
                </div>
            </div>

            <div class="col-md-7">
                <div class="register-form">
                    <h3>Register</h3>
                    <p class="register-note">Complete the form to start shopping.</p>

                    <form action="/auth/register" method="POST">
                        <?= csrf_field() ?>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control <?= session('errors.first_name') ? 'is-invalid' : '' ?>" id="first_name" name="first_name" value="<?= old('first_name') ?>" required>
                                <?php if (session('errors.first_name')): ?>
                                    <div class="invalid-feedback"><?= session('errors.first_name') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="col-sm-6">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control <?= session('errors.last_name') ? 'is-invalid' : '' ?>" id="last_name" name="last_name" value="<?= old('last_name') ?>" required>
                                <?php if (session('errors.last_name')): ?>
                                    <div class="invalid-feedback"><?= session('errors.last_name') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= old('username') ?>" required>
                            <?php if (session('errors.username')): ?>
                                <div class="invalid-feedback"><?= session('errors.username') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email') ?>" required>
                            <?php if (session('errors.email')): ?>
                                <div class="invalid-feedback"><?= session('errors.email') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" id="password" name="password" required>
                                <?php if (session('errors.password')): ?>
                                    <div class="invalid-feedback"><?= session('errors.password') ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-sm-6">
                                <label for="password_confirm" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control <?= session('errors.password_confirm') ? 'is-invalid' : '' ?>" id="password_confirm" name="password_confirm" required>
                                <?php if (session('errors.password_confirm')): ?>
                                    <div class="invalid-feedback"><?= session('errors.password_confirm') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Create Account</button>
                        </div>
                    </form>

                    <p class="mt-3 mb-0 text-center">Already registered? <a class="auth-link" href="/auth/login">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
