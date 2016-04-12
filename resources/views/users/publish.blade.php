@extends('layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('partials/success')
                <div class="panel panel-default">
                    <div class="panel-heading">Pubblica un Post!</div>
                    <div class="panel-body">

                        {!! Form::open(['url' => 'publish', 'method' => 'POST']) !!}
                        <div class="form-group">
                            {!! Form::label('post','Post') !!}
                            {!! Form::text('post', null, ['class' => 'form-control',
                            'placeholder' => 'Escribe il tuo post', 'required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Invia',['class' => 'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection