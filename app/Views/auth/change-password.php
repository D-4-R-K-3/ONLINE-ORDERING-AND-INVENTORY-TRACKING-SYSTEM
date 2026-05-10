<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2 class="mb-4">Change Password</h2>

            <div class="card">
                <div class="card-body">
                    <form action="/auth/change-password" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                            <?php if (session('errors') && isset(session('errors')['current_password'])): ?>
                                <small class="text-danger"><?= session('errors')['current_password'] ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <?php if (session('errors') && isset(session('errors')['new_password'])): ?>
                                <small class="text-danger"><?= session('errors')['new_password'] ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <?php if (session('errors') && isset(session('errors')['confirm_password'])): ?>
                                <small class="text-danger"><?= session('errors')['confirm_password'] ?></small>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Change Password</button>
                    </form>

                    <div class="mt-3">
                        <a href="/auth/profile" class="btn btn-outline-secondary w-100">Back to Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
