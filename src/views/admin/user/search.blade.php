@extends('adm_theme::layouts.app')
@section('page_heading','cerca')
@section('section')
@include('includes.flash')
@include('includes.components')
<?php
$routename=Request::route()->getName();	
?>
{{-- $routename --}}
{{ Form::open(['route' => $routename]) }}
{{ method_field('POST') }}
{!! csrf_field() !!}
{{ Form::bsText('handle') }}
{{ Form::bsText('cognome') }}
{{ Form::bsText('nome') }}
{{ Form::bsSubmit('vai') }}
{!! Form::close() !!}
@endsection