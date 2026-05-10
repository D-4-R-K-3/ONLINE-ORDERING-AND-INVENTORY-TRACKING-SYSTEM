<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="mb-4">My Profile</h2>

            <div class="card mb-4">
                <div class="card-header">
                    <h5>Profile Information</h5>
                </div>
                <div class="card-body">
                    <form action="/auth/update-profile" method="POST">
                        <?= csrf_field() ?>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= esc($user['first_name']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= esc($user['last_name']) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email (Read Only)</label>
                            <input type="email" class="form-control" id="email" value="<?= esc($user['email']) ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= esc($user['phone'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3"><?= esc($user['address'] ?? '') ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Security</h5>
                </div>
                <div class="card-body">
                    <a href="/auth/change-password" class="btn btn-warning">Change Password</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
