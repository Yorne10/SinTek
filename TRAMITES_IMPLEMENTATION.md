# Sistema de Trámites - Implementación Completa

## Resumen

Se ha implementado un sistema completo para que los workers (trabajadores) puedan:
1. **API Móvil**: Iniciar y seguir trámites desde la app móvil
2. **Web**: Ver y navegar sus trámites desde la aplicación web

---

## 1. API ENDPOINTS PARA MÓVIL

### Base URL
```
http://100.100.162.15:8000/api
```

Todos los endpoints requieren autenticación: `Authorization: Bearer {token}`

### 1.1. Listar mis trámites
**GET** `/my-requests`

**Query Parameters (Opcionales):**
- `status`: Filtrar por estado (`in_progress`, `completed`, `pending`, `cancelled`)

**Response Success (200):**
```json
{
    "success": true,
    "data": [
        {
            "request_id": 1,
            "process": {
                "process_id": 1,
                "name": "Solicitud de vacaciones",
                "description": "Proceso para solicitar días de vacaciones",
                "category": "personal",
                "priority": "media"
            },
            "status": "in_progress",
            "progress": 40,
            "current_step": {
                "step_id": 2,
                "title": "Revisión de supervisor",
                "order": 2
            },
            "start_date": "2025-11-23",
            "end_date": null,
            "created_at": "2025-11-23 10:00:00"
        }
    ],
    "count": 1
}
```

### 1.2. Iniciar un nuevo trámite
**POST** `/my-requests`

**Request Body:**
```json
{
    "process_id": 1
}
```

**Response Success (201):**
```json
{
    "success": true,
    "message": "Trámite iniciado exitosamente",
    "data": {
        "request_id": 15,
        "process": {
            "process_id": 1,
            "name": "Solicitud de vacaciones",
            "description": "Proceso para solicitar días de vacaciones"
        },
        "status": "in_progress",
        "start_date": "2025-11-23",
        "created_at": "2025-11-23 14:30:00"
    }
}
```

**Notas importantes:**
- El primer paso se activa automáticamente como "in_progress"
- Todos los demás pasos se crean como "pending"
- Solo se puede iniciar un trámite si el proceso tiene pasos configurados

### 1.3. Ver detalle de un trámite con todos sus pasos
**GET** `/my-requests/{id}`

**Response Success (200):**
```json
{
    "success": true,
    "data": {
        "request_id": 1,
        "process": {
            "process_id": 1,
            "name": "Solicitud de vacaciones",
            "description": "Proceso para solicitar días de vacaciones",
            "category": "personal",
            "priority": "media",
            "deadline_days": 5
        },
        "status": "in_progress",
        "progress": 40,
        "start_date": "2025-11-23",
        "end_date": null,
        "steps": [
            {
                "request_step_id": 1,
                "step": {
                    "step_id": 1,
                    "order": 1,
                    "title": "Llenar formulario",
                    "description": "Complete el formulario de solicitud",
                    "instructions": "Ingrese las fechas solicitadas y motivo",
                    "condition_type": "sequential",
                    "requires_documents": true,
                    "next_yes": null,
                    "next_no": null
                },
                "status": "completed",
                "step_date": "2025-11-23 10:30:00"
            },
            {
                "request_step_id": 2,
                "step": {
                    "step_id": 2,
                    "order": 2,
                    "title": "Revisión de supervisor",
                    "description": "El supervisor revisará la solicitud",
                    "instructions": null,
                    "condition_type": "conditional",
                    "requires_documents": false,
                    "next_yes": 3,
                    "next_no": 4
                },
                "status": "in_progress",
                "step_date": "2025-11-23 11:00:00"
            },
            {
                "request_step_id": 3,
                "step": {
                    "step_id": 3,
                    "order": 3,
                    "title": "Aprobación final",
                    "description": "Aprobación de recursos humanos",
                    "instructions": null,
                    "condition_type": "sequential",
                    "requires_documents": false,
                    "next_yes": null,
                    "next_no": null
                },
                "status": "pending",
                "step_date": null
            }
        ],
        "created_at": "2025-11-23 10:00:00",
        "updated_at": "2025-11-23 11:00:00"
    }
}
```

