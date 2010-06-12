<?xml version="1.0" ?>
<opt:root xmlns:opt="http://invenzzia.org/opt" xmlns:opf="http://invenzzia.org/opf">
<opt:snippet name="widget">
  <div opt:component-attributes="default">
    <opt:on-event name="error">
	  <opt:section name="errors" datasource="$system.component.errors">
      <p class="error">{$errors}</p>
	  </opt:section>
    </opt:on-event>
    <label for="">{$system.component.label} <opt:on-event name="required"><sup>*</sup></opt:on-event></label>
    <opt:display />
  </div>
</opt:snippet>
<html>
  <head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><opt:use snippet="title" /> - Open Power Forms</title>

    <link rel="stylesheet" type="text/css" href="design/generic.css"  />
    <!--[if lte IE 6]><link rel="stylesheet" href="design/ie.css" type="text/css" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="design/ie7.css" type="text/css" /><![endif]-->	
  </head>
  <body>
    <h1><opt:use snippet="title" /></h1>

    <opt:use snippet="content">
	<p>No form loaded.</p>

    </opt:use>
  </body>
</html>
</opt:root>