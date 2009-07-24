<?xml version="1.0" ?>
<opt:root>
<opt:snippet name="widget">
  <com:div>
    <p>{$system.component.title}</p>
    <opt:display />
    <opt:onEvent name="error">
      <p class="error">{$system.component.error}</p>
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
	<p>No form loaded.

    </opt:insert>
  </body>
</html>
</opt:root>