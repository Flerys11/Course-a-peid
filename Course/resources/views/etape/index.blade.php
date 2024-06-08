@extends('base')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="text-center">
                    <h2>Liste des etapes du course</h2>
                </div>
                <br>
            </div>
        </div>
    </section>
    <div class="card mr-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    @foreach($data as $datas)
                        <tr>
                            <td> <p class="text-dark text-center"><strong>{{ $datas->rang }}.  {{ $datas->nom }} ( courreur : {{ $datas->nb_coureur }} )   {{ $datas->longeur }} km </strong> </p></td>
                            <td>
                                                        <tr>
                                                            <td colspan="5">
                                                                <div class="table-responsive">
                                                                    <table class="table inner-table">
                                                                    <table class="table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>NOM</th>
                                                                            <th>Durée Chrono</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @foreach($datas->chrono as $classe)
                                                                            <tr>
                                                                                <td>{{ $classe->nom }}</td>
                                                                                <td>{{ $classe->duree }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                            </td>
                            <td style="width: 120px">
                                <div class="float-start">
                                    <button class="btn btn-success" onclick="modalClick('{{$datas->id}}', '{{ $datas->nb_coureur }}')">Ajout Coureur</button>
                                </div>
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
                    <h5 class="modal-title" id="parkingDetailsModalLabel">Ajout Coureur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeFormPopup()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="etape_id" id="etape_id" value="">

                        <div class="form-group">
                            <label>Courreur</label>
                            <select class="form-control" name="courreur" id="courreur">
                                @foreach($courreur as $courreurs)
                                    <option value="{{ $courreurs->id }}">{{ $courreurs->nom }} </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="model-select"></div>
                        <div class="mt-1">
                            <button type="button" class="btn btn-success d-inline-block" onclick="addSelectField()">+</button>
                            <button type="button" class="btn btn-danger d-inline-block" onclick="removeSelectField()">-</button>
                        </div>

                    <div id="error-message" style="color: red;"></div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" onclick="submitForm()">Ajouter</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script async>

        let maxCoureurs;


        function addSelectField() {
            var currentSelectCount = document.querySelectorAll(".modal-body select").length;

            if (currentSelectCount >= maxCoureurs) {
                alert('Vous ne pouvez pas ajouter plus de ' + maxSelects + ' coureurs.');
                return;
            }

            var newSelect = document.createElement("select");
            newSelect.className = "form-control";
            newSelect.name = "courreur[]";

            newSelect.id = "courreur" + currentSelectCount;

            var existingOptions = document.getElementById("courreur").options;
            for (var i = 0; i < existingOptions.length; i++) {
                var opt = existingOptions[i];
                var el = document.createElement("option");
                el.text = opt.text;
                el.value = opt.value;
                newSelect.add(el);
            }

            var formGroup = document.createElement("div");
            formGroup.className = "form-group";

            var label = document.createElement("label");
            label.textContent = "Courreur " + (currentSelectCount + 1);

            formGroup.appendChild(label);
            formGroup.appendChild(newSelect);

            document.querySelector(".model-select").appendChild(formGroup);
        }

        function removeSelectField() {
            var formGroups = document.querySelectorAll(".model-select .form-group");

            if (formGroups.length > 0) {
                var lastFormGroup = formGroups[formGroups.length - 1];
                lastFormGroup.remove();
            } else {
                alert('Aucun coureur à supprimer.');
            }
        }


        function modalClick(id, nbCoureurs) {
            maxCoureurs = nbCoureurs;
            var etape_id = document.getElementById('etape_id');
            etape_id.value = id;
            document.getElementById('overlay').style.display = 'flex';
        }

        function closeFormPopup(){
            document.getElementById('overlay').style.display = 'none';
        }

        function submitForm() {
            var etape_id = document.getElementById('etape_id').value;
            var selects = document.querySelectorAll('select[name="courreur[]"]');
            var courreur = document.getElementById('courreur');
            var courreurs = [];

            selects.forEach(function(select) {
                courreurs.push(select.value);
            });

            var dataForm = {
                '_token': '{{ csrf_token() }}',
                'etape_id': etape_id,
                'courreur' : courreur.value,
                'courreurs': courreurs,
                'max' : maxCoureurs
            };

            $.ajax({
                url: "{{ route('insert.courreur') }}",
                type: "POST",
                data: JSON.stringify(dataForm),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(data) {
                    if (data.message) {
                        closeFormPopup();
                    } else if (data.error) {
                        document.getElementById('error-message').innerHTML = data.error;
                    }
                },
                error: function(xhr, status, errorThrown) {
                    document.getElementById('error-message').innerHTML = "An error occurred: " + errorThrown;
                }
            });
        }

    </script>
@endsection
