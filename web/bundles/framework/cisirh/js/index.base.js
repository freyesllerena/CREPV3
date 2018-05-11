function App_calendrier(){
	// transforme le champ dateCommission en calendrier datePicker
    $('.date-picker').daterangepicker({
    	format: 'DD/MM/YYYY',
        locale: {
               applyLabel: 'Submit',
               cancelLabel: 'Clear',
               fromLabel: 'From',
               toLabel: 'To',
               customRangeLabel: 'Custom',
               daysOfWeek: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
               monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
               firstDay: 1
             },
         singleDatePicker: true,
         calender_style: "picker_3"
       }, function(start, end, label) {
         
       }
    );
}

function App_calendrier_campagne(){
	// transforme le champ dateCommission en calendrier datePicker
	var date = new Date();
	var formattedDate = moment(date).format('DD/MM/YYYY');
	$('.date-picker-campagne').daterangepicker({
			format: 'DD/MM/YYYY',
			minDate: formattedDate,
			locale: {
				applyLabel: 'Submit',
				cancelLabel: 'Clear',
				fromLabel: 'From',
				toLabel: 'To',
				customRangeLabel: 'Custom',
				daysOfWeek: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
				monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
				firstDay: 1
			},
			singleDatePicker: true,
			calender_style: "picker_3"
		}, function(start, end, label) {
			
		}
	);
}


// flashbag pour les messages de notification
function notification(message){
	var stack_topright = {"dir1": "down", "dir2": "left", "firstpos1": 70, "firstpos2": 50};
	new PNotify({
		text: message,
		type: 'success',
		styling: 'bootstrap3',
		addclass: "stack-topright",
        stack: stack_topright,
		delay: 2000 + message.length*10
	});
}

// flashbag pour les messages d'erreur
function alert(message){
	var stack_topright = {"dir1": "down", "dir2": "left", "firstpos1": 70, "firstpos2": 50};
	new PNotify({
		text: message,
		type: 'error',
		styling: 'bootstrap3',
		addclass: "stack-topright",
		stack: stack_topright,
		delay: 5000 + message.length*10
	});
}
   
  
function information(event, titre, message){
	
	var stack_center = {"dir1": "down", "dir2": "right", "firstpos1": event.clientY, "firstpos2": event.clientX};
    
	new PNotify({
		title: titre,
		text: message,
		type: 'info',
		styling: 'bootstrap3',
		addclass: "stack-center",
        stack: stack_center,
        delay: 5000 + message.length*10
	});
}

function App_dataTable(){
	$(".app_datatable").DataTable({
		
		"oLanguage": oLanguage_fr(),

});

}

function App_dataTable_disable_feature(){
	$(".app_datatable_disable_feature").DataTable({
		  "oLanguage": oLanguage_fr(),
//	scrollX : true,  // Si on le met à false, l'entête de colonne ne suit pas le scroll
		  "bFilter": false,
	        "paging":   false,
	        "ordering": false,
	        "info":     false

});

}

function app_datatable_without_defaultSort() {
	$(".app_datatable_without_defaultSort").DataTable({

		"order": [],
		"oLanguage": oLanguage_fr(),
	});
}

function App_file_upload(maxFileSize){

	$(".file-loading").fileinput({
    	language:'fr',
    	 showPreview: false,
    	 maxFileSize: maxFileSize*1000,
    	 allowedFileExtensions: ["csv"],
    	 elErrorContainer: "#errorBlock",
    	 showUpload: false
        	});
}

function App_file_upload_campagne(maxFileSize){
	$(".documents input:not(.hide)").fileinput({
	language:'fr',
	 showPreview: false,
	 maxFileSize: maxFileSize*1000,
	 allowedFileExtensions: ["csv","pdf","xls","xlsx","doc","docx","odt","ods", "ppt", "pptx", "odp"],
	 elErrorContainer: "#errorBlock",
	 showUpload: false
});

}

function App_flash_enveloppe(){
	setInterval(function () {
        $('.btn_motif').fadeIn('300').fadeOut('300').fadeIn('300')
    }, 1500);

}

