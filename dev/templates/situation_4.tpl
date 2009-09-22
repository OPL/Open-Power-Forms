<?xml version="1.0" ?>
<opt:extend file="base.tpl">
  <opt:snippet name="title">Situation 4</opt:snippet>
  <opt:snippet name="content">
	{$design.form.valid is 'form'}
	{$design.field.valid is 'row'}
	{$design.field.invalid is 'row row-error'}
	{$design.input is 'inputText'}
    <opf:form name="form1">
	 <div class="errors" opt:if="not $system.form.valid"><p>The form is invalid.</p></div>
     <opt:section name="default">
      <opt:component from="$default.component" template="widget">
      </opt:component>
     </opt:section>
	 <input type="submit" value="Submit" />
    </opf:form>
  </opt:snippet>
</opt:extend>