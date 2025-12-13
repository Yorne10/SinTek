{{--
Company: CETAM
Project: ST
File: sidenav.blade.php
Created on: 04/11/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
    Modified by: <Developer name>
    Description: <Brief description of change>
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
