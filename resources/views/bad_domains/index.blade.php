@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Bad Domains <a class='btn btn-success' href="{{ route('bad-domains.create') }}">Create bad domain</a></div>
                    <div class="card-body">
                        <div class="card-body">
                            @if ($badDomains)
                                <table class="table" id="bad_domain_table">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    @foreach ($badDomains as $badDomain)
                                        <tr>
                                            <td>{{ $badDomain->getId() }}</td>
                                            <td>{{ $badDomain->getDomain() }}</td>
                                            <td><a class='btn btn-success' href="{{ route('bad-domains.edit', $badDomain->getId()) }}">Edit</a></td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        </div>
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
            $('#bad_domain_table').DataTable();
        } );
    </script>
@endsection