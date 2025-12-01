{{--
  Company: CETAM
  Project: ST
  File: sidenav.blade.php
  Created on: 04/11/2025
  Created by: Alfonso Angel Garca Hernndez
  Approved by: Alfonso Angel Garca Hernndez

  Changelog:
--}}

@php
    $userRole = auth()->user()->role ?? 'worker';
@endphp

@if($userRole === 'admin')
    @include('layouts.sidenav-admin')
@elseif($userRole === 'secretary')
    @include('layouts.sidenav-secretary')
@elseif($userRole === 'worker')
    @include('layouts.sidenav-worker')
@else
    @include('layouts.sidenav-basic')
@endif
