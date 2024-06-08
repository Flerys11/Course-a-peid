@extends('base2')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="text-center">
                <h1>DETAIL COURREUR EQUIPE</h1>
            </div>
            <br>
        </div>
    </div>
</section>
<div class="card mr-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Non Courreur</th>
                    <th>Equipe</th>
                    <th>Points</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $datas)
                    <tr>
                        <td>{{ $datas->nom }}</td>
                        <td>{{ $datas->nom_equipe }}</td>
                        <td> {{ $datas->point_total }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
