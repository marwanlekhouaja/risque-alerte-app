<div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAdminModalLabel">Edit Admin Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="model-body p-4">
                <form action="{{ route('admin.updateProfile') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">nom</label>
                        <input type="text" id="name" name="nom" class="form-control"
                            value="{{ old('nom', $admin->nom) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="name">prenom</label>
                        <input type="text" id="name" name="prenom" class="form-control"
                            value="{{ old('prenom', $admin->prenom) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control"
                            value="{{ old('email', $admin->email) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="password">New Password (Leave blank to keep current password)</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>
