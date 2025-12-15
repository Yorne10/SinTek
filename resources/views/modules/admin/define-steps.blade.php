<div wire:key="define-steps-root">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-0">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">
                            @icon('home', 'fa-xs')
                        </a>
                    </li>
                    @if (auth()->user()->role === 'secretary')
                        <li class="breadcrumb-item">Secretaria</li>
                        <li class="breadcrumb-item">
                            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.processes') }}">
                                Gestionar procesos
                            </a>
                        </li>
                    @else
                        <li class="breadcrumb-item">Administracion</li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">Definir pasos</li>
                </ol>
            </nav>
            <h2 class="h4">Definir pasos de proceso</h2>
            <p class="mb-0">Configura el flujo de trabajo y los pasos que componen el proceso.</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0 gap-2">
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.secretary.processes') }}"
                class="btn btn-sm btn-gray-200 d-inline-flex align-items-center">
                @icon('back', 'me-2')
                Volver
            </a>
            <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.create-step', ['process_id' => $selectedProcessId]) }}"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                @icon('add', 'me-2')
                Agregar paso
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow">
                <div class="card-body">
                    @if ($selectedProcess)
                        <div class="d-flex align-items-stretch justify-content-between flex-wrap gap-2">
                            <div>
                                <h3 class="h6 mb-1">{{ $selectedProcess->name }}</h3>
                                @if ($selectedProcess->process_code)
                                    <p class="small text-gray mb-0">Codigo: {{ $selectedProcess->process_code }}</p>
                                @endif
                                @if ($selectedProcess->category)
                                    <p class="small text-gray mb-0">Categoria: {{ ucfirst($selectedProcess->category) }}</p>
                                @endif
                                @if ($selectedProcess->department)
                                    <p class="small text-gray mb-0">Area responsable: {{ $selectedProcess->department }}</p>
                                @endif
                            </div>
                            <div class="text-end d-flex flex-column justify-content-between align-items-end">
                                @if ($selectedProcess->active)
                                    <span class="fw-bold text-success">Activo</span>
                                @else
                                    <span class="fw-bold text-warning">Inactivo</span>
                                @endif
                                <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.configure-flow', ['process_id' => $selectedProcessId]) }}"
                                    class="btn btn-secondary btn-sm d-inline-flex align-items-center text-white">
                                    @icon('process', 'icon-xs me-2 text-white')
                                    Configurar flujo
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning mb-0" role="alert">
                            No hay procesos disponibles. Por favor, crea un proceso primero.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow">
                <div class="card-body d-flex flex-column gap-3">
                    <h2 class="h6 mb-3">Informacion importante</h2>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <div class="d-flex align-items-start">
                                @icon('info', 'fa-xs text-info me-3')
                                <div>
                                    <p class="text-gray-700 small mb-0">
                                        Primero se deben crear los pasos y despues definir el flujo.
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-body shadow border-0 table-wrapper table-responsive">
        <table class="table table-centered table-nowrap mb-0 rounded user-table align-items-center" style="table-layout: fixed;">
            <colgroup>
                <col style="width: 35%">
                <col style="width: 18%">
                <col style="width: 20%">
                <col style="width: 12%; min-width: 72px;">
            </colgroup>
            <thead class="thead-light">
                <tr>
                    <th class="border-0 rounded-start">Paso</th>
                    <th class="border-0">Tipo</th>
                    <th class="border-0">Estado</th>
                    <th class="border-0 rounded-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if ($selectedProcess && count($steps) > 0)
                    @foreach ($steps as $step)
                        <tr>
                            <td>
                                <span class="fw-bold text-gray-900">{{ $step->title }}</span>
                            </td>
                            <td>
                                @php
                                    $displayType = $step->step_type_display ?? $step->step_type;
                                    $typeClass = match ($displayType) {
                                        'initial' => 'text-success',
                                        'final' => 'text-danger',
                                        'conditional' => 'text-warning',
                                        default => 'text-info',
                                    };
                                @endphp
                                <span class="fw-bold {{ $typeClass }}">{{ $this->getStepTypeLabel($displayType) }}</span>
                            </td>
                            <td>
                                @if ($step->is_initial_step)
                                    <span class="fw-bold text-primary">Paso inicial</span>
                                @elseif($step->is_linked)
                                    <span class="fw-bold text-success">Vinculado</span>
                                @else
                                    <span class="fw-bold text-warning">Sin vincular</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group position-static">
                                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        @icon('menu', 'icon icon-xs')
                                    </button>
                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                        @php
                                            $nextStep = $step->nextStep ? $step->nextStep->title : '';
                                            $nextYes = $step->nextYesStep ? $step->nextYesStep->title : '';
                                            $nextNo = $step->nextNoStep ? $step->nextNoStep->title : '';
                                            $providedDocs = $step->providedDocuments ? $step->providedDocuments->count() : 0;
                                            $docsPayload = $step->providedDocuments ? $step->providedDocuments->map(function ($doc) {
                                                return [
                                                    'name' => $doc->name ?? 'Documento',
                                                    'show' => route(config('proj.route_name_prefix', 'proj') . '.step-provided-document.show', $doc->document_id),
                                                    'download' => route(config('proj.route_name_prefix', 'proj') . '.step-provided-document.download', $doc->document_id),
                                                ];
                                            })->values()->toArray() : [];
                                        @endphp
                                        <button type="button" class="dropdown-item d-flex align-items-center view-step-detail"
                                            data-step-title="{{ $step->title }}"
                                            data-step-type="{{ $step->step_type }}"
                                            data-step-type-label="{{ $this->getStepTypeLabel($step->step_type) }}"
                                            data-step-instruction="{{ $step->instruction ?? 'Sin instrucciones' }}"
                                            data-step-condition="{{ $step->condition_question ?? '' }}"
                                            data-step-finalization="{{ $step->finalization_message ?? '' }}"
                                            data-step-initial="{{ $step->is_initial_step ? 'Si' : 'No' }}"
                                            data-step-linked="{{ $step->is_linked ? 'Si' : 'No' }}"
                                            data-step-docs="{{ $step->requiredDocuments->count() ?? 0 }}"
                                            data-step-provided-docs="{{ $providedDocs }}"
                                            data-step-next="{{ $nextStep }}"
                                            data-step-next-yes="{{ $nextYes }}"
                                            data-step-next-no="{{ $nextNo }}">
                                            @icon('view', 'dropdown-icon text-gray-400 me-2')
                                            Ver detalles
                                        </button>
                                        @if ($providedDocs > 0)
                                            <button type="button"
                                                class="dropdown-item d-flex align-items-center open-step-docs-modal"
                                                data-step-title="{{ $step->title }}" data-docs='@json($docsPayload)'>
                                                @icon('file', 'dropdown-icon text-gray-400 me-2')
                                                Documentos ({{ $providedDocs }})
                                            </button>
                                        @endif
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route(config('proj.route_name_prefix', 'proj') . '.admin.edit-step', ['step_id' => $step->step_id]) }}">
                                            @icon('edit', 'dropdown-icon text-gray-400 me-2')
                                            Editar
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center py-4">
                            <div class="text-gray-500">
                                <div class="mb-3">
                                    @icon('checkList', 'fa-2x text-gray-400')
                                </div>
                                <p class="fw-bold">No hay pasos registrados</p>
                                <p class="small">Este proceso aun no tiene pasos configurados.</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@push('styles')