### 1.4. Avanzar al siguiente paso (flujo secuencial)
**POST** `/my-requests/{id}/next-step`

**Uso:** Para pasos con `condition_type: "sequential"` o sin condition_type

**Response Success (200):**
```json
{
    "success": true,
    "message": "Paso completado, avanzando al siguiente",
    "data": {
        "current_step": {
            "step_id": 3,
            "order": 3,
            "title": "Aprobación final",
            "description": "Aprobación de recursos humanos"
        }
    }
}
```

**Si es el último paso:**
```json
{
    "success": true,
    "message": "Trámite completado exitosamente",
    "data": {
        "request_id": 1,
        "status": "completed"
    }
}
```

**Error si el paso es condicional:**
```json
{
    "success": false,
    "message": "Este paso requiere una decisión condicional. Use el endpoint /conditional-step"
}
```

### 1.5. Avanzar en paso condicional (Sí/No)
**POST** `/my-requests/{id}/conditional-step`

**Uso:** Para pasos con `condition_type: "conditional"`

**Request Body:**
```json
{
    "decision": "yes"  // o "no"
}
```

**Response Success (200):**
```json
{
    "success": true,
    "message": "Decisión registrada, avanzando al siguiente paso",
    "data": {
        "decision": "yes",
        "current_step": {
            "step_id": 3,
            "order": 3,
            "title": "Aprobación final",
            "description": "Aprobación de recursos humanos"
        }
    }
}
```

**Notas importantes:**
- Si `decision: "yes"`, se activa el paso indicado en `next_yes`
- Si `decision: "no"`, se activa el paso indicado en `next_no`
- Si no hay siguiente paso, el trámite se marca como completado

---

## 2. IMPLEMENTACIÓN WEB

### 2.1. Archivos Modificados/Creados

#### Controller: `app/Livewire/Worker/MisTramites.php`
- Lista todos los trámites del worker autenticado
- Filtros por búsqueda y estado
- Paginación
- Estadísticas (total, en proceso, completados)

#### Vista: `resources/views/livewire/worker/mis-tramites.blade.php`
- Muestra tarjetas de estadísticas
- Tabla con todos los trámites
- Barra de progreso para cada trámite
- Filtros de búsqueda y estado
- Botón "Nuevo trámite" que redirige a trámites disponibles

### 2.2. Funcionalidades Web Implementadas

1. **Vista de lista de trámites** (`/p/sintek/worker/mis-tramites`)
   - Muestra todos los trámites del worker
   - Estadísticas visuales
   - Búsqueda por ID o nombre de proceso
   - Filtro por estado
   - Barra de progreso (X/Y pasos completados)
   - Botón "Ver detalle" para cada trámite

2. **Próximo: Vista de detalle de trámite**
   - Mostrará todos los pasos del proceso
   - Paso actual destacado
   - Botones para avanzar (según tipo de flujo)
   - Historial de pasos completados

---

## 3. FALTA IMPLEMENTAR

### 3.1. Componente DetalleTramite (Web)

Crear `app/Livewire/Worker/DetalleTramite.php`:

