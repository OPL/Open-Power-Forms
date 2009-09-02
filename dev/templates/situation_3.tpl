<?xml version="1.0" ?>
<opt:extend file="base.tpl">
  <opt:snippet name="title">Situation 3</opt:snippet>
  <opt:snippet name="content">
    <opf:form name="form1">
	 <p opt:if="not $system.form.valid">The form is invalid.</p>

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