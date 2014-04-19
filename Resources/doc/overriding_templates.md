Overriding templates
====================
As you start to incorporate LatchBundle into your application, you will probably find that you need to override the default templates that are provided by the bundle. This is the a way to override the templates of a bundle.

- Define a new template of the same name in the app/Resources directory
- Override the template for example.

```html
	{# app / Resources / FourcodersLatchBundle / views / Registration / #}
	{% extends "FourcodersDemolatchBundle::layout.html.twig" %}
	{% block body %}

	<section id="forms">
		<form method="post" action="{{ path('fourcoders_latch_register') }}" class="bs-docs-example">
	        <fieldset>
	      	<legend>Register</legend>
			{{ form_widget(form._token) }}
			<div class="latch container_register">
				<table>
					<thead >
						<tr>
							<td colspan="2" style="background-color: #2980b9;">
								<img src="http://localhost:8000/demo-latch-bundle/logo_Latch.png">
							</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="2" {% if error.message != '' %}class="error"{% endif %}>
								<span>{{error.message}}</span>
							</td>
						</tr>
						<tr>
							<td>{{ 'latch_token'|trans }}</td>
							<td>{{ form_widget(form.latch) }}</td>
						</tr>						
					</tbody>
					<tfoot>
						<tr>
							<td>
								<button type="submit" class="btn">{{'latch_pair'|trans}}</button>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			</fieldset>
		</form>
	{% endblock %}
```
