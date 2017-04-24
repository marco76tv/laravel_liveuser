@extends('adm_theme::layouts.app')
@section('page_heading','Modifica Gruppi Utente')

@section('section')
@include('includes.flash')
@include('includes.components')
{{-- per update ci vuole id_area .. --}}

{!! Form::bsOpen($rows,'index','store') !!}

{{ Form::bsMultiSelect('group_id',$rows->get(),$rows->first()->full()->get()) }}

{{Form::submit('Salva ed esci',['class'=>'submit btn btn-success green-meadow'])}}

{!! Form::close() !!}

@endsection