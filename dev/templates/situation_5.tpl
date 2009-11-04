<?xml version="1.0" ?>
<opt:extend file="base.tpl">
  <opt:snippet name="title">Situation 5</opt:snippet>

  <opt:snippet name="content">
	<!-- configure CSS styles for the elements -->
	{$design.form.valid is 'form'}
	{$design.field.valid is 'row'}
	{$design.field.invalid is 'row row-error'}
	{$design.input is 'inputText'}

	<!-- display a form -->
    <opf:form name="form5">
	<table border="1">
		<thead>
			<th opt:section="labels">{$labels.label}</th>
		</thead>
		<tbody>
			<tr opt:section="subform">
			<opf:form from="$subform">
				<td><opf:input name="field1"><opt:display /></opf:input></td>
				<td><opf:input name="field2"><opt:display /></opf:input></td>
			</opf:form>
			</tr>
		</tbody>
	</table>

	<!-- some final stuff -->
	<input type="submit" value="Submit" />
    </opf:form>
  </opt:snippet>
</opt:extend>