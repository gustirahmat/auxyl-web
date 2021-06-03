@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Dashboard</h5>
                <div class="card-body">
                    @include('layouts.flash-message')
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
