@extends('adm_theme::layouts.app')
@section('page_heading','Modifica Aree Utente')

@section('section')
@include('backend::includes.flash')
@include('backend::includes.components')
{{-- per update ci vuole id_area .. --}}

{!! Form::bsOpen($rows,'index','store') !!}

{{ Form::bsMultiSelect('area_id',$rows->get(),$rows->first()->full()->get()) }}

{{Form::submit('Salva ed esci',['class'=>'submit btn btn-success green-meadow'])}}

{!! Form::close() !!}

@endsection