<?php

namespace li3_bootstrap\extensions\helper;

use lithium\util\Set;
use lithium\util\Inflector;
use lithium\core\Libraries;

class Form extends \lithium\template\helper\Form {

	/**
	 * String templates used by this helper.
	 *
	 * @var array
	 */
	protected $_strings = array(
		'button'         => '<button{:options}>{:title}</button>',
		'checkbox'       => '<input type="checkbox" name="{:name}"{:options} />',
		'checkbox-multi' => '<input type="checkbox" name="{:name}[]"{:options} />',
		'checkbox-multi-group' => '{:raw}',
		'error'          => '<span class="help-inline">{:content}</span>',
		'errors'         => '{:raw}',
		'input'          => '<input type="{:type}" name="{:name}"{:options} />',
		'file'           => '<input type="file" name="{:name}"{:options} />',
		'form'           => '<form action="{:url}"{:options} role="form">{:append}',
		'form-end'       => '</form>',
		'hidden'         => '<input type="hidden" name="{:name}"{:options} />',
		'field'          => '<div{:wrap}>{:label}<div class="controls">{:input}{:error}</div></div>',
		'field-checkbox' => '<div{:wrap}>{:input}<div class="controls">{:label}{:error}</div></div>',
		'field-radio'    => '<div{:wrap}>{:input}<div class="controls">{:label}{:error}</div></div>',
		'label'          => '<label for="{:id}" class="control-label"{:options}>{:title}</label>',
		'legend'         => '<legend>{:content}</legend>',
		'option-group'   => '<optgroup label="{:label}"{:options}>{:raw}</optgroup>',
		'password'       => '<input type="password" name="{:name}"{:options} />',
		'radio'          => '<input type="radio" name="{:name}"{:options} />',
		'select'         => '<select name="{:name}"{:options}>{:raw}</select>',
		'select-empty'   => '<option value=""{:options}>&nbsp;</option>',
		'select-multi'   => '<select name="{:name}[]"{:options}>{:raw}</select>',
		'select-option'  => '<option value="{:value}"{:options}>{:title}</option>',
		'submit'         => '<input type="submit" value="{:title}"{:options} />',
		'submit-image'   => '<input type="image" src="{:url}"{:options} />',
		'text'           => '<input type="text" name="{:name}"{:options} />',
		'textarea'       => '<textarea name="{:name}"{:options}>{:value}</textarea>',
		'fieldset'       => '<fieldset{:options}><legend>{:content}</legend>{:raw}</fieldset>',

		'money'          => '<div class="input-prepend"><span class="add-on">$</span><input type="text" name="{:name}"{:options} /></div>',
		'date'           => '<input type="text" data-date-format="yyyy-mm-dd" class="date-field" name="{:name}"{:options} />',
		'submit-button'  => '<button type="submit"{:options}>{:name}</button>'
	);

	/**
	 * Sets up defaults and passes to parent to setup class.
	 *
	 * @param  array $config Configuration options.
	 * @return void
	 */
	public function __construct(array $config = array()) {
		$defaults = array(
			'base' => array('class' => 'form-control'),
		);
		parent::__construct(Set::merge($defaults, $config));
	}

	public function button($title = null, array $options = array()) {
		if (isset($options['icon'])) {
			$icon = $options['icon'];
			$title = sprintf('<i class="icon-%s"></i> %s', $icon, $title);
			$options['escape'] = false;
		}
		return parent::button($title, $options);
	}

	public function create($bindings = null, array $options = array()) {
		$result = parent::create($bindings, $options);
		if ($this->_binding) {
			$model = $this->_binding->model();
			$this->model = $model;
			$this->instance = Libraries::instance('model', $model);
			$this->schema = $model::schema();
			$this->rules = $this->instance->validates;
		}
		return $result;
	}

	public function end() {
		unset($this->model);
		unset($this->instance);
		unset($this->schema);
		unset($this->rules);
		return parent::end();
	}

	public function field($name, array $options = array()) {
		$meta = (isset($this->schema) && is_object($this->schema)) ? $this->schema->fields($name) : array();

		if (!isset($options['wrap'])) {
			$options['wrap'] = array();
		}
		if (!isset($options['wrap']['class'])) {
			$options['wrap']['class'] = '';
		}
		$options['wrap']['class'] .= ' form-group';
		if (isset($meta['required']) && $meta['required']) {
			$options['required'] = true;
			$options['wrap']['class'] .= ' required';
		}

		if ($this->_binding) {
			$errors = $this->_binding->errors();
			if (isset($errors[$name])) {
				$options['wrap']['class'] .= ' has-error';
			}
		}

		# Auto-populate select-box lists from validation rules or methods
		if (isset($options['type']) and $options['type'] == 'select' and !isset($options['list'])) {
			$options = $this->_autoSelects($name, $options);
		}
		return parent::field($name, $options);
	}

	protected function _autoSelects($name, array $options = array()) {
		$rules = $this->instance->validates;

		if (isset($rules[$name])) {
			if (is_array($rules[$name][0])) {
				$rule_list = $rules[$name];
			} else {
				$rule_list = array($rules[$name]);
			}

			foreach ($rule_list as $rule) {
				if ($rule[0] === 'inList' and isset($rule['list'])) {
					foreach ($rule['list'] as $optval) {
						$options['list'][$optval] = Inflector::humanize($optval);
					}
				}
			}
		}
		return $options;
	}
}