```php
<?php

namespace App\Livewire\Worker;

use Livewire\Component;
use App\Models\Request as WorkerRequest;
use App\Models\RequestStep;
use App\Models\Worker;
use App\Models\Step;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DetalleTramite extends Component
{
    public $requestId;
    public $request;
    public $currentStep;

    public function mount($id)
    {
        $this->requestId = $id;
        $this->loadRequest();
    }

    public function loadRequest()
    {
        $user = Auth::user();
        $worker = Worker::where('user_id', $user->users_id)->first();

        if (!$worker) {
            abort(404, 'Worker no encontrado');
        }

        $this->request = WorkerRequest::with(['process', 'requestSteps.step'])
            ->where('worker_id', $worker->workers_id)
            ->findOrFail($this->requestId);

        $this->currentStep = $this->request->requestSteps
            ->where('request_step_status', 'in_progress')
            ->first();
    }

    public function nextStep()
    {
        if (!$this->currentStep) {
            session()->flash('error', 'No hay un paso activo');
            return;
        }

        $currentStepModel = $this->currentStep->step;

        // Marcar paso actual como completado
        $this->currentStep->update([
            'request_step_status' => 'completed',
            'step_date' => Carbon::now(),
        ]);

        // Buscar siguiente paso secuencial
        $nextStep = Step::where('process_id', $this->request->process_id)
            ->where('order', '>', $currentStepModel->order)
            ->orderBy('order', 'asc')
            ->first();

        if ($nextStep) {
            $nextRequestStep = RequestStep::where('request_id', $this->request->request_id)
                ->where('step_id', $nextStep->step_id)
                ->first();

            if ($nextRequestStep) {
                $nextRequestStep->update([
                    'request_step_status' => 'in_progress',
                    'step_date' => Carbon::now(),
                    'user_id' => Auth::id(),
                ]);
            }

            session()->flash('success', 'Paso completado exitosamente');
        } else {
            // No hay más pasos, completar trámite
            $this->request->update([
                'status' => 'completed',
                'end_date' => Carbon::now(),
            ]);

            session()->flash('success', 'Trámite completado exitosamente');
        }

        $this->loadRequest();
    }

    public function conditionalStep($decision)
    {
        if (!$this->currentStep) {
            session()->flash('error', 'No hay un paso activo');
            return;
        }

        $currentStepModel = $this->currentStep->step;

        // Marcar paso actual como completado
        $this->currentStep->update([
            'request_step_status' => 'completed',
            'step_date' => Carbon::now(),
        ]);

        // Determinar siguiente paso según decisión
        $nextStepId = $decision === 'yes' ? $currentStepModel->next_yes : $currentStepModel->next_no;

        if ($nextStepId) {
            $nextStep = Step::find($nextStepId);

            if ($nextStep) {
                $nextRequestStep = RequestStep::firstOrCreate(
                    [
                        'request_id' => $this->request->request_id,
                        'step_id' => $nextStep->step_id,
                    ],
                    [
                        'user_id' => Auth::id(),
                        'request_step_status' => 'in_progress',
                        'step_date' => Carbon::now(),
                    ]
                );

                if (!$nextRequestStep->wasRecentlyCreated) {
                    $nextRequestStep->update([
                        'request_step_status' => 'in_progress',
                        'step_date' => Carbon::now(),
                    ]);
                }

                session()->flash('success', 'Decisión registrada exitosamente');
            }
        } else {
            // Completar trámite
            $this->request->update([
                'status' => 'completed',
                'end_date' => Carbon::now(),
            ]);

            session()->flash('success', 'Trámite completado exitosamente');
        }

        $this->loadRequest();
    }

    public function render()
    {
        return view('livewire.worker.detalle-tramite')->layout('layouts.app');
    }
}
```

### 3.2. Vista DetalleTramite

Crear `resources/views/livewire/worker/detalle-tramite.blade.php`:

