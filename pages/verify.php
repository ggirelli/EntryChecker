
<div ng-repeat="ticket in ticketList">
	{{ticket.id}}
	{{ticket.name}}
	{{ticket.residency}}
	{{ticket.when}}
</div>

<button class="btn btn-aqua btn-block" ng-click="page.set(1)">back</button>