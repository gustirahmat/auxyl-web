@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <h5 class="card-header">Dashboard</h5>
        <div class="card-body">
            @include('layouts.flash-message')
            You are logged in!
        </div>
    </div>
</div>
@endsection
