@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Clicks</div>
                <div class="card-body">
                    @if ($clicks)
                        <table class="table" id="clicks_table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User Agent</th>
                                    <th>IP</th>
                                    <th>Referer</th>
                                    <th>Param 1</th>
                                    <th>Param 2</th>
                                    <th>Errors count</th>
                                    <th>Is bad domain</th>
                                </tr>
                            </thead>
                            @foreach ($clicks as $click)
                                <tr>
                                    <td>{{ $click->getId() }}</td>
                                    <td>{{ $click->getUserAgent() }}</td>
                                    <td>{{ $click->getIpAddress() }}</td>
                                    <td>{{ $click->getReferer() }}</td>
                                    <td>{{ $click->getParam1() }}</td>
                                    <td>{{ $click->getParam2() }}</td>
                                    <td>{{ $click->getErrorsCount() }}</td>
                                    <td>{{ $click->isBadDomain() ? 'Yes' : 'No' }}</td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('#clicks_table').DataTable();
        } );
    </script>
@endsection
