<!-- resources/views/incident/models/edit_model.blade.php -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="editForm" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title" id="editModalLabel">Modifier l'Incident</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="mb-3">
            <label for="incident_name" class="form-label">Nom de l'Incident</label>
            <input type="text" class="form-control" id="incident_name" name="incident_name" required>
          </div>
          <div class="mb-3">
            <label for="detail" class="form-label">Détails</label>
            <textarea class="form-control" id="detail" name="detail" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" class="form-control" id="adresse" name="adresse">
          </div>
         
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        </div>
      </div>
    </form>
  </div>
</div>