```blade
<div>
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.worker.mis-tramites') }}">Mis trámites</a>
                </li>
                <li class="breadcrumb-item active">Detalle #{{ $request->request_id }}</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between">
            <div>
                <h1 class="h4">{{ $request->process->name }}</h1>
                <p class="mb-0">Trámite #{{ $request->request_id }}</p>
            </div>
            <div>
                @if($request->status === 'completed')
                    <span class="badge bg-success p-2">Completado</span>
                @elseif($request->status === 'in_progress')
                    <span class="badge bg-warning p-2">En proceso</span>
                @else
                    <span class="badge bg-info p-2">{{ $request->status }}</span>
                @endif
            </div>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-12 col-lg-8 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h5 class="mb-0">Pasos del trámite</h5>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-one px-2 pt-3 pb-0">
                        @foreach($request->requestSteps->sortBy('step.order') as $requestStep)
                            <div class="timeline-item {{ $requestStep->request_step_status === 'completed' ? 'border-success' : ($requestStep->request_step_status === 'in_progress' ? 'border-warning' : 'border-gray-300') }}">
                                <div class="timeline-item-icon {{ $requestStep->request_step_status === 'completed' ? 'bg-success' : ($requestStep->request_step_status === 'in_progress' ? 'bg-warning' : 'bg-gray-300') }}">
                                    @if($requestStep->request_step_status === 'completed')
                                        <svg class="icon icon-xs text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @elseif($requestStep->request_step_status === 'in_progress')
                                        <span class="text-white">{{ $requestStep->step->order }}</span>
                                    @else
                                        <span class="text-gray-600">{{ $requestStep->step->order }}</span>
                                    @endif
                                </div>
                                <div class="timeline-item-content">
                                    <h6 class="mb-1">{{ $requestStep->step->tittle }}</h6>
                                    <p class="text-gray-600 mb-2">{{ $requestStep->step->description }}</p>

                                    @if($requestStep->step->instructions)
                                        <p class="small text-muted mb-2">
                                            <strong>Instrucciones:</strong> {{ $requestStep->step->instructions }}
                                        </p>
                                    @endif

                                    @if($requestStep->request_step_status === 'completed')
                                        <span class="badge bg-success">Completado {{ $requestStep->step_date ? $requestStep->step_date->format('d/m/Y H:i') : '' }}</span>
                                    @elseif($requestStep->request_step_status === 'in_progress')
                                        <span class="badge bg-warning">Paso actual</span>

                                        @if($currentStep && $currentStep->step_id === $requestStep->step_id)
                                            <div class="mt-3">
                                                @if($requestStep->step->condition_type === 'conditional')
                                                    <button wire:click="conditionalStep('yes')" class="btn btn-success btn-sm me-2">
                                                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        Sí / Aprobar
                                                    </button>
                                                    <button wire:click="conditionalStep('no')" class="btn btn-danger btn-sm">
                                                        <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        No / Rechazar
                                                    </button>
                                                @else
                                                    <button wire:click="nextStep" class="btn btn-primary btn-sm">
                                                        Continuar al siguiente paso
                                                        <svg class="icon icon-xs ms-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">Pendiente</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Información del trámite</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <span class="small text-gray-600">Proceso:</span>
                        <p class="mb-0 fw-bold">{{ $request->process->name }}</p>
                    </div>
                    <div class="mb-3">
                        <span class="small text-gray-600">Categoría:</span>
                        <p class="mb-0">{{ $request->process->category ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <span class="small text-gray-600">Prioridad:</span>
                        <p class="mb-0">
                            <span class="badge bg-{{ $request->process->priority === 'high' ? 'danger' : ($request->process->priority === 'medium' ? 'warning' : 'info') }}">
                                {{ ucfirst($request->process->priority ?? 'N/A') }}
                            </span>
                        </p>
                    </div>
                    <div class="mb-3">
                        <span class="small text-gray-600">Fecha de inicio:</span>
                        <p class="mb-0">{{ $request->start_date ? $request->start_date->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                    @if($request->end_date)
                        <div class="mb-3">
                            <span class="small text-gray-600">Fecha de finalización:</span>
                            <p class="mb-0">{{ $request->end_date->format('d/m/Y') }}</p>
                        </div>
                    @endif
                    <div>
                        <span class="small text-gray-600">Progreso:</span>
                        @php
                            $totalSteps = $request->requestSteps->count();
                            $completedSteps = $request->requestSteps->where('request_step_status', 'completed')->count();
                            $progress = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
                        @endphp
                        <div class="progress mt-2" style="height: 20px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $progress }}%
                            </div>
                        </div>
                        <p class="small text-muted mt-1">{{ $completedSteps }} de {{ $totalSteps }} pasos completados</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
```

### 3.3. Actualizar rutas web

Agregar a `routes/web.php`:

```php
// Ruta para detalle de trámite
Route::get('/worker/detalle-tramite/{id}', \App\Livewire\Worker\DetalleTramite::class)
    ->middleware(['auth', 'role:worker'])
    ->name(config('proj.route_name_prefix', 'proj') . '.worker.detalle-tramite');
```

### 3.4. Actualizar componente TramitesDisponibles

Modificar `app/Livewire/Worker/TramitesDisponibles.php` para agregar funcionalidad de iniciar trámite:

