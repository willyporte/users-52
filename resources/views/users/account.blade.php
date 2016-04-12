@extends('layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('partials/success')
                <div class="panel panel-default">
                    <div class="panel-heading">Profilo del usuario</div>
                    <div class="panel-body">

                        <ul>
                            <li><a href="#">Cambia il tuo Profile</a></li>
                            <li><a href="#">Cambia la tua Password</a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection