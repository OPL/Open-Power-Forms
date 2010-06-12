<?xml version="1.0" ?>
<opt:extend file="base.tpl" xmlns:opt="http://invenzzia.org/opt" xmlns:opf="http://invenzzia.org/opf">
  <opt:snippet name="title">Situation 1</opt:snippet>

  <opt:snippet name="content">
	<!-- configure CSS styles for the elements -->
	{$design.form.valid is 'form'}
	{$design.field.valid is 'row'}
	{$design.field.invalid is 'row row-error'}
	{$design.input is 'inputText'}
	<!-- display a form -->
    <opf:form name="form1">
	 <div class="errors" opt:if="not $system.form.valid"><p>The form is invalid.</p></div>

	 <!-- load the components assigned to the "default" placeholders -->
     <opt:section name="default">
      <opt:component from="$default.component" template="widget" />
     </opt:section>

	 <!-- some final stuff -->
	 <div class="row row-submit">
        <input type="submit" class="inputSubmit" value="Submit" id="parse:'form1:submit'"/>
    </div>
    </opf:form>
  </opt:snippet>
</opt:extend>