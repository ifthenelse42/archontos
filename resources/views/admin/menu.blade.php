<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
	<div class="list-group">
		<a href="{{ url('admin/index') }}" class="list-group-item @if(Request::segment(2) == 'index') active disabled @endif">Index</a>
		<a href="{{ url('admin/membre') }}" class="list-group-item @if(Request::segment(2) == 'membre') active @endif">Gestion des membres</a>
		<a href="{{ url('admin/moderation') }}" class="list-group-item @if(Request::segment(2) == 'moderation') active @endif">Gestion des modérateurs</a>
		<a href="{{ url('admin/exclusion') }}" class="list-group-item @if(Request::segment(2) == 'ban') active @endif">Gestion des exclusions</a>
		<a href="{{ url('admin/forum') }}" class="list-group-item @if(Request::segment(2) == 'forum') active @endif">Gestion du forum</a>
		<a href="{{ url('admin/maintenance') }}" class="list-group-item critique">Maintenance du site</a>
	</div>
</div>
