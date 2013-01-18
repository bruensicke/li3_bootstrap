<ul class="{{^class}}nav{{/class}}{{#class}}{{ class }}{{/class}}{{#active}} active{{/active}}">
	{{#items}}
		<li class="{{#class}} {{ class }}{{/class}}{{#active}} active{{/active}}">
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
	{{/items}}
</ul>
