<?xml version="1.0" ?>
<opt:extend file="base.tpl" xmlns:opt="http://invenzzia.org/opt" xmlns:opf="http://invenzzia.org/opf">
  <opt:snippet name="title">Situation 6</opt:snippet>
  <opt:snippet name="content">
	{$design.form.valid is 'form'}
	{$design.field.valid is 'row'}
	{$design.field.invalid is 'row row-error'}
	{$design.input is 'inputText'}
    <opf:form name="form6">
	 <div class="errors" opt:if="not $system.form.valid"><p>The form is invalid.</p></div>

	 <opf:input name="title" template="widget">
	<!--	 <opt:set str:name="label" str:value="Title" /> -->
     </opf:input>

	 <opf:select name="countries" template="widget">
		 <opt:set name="str:label" value="str:Countries" />
     </opf:select>

	 <input type="submit" value="Submit" />
    </opf:form>
  </opt:snippet>
</opt:extend>