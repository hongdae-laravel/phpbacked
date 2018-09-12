@extends('layouts.app')

@section('content')
    <div class="container text-center my-5">
        <site-info></site-info>
    </div>
    <div class="container">
        <product-form :errors="{{ $errors }}"></product-form>

        <div class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <p>Now processing. Please wait for a while.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
