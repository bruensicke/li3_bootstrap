<div class="panel {{#class}}{{ class }}{{/class}}{{^class}}panel-default{{/class}}">
	{{#heading}}
		<div class="panel-heading">
			{{ heading }}
		</div>
	{{/heading}}
	{{#title}}
		<div class="panel-heading">
			<h3 class="panel-title">{{ title }}</h3>
		</div>
	{{/title}}
	{{#content}}
		{{ content }}
	{{/content}}
	{{#body}}
		<div class="panel-body">
			{{ body }}
		</div>
	{{/body}}
	{{#footer}}
		<div class="panel-footer">{{ footer }}</div>
	{{/footer}}
</div>