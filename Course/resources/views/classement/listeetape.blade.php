@extends('base')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="text-center">
                    <h1>Classement etape</h1>
                </div>
                <br>

{{--                <strong> Trie par : {{ $trie }}</strong>--}}
{{--                <br>--}}
{{--                <form action="{{ route('trie.categorie') }}" method="POST">--}}
{{--                    @csrf--}}
{{--                    <div class="form-group">--}}
{{--                        <input type="hidden" name="categorie" id="" value=" {{ $etape[0]->idetape }}">--}}
{{--                        <select class="form-control w-25" name="trie" onchange="this.form.submit()">--}}
{{--                            <option value="">Trie categorie</option>--}}

{{--                            @foreach($genre as $genres)--}}
{{--                                <option value="{{ $genres->nom }}">{{ $genres->nom }}</option>--}}
{{--                            @endforeach--}}
{{--                            @foreach($cate as $cates)--}}
{{--                                <option value="{{ $cates->nom }}">{{ $cates->nom }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </form>--}}
            </div>
        </div>
    </section>
    <div class="card mr-3">
        <div class="mt-4 ml-4">
            <p class="text-dark text-center"><strong>Etape : {{ $nom_etape->nom }}</strong></p>
        </div>
        <br>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Rang</th>
                        <th>Nom</th>
                        <th>Genre</th>
                        <th>Chrono</th>
                        <th>Penalité</th>
                        <th>Temps final</th>
                    </tr>
                    </thead>
                    @php
                        if (!function_exists('convertToSeconds')) {
                        function convertToSeconds($time) {
                            list($hours, $minutes, $seconds) = explode(':', $time);
                                    return $hours * 3600 + $minutes * 60 + $seconds;
                                }
                            }

                            if (!function_exists('convertToTimeString')) {
                                function convertToTimeString($totalSeconds) {
                                    $hours = floor($totalSeconds / 3600);
                                    $minutes = floor(($totalSeconds % 3600) / 60);
                                    $seconds = $totalSeconds % 60;
                                    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                                }
                            }
                    @endphp
                    <tbody>
                    @foreach($etape as $etapes)
                        @php
                            $difference_heure_seconds = convertToSeconds($etapes->difference_heure);
                            $penaltie_seconds = convertToSeconds($etapes->penaltie);
                            $total_seconds = $difference_heure_seconds + $penaltie_seconds;
                            $total_time = convertToTimeString($total_seconds);
                        @endphp
                        <tr>
                            <td>{{ $etapes->rang_coureur }}</td>
                            <td>{{ $etapes->nom }}</td>
                            <td>{{ $etapes->genre }}</td>
                            <td>{{ $etapes->difference_heure }}</td>
                            <td>{{ $etapes->penaltie }}</td>
                            <td>{{ $total_time }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination justify-content-center mt-4">
                {{ $etape->appends(request()->input())->links() }}
            </div>
        </div>
    </div>

@endsection


