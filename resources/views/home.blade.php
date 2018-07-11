@extends('layouts.app')

@section('content')
    <div class="container text-center my-5">
        <site-info></site-info>
        <p><a href="/products/create">Do you have any php applications you would like to register?</a></p>
    </div>
    <div class="container">
        <product-list></product-list>
    </div>
@endsection
