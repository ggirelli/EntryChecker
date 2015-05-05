
<h2>
	Compilando questo modulo potrai vendere ulteriori biglietti,<br/>
	fai attenzione perché è <u>irreversibile</u>!
</h2>

<form class="saleForm">
	<input class="form-control" type="text" placeholder="Inserisci il numero del biglietto" ng-model="saleTmp.number" />
	<input type="text" class="form-control" placeholder="Inserisci il nominativo" ng-model="saleTmp.name" />
	<input type="password" class="form-control" placeholder="Password di amministrazione" ng-model="saleTmp.pwd" />

	<button class="btn btn-reddish btn-block" ng-click="sale()">Vendi</button>
</form>

<button class="btn btn-aqua btn-block" ng-click="page.set(1)">Indietro</button>
