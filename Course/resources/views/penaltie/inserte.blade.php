@extends('base')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>
                        Ajout Penalité Equipe
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        <div class="card">

            {!! Form::open(['route' => 'insert.penalite']) !!}

            <div class="card-body">

                <div class="row">
                    @include('penaltie.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Valider', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('etape.liste') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
