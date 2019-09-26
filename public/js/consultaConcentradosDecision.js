function borrarInputConsecutivo() {
	var inputConsecutivo = document.getElementById('consecutivoConcentrado');
	inputConsecutivo.value = "";
}

function DecisionAdicional(estado) {

	var inputConsecutivo = document.getElementById('consecutivoConcentrado');
	var decision = estado;

	var objeto = {
		consecutivo: inputConsecutivo.value,
		decision: decision
	}
	var ajax = new XMLHttpRequest();
	ajax.open("GET", "http://201.236.212.130:82/intranetcercafe/public/admin/decisionAdicional?data=" + encodeURIComponent(JSON.stringify(objeto)), true);
	ajax.setRequestHeader("Content-Type", "application/json");
	ajax.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			location.reload();
		}
	}
	ajax.send();

}