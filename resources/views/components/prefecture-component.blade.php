<div>
    <div class="mb-3">
        <label for="prefecture" class="form-label">Préfecture / Province</label>
        <select class="form-control" id="prefecture" name="prefecture" required>
            <option value="">-- Sélectionner une ville ou province --</option>
            
            {{-- Grandes villes --}}
            <option value="Casablanca" {{ old('prefecture') == 'Casablanca' ? 'selected' : '' }}>Casablanca</option>
            <option value="Rabat" {{ old('prefecture') == 'Rabat' ? 'selected' : '' }}>Rabat</option>
            <option value="Fès" {{ old('prefecture') == 'Fès' ? 'selected' : '' }}>Fès</option>
            <option value="Marrakech" {{ old('prefecture') == 'Marrakech' ? 'selected' : '' }}>Marrakech</option>
            <option value="Tanger" {{ old('prefecture') == 'Tanger' ? 'selected' : '' }}>Tanger</option>
            <option value="Agadir" {{ old('prefecture') == 'Agadir' ? 'selected' : '' }}>Agadir</option>
            <option value="Meknès" {{ old('prefecture') == 'Meknès' ? 'selected' : '' }}>Meknès</option>
            <option value="Oujda" {{ old('prefecture') == 'Oujda' ? 'selected' : '' }}>Oujda</option>
            <option value="Tétouan" {{ old('prefecture') == 'Tétouan' ? 'selected' : '' }}>Tétouan</option>
            <option value="Safi" {{ old('prefecture') == 'Safi' ? 'selected' : '' }}>Safi</option>
            <option value="Mohammédia" {{ old('prefecture') == 'Mohammédia' ? 'selected' : '' }}>Mohammédia</option>
            <option value="Khouribga" {{ old('prefecture') == 'Khouribga' ? 'selected' : '' }}>Khouribga</option>
            <option value="El Jadida" {{ old('prefecture') == 'El Jadida' ? 'selected' : '' }}>El Jadida</option>
            <option value="Béni Mellal" {{ old('prefecture') == 'Béni Mellal' ? 'selected' : '' }}>Béni Mellal</option>
            <option value="Nador" {{ old('prefecture') == 'Nador' ? 'selected' : '' }}>Nador</option>
            <option value="Taza" {{ old('prefecture') == 'Taza' ? 'selected' : '' }}>Taza</option>
            <option value="Kénitra" {{ old('prefecture') == 'Kénitra' ? 'selected' : '' }}>Kénitra</option>
            <option value="Settat" {{ old('prefecture') == 'Settat' ? 'selected' : '' }}>Settat</option>
            <option value="Larache" {{ old('prefecture') == 'Larache' ? 'selected' : '' }}>Larache</option>
            <option value="Al Hoceima" {{ old('prefecture') == 'Al Hoceima' ? 'selected' : '' }}>Al Hoceima</option>
            <option value="Ouarzazate" {{ old('prefecture') == 'Ouarzazate' ? 'selected' : '' }}>Ouarzazate</option>
    
            {{-- Provinces supplémentaires --}}
            <option value="Salé" {{ old('prefecture') == 'Salé' ? 'selected' : '' }}>Salé</option>
            <option value="Skhirat-Témara" {{ old('prefecture') == 'Skhirat-Témara' ? 'selected' : '' }}>Skhirat-Témara</option>
            <option value="Bouznika" {{ old('prefecture') == 'Bouznika' ? 'selected' : '' }}>Bouznika</option>
            <option value="Berrechid" {{ old('prefecture') == 'Berrechid' ? 'selected' : '' }}>Berrechid</option>
            <option value="Benslimane" {{ old('prefecture') == 'Benslimane' ? 'selected' : '' }}>Benslimane</option>
            <option value="Azemmour" {{ old('prefecture') == 'Azemmour' ? 'selected' : '' }}>Azemmour</option>
            <option value="Sidi Bennour" {{ old('prefecture') == 'Sidi Bennour' ? 'selected' : '' }}>Sidi Bennour</option>
            <option value="Youssoufia" {{ old('prefecture') == 'Youssoufia' ? 'selected' : '' }}>Youssoufia</option>
            <option value="Sidi Slimane" {{ old('prefecture') == 'Sidi Slimane' ? 'selected' : '' }}>Sidi Slimane</option>
            <option value="Sidi Kacem" {{ old('prefecture') == 'Sidi Kacem' ? 'selected' : '' }}>Sidi Kacem</option>
            <option value="Ouezzane" {{ old('prefecture') == 'Ouezzane' ? 'selected' : '' }}>Ouezzane</option>
            <option value="Taourirt" {{ old('prefecture') == 'Taourirt' ? 'selected' : '' }}>Taourirt</option>
            <option value="Dakhla" {{ old('prefecture') == 'Dakhla' ? 'selected' : '' }}>Dakhla</option>
            <option value="Laâyoune" {{ old('prefecture') == 'Laâyoune' ? 'selected' : '' }}>Laâyoune</option>
            <option value="Tan-Tan" {{ old('prefecture') == 'Tan-Tan' ? 'selected' : '' }}>Tan-Tan</option>
            <option value="Tiznit" {{ old('prefecture') == 'Tiznit' ? 'selected' : '' }}>Tiznit</option>
            <option value="Guelmim" {{ old('prefecture') == 'Guelmim' ? 'selected' : '' }}>Guelmim</option>
            <option value="Errachidia" {{ old('prefecture') == 'Errachidia' ? 'selected' : '' }}>Errachidia</option>
        </select>
    </div>
    
</div>