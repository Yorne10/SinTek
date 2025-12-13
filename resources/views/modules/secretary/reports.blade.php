{{--
Company: CETAM
Project: ST
File: reports.blade.php
Created on: 04/11/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
    Description: <Brief description of change>
--}}

<div class="col-12 col-lg-6">
    <div class="card border-0 shadow h-100">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h2 class="fs-5 fw-bold mb-0">Tiempo promedio de resolución</h2>
            <button type="button" class="btn btn-sm btn-link text-gray-600 p-0">
                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="h6 mb-1">Solicitud de vacaciones</h3>
                        <p class="small text-gray-500 mb-0">Objetivo: 3 días</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-success">2.5 días</span>
                    </div>
                </li>
                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="h6 mb-1">Permiso</h3>
                        <p class="small text-gray-500 mb-0">Objetivo: 1 día</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-success">0.8 días</span>
                    </div>
                </li>
                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="h6 mb-1">Incapacidad</h3>
                        <p class="small text-gray-500 mb-0">Objetivo: 2 días</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-warning">2.3 días</span>
                    </div>
                </li>
                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="h6 mb-1">Cambio de adscripción</h3>
                        <p class="small text-gray-500 mb-0">Objetivo: 7 días</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-danger">8.5 días</span>
                    </div>
                </li>
                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="h6 mb-1">Promoción</h3>
                        <p class="small text-gray-500 mb-0">Objetivo: 15 días</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-success">12.2 días</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fs-5 fw-bold mb-0">Detalle de trámites por período</h2>
                    <p class="small text-gray-500 mb-0 mt-1">Resumen mensual del año en curso</p>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary">
                    <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Exportar a Excel
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0">Mes</th>
                            <th class="border-0">Total</th>
                            <th class="border-0">Pendientes</th>
                            <th class="border-0">En proceso</th>
                            <th class="border-0">Completados</th>
                            <th class="border-0">Rechazados</th>
                            <th class="border-0">Tasa de éxito</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold">November 2025</td>
                            <td>78</td>
                            <td>12</td>
                            <td>23</td>
                            <td>40</td>
                            <td>3</td>
                            <td>
                                <span class="badge bg-success">93.0%</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">October 2025</td>
                            <td>92</td>
                            <td>0</td>
                            <td>0</td>
                            <td>85</td>
                            <td>7</td>
                            <td>
                                <span class="badge bg-success">92.4%</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Septiembre 2025</td>
                            <td>85</td>
                            <td>0</td>
                            <td>0</td>
                            <td>79</td>
                            <td>6</td>
                            <td>
                                <span class="badge bg-success">92.9%</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Agosto 2025</td>
                            <td>105</td>
                            <td>0</td>
                            <td>0</td>
                            <td>98</td>
                            <td>7</td>
                            <td>
                                <span class="badge bg-success">93.3%</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Julio 2025</td>
                            <td>118</td>
                            <td>0</td>
                            <td>0</td>
                            <td>108</td>
                            <td>10</td>
                            <td>
                                <span class="badge bg-success">91.5%</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Junio 2025</td>
                            <td>95</td>
                            <td>0</td>
                            <td>0</td>
                            <td>88</td>
                            <td>7</td>
                            <td>
                                <span class="badge bg-success">92.6%</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer px-3 border-0 d-flex justify-content-between align-items-center">
                <div class="fw-normal small">Mostrando <b>6</b> de <b>11</b> meses</div>
                <a href="#" class="btn btn-sm btn-link text-primary">Ver todos los meses</a>
            </div>
        </div>
    </div>
</div>
</div>
