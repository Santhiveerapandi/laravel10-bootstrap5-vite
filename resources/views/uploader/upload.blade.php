@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Big CSV Import') }}</div>
                <div class="card-body">
                @if($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if($message = Session::get('errors'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <ul>
                    @foreach($errors->all() as $error) 
                        <li>{{$error}}</li>
                    @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                    <form method="POST" id="csvupform" enctype="multipart/form-data" action="{{ route('uploader.store') }}">
                        @csrf

                        <input type="file" class="form-control" name="excelfile" id="excelfile" />
                        <input type="submit" class="btn btn-primary btn-csvimport" name="submit" disabled="true" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection