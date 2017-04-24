@extends('adm_theme::layouts.app')
@section('page_heading','Modifica Utente')

@section('section')
@include('includes.flash')
@include('includes.components')

<a href="{{route('lu.user.area.index',$params)}}" class="btn btn-small btn-info"  data-toggle="tooltip" title="Aree Utente" >
<i class="fa fa-link fa-fw" aria-hidden="true"></i>&nbsp;</a>

<a href="{{route('lu.user.group.index',$params)}}" class="btn btn-small btn-info"  data-toggle="tooltip" title="Gruppi Utente" >
<i class="fa fa-users fa-fw" aria-hidden="true"></i>&nbsp;</a>


<a href="" class="btn btn-small btn-info"  data-toggle="tooltip" title="Livello Utente">
<i class="fa fa-level-up fa-fw" aria-hidden="true"></i>&nbsp;</a>


{!! Form::bsOpen($row,'update') !!}

{{ Form::bsText('cognome') }}
{{ Form::bsText('nome') }}
{{ Form::bsText('email') }}
{{ Form::bsText('ente') }}
{{ Form::bsText('matr') }}
{{ Form::bsText('passwd') }}



{{-- Form::bsSelect('giust',null,$row->giust_opts()) --}}

{{Form::submit('Salva ed esci',['class'=>'submit btn btn-success green-meadow'])}}
{!! Form::close() !!}

@endsection


