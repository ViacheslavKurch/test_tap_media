@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Error</div>
                    <div class="card-body">
                        <table class="table">
                            @include('responses.table')
                            <tr>
                                <td>Count errors</td>
                                <td>{{ $click->getErrorsCount() }}</td>
                            </tr>
                            <tr>
                                <td>Is bad domain</td>
                                <td>{{ $click->isBadDomain() ? 'Yes' : 'No' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection