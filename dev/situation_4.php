<?php
/**
 * The development test file used in the implementation process.
 *
 * @author Tomasz Jędrzejewski <http://www.zyxist.com/>
 */

require('./init.php');

class MyForm1 extends Opf_Form
{
	public function onInit()
	{
		$item = $this->itemFactory('field1');
		$item->addValidator(new Opf_Validator_Type(Opf_Validator_Type::STRING));
		$item->getWidget()->setLabel('Field 1');
		$item->setRequired(true);
		$item->setWidget(new Opf_Widget_Input);

		$item = $this->itemFactory('field2');
		$item->addValidator(new Opf_Validator_Type(Opf_Validator_Type::STRING));
		$item->getWidget()->setLabel('Field 2');
		$item->setRequired(true);
		$item->setWidget(new Opf_Widget_Input);
	} // end onInit();
} // end MyForm1;

class MyForm2 extends Opf_Form
{
	public function onInit()
	{
		$item = $this->itemFactory('field3');
		$item->addValidator(new Opf_Validator_Type(Opf_Validator_Type::STRING));
		$item->getWidget()->setLabel('Field 3');
		$item->setRequired(true);
		$item->setWidget(new Opf_Widget_Input);

		$item = $this->itemFactory('field4');
		$item->addValidator(new Opf_Validator_Type(Opf_Validator_Type::STRING));
		$item->getWidget()->setLabel('Field 4');
		$item->setRequired(true);
		$item->setWidget(new Opf_Widget_Input);
	} // end onInit();
} // end MyForm2;

class MyForm3 extends Opf_Form
{
	public function onInit()
	{
		$item = $this->itemFactory('field5');
		$item->addValidator(new Opf_Validator_Type(Opf_Validator_Type::STRING));
		$item->getWidget()->setLabel('Field 5');
		$item->setRequired(true);
		$item->setWidget(new Opf_Widget_Input);

		$item = $this->itemFactory('field6');
		$item->addValidator(new Opf_Validator_Type(Opf_Validator_Type::STRING));
		$item->getWidget()->setLabel('Field 6');
		$item->setRequired(true);
		$item->setWidget(new Opf_Widget_Input);
	} // end onInit();
} // end MyForm3;

class GeneralForm extends Opf_Form_Sequence
{
	public function onInit()
	{
		$this->appendItem(new MyForm1('step1'));
		$this->appendItem(new MyForm2('step2'));
		$this->appendItem(new MyForm3('step3'));
	} // end onInit();

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
} // end GeneralForm;

try
{
	$tpl = new Opt_Class;
	$opf = new Opf_Class;
	$tpl->sourceDir = './templates/';
	$tpl->compileDir = './templates_c/';
	$tpl->compileMode = Opt_Class::CM_REBUILD;
	$tpl->stripWhitespaces = false;
	$tpl->setup();

	$translate = new Opc_Translate(new Opc_Translate_Adapter_Ini(array('directory' => './lang/')));
	$translate->setLanguage('en');

	$opf->setTranslationInterface($translate);

	$view = new Opt_View('situation_4.tpl');
	$view->devFile = 'situation_4.php';

	$form = new GeneralForm('form4');
	$form->setView($view);

	$form->execute();

	$output = new Opt_Output_Http;
	$output->render($view);
}
catch(Exception $e)
{
	var_dump($e);
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
catch(Opc_Exception $exception)
{
	$handler = new Opc_ErrorHandler;
	$handler->display($exception);
}
catch(Opl_Exception $exception)
{
	$handler = new Opl_ErrorHandler;
	$handler->display($exception);
}