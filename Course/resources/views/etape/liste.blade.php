@extends('base')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <form method="POST" action="{{ route('import.etape') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row align-items-center">
                        <div class="col-auto">
                            <div class="form-group">
                                <label for="file" class="sr-only">Etape :</label>
                                <input type="file" class="form-control" id="file" name="file">
                            </div>
                            <div class="form-group">
                                <label for="fileé" class="sr-only">Resultat :</label>
                                <input type="file" class="form-control" id="file2" name="file2">
                            </div>
                            <br>
                            <div class="col-form">
                                <button type="submit" class="btn btn-primary">Valider</button>
                            </div>
                        </div>

                    </div>
                </form>

                <div class="col-12 text-center">
                    <h2>Liste des etapes du course</h2>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12 d-flex justify-content-center">
                    <a class="btn btn-primary mx-2" href="{{ route('add.etape') }}">
                        Ajout Etape
                    </a>
                    <a class="btn btn-secondary mx-2" href="{{ route('generate.categorie') }}">
                        Generate
                    </a>
                </div>
            </div>

            @if (session('nonMatchingRefs') && count(session('nonMatchingRefs')) > 0)
                <ul>
                    <p style="color: red;">Erreur des données</p>
                    @foreach (session('nonMatchingRefs') as $ref)
                        @if(is_array($ref))
                            <li style="color: red;" >
                                Ligne {{ $ref['line'] }}: {{ $ref['rang'] }}
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif

        </div>
    </section>

    <div class="card mr-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>N° Etape</th>
                        <th>Nom</th>
                        <th>Distance</th>
                        <th>Nombre coureur max</th>
                        <th>Voir Courreur Inscrit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $etapes)
                        <tr>
                            <td>{{ $etapes->rang }}</td>
                            <td>{{ $etapes->nom }}</td>
                            <td>{{ $etapes->longeur }}</td>
                            <td>{{ $etapes->nb_coureur }}</td>
                            <td  style="width: 120px">
                                <div class='btn-group'>
                                    <a href="{{ route('etape.liste-courreur', [$etapes->id]) }}">
                                        <i class="bx bx-right-arrow-circle bx-fade-right-hover"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
