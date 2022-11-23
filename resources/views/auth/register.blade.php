@extends('layouts.app')

@section('content')
<ul class="breadcrumb no-border no-radius b-b b-light pull-in"> 
	<li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Accueil</a></li> 
	<li class="active">Inscription</li> 
</ul> 

<div class="m-b-md"> 
	<h3 class="m-b-none">Formulaire d'inscription</h3> 
</div>

@if(Session::has('message'))
	<div class="alert alert-success">
	  {{Session::get('message')}}
	</div>
@endif

@if (!empty($errors))
	<!--div class="alert alert-danger">
		VEUILLEZ RENSEIGNER CORRECTEMENT LE FORMULAIRE
		<br/>
		<ul>
		@foreach($errors as $error)
			<li>{{$error}}</li>
		@endforeach
		</ul>
	</div-->
@endif

<div class="panel panel-default"> 

	<div class="wizard-steps clearfix" id="form-wizard"> 
		<ul class="steps"> 
			<li data-target="#step3"><span class="badge"></span>Informations</li>
		</ul> 
	</div> 

	<div class="step-content clearfix"> 
		
		 
	
	</div>
	
	
	
	
	
</div>
 
@endsection