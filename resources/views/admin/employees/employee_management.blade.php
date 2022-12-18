{{--  its view  --}}
@extends('admin.layout.layout')

@section('content')
    <!-- partial:partials/_sidebar.html -->
    @include('admin.layout.side_bar')
    <!-- partial -->
    <livewire:admin.employees.employee-managemen-wired />

    {{--  <style>
        @media (prefers-reduced-motion: reduce) {
            .fade {
                transition: none;
            }
        }
    </style>  --}}
@endsection
