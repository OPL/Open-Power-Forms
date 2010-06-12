<?xml version="1.0" ?>
<opt:extend file="base.tpl" xmlns:opt="http://invenzzia.org/opt">
  <opt:snippet name="title">Results</opt:snippet>
  <opt:snippet name="content">
    <p>The form results:</p>
	<opt:section name="results">
		<p>{$results.name} = {dump($results.value)}</p>
	</opt:section>
  </opt:snippet>
</opt:extend>