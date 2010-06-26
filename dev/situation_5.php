<?php
/**
 * The development test file used in the implementation process.
 *
 * @author Tomasz Jędrzejewski <http://www.zyxist.com/>
 */

require('./init.php');

class SingleForm extends Opf_Form
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
} // end SingleForm;

class GeneralForm extends Opf_Form
{
	public function onInit()
	{
		$this->appendItem($item = new Opf_Repeater(new SingleForm('subform'), 10));
		$item->setMinRequired(3);

		parent::onInit();
	} // end onInit();

	public function onAccept()
	{
		$view = $this->getView();
		$view->setTemplate('results2.tpl');
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
	$opf = new Opf_Class($tpl);
	$tpl->sourceDir = './templates/';
	$tpl->compileDir = './templates_c/';
	$tpl->compileMode = Opt_Class::CM_REBUILD;
	$tpl->stripWhitespaces = false;
	$tpl->gzipCompression = false;
	$tpl->register(Opt_Class::PHP_FUNCTION, 'dump', 'var_dump');
	$tpl->setup();

	$translate = new Opc_Translate(new Opc_Translate_Adapter_Ini(array('directory' => './lang/')));
	$translate->setLanguage('en');

	$opf->setTranslationInterface($translate);

	$view = new Opt_View('situation_5.tpl');
	$view->devFile = 'situation_5.php';

	$form = new GeneralForm('form5');
	$form->setView($view);

	$form->execute();

	$output = new Opt_Output_Http;
	$output->render($view);
}
/*catch(Opf_Exception $exception)
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
}*/
catch(Exception $e)
{
	var_dump($e);
}
catch(Opl_Exception $exception)
{
	$handler = new Opl_ErrorHandler;
	$handler->display($exception);
}