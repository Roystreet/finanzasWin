<!-- Id Field -->
<!-- <div class="form-group col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $auditoria->id !!}</p>
</div> -->


<div class="form-group col-sm-4">
    {!! Form::label('user_type', 'Tipo de Usuario:') !!}
    <p>{!! $auditoria->user_type !!}</p>
</div>

<div class="form-group col-sm-4">
    {!! Form::label('user_id', 'Usuario:') !!}
    <p>{!! ($auditoria->user_id)? mb_strtoupper($auditoria->userModified->username) : '' !!}</p>
</div>

<div class="form-group col-sm-4">
    {!! Form::label('ip_address', 'IP:') !!}
    <p>{!! $auditoria->ip_address !!}</p>
</div>

<div class="form-group col-sm-4">
    {!! Form::label('event', 'Evento:') !!}
    <p>{!! $auditoria->event !!}</p>
</div>

<div class="form-group col-sm-4">
    {!! Form::label('auditable_type', 'Model/Table:') !!}
    <p>{!! $auditoria->auditable_type !!}</p>
</div>

<div class="form-group col-sm-4">
    {!! Form::label('url', 'URL/Pagina:') !!}
    <p>{!! $auditoria->url !!}</p>
</div>

<div class="form-group col-sm-4">
    {!! Form::label('user_agent', 'Agente:') !!}
    <p>{!! $auditoria->user_agent !!}</p>
</div>

<div class="form-group col-sm-4">
    {!! Form::label('tags', 'Tags:') !!}
    <p>{!! $auditoria->tags !!}</p>
</div>

<div class="form-group col-sm-4">
    {!! Form::label('auditable_id', 'ID/Campo:') !!}
    <p>{!! $auditoria->auditable_id !!}</p>
</div>
<div class="form-group col-sm-12">
    {!! Form::label('old_values', 'Campos/Anteriores:') !!}
    <p>{!! $auditoria->old_values !!}</p>
</div>
<div class="form-group col-sm-12">
    {!! Form::label('new_values', 'Campos/Actuales:') !!}
    <p>{!! $auditoria->new_values !!}</p>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('created_at', 'Creado:') !!}
    <p>{!! $auditoria->created_at !!}</p>
</div>
