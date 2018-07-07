@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Success</div>
                    <div class="card-body">
                        <table class="table">
                            @include('responses.table')
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection