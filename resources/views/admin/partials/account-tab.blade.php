<div class="row">
    <div class="col-md-5">
        <h2 class="h5 mb-3">Change Password</h2>
        <form id="change-password-form">
            <div class="mb-3">
                <label for="current-password" class="form-label">Current Password</label>
                <input type="password" class="form-control" id="current-password" required>
            </div>
            <div class="mb-3">
                <label for="new-password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="new-password" required minlength="8">
            </div>
            <div class="mb-3">
                <label for="new-password-confirmation" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="new-password-confirmation" required minlength="8">
            </div>
            <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
    </div>
</div>
