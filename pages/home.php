<h1 class="title" class="col-sm-8 col-sm-offset-2">Get Inside!</h1>

<form class="ticket-input input-group col-sm-8 col-sm-offset-2" ng-submit="enter()">
	<span class="input-group-addon">R</span>
	<input class="form-control" type="number" placeholder="Inserisci il numero del biglietto" name="r-ticket" id="r-ticket" ng-model='rTicket.value' ng-disabled="ticket.is()" />
	<span class="input-group-addon btn btn-default" ng-click="rTicket.reset()" ng-disabled="ticket.is()"><span class="glyphicon glyphicon-remove"></span></span>
</form>

<form class="ticket-input input-group col-sm-8 col-sm-offset-2" ng-submit="enter()">
	<input class="form-control" type="number" placeholder="Inserisci il numero del biglietto" name="ticket" id="ticket" ng-model="ticket.value" ng-disabled="rTicket.is()" />
	<span class="input-group-addon btn btn-default" ng-click="ticket.reset()" ng-disabled="rTicket.is()"><span class="glyphicon glyphicon-remove"></span></span>
</form>

<div class="submit col-sm-8 col-sm-offset-2">
	<button class="btn btn-aqua btn-block" ng-click="enter()">
		Inserisci
	</button>
</div>

<div id="menu" class="col-sm-8 col-sm-offset-2">
	<button class="btn btn-reddish btn-block" ng-click="page.set(2)">Vendita</button>
	<button class="btn btn-gold btn-block" ng-click="page.set(3)">Manager</button>
	<button class="btn btn-sky btn-block" ng-click="page.set(4)">Istruzioni</button>
</div>
