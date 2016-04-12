@extends('layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                @include('partials/success')

                <div class="panel panel-default">
                    <div class="panel-heading">Solo accesso Editor</div>
                    <div class="panel-body">
                        <h1>Esempio di Posts</h1>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection