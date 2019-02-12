
function sendData(idMusique,action){

	var date = new Date();
	var timestamp = date.getTime();

	$.ajax({
		  // chargement du fichier externe monfichier-ajax.php 
		  url      : "/log.php",
		  // Passage des données au fichier externe (ici le nom cliqué)  
		  data     : 'time=' + timestamp + '&action=' + action+'&idMusique='idMusique,
		  type : 'POST',
		  cache    : false,
		  dataType : "html",
		  error    : function(request, error) { // Info Debuggage si erreur         
					   //alert("Erreur : responseText: "+request.responseText);
					 },
		  success  : function(data) {  
					   // Informe l'utilisateur que l'opération est terminé et renvoie le résultat
						 }       
	});
}
