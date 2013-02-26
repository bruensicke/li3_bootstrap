<ul class="nav{{^class}} nav-tabs{{/class}}{{#class}} {{ class }}{{/class}}{{#active}} active{{/active}}"{{#id}} id="{{ id }}"{{/id}}>
	{{#right}}
		<li class="pull-right">{{{ right }}}</li>
	{{/right}}
	{{#tabs}}
		<li class="{{#class}}{{ class }}{{/class}}{{#active}} active{{/active}}">
			{{#url}}
				<a href="{{ url }}"{{#tab}} data-toggle="tab"{{/tab}}>
			{{/url}}
				{{#icon}}
					<i class="icon-{{ icon }}"></i>
				{{/icon}}
				{{#name}}
					{{ name }}
				{{/name}}
			{{#url}}
				</a>
			{{/url}}
		</li>
	{{/tabs}}
</ul>
<div class="tab-content">
	{{#panes}}
		<div class="tab-pane{{#class}} {{ class }}{{/class}}{{#active}} active{{/active}}"{{#id}} id="{{ id }}"{{/id}}>
			{{{ content }}}
		</div>
	{{/panes}}
</div>