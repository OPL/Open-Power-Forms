<?xml version="1.0" ?>
<opt:root>
<opt:snippet name="widget">
  <com:div>
    <p>{$system.component.label}</p>
    <opt:display />
    <opt:onEvent name="error">
	  <opt:section name="errors" datasource="$system.component.errors">
      <p class="error">{$errors}</p>
	  </opt:section>
    </opt:onEvent>
  </com:div>
</opt:snippet>
<html>
  <head>
    <title><opt:insert snippet="title" /> - Open Power Forms</title>
  </head>
  <body>
    <h1><opt:insert snippet="title" /></h1>

    <opt:insert snippet="content">
	<p>No form loaded.</p>

    </opt:insert>
  </body>
</html>
</opt:root>