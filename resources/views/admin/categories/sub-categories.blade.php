{{--  its view  --}}
@extends('admin.layout.layout')

@section('content')
    <!-- partial:partials/_sidebar.html -->
    @include('admin.layout.side_bar')
    <!-- livewirepartial -->
    <livewire:admin.categories.sub-categories-wired/>

@endsection
