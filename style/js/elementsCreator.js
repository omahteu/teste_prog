var selected = new Array();
var tableId;

/**
 * Função que principal que adiciona os elementos
 */
function addElement(element) {
	// Adiciona elemnto ao array
	selected.push(element);

	addTableElement(element);
}

function removeElement(element) {
	// Pega o indice do elemento
	var index = selected.indexOf(element);

	if (index > -1) {
		selected.splice(index, 1);

		removeTableElement(element);
	}
}

function addTableElement(element) {
	tableId.append(element);
}

function removeTableElement(trElementId) {
	trElementId.remove();
}