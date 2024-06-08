<div class="form-group col-sm-6">
    {!! Form::label('etape', 'Etape:')!!}
    {!! Form::select('etape', $etape->pluck('nom', 'id')->toArray(), null,['class' => 'form-control', 'required']) !!}
</div>


<div class="form-group col-sm-6">
    {!! Form::label('equipe', 'Equipe:') !!}
    {!! Form::select('equipe', $equipe->pluck('name', 'id')->toArray(), null,['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('penalite', 'Temps penlaité:') !!}
    {!! Form::time('penalite', null, ['class' => 'form-control', 'required', 'placeholder' => 'HH:mm:ss', 'step' => '1'])!!}
</div>

