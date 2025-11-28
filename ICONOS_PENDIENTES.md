# Iconos pendientes

- resources/views/livewire/worker/dashboard.blade.php: el boton de "Convocatorias" usa `@icon('calendar.generic')`, pero no existe un alias de calendario en `config/icons.php`. Sugerencia: agregar un alias como `calendar.events => fa-solid fa-calendar-days`.
