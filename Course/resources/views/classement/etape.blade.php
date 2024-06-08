<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="text-center">
                <h1>ETAPE COURSE</h1>
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
                    <th>N° Etape</th>
                    <th>Nom</th>
                    <th>Voir classemnt</th>
                </tr>
                </thead>
                <tbody>
                @foreach($etape as $etapes)
                    <tr>
                        <td>{{ $etapes->rang }}</td>
                        <td>{{ $etapes->nom }}</td>
                        <td  style="width: 120px">
                            <div class='btn-group'>
                                <a href="{{ route('classement.etape', [$etapes->id]) }}">
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
