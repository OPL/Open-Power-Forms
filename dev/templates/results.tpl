<?xml version="1.0" ?>
<opt:extend file="base.tpl">
  <opt:snippet name="title">Results</opt:snippet>
  <opt:snippet name="content">
    <p>The form results:</p>
	<opt:section name="results">
		<p>{$results.name} = {$results.value}</p>
	</opt:section>
  </opt:snippet>
</opt:extend>