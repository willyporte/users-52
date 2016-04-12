@extends('layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                @include('partials/success')

                <div class="panel panel-default">
                    <div class="panel-heading">Settings change only for Admins</div>
                    <div class="panel-body">
                        <h1>Settings</h1>

                        <p>Cantidad de post por paginas: </p>
                        <p>Etc.</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection