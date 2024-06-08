@extends('base')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="text-center">
                    <h1>Pinalité equipe</h1>
                </div>
                <br>

                <div class="row mb-2">
                    <div class="col-12 d-flex justify-content-center">
                        <a class="btn btn-primary mx-2" href="{{ route('page.penalite')}}">
                            Ajout Penalité
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="card mr-3">
        <br>



        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Etape</th>
                        <th>Equipe</th>
                        <th>Temps Pénalité</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $datas)
                        <tr>
                            <td>{{ $datas->nom_etape }}</td>
                            <td>{{ $datas->nom_equipe }}</td>
                            <td>{{ $datas->penaltie }}</td>
                            <td  style="width: 120px">
                                {!! Form::open(['route' => 'delete.penalite']) !!}
                                        {!! Form::hidden('etape', $datas->idetape, ['class' => 'form-control', 'required'])!!}
                                        {!! Form::hidden('id', $datas->id, ['class' => 'form-control', 'required'])!!}
                                        {!! Form::hidden('equipe', $datas->iduser, ['class' => 'form-control', 'required'])!!}

                                    {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Est ce que vous est vraiment sur?')"]) !!}
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
{{--            <div class="pagination justify-content-center mt-4">--}}
{{--                {{ $etape->appends(request()->input())->links() }}--}}
{{--            </div>--}}
        </div>
    </div>

@endsection


