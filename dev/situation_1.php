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
		$item->addValidator(new Opf_Validator_MinLength(5), 'The length is invalid');
		$item->setWidget(new Opf_Widget_Input)
			->setLabel('Title');

		$item = $this->itemFactory('countries');
		$item->setRequired(true);
		$item->addValidator(new Opf_Validator_Type(Opf_Validator_Type::INTEGER), 'The field type is invalid.');
		$item->setWidget(new Opf_Widget_Select)
			->setLabel('Countries');
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
	$opc = new Opc_Class;
	$tpl = new Opt_Class;
	$opf = new Opf_Class($tpl);
	$tpl->sourceDir = './templates/';
	$tpl->compileDir = './templates_c/';
	$tpl->compileMode = Opt_Class::CM_REBUILD;
	$tpl->stripWhitespaces = false;
	$tpl->gzipCompression = false;
	$tpl->setup();

	$translate = new Opc_Translate(new Opc_Translate_Adapter_Ini(array('directory' => './lang/')));
	$translate->setLanguage('en');

	$opf->setTranslationInterface($translate);

	$view = new Opt_View('situation_1.tpl');
	$view->devFile = 'situation_1.php';

	$form = new My_Form('form1');
	$form->setView($view);

	$form->execute();

	$output = new Opt_Output_Http;
	$output->render($view);
}
//catch(Exception $e)
//{
//	ob_end_flush();
//	var_dump($e);
//}
catch(Opl_Exception $exception)
{
	$handler = new Opf_ErrorHandler;
	$handler->addPort(new Opf_ErrorHandler_Port);
	$handler->addPort(new Opt_ErrorHandler_Port);
	$handler->display($exception);
}