<style>
    .swal2-popup .btn-outline-secondary:hover,
    .swal2-popup .btn-outline-secondary:active,
    .swal2-popup .btn-outline-secondary:focus-visible {
        background-color: var(--bs-secondary, #6c757d) !important;
        border-color: var(--bs-secondary, #6c757d) !important;
        color: #fff !important;
    }
</style>
@endpush

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-gray'
            },
            buttonsStyling: false
        });

        document.addEventListener('click', function (e) {
            if (e.target.closest('.view-step-detail')) {
                e.preventDefault();
                const button = e.target.closest('.view-step-detail');
                const title = button.getAttribute('data-step-title');
                const type = button.getAttribute('data-step-type');
                const typeLabel = button.getAttribute('data-step-type-label');
                const instruction = button.getAttribute('data-step-instruction');
                const condition = button.getAttribute('data-step-condition');
                const finalization = button.getAttribute('data-step-finalization');
                const isInitial = button.getAttribute('data-step-initial');
                const isLinked = button.getAttribute('data-step-linked');
                const docs = button.getAttribute('data-step-docs');
                const providedDocs = button.getAttribute('data-step-provided-docs');
                const nextStep = button.getAttribute('data-step-next');
                const nextYes = button.getAttribute('data-step-next-yes');
                const nextNo = button.getAttribute('data-step-next-no');

                let htmlContent = `
                    <div class="text-start">
                        <p class="mb-2"><span class="fw-bold">Tipo:</span> ${typeLabel}</p>
                        <p class="mb-2"><span class="fw-bold">Instrucciones:</span> ${instruction}</p>
                `;

                if (condition) {
                    htmlContent += `<p class="mb-2"><span class="fw-bold">Pregunta condicional:</span> ${condition}</p>`;
                }

                if (finalization) {
                    htmlContent += `<p class="mb-2"><span class="fw-bold">Mensaje de finalizacion:</span> ${finalization}</p>`;
                }

                if (type === 'conditional') {
                    htmlContent += `<p class="mb-2"><span class="fw-bold">Si:</span> ${nextYes || 'No definido'}</p>`;
                    htmlContent += `<p class="mb-2"><span class="fw-bold">Si NO:</span> ${nextNo || 'No definido'}</p>`;
                } else if (type !== 'final') {
                    htmlContent += `<p class="mb-2"><span class="fw-bold">Siguiente paso:</span> ${nextStep || 'No definido'}</p>`;
                }

                htmlContent += `
                        <p class="mb-2"><span class="fw-bold">Es paso inicial:</span> ${isInitial}</p>
                        <p class="mb-2"><span class="fw-bold">Vinculado al flujo:</span> ${isLinked}</p>
                        <p class="mb-2"><span class="fw-bold">Documentos requeridos:</span> ${docs}</p>
                        <p class="mb-0"><span class="fw-bold">Documentos proporcionados:</span> ${providedDocs}</p>
                    </div>
                `;

                swalWithBootstrapButtons.fire({
                    title: title,
                    html: htmlContent,
                    icon: 'info',
                    confirmButtonText: 'Cerrar',
                    width: '500px'
                });
            }
        });

        document.addEventListener('click', function (e) {
            if (e.target.closest('.open-step-docs-modal')) {
                e.preventDefault();
                const button = e.target.closest('.open-step-docs-modal');
                const stepTitle = button.getAttribute('data-step-title') || 'Documentos';
                const docsRaw = button.getAttribute('data-docs') || '[]';
                let docs = [];
                try {
                    docs = JSON.parse(docsRaw);
                } catch (err) {
                    docs = [];
                }

                if (!docs.length) {
                    swalWithBootstrapButtons.fire({
                        title: `Documentos - ${stepTitle}`,
                        html: '<div class="text-center text-gray-500 py-2">Sin documentos</div>',
                        icon: 'info',
                        confirmButtonText: 'Cerrar',
                    });
                    return;
                }

                const listHtml = docs.map((doc) => {
                    const name = doc.name || 'Documento';
                    const showUrl = doc.show || '#';
                    const downloadUrl = doc.download || '#';
                    return `
                        <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                            <div class="me-3">
                                <div class="fw-bold text-gray-800">${name}</div>
                            </div>
                            <div class="d-flex gap-2">
                                <a class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center" href="${showUrl}" target="_blank" rel="noopener">
                                    Abrir
                                </a>
                                <a class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center" href="${downloadUrl}" target="_blank" rel="noopener">
                                    Descargar
                                </a>
                            </div>
                        </div>
                    `;
                }).join('');

                swalWithBootstrapButtons.fire({
                    title: `Documentos - ${stepTitle}`,
                    html: `<div class="list-group list-group-flush">${listHtml}</div>`,
                    icon: 'info',
                    confirmButtonText: 'Cerrar',
                    width: '550px'
                });
            }
        });
    });
</script>
@endsection
