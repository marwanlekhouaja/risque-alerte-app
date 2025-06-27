<div class="">
    <label for="prefecture" class="form-label">Préfecture / Province</label>
    <select class="form-control" id="prefecture" name="prefecture">
        <option value="">-- Sélectionner une ville ou province --</option>

        {{-- Grandes villes --}}
        {{-- <option value="Casablanca" {{ request('prefecture') == 'Casablanca' ? 'selected' : '' }}>Casablanca</option> --}}
        <option value="Rabat" {{ request('prefecture') == 'Rabat' ? 'selected' : '' }}>Rabat</option>
  
        <option value="El Jadida" {{ request('prefecture') == 'El Jadida' ? 'selected' : '' }}>sale El Jadida</option>
    
        {{-- Provinces supplémentaires --}}
        <option value="SALE" {{ request('prefecture') == 'SALE' ? 'selected' : '' }}>Salé</option>
        <option value="Skhirat-Témara" {{ request('prefecture') == 'Skhirat-Témara' ? 'selected' : '' }}>Skhirat-Témara</option>
    </select>
</div>
