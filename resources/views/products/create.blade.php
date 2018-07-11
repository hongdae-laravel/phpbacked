@extends('layouts.app')

@section('content')
    <div class="container text-center my-5">
        <site-info></site-info>
    </div>
    <div class="container">
        <product-form :errors="{{ $errors }}"></product-form>
    </div>
@endsection
