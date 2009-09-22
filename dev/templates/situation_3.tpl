<?xml version="1.0" ?>
<opt:extend file="base.tpl">
  <opt:snippet name="title">Situation 3</opt:snippet>
  <opt:snippet name="content">
	{$design.form.valid is 'form'}
	{$design.field.valid is 'row'}
	{$design.field.invalid is 'row row-error'}
	{$design.input is 'inputText'}
    <opf:form name="form1">
	 <div class="errors" opt:if="not $system.form.valid"><p>The form is invalid.</p></div>

	 <opf:input name="title" template="widget">
	<!--	 <opt:set str:name="label" str:value="Title" /> -->
     </opf:input>

	 <opf:select name="countries" template="widget">
		 <opt:set str:name="label" str:value="Countries" />
     </opf:select>

	 <input type="submit" value="Submit" />
    </opf:form>
  </opt:snippet>
</opt:extend>