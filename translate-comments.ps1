# PowerShell Script to Translate Spanish Comments to English
# Company: CETAM
# Project: ST

Write-Host "🌐 Traduciendo comentarios de español a inglés..." -ForegroundColor Cyan
Write-Host ""

# Translation dictionary for common Spanish comments to English
$translations = @{
    # Conditionals
    '// Si ' = '// If '
    '// Si es' = '// If it is'
    '// Si se' = '// If '
    
    # Verbs
    '// Verificar' = '// Verify'
    '// Validar' = '// Validate'
    '// Crear' = '// Create'
    '// Actualizar' = '// Update'
    '// Eliminar' = '// Delete'
    '// Obtener' = '// Get'
    '// Buscar' = '// Search'
    '// Filtrar' = '// Filter'
    '// Cargar' = '// Load'
    '// Guardar' = '// Save'
    '// Enviar' = '// Send'
   

 '// Recibir' = '// Receive'
    
    # Common phrases
    '// En ' = '// In '
    '// Para ' = '// For '
    '// Cuando' = '// When'
    '// Esto ' = '// This '
    '// Este ' = '// This '
    '// Esta ' = '// This '
    '// Aquí' = '// Here'
    
    # Specific patterns
    '// Verificar que el trámite pueda ser cancelado' = '// Verify that the request can be cancelled'
    '// Actualizar el estado del trámite' = '// Update the request status'  
    '// Verificar si el modo mantenimiento está activo' = '// Check if maintenance mode is active'
    '// Obtener trámites paginados' = '// Get paginated requests'
    '// Obtener el worker asociado al usuario' = '// Get the worker associated with the user'
    '// Verificar que el proceso existe y está activo' = '// Verify that process exists and is active'
    '// Verificar que haya al menos un paso' = '// Verify that there is at least one step'
    '// Verificar paso inicial' = '// Verify initial step'
    '// Verificar paso final' = '// Verify final step'
    '// Verificar que todos los pasos estén vinculados' = '// Verify that all steps are linked'
    '// Obtener solo convocatorias activas y próximas' = '// Get only active and upcoming convocations'
    
    # Blade comments
    '{{-- Breadcrumb y Header --}}' = '{{-- Breadcrumb and Header --}}'
    '{{-- Columna principal: Pasos del trámite --}}' = '{{-- Main column: Request steps --}}'
    '{{-- Barra de progreso --}}' = '{{-- Progress bar --}}'
    '{{-- Timeline de pasos --}}' = '{{-- Steps timeline --}}'
    '{{-- Botón' = '{{-- Button'
    '{{-- Formulario' = '{{-- Form'
    '{{-- Tabla' = '{{-- Table'
    '{{-- Menú' = '{{-- Menu'
    '{{-- Sección' = '{{-- Section'
    '{{-- Card' = '{{-- Card'
    '{{-- Modal' = '{{-- Modal'
    '{{-- Lista' = '{{-- List'
    '{{-- Icono' = '{{-- Icon'
}

# Get all PHP files
$phpFiles = Get-ChildItem -Path "c:\Users\alpon\CETAM\Proyectos\SinTek\app" -Filter "*.php" -Recurse
$bladeFiles = Get-ChildItem -Path "c:\Users\alpon\CETAM\Proyectos\SinTek\resources\views" -Filter "*.blade.php" -Recurse

$totalFiles = $phpFiles.Count + $bladeFiles.Count
$modifiedCount = 0
$current = 0

# Process PHP files
foreach ($file in $phpFiles) {
    $current++
    Write-Progress -Activity "Translating comments" -Status "Processing $($file.Name)" -PercentComplete (($current / $totalFiles) * 100)
    
    $content = Get-Content $file.FullName -Raw -Encoding UTF8
    $originalContent = $content
    $modified = $false
    
    foreach ($spanish in $translations.Keys) {
        if ($content -match [regex]::Escape($spanish)) {
            $content = $content -replace [regex]::Escape($spanish), $translations[$spanish]
            $modified = $true
        }
    }
    
    if ($modified) {
        $utf8NoBom = New-Object System.Text.UTF8Encoding $false
        [System.IO.File]::WriteAllText($file.FullName, $content, $utf8NoBom)
        Write-Host "  ✅ $($file.Name)" -ForegroundColor Green
        $modifiedCount++
    }
}

# Process Blade files
foreach ($file in $bladeFiles) {
    $current++
    Write-Progress -Activity "Translating comments" -Status "Processing $($file.Name)" -PercentComplete (($current / $totalFiles) * 100)
    
    $content = Get-Content $file.FullName -Raw -Encoding UTF8
    $originalContent = $content
    $modified = $false
    
    foreach ($spanish in $translations.Keys) {
        if ($content -match [regex]::Escape($spanish)) {
            $content = $content -replace [regex]::Escape($spanish), $translations[$spanish]
            $modified = $true
        }
    }
    
    if ($modified) {
        $utf8NoBom = New-Object System.Text.UTF8Encoding $false
        [System.IO.File]::WriteAllText($file.FullName, $content, $utf8NoBom)
        Write-Host "  ✅ $($file.Name)" -ForegroundColor Green
        $modifiedCount++
    }
}

Write-Progress -Activity "Translating comments" -Completed

Write-Host ""
Write-Host "✅ Traducción completada" -ForegroundColor Green
Write-Host "   Archivos modificados: $modifiedCount de $totalFiles" -ForegroundColor White
