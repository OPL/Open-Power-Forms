<?xml version="1.0" ?>
<opt:root>
<opt:snippet name="widget">
  <com:div>
    <opt:onEvent name="error">
	  <opt:section name="errors" datasource="$system.component.errors">
      <p class="error">{$errors}</p>
	  </opt:section>
    </opt:onEvent>
    <label for="">{$system.component.label}</label>
    <opt:display />
  </com:div>
</opt:snippet>
<html>
  <head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><opt:insert snippet="title" /> - Open Power Forms</title>

    <link rel="stylesheet" type="text/css" href="design/generic.css"  />
    <!--[if lte IE 6]><link rel="stylesheet" href="design/ie.css" type="text/css" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="design/ie7.css" type="text/css" /><![endif]-->	
  </head>
  <body>
    <h1><opt:insert snippet="title" /></h1>

    <opt:insert snippet="content">
	<p>No form loaded.</p>

    </opt:insert>
  </body>
</html>
</opt:root>