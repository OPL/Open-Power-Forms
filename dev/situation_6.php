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
		$item->addFilter(new Opf_Filter_Sample());
		$item->addValidator(new Opf_Validator_Type(Opf_Validator_Type::INTEGER));
		$item->getWidget()
			->setLabel('Integer value');

		$item = $this->itemFactory('countries');
		$item->setRequired(true);
		$item->addValidator(new Opf_Validator_Type(Opf_Validator_Type::INTEGER), 'The field type is invalid.');
	} // end onInit();

	// An event
	public function onRender()
	{
		$view = $this->getView();

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
	public function onAccept()
	{
		$view = $this->getView();
		$view->setTemplate('results.tpl');
		$results = array();
		foreach($this->getValue() as $name => $value)
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

	$view = new Opt_View('situation_6.tpl');
	$view->devFile = 'situation_6.php';

	$form = new My_Form('form6');
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