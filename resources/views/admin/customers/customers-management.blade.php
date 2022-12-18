{{--  its view  --}}
@extends('admin.layout.layout')

@section('content')
    <!-- partial:partials/_sidebar.html -->
    @include('admin.layout.side_bar')
    <!-- partial -->
    <livewire:admin.customers.customer-mgmtwired />

@endsection