// fonction pour plusieur bouton
function App_modal_sweet_many_buttton(title, text, type, confirm, cancel, callback ){

		var options = {
            title: title,
            type: type,
            html: text,
            animation: false,
            showCancelButton: true,
            confirmButtonColor: "#26B99A",
            confirmButtonText: confirm,
            cancelButtonText: cancel,
            closeOnConfirm: false,
            closeOnCancel: true
         };


        swal(options).then(callback).done();

}

// fonction pour un seul bouton (class="sweet")
function App_modal_sweet(title, text, type, confirm, cancel, callback ){

	function eventOuvrir(){
		var options = {
            title: title,
            type: type,
            html: text,
            animation: false,
            showCancelButton: true,
            confirmButtonColor: "#26B99A",
            confirmButtonText: confirm,
            cancelButtonText: cancel,
            closeOnConfirm: false,
            closeOnCancel: true
         };

        swal(options).then(callback);
	}

	$('.sweet').click(eventOuvrir);
}


//fonction pour une information (class="sweet_info")
function App_modal_sweet_info(title, text, type, cancel ){

		var options = {
            title: title,
            type: type,
            html: text,
            showConfirmButton: false,
            animation: false,
            showCancelButton: true,
            cancelButtonText: cancel,
            closeOnCancel: true
         };


        swal(options).done();
}

function autoCompleteFormation(){
	$('.formation-autocomplete').autocomplete({
	    serviceUrl: urlAjax,
	    minChars: 3
	});
}

//fonction appelée lors de l'ajout d'une formation demandeeAgent
function eligibleDifformationAjout(input, select){
	
	if(select.val() == 0){
		input.iCheck('uncheck').prop('disabled', true);
	}
	
	select.on('change', function(){
		if($(this).val() == 0){
			input.iCheck('uncheck').prop('disabled', true);	
		}else{
			input.prop('disabled', false).parent().removeClass('disabled');
		}
	})
}

//Fonction appelée au chargement de la page édition du crep
function eligibleDifFormation(prefixId){
	$('.eligible-dif').each(function( index ) {
		
		input = $('input#'+ prefixId + index +'_dif');
		select = $(this);
		
		eligibleDifformationAjout(input, select);
		
	});
}


// prototype fonction CREP
var Crep = Crep || {};

/**
 * Classe Collections
 * classe permettant la génération de collection pour
 * tous type de formulaire
 *
 * @param {Dom} containerCollection est votre balise ou id qui contient le data-prototype
 * @param {String} containerCollection est votre balise ou id qui contient le data-prototype
 */
