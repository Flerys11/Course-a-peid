
<div class="form-group col-sm-6">
    {!! Form::label('nom', 'Nom:') !!}
    {!! Form::text('nom', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('longueur', 'Longueur:') !!}
    {!! Form::text('longueur', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('nb_courreur', 'Nombre courreur:') !!}
    {!! Form::number('nb_courreur', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('rang', 'Rang:') !!}
    {!! Form::number('rang', null, ['class' => 'form-control', 'required']) !!}
</div>
