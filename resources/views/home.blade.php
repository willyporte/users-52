@extends('layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                @include('partials/success')

                @if (Session::has('link'))
                    <div class="alert alert-info">
                        Fai click in: <a href="{{ url(session('link')) }}">Rinvio E-mail</a> per avere un nuovo email di conferma.
                    </div>
                @endif

                <div class="panel panel-default">
                    <div class="panel-heading">Bienvenidos!</div>
                    <div class="panel-body">
                        <h1>Laravel users-52</h1>

                        @if (Auth::check())
                            <h2>Ciao {{ Auth::user()->name }}!</h2>
                        @else
                            <h2>Benvenuto al nostro sito</h2>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection