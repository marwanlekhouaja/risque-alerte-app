    <div class="modal fade" id="incidentDetailModal-{{ $incident->id }}" tabindex="-1"
        aria-labelledby="incidentDetailModalLabel-{{ $incident->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="incidentDetailModalLabel-{{ $incident->id }}">Détails de l'Incident : <span class="text-secondary">{{$incident->sheet_id}}</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    @if ($incident->photo)
                        <img src="{{ asset('storage/' . $incident->photo) }}" style="height:200px" class="img-fluid shadow-lg w-100 mt-3"
                            alt="Photo Incident">
                    @endif
                    <p><strong>Nom de l'incident :</strong> {{ $incident->incident_name }}</p>
                    <p><strong>Catégorie :</strong> {{ $incident->category->nomCategorie ?? 'Non spécifiée' }}</p>
                    <p><strong>Détails :</strong> {{ $incident->detail??"non details existe" }}</p>
                    <p><strong>Adresse :</strong> {{ $incident->adresse }}</p>
                    <p><strong>Prefecture :</strong> {{ $incident->prefecture }}</p>
                    <p><strong>Longitude :</strong> {{ $incident->longitude }}</p>
                    <p><strong>Latitude :</strong> {{ $incident->latitude }}</p>
                    <p><strong>Date de declaration :</strong> {{ $incident->date }}</p>
                    <p><strong>declaré par : </strong>{{$incident->user->prenom}} {{$incident->user->nom}}</p>
                    <p><strong>photo : </strong>aucun photo</p>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

