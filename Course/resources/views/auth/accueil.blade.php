@extends('base')

@section('content')
    @auth
        {{ \Illuminate\Support\Facades\Auth::user()->name }}
    @endauth
    </div>
    <h>Bienvenu vous êtes Authentifiée"</h>

    @if(Auth::check())
        @if(Auth::user()->role === 'admin')
            <button>Opération réservée aux administrateurs</button>
        @elseif(Auth::user()->role === 'equipe')
            <button>Opération simple utilisateur</button>
        @endif
    @endif
@endsection
