<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .auth-wrap {
        max-width: 980px;
        margin: 0 auto;
        padding: 0.5rem 0;
    }

    .auth-card {
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid var(--border);
        background: rgba(255, 255, 255, 0.5);
        box-shadow: var(--shadow);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
    }

    html[data-theme="dark"] .auth-card {
        background: rgba(20, 26, 36, 0.58);
    }

    .auth-panel {
        background: linear-gradient(145deg, rgba(173, 109, 61, 0.82), rgba(106, 159, 143, 0.82));
        color: #fff;
        min-height: 100%;
        padding: 2.2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .auth-panel h2 {
        font-size: clamp(1.6rem, 3vw, 2.2rem);
    }

    .auth-panel p {
        margin: 0;
        opacity: 0.92;
    }

    .auth-form-wrap {
        padding: clamp(1.25rem, 3vw, 2.2rem);
    }

    .auth-form-title {
        margin-bottom: 0.2rem;
    }

    .auth-form-subtitle {
        color: var(--muted);
        margin-bottom: 1.2rem;
    }

    .auth-link {
        color: var(--accent);
        font-weight: 600;
    }

    @media (max-width: 767.98px) {
        .auth-panel {
            padding: 1.4rem;
            min-height: auto;
        }
    }
</style>

<div class="auth-wrap">
    <div class="auth-card">
        <div class="row g-0">
            <div class="col-md-5">
                <div class="auth-panel">
                    <h2>Welcome back</h2>
                    <p>Sign in to continue managing orders, tracking inventory, and providing a clean shopping experience.</p>
                </div>
            </div>
            <div class="col-md-7">
                <div class="auth-form-wrap">
                    <h3 class="auth-form-title">Login</h3>
                    <p class="auth-form-subtitle">Use your username or email account.</p>

                    <form action="/auth/login" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username or Email</label>
                            <input type="text" class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= old('username') ?>" required>
                            <?php if (session('errors.username')): ?>
                                <div class="invalid-feedback"><?= session('errors.username') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" id="password" name="password" required>
                            <?php if (session('errors.password')): ?>
                                <div class="invalid-feedback"><?= session('errors.password') ?></div>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>

                    <p class="mt-3 mb-0 text-center">Need an account? <a class="auth-link" href="/auth/register">Create one</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
