
$(document).ready(function() {
	
	function getCurrentDateTime(){
		
		var today = new Date();
		var date = today.getFullYear()+'-'+pad(today.getMonth()+1)+'-'+pad(today.getDate());
		var time = pad(today.getHours()) + ":" + pad(today.getMinutes()) + ":" + pad(today.getSeconds());
		
		var dateTime = date+' '+time;
		
		return dateTime;
	}

	
	
	//UTILISATION DES COOKIES
	function setCookie(cname, cvalue, exdays) {
		
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires="+d.toUTCString();

		// règle le pb des caractères interdits
		if ('btoa' in window) {
			cvalue = btoa(cvalue);
		}

		document.cookie = cname + "=" + cvalue + "; " + expires+';path=/';
		
	}
	
	function getCookie(cname) {
		
		var name = cname + "=";
		var ca = document.cookie.split(';');

		for(var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c[0] == ' ') {
				c = c.substring(1);
			}

			if (c.indexOf(name) != -1) {
				if ('btoa' in window) return atob(c.substring(name.length,c.length));
				else return c.substring(name.length,c.length);
			}
		}

		return false;
	}
	
	
	function saveCart(inCartItemsNum, cartArticles) {
		
		setCookie('inCartItemsNum', inCartItemsNum, 5);
		
		setCookie('cartArticles', JSON.stringify(cartArticles), 5);
		
		$('#in-cart-items-num').html(cartArticles.length);
		
		location.href="panier";
		notificationSuccess('Article ajouté au panier avec succès !');
		
	}
	
	

	// affiche/cache les éléments du panier selon s'il contient des produits
	function cartEmptyToggle() {
		if (inCartItemsNum > 0) {
			$('#cart-dropdown .hidden').removeClass('hidden');
			$('#empty-cart-msg').hide();
		}

		else {
			$('#cart-dropdown .go-to-cart').addClass('hidden');
			$('#empty-cart-msg').show();
		}
	}

	
	$('.btnAddPanier').on('click', function(){
		
		var item = {
			id: $(this).attr('data-livre_id'),
			prix: $(this).attr('data-livre_prix'),
			nom: $(this).attr('data-livre_nom'),
			description: $(this).attr('data-livre_description'),
			couverture: $(this).attr('data-livre_couverture'),
		}
		
		// récupération des infos du produit
		// var $this = $(this);
		var id = item.id;
		var name = item.nom;
		var price = item.prix;
		var weight = item.id;;
		var url = item.couverture;;
		var qt = 1;
		inCartItemsNum = parseInt($('#in-cart-items-num').text());;

		// mise à jour du nombre de produit dans le widget
		$('#in-cart-items-num').html(inCartItemsNum);

		var newArticle = true;

		// vérifie si l'article est pas déjà dans le panier
		cartArticles.forEach(function(v) {
			// si l'article est déjà présent, on incrémente la quantité
			if (v.id == id) {
				newArticle = false;
				v.qt += qt;
				// $('#'+ id).html('<a href="'+ url +'">'+ name +'<br><small>Quantité : <span class="qt">'+ v.qt +'</span></small></a>');
			}
		});

		// s'il est nouveau, on l'ajoute
		if (newArticle) {
			
			// $('#cart-dropdown').prepend('<li id="'+ id +'"><a href="'+ url +'">'+ name +'<br><small>Quantité : <span class="qt">'+ qt +'</span></small></a></li>');

			cartArticles.push({
				id: id,
				name: name,
				price: price,
				weight: weight,
				qt: qt,
				url: url
			});
			
		}

		// sauvegarde le panier
		saveCart(inCartItemsNum, cartArticles);

		// affiche le contenu du panier si c'est le premier article
		cartEmptyToggle();
		
	});
	
	
	// variables pour stocker le nombre d'articles et leurs noms
	var inCartItemsNum;
	var cartArticles;
	
	// récupère les informations stockées dans les cookies
	inCartItemsNum = parseInt(getCookie('inCartItemsNum') ? getCookie('inCartItemsNum') : 0);
	cartArticles = getCookie('cartArticles') ? JSON.parse(getCookie('cartArticles')) : [];

	cartEmptyToggle();

	// affiche le nombre d'article du panier dans le widget
	$('#in-cart-items-num').html(cartArticles.length);

	// hydrate le panier
	var items = '';
	cartArticles.forEach(function(v) {
		items += '<option data-icon="flag-icon flag-icon-fr">'+ v.name +' ('+ v.price +')</option>';
	   // items += '<li id="'+ v.id +'"><a href="'+ v.url +'">'+ v.name +'<br><small>Prix : <span class="qt">'+ v.price +'</span></small></a></li>';
	});

	// $('#cart-dropdown').prepend(items);


	
//RENDU SUR LA PAGE DU PANIER
// si on est sur la page ayant pour url monsite.fr/panier/

// if (window.location.pathname == '/reussiteconcours/public/panier' ) {
    var items = '';
    var subTotal = 0;
    var total;
    var weight = 0;

    /* on parcourt notre array et on créé les lignes du tableau pour nos articles :
    * - Le nom de l'article (lien cliquable qui mène à la fiche produit)
    * - son prix
    * - la dernière colonne permet de modifier la quantité et de supprimer l'article
    *
    * On met aussi à jour le sous total et le poids total de la commande
    */
    cartArticles.forEach(function(v) {
        // opération sur un entier pour éviter les problèmes d'arrondis
        
		items += '<tr data-id="'+ v.id +'">\
             <td><img src="'+ v.url +'" style="width:100px;"/></td>\
             <td><a href="'+ v.url +'">'+ v.name +'</a></td>\
             <td width="150" align="center" class="font-weight-900">'+ v.price +' FCFA</td><td align="center"><a href="javascript:void(0)" class="delete-item btn btn-circle btn-danger btn-xs" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash"></i></a></td></tr>';
        
		subTotal += parseInt(v.price);
        
		
    });

    // on reconverti notre résultat en décimal
    // subTotal = subTotal * 1;

    // On insère le contenu du tableau et le sous total
    $('#cart-tablebody').empty().html(items);
    $('.subtotal').html(subTotal);
    $('#cartArticlesCount').html(cartArticles.length);

	
    // suppression d'un article
    $('.delete-item').click(function() {
        var $this = $(this);
        var qt = parseInt($this.prevAll('.qt').html());
        var id = $this.parent().parent().attr('data-id');
        var artWeight = parseInt($this.parent().parent().attr('data-weight'));
        var arrayId = 0;
        var price;

        // maj qt
        inCartItemsNum -= qt;
        $('#in-cart-items-num').html(inCartItemsNum);

        // supprime l'item du DOM
        $this.parent().parent().hide(600);
        $('#'+ id).remove();

        cartArticles.forEach(function(v) {
            // on récupère l'id de l'article dans l'array
            if (v.id == id) {
                // on met à jour le sous total et retire l'article de l'array
                // as usual, calcul sur des entiers
                subTotal -= parseInt(v.price);
                
                cartArticles.splice(arrayId, 1);

                return false;
            }

            arrayId++;
        });

        $('.subtotal').html(subTotal);
        saveCart(inCartItemsNum, cartArticles);
        cartEmptyToggle();
    });
	
	
	$('#btnAnnulerCommande').click(function() {
		
		setCookie('inCartItemsNum', 0, 5);
		
		setCookie('cartArticles', "", 5);
		
		$('#in-cart-items-num').html(0);
		
		notificationSuccess('Commande annulée avec succès!');
		
		location.href = '../public';
	
	});
	
	
	$('#btnConfirmerCommandeD').click(function() {
		
		$.ajax({
			url:'post',
			type:'post',
			data:data,
			success:function(e){
				if(e == 1){
					
				}else{
						
				}
			},
			error:function(){
				
			},
		});
	
	});
	
	
// }




//NOTY
function notificationSuccess(text){
	
	noty({
		dismissQueue: false,
		force: true,
		layout:'center',
		modal: true,
		theme: 'defaultTheme',
		text:text,
		type: 'success',
		buttons: [{addClass: 'btn btn-info ', text: 'OK', onClick: function($noty) {
		   $noty.close();
		  
		   }}]
	});
}

function notificationWarning(text){
	
	noty({
		dismissQueue: false,
		force: true,
		layout:'center',
		modal: true,
		theme: 'defaultTheme',
		text:text,
		type: 'warning',
		buttons: [{addClass: 'btn btn-info ', text: 'OK', onClick: function($noty) {
		   $noty.close();
		  
		   }}]
	});
}

function notificationError(text){
	
	noty({
		dismissQueue: false,
		force: true,
		layout:'center',
		modal: true,
		theme: 'defaultTheme',
		text:text,
		type: 'error',
		buttons: [{addClass: 'btn btn-info ', text: 'OK', onClick: function($noty) {
		   $noty.close();
		  
		   }}]
	});
}


	
});


var encryptedAES = 'U2FsdGVkX1+KmVi/EQAfg4vOz8iVl8ewXRuA7uSykHJiWC6/ImqZEXdamCBC7X7VMe3iyu+S4nqqidBcDCeWYA==';

var decryptedBytes 	= CryptoJS.AES.decrypt(encryptedAES, "@RuthK2022");
var apikey 			= decryptedBytes.toString(CryptoJS.enc.Utf8);

			
