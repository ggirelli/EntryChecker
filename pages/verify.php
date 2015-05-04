
<div class="input-group ticket-filter">
	<input class="form-control" type="text" id="filterNumber" name="filterNumber" ng-model="ticketFilter.number"
		placeholder="Inserisci il numero di un biglietto per cercarlo nella tabella" />
	<span class="input-group-addon btn btn-default" ng-click="ticketFilter.resetNumber()"><span class="glyphicon glyphicon-remove"></span></span>
</div>

<div class="input-group ticket-filter">
	<input class="form-control" type="text" id="filterName" name="filterName" ng-model="ticketFilter.name"
		placeholder="Inserisci un nominativo per cercarlo nella tabella" />
	<span class="input-group-addon btn btn-default" ng-click="ticketFilter.resetName()"><span class="glyphicon glyphicon-remove"></span></span>
</div>



<table class="table">
	<tr>
		<th>Ticket</th>
		<th>Nome</th>
		<th>R</th>
		<th>Entrato</th>
		<th>Opzioni</th>
	</tr>
	<tr ng-repeat="ticket in ticketList | filter:{id: ticketFilter.number, name: ticketFilter.name}">
		<td>{{ticket.id}}</td>
		<td>{{ticket.name}}</td>
		<td>{{ticket.residency}}</td>
		<td>{{ticket.when}}</td>
		<td><a href="" ng-click="setNotEntered(ticket.id, pwd)" class="option_link">Imposta come non entrato</a></td>
	</tr>
</table>

<input class="input-password form-control" type="password" id="password" name="password" ng-model="pwd" placeholder="Password di amministrazione richiesta per operare." />

<button class="btn btn-aqua btn-block" ng-click="page.set(1)">back</button>