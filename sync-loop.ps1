while ($true) {
    Write-Host "[$(Get-Date -Format 'HH:mm:ss')] Lancement de la synchronisation..."

    & "C:\xampp\php\php.exe" artisan sync:validated-incidents

    Write-Host "[$(Get-Date -Format 'HH:mm:ss')] Attente de 4 secondes..."
    Start-Sleep -Seconds 4
}
