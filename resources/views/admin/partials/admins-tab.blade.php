<div class="row">
    <div class="col-md-7">
        <h2 class="h5 mb-3">Admins</h2>
        <table class="table table-sm table-striped align-middle">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Created</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($admins as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="col-md-5">
        <h2 class="h5 mb-3">Register New Admin</h2>
        <form id="new-admin-form">
            <div class="mb-3">
                <label for="new-admin-name" class="form-label">Name</label>
                <input type="text" class="form-control" id="new-admin-name" required>
            </div>
            <div class="mb-3">
                <label for="new-admin-email" class="form-label">Email</label>
                <input type="email" class="form-control" id="new-admin-email" required>
            </div>
            <div class="mb-3">
                <label for="new-admin-password" class="form-label">Password</label>
                <input type="password" class="form-control" id="new-admin-password" required minlength="8">
            </div>
            <div class="mb-3">
                <label for="new-admin-password-confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="new-admin-password-confirmation" required minlength="8">
            </div>
            <button type="submit" class="btn btn-primary">Register Admin</button>
        </form>
    </div>
</div>
