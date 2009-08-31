<?php
/**
 * The development test file used in the implementation process.
 *
 * @author Tomasz Jędrzejewski <http://www.zyxist.com/>
 */

require('./init.php');

class My_Form extends Opf_Form
{
	// An event
	public function onInit()
	{
		$item = $this->itemFactory('title');
		$item->setRequired(true);
		$item->addValidator(new Opf_Validator_Length(5), 'The length is invalid');
		$item->setWidget(new Opf_Widget_Input);

		$item = $this->itemFactory('countries');
		$item->setRequired(true);
		$item->addValidator(new Opf_Validator_Type(Opf_Validator_Type::INTEGER), 'The field type is invalid.');
		$item->setWidget(new Opf_Widget_Select);
	} // end onInit();

	// An event
	public function onRender()
	{
		$view = $this->getView();
		$view->setFormat('default', 'Form/Form');
		$item = $this->itemFactory('countries');
		$item->getWidget()->setOptions(array(0 =>
			'China',
			'France',
			'Germany',
			'Great Britain',
			'Poland',
			'Russia',
			'Spain',
			'United States'
		));
	} // end onRender();

	// An event
	public function onValidate()
	{
		return true;
	} // end onValidate();

	// An event
	public function onAccept()
	{
		$view = $this->getView();
		$view->setTemplate('results.tpl');
		$results = array();
		foreach($this->getValues() as $name => $value)
		{
			$results[] = array('name' => $name, 'value' => $value);
		}
		$view->results = $results;
	} // end onAccept();
} // end MyForm;

try
{
	$tpl = new Opt_Class;
	$opf = new Opf_Class;
	$tpl->sourceDir = './templates/';
	$tpl->compileDir = './templates_c/';
	$tpl->compileMode = Opt_Class::CM_REBUILD;
	$tpl->setup();	

	$view = new Opt_View('situation_1.tpl');
	$view->devFile = 'situation_1.php';

	$form = new My_Form('form1');
	$form->setView($view);

	$form->execute();

	$output = new Opt_Output_Http;
	$output->render($view);
}
catch(Opf_Exception $exception)
{
	$handler = new Opf_ErrorHandler;
	$handler->display($exception);
}
catch(Opt_Exception $exception)
{
	$handler = new Opt_ErrorHandler;
	$handler->display($exception);
}
catch(Opl_Exception $exception)
{
	$handler = new Opl_ErrorHandler;
	$handler->display($exception);
}