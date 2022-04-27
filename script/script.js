// Registering Service Worker
/*if ('serviceWorker' in navigator) {
	navigator.serviceWorker.register('./sw.js')
	.then(function(registration){
		console.log("funfou: ", registration.scope);
	})
	.catch(function(error){
		console.log("deu ruim: ", error)
	})
}*/

// MENU TABELA OQ GASTOU NO DIA MENU DE ACOES
$(document).on("click", "#acao_mob", function(e) {
	e.preventDefault();
	$(this).prev().toggleClass("show_acao_mob");
});

$(document).on("click", "#close_acao_mob", function(e) {
	e.preventDefault();
	$(this).parent().toggleClass("show_acao_mob");
});
// MENU TABELA OQ GASTOU NO DIA MENU DE ACOES