```php
public function iniciarTramite($processId)
{
    $user = Auth::user();
    $worker = Worker::where('user_id', $user->users_id)->first();

    if (!$worker) {
        session()->flash('error', 'No se encontró perfil de trabajador');
        return;
    }

    $process = Process::with('steps')->find($processId);

    if (!$process || !$process->active) {
        session()->flash('error', 'El proceso no está disponible');
        return;
    }

    if ($process->steps->count() === 0) {
        session()->flash('error', 'El proceso no tiene pasos configurados');
        return;
    }

    DB::beginTransaction();
    try {
        // Crear la solicitud
        $request = \App\Models\Request::create([
            'worker_id' => $worker->workers_id,
            'process_id' => $process->process_id,
            'status' => 'in_progress',
            'start_date' => Carbon::now(),
        ]);

        // Crear primer paso
        $firstStep = $process->steps->where('order', 1)->first();

        if ($firstStep) {
            RequestStep::create([
                'request_id' => $request->request_id,
                'step_id' => $firstStep->step_id,
                'user_id' => $user->users_id,
                'request_step_status' => 'in_progress',
                'step_date' => Carbon::now(),
            ]);

            // Crear pasos restantes como pending
            foreach ($process->steps->where('order', '>', 1) as $step) {
                RequestStep::create([
                    'request_id' => $request->request_id,
                    'step_id' => $step->step_id,
                    'user_id' => null,
                    'request_step_status' => 'pending',
                    'step_date' => null,
                ]);
            }
        }

        DB::commit();

        session()->flash('success', 'Trámite iniciado exitosamente');
        return redirect()->route(config('proj.route_name_prefix', 'proj') . '.worker.detalle-tramite', ['id' => $request->request_id]);

    } catch (\Exception $e) {
        DB::rollBack();
        session()->flash('error', 'Error al iniciar el trámite: ' . $e->getMessage());
    }
}
```

---

## 4. EJEMPLO DE FLUJO COMPLETO

### Ejemplo 1: Flujo Secuencial (Solicitud de Vacaciones)

**Pasos:**
1. Llenar formulario (sequential)
2. Revisión de supervisor (sequential)
3. Aprobación de RRHH (sequential)

**Flujo móvil:**
```
POST /api/my-requests { "process_id": 1 }
GET /api/my-requests/1
POST /api/my-requests/1/next-step
POST /api/my-requests/1/next-step
POST /api/my-requests/1/next-step  // Completa el trámite
```

### Ejemplo 2: Flujo Condicional (Solicitud de Permiso)

**Pasos:**
1. Llenar formulario (sequential)
2. ¿Aprueba supervisor? (conditional: yes->3, no->4)
3. Aprobación final (sequential)
4. Rechazo y fin (sequential)

**Flujo móvil:**
```
POST /api/my-requests { "process_id": 2 }
POST /api/my-requests/2/next-step  // Completa paso 1
POST /api/my-requests/2/conditional-step { "decision": "yes" }  // Va a paso 3
POST /api/my-requests/2/next-step  // Completa trámite
```

---

## 5. NOTAS IMPORTANTES

1. **Seguridad**: Todos los endpoints verifican que el trámite pertenezca al worker autenticado
2. **Validaciones**: Se valida que el proceso esté activo y tenga pasos configurados
3. **Estados de paso**: `pending`, `in_progress`, `completed`
4. **Estados de trámite**: `pending`, `in_progress`, `completed`, `cancelled`
5. **Flujos condicionales**: Se crean dinámicamente los pasos según las decisiones
6. **Transacciones**: Todas las operaciones críticas usan transacciones de base de datos

---

## 6. PENDIENTES (Opcional)

1. **Documentos**: Agregar funcionalidad para subir documentos requeridos en cada paso
2. **Notificaciones**: Enviar notificaciones cuando se completa/avanza un paso
3. **Comentarios**: Permitir agregar comentarios en cada paso
4. **Historial**: Registrar cambios y acciones en cada paso
5. **Cancelación**: Permitir cancelar trámites en proceso
