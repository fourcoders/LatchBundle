Use LatchBundle with FOSUserBundle
==================================

You can override some template of FOSUserBundle and redirect to the path of LatchBundle. For example:

```html
	{# app / Resources / FOSUserBundle / views / Registration / confirmed.html.twig #}
	{% extends "FOSUserBundle::layout.html.twig" %}

	{% trans_default_domain 'FOSUserBundle' %}

	{% block fos_user_content %}
		<script type="text/javascript">
			window.location = '{{ path('fourcoders_latch_register') }}'
		</script>
	{% endblock fos_user_content %}	
```