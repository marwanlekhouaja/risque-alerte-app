<script>
    setInterval(() => {
        window.location.reload();
    }, 10000); // toutes les 10 secondes
</script>

@foreach ($incidents as $incident)
<div>
    {{ $incident->id }}
    {{ $incident->incident_name }}
    {{ $incident->detail }}
    {{ $incident->adresse }}
    {{ $incident->latitude }}
    {{ $incident->longitude }}
    {{ $incident->created_at }}
</div>
@endforeach