<?php
/**
 * The development test file used in the implementation process.
 *
 * @author Tomasz Jędrzejewski <http://www.zyxist.com/>
 */

require('./init.php');

class My_EventListener extends Opf_EventListener
{
	public function postInit(Opf_Form $form)
	{
		$item = $this->itemFactory('age');
		$item->setRequired(true);
		$item->addValidator(new Opf_Validator_Type(Opf_Validator_Type::INTEGER));
		$item->addValidator(new Opf_Validator_Scope(16, 100));
		$item->setWidget(new Opf_Component_Input);
	} // end postInit();
} // end Opf_EventListener;

class My_Form extends Opf_Form
{
	// An event
	public function onInit()
	{
		$item = $this->itemFactory('title');
		$item->setRequired(true);
		$item->addValidator(new Opf_Validator_Length(3, 100), 'The length is invalid');
		$item->setWidget(new Opf_Component_Input);

		$item = $this->itemFactory('countries');
		$item->setRequired(true);
		$item->addValidator(new Opf_Validator_Type(Opf_Validator_Type::INTEGER), 'The field type is invalid.');
		$item->setWidget(new Opf_Component_Select);
	} // end onInit();

	// An event
	public function onRender()
	{
		$item = $this->itemFactory('countries');
		$item->setOptions(array(0 =>
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

	} // end onValidate();

	// An event
	public function onAccept()
	{
		$view = $this->getView();
		$view->setTemplate('results.tpl');
		$view->data = $form->getValues();
	} // end onAccept();
} // end MyForm;

try
{
	$tpl = new Opt_Class;
	$tpl->sourceDir = './templates/';
	$tpl->compileDir = './templates_c/';
	$tpl->setup();

	$opf = new Opf_Class;

	$view = new Opt_View('situation_2.tpl');
	$view->devFile = 'situation_2.php';

	$form = new My_Form('form1');
	$form->appendListener(new My_EventListener);
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