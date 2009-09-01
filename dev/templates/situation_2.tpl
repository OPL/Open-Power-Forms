<?xml version="1.0" ?>
<opt:extend file="base.tpl">
  <opt:snippet name="title">Situation 2</opt:snippet>
  <opt:snippet name="content">
    <opf:form name="form1">
     <opt:section name="default">
      <opt:component from="$default.component" template="widget">
      </opt:component>
     </opt:section>
	 <input type="submit" value="Submit" />
    </opf:form>
  </opt:snippet>
</opt:extend>