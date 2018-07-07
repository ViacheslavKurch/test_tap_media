@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit bad domain</div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                <strong>Success!</strong> {{ session('success') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('bad-domains.update', $badDomain->getId()) }}">
                            @method('PUT')
                            @csrf
                            <div class="form-group row">
                                <label for="Name" class="col-md-4 col-form-label text-md-right">{{ __('Domain') }}*</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $badDomain->getDomain()) }}" required />
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection