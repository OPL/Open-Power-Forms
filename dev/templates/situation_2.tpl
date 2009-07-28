<?xml version="1.0" ?>
<opt:extend file="base.tpl">
  <opt:snippet name="title">Situation 1</opt:snippet>
  <opt:snippet name="content">
    <opf:form name="form1">
     <opt:section name="content" datasource="$system.form.content">
      <opt:component from="$content.component" template="widget">
      </opt:component>
     </opt:section>
    </opf:form>
  </opt:snippet>
</opt:extend>