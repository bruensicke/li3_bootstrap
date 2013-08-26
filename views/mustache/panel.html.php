<div class="panel {{#class}}{{ class }}{{/class}}{{^class}}panel-default{{/class}}">
	{{#heading}}
		<div class="panel-heading">
			<h3 class="panel-title">{{ heading }}</h3>
		</div>
	{{/heading}}
	{{#content}}
		{{ content }}
	{{/content}}
	{{#body}}
		<div class="panel-body">
			{{ body }}
		</div>
	{{/body}}
</div>