function Collections () {

    function Collections() {

    	
        var collectionsPrototypes = $('div.row[data-prototype]');
        var collectionCount = collectionsPrototypes.length, i;
        $('.btn.remove-from-collection').on('click', function(e) {
            e.preventDefault();
            remove(this);
            $('#btnAddObjectifsPasses').show();
            $('#btnAddObjectifsFuturs').show();
        });

        for (i = 0; i < collectionCount; i++) {
            // definir l'index de départ avec le nombre d'élément présent dans la collection
            var collection = $(collectionsPrototypes[i]);
            var index = collection.find("table > tbody > tr").length
            collection.data('index', index);
            var button = findAddButton(collectionsPrototypes[i])
            
            if (button != null) {
                button.on('click', function(e) {
                	e.preventDefault();
                    add(this);
                    
                    // Récupérer l'id de la div qui contient la table du prototype
                	divTableId = $(this).parent().parent().prev().attr('id');
                	
                	// Récupérer la dernière ligne ajoutée
                	lastTr = $("#" + divTableId + " > div > table > tbody > tr:last");

                	autoCompleteFormation();
                    eligibleDifFormation('crep_minef_abc_formationsDemandeesAgent_');
                    eligibleDifFormation('crep_ac_formationsDemandeesAgent_');
                    
                    miseEnformeChamps(lastTr);
//                    setIcheckModel(lastTr);
//                    App_calendrier();
                });
            }
        }
        
    }

    function add(element) {
    	
        var elementCollectionPrototype =  $(element)
            .parent() // remonte au premier noeud parent
            .parent() // remonte au second noeud parent
            .prev();   // prend le précédent noeud frère

        var table = elementCollectionPrototype.find("table")
        if (table.length > 0) {

            var prototype = elementCollectionPrototype.data('prototype');
            var index = elementCollectionPrototype.data('index');
            var _form = prototype.replace(/__name__/g, index);
            elementCollectionPrototype.data('index', index + 1);

            tbody = table.find("tbody"); 
            tbody.append(_form);
            
            //EligibleDif
            var input = $('tr:last input.dif', tbody);
            var select = $('tr:last input.eligible-dif', tbody);
            eligibleDifformationAjout(input, select);
            
            //Mettre à jour l'ensemble des id et name des éléments du prototype
            miseAjourIndex(tbody);
            
            elementCollectionPrototype.on('click', '.btn.remove-from-collection', function(e) {
                e.preventDefault();
                remove(this);
                $('#btnAddObjectifsPasses').show();
                $('#btnAddObjectifsFuturs').show();
            });
        }
    }
    function remove(element) {
    	//Récupérer le tr à supprimer 
    	tr = $(element).closest('tr');
    	tbody = tr.parent();
        tr.remove();
        miseAjourIndex(tbody);
    }
    
    function miseAjourIndex(tbody) {
        var newIndex = 0;
//            //On met à jour les id pour ne pas avoir de décalage entre eux (ex: si on supprime un proto, 
//            //on remet les index depuis 0, 1, 2 ... au lieu de 0,2,6...) pour ne pas avoir de problème avec l'affichage des erreurs validators
        $('tr', tbody).each(function () {
        	$('td:not(:last)', $(this)).each(function () {
        		
    			element = $(this).find('.fieldCollection');
    			
    			//Récupérer le name à mettre à jour 
    			nomAMettreAJour = element.attr('name');
    			//S'il n'y a pas de name donc c'est le bouton remove du prototype, on ne fait rien 
    			if(typeof nomAMettreAJour !== 'undefined'){
	    			tab = nomAMettreAJour.split('['); 
	    			
	    			//Reconstruire le name avec le nouvel indice 
	    			tab[1] = '[' + tab[1];
	    			tab[2] = '[' + newIndex +']';
	    			tab[3] = '[' + tab[3];
	    			//newName = tab[0] + tab[1] + tab[2] + tab[3]
	    			newName = tab.join("");
	    			element.attr('name' , newName);
	    			
	    			//Reconstruire l'id 
	    			tabId = element.attr('id').split('_');
	    			
	    			//On récupère l'index qui est l'avant dernier élement 
	    			tabId[ tabId.length - 2 ] = newIndex;
	    			newId = tabId.join("_")
	    			element.attr('id' , newId);
	        	}
        		
        	})
	            newIndex++;
        })
    }


    /**
     * Permet de recupérer le button ajouter associé au prototype
     *
     *  "<button class="btn btn-primary add_collection_link competencesPostes pull-right">"
     *  "       <i class="fa fa-plus"></i> Ajouter
     *  "</button>"
     *
     * @param {HTMLDivElement} container la div containant le container
     * @return {HTMLDivElement}  retourne le bouton
     */
    function findAddButton(container) {
        var btn = $(container)
            .next()
            .find("button.add_collection_link");

        return (btn.length > 0) ? btn : null;
    }

    /*
     * Fonction qui reçoit un élément <tr> et applique une mise en forme sur les icheck, datePicker et select2 sur ses champs
     * @param tr : element
     * 
     */
    function miseEnformeChamps(tr) {
        // Mise en forme des boutons radio et des checkBox en icheck
    	tr.iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
        
//    	// Mise en forme des select2
//    	tr.find('.select2_single').select2();
//    	
//    	// Mise en forme des datePicker
//    	// transforme le champ dateCommission en calendrier datePicker
//    	tr.find('.date-picker').daterangepicker({
//        	format: 'DD/MM/YYYY',
//            locale: {
//                   applyLabel: 'Submit',
//                   cancelLabel: 'Clear',
//                   fromLabel: 'From',
//                   toLabel: 'To',
//                   customRangeLabel: 'Custom',
//                   daysOfWeek: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
//                   monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
//                   firstDay: 1
//                 },
//             singleDatePicker: true,
//             calender_style: "picker_3"
//           }, function(start, end, label) {
//             
//           }
//        );
//    	
    	
    }
    

    Collections()
}

	function oLanguage_fr(){
		
		return {
		    "sProcessing":     "Traitement en cours...",
			"sSearch":         "Rechercher&nbsp;:",
			"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
			"sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
			"sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
			"sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
			"sInfoPostFix":    "",
			"sLoadingRecords": "Chargement en cours...",
			"sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
			"sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
			"oPaginate": {
				"sFirst":      "Premier",
				"sPrevious":   "Pr&eacute;c&eacute;dent",
				"sNext":       "Suivant",
				"sLast":       "Dernier"
			},
			"oAria": {
				"sSortAscending":  ": activer pour trier la colonne par ordre croissant",
				"sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
			}
		  };
		  
	}

