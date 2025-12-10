{{-- 
    Company: CETAM
    Project: ST
    File: alerts-preview.blade.php
    Purpose: Pantalla temporal para revisar estilos de alerts (Bootstrap y SweetAlert2)
--}}
@extends('layouts.app')

@section('content')
<div class="py-4">
  <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
    <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
      <li class="breadcrumb-item">
        <a href="{{ route(config('proj.route_name_prefix', 'proj') . '.dashboard.index') }}">@icon('home', 'fa-xs')</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">Alerts preview</li>
    </ol>
  </nav>
  <div class="d-flex justify-content-between w-100 flex-wrap">
    <div class="mb-3 mb-lg-0">
      <h1 class="h4">Vista de alerts</h1>
      <p class="mb-0">Revisión rápida de colores y estados (Bootstrap + SweetAlert2).</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12 col-xl-6 mb-4">
    <div class="card border-0 shadow">
      <div class="card-header">
        <h2 class="h6 mb-0">Bootstrap Alerts</h2>
      </div>
      <div class="card-body">
        <div class="alert alert-primary" role="alert">Primary alert</div>
        <div class="alert alert-secondary" role="alert">Secondary alert</div>
        <div class="alert alert-success" role="alert">Success alert</div>
        <div class="alert alert-danger" role="alert">Danger alert</div>
        <div class="alert alert-warning" role="alert">Warning alert</div>
        <div class="alert alert-info" role="alert">Info alert</div>
        <div class="alert alert-light" role="alert">Light alert</div>
        <div class="alert alert-dark mb-0" role="alert">Dark alert</div>
      </div>
    </div>
  </div>

  <div class="col-12 col-xl-6 mb-4">
    <div class="card border-0 shadow">
      <div class="card-header d-flex align-items-center">
        <h2 class="h6 mb-0">SweetAlert2 States</h2>
        <span class="text-muted small ms-auto">Usa colores configurados</span>
      </div>
      <div class="card-body">
        <div class="d-flex flex-wrap gap-2">
          <button type="button" class="btn btn-success" data-swal="success">Success</button>
          <button type="button" class="btn btn-danger" data-swal="error">Error</button>
          <button type="button" class="btn btn-warning" data-swal="warning">Warning</button>
          <button type="button" class="btn btn-info text-white" data-swal="info">Info</button>
          <button type="button" class="btn btn-secondary" data-swal="question">Question</button>
        </div>
        <p class="text-muted small mt-3 mb-0">Tip: revisa que “question” sea gris y el resto respete la paleta.</p>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const ensureSwal = () => {
      if (window.Swal) return Promise.resolve(window.Swal);
      return new Promise((resolve) => {
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
        script.onload = () => resolve(window.Swal);
        document.head.appendChild(script);
      });
    };

    const map = {
      success: { icon: 'success', title: 'Success', text: 'Estado success' },
      error:   { icon: 'error', title: 'Error', text: 'Estado error' },
      warning: { icon: 'warning', title: 'Warning', text: 'Estado warning' },
      info:    { icon: 'info', title: 'Info', text: 'Estado info' },
      question:{ icon: 'question', title: 'Question', text: 'Estado question' },
    };

    ensureSwal().then(() => {
      document.querySelectorAll('[data-swal]').forEach(btn => {
        btn.addEventListener('click', () => {
          const key = btn.getAttribute('data-swal');
          const conf = map[key];
          const swalLib = window.Swal || window.swal;
          if (conf && swalLib) {
            swalLib.fire({
              icon: conf.icon,
              title: conf.title,
              text: conf.text,
              confirmButtonText: 'Ok'
            });
          }
        });
      });
    });
  });
</script>
@endsection
