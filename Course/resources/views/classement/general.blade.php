<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="text-center">
                <h1>CLASSEMENT GENERAL</h1>
            </div>
            <strong> Trie par : {{ $trie }}</strong>
            <br>
            <form action="{{ route('trie.general') }}" method="POST">
                @csrf
                <div class="form-group">
                    <select class="form-control w-25" name="trie" onchange="this.form.submit()">
                        <option value="">Trie categorie</option>
                        @foreach($genre as $genres)
                            <option value="{{ $genres->nom }}">{{ $genres->nom }}</option>
                        @endforeach
                        @foreach($cate as $cates)
                            <option value="{{ $cates->nom }}">{{ $cates->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        @if(Auth::check())
            @if(Auth::user()->role === 'admin')
                <div class="row mb-2">
                    <div class="col-12 d-flex justify-content-center">
{{--                        tene ete--}}
                        <a class="btn btn-primary mx-2" href="{{ route('genarete.pdf')}}">
                            winner
                        </a>
                    </div>
                </div>
            @endif
        @endif
    </div>
</section>
<div class="container mt-5">
    <div class="row">
        <!-- Colonne pour le tableau -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table" id="table">
                            <thead>
                            <tr>
                                <th>Rang</th>
                                <th>Equipe</th>
                                <th>Points</th>
                                <th>Action</th>
                            </tr>
                            @php
                                $rangCounts = [];
                                foreach ($global as $globals) {
                                    if (!isset($rangCounts[$globals->rang_equipe])) {
                                        $rangCounts[$globals->rang_equipe] = 0;
                                    }
                                    $rangCounts[$globals->rang_equipe]++;
                                }

                            @endphp
                            </thead>
                            <tbody>
                            @foreach($global as $globals)
                                @php
                                    $textColor = 'black';
                                    if ($rangCounts[$globals->rang_equipe] > 1) {
                                        $textColor = 'blue';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $globals->rang_equipe }}</td>
                                    <td>{{ $globals->nom_equipe }}</td>
                                    <td style="width: 120px; color: {{ $textColor }}">{{ $globals->points_equipe }}</td>
                                    <td  style="width: 120px">
                                        <div class='btn-group'>
                                            <a href="{{ route('equipe.c', [$globals->idequipe]) }}">
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
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body p-0">
                    <canvas id="myChart" width="10" height="10"></canvas>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var globalData = <?php echo json_encode($global);?>;
</script>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');

    var labels = globalData.map(function(globals) {
        return globals.nom_equipe;
    });

    function generateRandomColor(value) {
        let r = Math.floor(Math.random() * 128);
        let g = Math.floor(Math.random() * 128);
        let b = Math.floor(Math.random() * 128);

        let rgb = `rgb(${r}, ${g}, ${b})`;

        return rgb;
    }



    var data = globalData.map(function(globals) {
        return { value: globals.points_equipe, color: generateRandomColor(globals.points_equipe) };
    });

    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data.map(item => item.value),
                backgroundColor: data.map(item => item.color),
            }]
        },
        options: {}
    });


</script>