Crep.Collections = Collections;


function initPopover(){
	 /* popover : info-bulles */
    $('[data-toggle="popover"]').popover({
   	 html: true,
   	 template: '<div class="popover popover" style="min-width:300px" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
   	 });
   	 
    $('[data-toggle="popover-info"]').popover({
   	 html: true,
   	 template: '<div class="popover popover-info" style="min-width:300px" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
   	 });

    $('[data-toggle="popover-primary"]').popover({
       	 html: true,
       	 template: '<div class="popover popover-primary" style="min-width:300px" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
       	 });

    $('[data-toggle="popover-success"]').popover({
       	 html: true,
       	 template: '<div class="popover popover-success" style="min-width:300px" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
       	 });

    $('[data-toggle="popover-warning"]').popover({
       	 html: true,
       	 template: '<div class="popover popover-warning" style="min-width:300px" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
       	 });

    $('[data-toggle="popover-danger"]').popover({
       	 html: true,
       	 template: '<div class="popover popover-danger" style="min-width:300px" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
       	 });
}


// Fontion qui permet à un data table de lancer les recherches dans les cas suivants
// - Si le champ de recherche est vide
// - Si le champ de recherche contient moins de 3 caratères et que l'utilsateur appuie sur "Entrée"
// - Après la saisie d'au moins 3 caractères
// - la recherche se fait une seule fois par seconde maximum pour éviter de surcharger le serveur
// exemple :
//		var dtable = $('#mon_dataTable').DataTable();
// 		setAjaxDataTable("#mon_dataTable", dtable);
function setAjaxDataTable(dataTableId, dataTable){
		
    var delay = (function(){
  	  var timer = 0;
  	  return function(callback, ms){
  	    clearTimeout (timer);
  	    timer = setTimeout(callback, ms);
  	  };
  	})();
    
    
    $(dataTableId + "_filter input")
    .unbind() // Pour éviter que la recherche par défaut se fasse
 	.bind('keyup paste', function(e) {
     	
		var e = e;

		if (e.type == 'paste') {
            var value = e.originalEvent.clipboardData.getData('text');
		} else {
            var value = this.value;
		}

		delay(function(){
        	if(value.length == 0 || (e.keyCode == 13 && value.length >0 && value.length < 3)){
        		dataTable.search( value ).draw();
            }
            else{
            	
                if( value.length >= 3 && e.keyCode != 13){
                	dataTable.search( value ).draw();
                }
            }
          }, 1000 );
      });
}

function redimensionnerIframe() {
	var bodyHeight = $BODY.outerHeight(),
	footerHeight = $BODY.hasClass('footer_fixed') ? 0 : $FOOTER.height(),
	leftColHeight = $LEFT_COL.eq(1).height() + $SIDEBAR_FOOTER.height(),
	contentHeight = bodyHeight < leftColHeight ? leftColHeight : bodyHeight;
	
		// normalize content
		contentHeight -= $NAV_MENU.height() + footerHeight;
	
		// redimensionner la iframe qui affiche un crep papier au chargement de la page 
	$iframe = $('.auto-resize-iframe');
	$iframe.css('min-height', contentHeight-footerHeight-120);
}

