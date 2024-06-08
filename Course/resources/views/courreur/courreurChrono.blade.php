@extends('base')
@section('content')
    <p></p>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <form method="POST" action="{{route('import.point')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row align-items-center">
                        <div class="col-auto">
                            <div class="form-group">
                                <label for="file" class="sr-only">Point :</label>
                                <input type="file" class="form-control" id="file" name="file">
                            </div>
                            <br>
                            <div class="col-form">
                                <button type="submit" class="btn btn-primary">Valider</button>
                            </div>
                        </div>

                    </div>
                </form>
                <div class="text-center">
                    <h2>Liste Courreurs</h2>
                </div>

                <br>
            </div>
        </div>
    </section>
    <div class="card mr-3">
        <div class="card-body p-0">
            <div class="mt-4 ml-4">
                <p class="text-dark text-center"><strong>Etape : {{ $nom_etape->nom }}</strong></p>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>N° Dossard</th>
                        <th>Nom</th>
                        <th>Age</th>
                        <th>Genre</th>
                        <th>Equipe</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    @php
                        use Carbon\Carbon;
                    @endphp
                    <tbody>
                    @foreach($data as $datas)
                        <tr>
                            <td>{{ $datas->numero }}</td>
                            <td>{{ $datas->nom }}</td>
                            <td>{{ Carbon::parse($datas->datanaissance)->age }} ans</td>
                            <td>{{ $datas->genre }}</td>
                            <td>{{ $datas->nom_equipe }}</td>
                            <td  style="width: 120px">
                                <button class="btn btn-success" onclick="modalClick('{{$datas->id}}')">Ajout Temps</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="overlay">
        <div id="popup">
            <div class="">
                <div class="modal-header">
                    <h5 class="modal-title" id="parkingDetailsModalLabel">Temps</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeFormPopup()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_courreur" id="id_courreur" value="">
                    <div class="form-group">
                        <label>Depart </label>
                        {{--                        <input type="time" step="any" class="form-control" name="depart" id="depart">--}}
                        <input type="datetime-local" step="1" class="form-control" id="depart" name="depart" value="{{$depart}}">
                    </div>
                    <div class="form-group">
                        <label>Arrivée</label>
                        <input type="datetime-local" step="1" class="form-control" name="arrivee" id="arrivee" placeholder="HH:mm:ss">
                    </div>

                    <div id="error-message" style="color: red;"></div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" onclick="submitForm()">Valider</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script async>
        function modalClick(id) {
            var id_courreur = document.getElementById('id_courreur');
            id_courreur.value = id;
            document.getElementById('overlay').style.display = 'flex';
        }

        function closeFormPopup(){
            document.getElementById('overlay').style.display = 'none';
        }

        function submitForm(){
            var depart = document.getElementById('depart');
            var id_courreur = document.getElementById('id_courreur');
            var arrivee = document.getElementById('arrivee');
            var dataForm = {
                '_token' : '{{ csrf_token() }}',
                'depart' : depart.value,
                'id_courreur' : id_courreur.value,
                'arrivee' : arrivee.value,
            }
            var jsonData = JSON.stringify(dataForm);
            console.log(jsonData);

            $.ajax({
                url : "{{ route('insert.time') }}",
                type : "POST",
                data : jsonData,
                contentType: "application/json; charset=utf-8",
                dataType : "json",
                success: function (data){
                    if (data.message) {
                        closeFormPopup();
                        location.reload();
                    } else if (data.error) {
                        console.log(data.error);
                        document.getElementById('error-message').innerHTML = data.error;
                    }
                },

                error : function (xhr, status, errorThrown){
                    document.getElementById('error-message').innerHTML = data.error
                }
            });
        }
    </script>

@endsection
