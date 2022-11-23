<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
	<link rel="stylesheet" href="{{asset('css/mail.css')}}"/>
  	<!--
		body{
			width:90%;
			margin:auto;
		}
		.logo{height:80px}
		.container{padding:7px;}

		.titre{
			font-size:20px;
			text-align:center;
			font-weight:bold;
		}
		table{width:100%;border-collapse:collapse;}
		td{border:1px solid #222;padding:5px 7px;}
		th{border:1px solid #222;background:#333;padding:2px 7px;color:white;}

		table.no-border td{border:none;}

		legend{font-weight:bold;padding:5px;}
		label{font-size:11px;}

		.row{margin-top:25px;}
		.tab{padding-left:70px;}
		.center{text-align:center}

		.role{text-align:center;width:140px;}
		.part{text-align:center;width:100px;}
		.signature{text-align:center;}

		#listeAyantsDroits{min-height:400px;}

		@page { margin-top: -1cm;margin-left:0.5cm;margin-right:0.5cm }


		@font-face {
			font-family: 'Elegance';
			font-weight: normal;
			font-style: normal;
			font-variant: normal;
			src: url("http://eclecticgeek.com/dompdf/fonts/Elegance.ttf") format("truetype");
		}

		body {
			font-family: sans-serif, Elegance;
			font-size:12px;
		}

		.th{
			width:155px;
			font-size:10px;
			font-weight:bold;
		}

		.btnConfirmer{
			padding:10px;background:green;color:white;border-radius:4px;
		}

		.btnRejeter{
			padding:10px;
			background:red;
			color:white;
			border-radius:4px;
		}
		-->

		
		<script>
		/*function SelonConfirmation() {
		  if (confirm("Voulez-vous vraiment valider votre part?")) 
		    {
		        return true;
		    } 
		    else 
		    {
		        return false;
		    }
		}*/
		</script>

  </head>
  <body style="font-family: sans-serif, Elegance;font-size:12px;">
    <div>
		<p style="line-height:20px;">
		Bonjour, votre mot de passe est <b>{{$demande->password_generated}}</b><br/>
		<b>BURIDA</b>
		</p>
    </div>
  </body>
</html>
