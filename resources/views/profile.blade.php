@extends('layouts.app')

@section('content')
<ul class="breadcrumb no-border no-radius b-b b-light pull-in"> 
	<li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Accueil</a></li>
	<li class="active"> Mon compte</a></li>
</ul> 

<div class="m-b-md"> 
	<h3 class="m-b-none">Mon compte utilisateur</h3> 
</div>

<!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css"-->
<script src="{{ asset('js/jquery-1.9.1.min.js') }}"></script>
<script src="{{ asset('js/dropzone.js') }}"></script>

<style type="text/css">
.dz-preview, .dz-file-preview {
    display: none;
}
</style>
<script type="text/javascript">
        Dropzone.options.dropzone =
         {
			 paramName: "file",
			  disablePreview: true,
			  capture: null,
			  dictDefaultMessage: "Choisir une photo",
            maxFilesize: 1,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
               return time+file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: false,
            timeout: 5000,
            success: function(file, response) 
            {
                // alert(response);
				this.removeFile(file);
				$('#myphoto').attr('src',"images/"+response);
            },
            error: function(file, response)
            {
               return false;
            }
};

</script>

<section class="panel panel-default"> 
	<!--header class="panel-heading"> Mon profil utilisateur</header--> 
	
	<div class="panel-body">
		<!--div class="row">
			<div class="col-md-12 lead">Informations personnelles<hr></div>
		</div-->
		<div class="row">
			<div class="col-md-4 text-center">
				
				<div class="wrapper">
					<div class="panel wrapper panel-info">
						<div class="text-center bg-info">
							@if(File::exists('images/'. $user->photo ) && !is_dir('images/'. $user->photo) )
							<img id="myphoto" class="col-md-12 rounded img-responsive"
							src="{{ asset('images/'. $user->photo ) }}">
							@else
							<img id="myphoto" class="col-md-12 rounded img-responsive" src="{{ asset('images/avatar.jpg') }}"/>
							@endif
						</div>
						<div class="col-md-12 text-center">
						</div>
						
						<div class="row">
							<br style="clear:both;"/> 
							<!--a href="{{route('update_photo')}}" class=" rounded btn btn-sm btn-warning">Modifier la photo</a-->
							
							<form method="post" action="{{route('UpdatePhoto')}}" enctype="multipart/form-data" class="dropzone" id="dropzone">
								{!! csrf_field() !!}
								<div class="dz-message  rounded btn btn-sm btn-warning" data-dz-message><span>Modifier la photo</span></div>
							</form>   
						</div>

					</div> 
					
					@if($user->profil_id !=4) 
					<div class="panel wrapper panel-info">
						<div class="text-center bg-info">Ma signature</div>
						<div class="text-center">
							@if(!empty($user->signature))
							<img class="" src="data:image/jpeg;base64,{{ Stdfn::KHLOE_DECRYPT($user->signature) }}" style="height:130px;"/>
							@endif
						</div>
					</div> 
					@endif
					
				</div>
				
			</div>
			
			<div class="col-md-8 bordered">
				
				
				<div class="list-group radius"> 
					<span class="list-group-item"> 
						<span class="badge bg-light">{{ $user->nom . ' ' . $user->prenoms}}</span> 
						<i class="fa fa- icon-muted"></i> Nom & Prénoms 
					</span>
					<span class="list-group-item"> 
						<span class="badge bg-light">{{ $user->email }}</span> 
						<i class="fa fa- icon-muted"></i> Login 
					</span> 
					<span class="list-group-item"> 
						<span class="badge bg-light">Profil {{ $user->profil_id . ' : ' . $user->profil_libelle }}</span> 
						<i class="fa fa- icon-muted"></i> Profil 
					</span> 
					<span class="list-group-item"> 
						<span class="badge bg-light">{{ $user->adresse_email }}</span> 
						<i class="fa fa- icon-muted"></i> E-mail 
					</span> 
					<span class="list-group-item"> 
						<span class="badge bg-light">{{ $user->telephone }}</span> 
						<i class="fa fa- icon-muted strong"></i> Téléphone 
					</span>
					@if($user->profil_id !=4) 
					<span class="list-group-item"> 
						<span class="badge bg-light">{{ $user->service_nom }}</span> 
						<i class="fa fa- icon-muted"></i> Département/Service 
					</span>
					<span class="list-group-item"> 
						<span class="badge bg-light">{{ $user->direction_nom }}</span> 
						<i class="fa fa- icon-muted"></i> Direction 
					</span>
					@endif
					<span class="list-group-item" href="#"> 
						<span class="badge bg-light">{{ Stdfn::dateTimeFromDB($user->created_at) }}</span> 
						<i class="fa fa- icon-muted"></i> Date d'enregistrement 
					</span> 
					<span class="list-group-item" href="#"> 
						<span class="badge bg-success">{{ $user->statut }}</span> 
						<i class="fa fa- icon-muted"></i> Statut 
					</span> 
				</div>
				
			</div>
		</div>
		
		
	</div>
	
</section>

@endsection