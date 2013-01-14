<?php
namespace li3_bootstrap\extensions\helper;

use lithium\util\Set;
use lithium\util\Inflector;

class Nav extends \lithium\template\Helper {

	protected $_strings = array(
		'ul' => '<ul{:options}>{:raw}</ul>',
		'li' => '<li{:options}><a href="{:link}"{:tab}>{:icon} {:name}</a></li>',

		'select' => '<ul{:options}>{:raw}</ul>',
		'select-option' => '<li{:options}><a href="{:link}"{:tab}>{:icon} {:name}</a></li>',
	);

	public function __construct(array $config = array()) {
		$self =& $this;

		$defaults = array(
			'base' => array(),
			'text' => array(),
			'textarea' => array(),
			'select' => array('multiple' => false),
			'attributes' => array(
				'id' => function($method, $name, $options) use (&$self) {
					if (in_array($method, array('create', 'end', 'label', 'error'))) {
						return;
					}
					if (!$name || ($method == 'hidden' && $name == '_method')) {
						return;
					}
					return 'foo';
					// $info = $self->binding($name);
					// $model = $info->class;
					// $id = Inflector::camelize(Inflector::slug($info->name));
					// return $model ? basename(str_replace('\\', '/', $model)) . $id : $id;
				},
				'name' => function($method, $name, $options) {
					if (!strpos($name, '.')) {
						return $name;
					}
					$name = explode('.', $name);
					$first = array_shift($name);
					return $first . '[' . join('][', $name) . ']';
				}
			),
		);
		parent::__construct(Set::merge($defaults, $config));
	}
	/**
	 * Object initializer. Adds a content handler for the `wrap` key in the `field()` method, which
	 * converts an array of properties to an attribute string.
	 *
	 * @return void
	 */
	protected function _init() {
		parent::_init();

		if ($this->_context) {
			$this->_context->handlers(array('wrap' => '_attributes'));
		}
	}


	public function render($links) {
		return $this->select('foo', $links);
	}


	public function select($name, $list = array(), array $options = array()) {
		$defaults = array('empty' => false, 'value' => null);
		list($name, $options, $template) = $this->_defaults(__FUNCTION__, $name, $options);
		list($scope, $options) = $this->_options($defaults, $options);

		if ($scope['empty']) {
			$list = array('' => ($scope['empty'] === true) ? '' : $scope['empty']) + $list;
		}
		if ($template == __FUNCTION__ && $scope['multiple']) {
			$template = 'select-multi';
		}
		$raw = $this->_selectOptions($list, $scope);
		return $this->_render(__METHOD__, $template, compact('name', 'options', 'raw'));
	}

	protected function _selectOptions(array $list, array $scope) {
		$result = "";

		foreach ($list as $value => $item) {
			// var_dump($item);exit;
			if (isset($item['children']) && is_array($item['children'])) {
				$label = $value;
				$options = array();

				$raw = $this->_selectOptions($item, $scope);
				$params = compact('label', 'options', 'raw', 'icon', 'link', 'name');
				$result .= $this->_render('select', 'select', $params);
				continue;
			}
			$selected = (
				(is_array($scope['value']) && in_array($value, $scope['value'])) ||
				($scope['empty'] && empty($scope['value']) && $value === '') ||
				(is_scalar($scope['value']) && ((string) $scope['value'] === (string) $value))
			);
			extract($item);
			$options = $item;
			$params = compact('value', 'title', 'options', 'name', 'icon');
			$result .= $this->_render('select', 'select-option',  $params);
		}
		return $result;
	}



// $base = $this->url('/');
// $here = $this->request()->url;
// $template = '<li class="{:active}"><a href="{:link}"{:tab}>{:icon} {:name}</a></li>';
// foreach ($links as $item) {
// 	$defaults = array('active' => '', 'white' => '', 'link' => '', 'tab' => false, 'icon' => false);
// 	$item['active'] = ($item['link'] == $here || !empty($item['active'])) ? 'active' : '';
// 	$item['white'] = ($item['link'] == $here) ? 'icon-white' : '';
// 	$item['link'] = $this->url($item['link']); # "$base{$item['link']}";
// 	$item['icon'] = (!empty($item['icon'])) ? '<i class="icon-'.$item['icon'].' '.$item['icon'].'"></i>' : '';
// 	$item['tab'] = (!empty($item['tab'])) ? ' data-toggle="tab"' : '';
// 	$item += $defaults;
// 	echo lithium\util\String::insert($template, $item);
// }


	/**
	 * Retrieve admin navigation either from cache or from navigation.
	 * @return Array an array containing whole navigation
	 */
	public function get(){
		$cache = $this->_classes['cache'];
		$key = md5('dashboard').'.admin.nav';
		$nav = $cache::read('default', $key);
		if ($nav) {
			return $nav;
		}

		$nav = $this->_getItems();
		$cache::write('default', $key, $nav, '+15 minutes');
		return $nav;
	}
	/**
	 * returns all menu items defined in config json file
	 * @return array
	 */
	protected function _getItems() {
		$libraries = $this->_classes['libraries'];
		$items = array();
		foreach ($libraries::get() as $name => $config) {
			if ($name === 'lithium') {
				continue;
			}
			$file = "{$config['path']}/{$this->_navigationFile}";
			$json = file_exists($file) ? file_get_contents($file) : null;
			$parsed = $json ? json_decode($json, true) : null;
			$parsed ? $items = array_merge_recursive($parsed, $items) : null;
		}
		//$items = $this->_weight($items);
		return $this->_processItems($items);
	}

	protected function _weight($items) {
		usort($items, function($a, $b){
			if ($a['weight'] == $b['weight']) {
				return 0;
			}
			return ($a['weight'] < $b['weight']) ? -1 : 1;
		});
		return $items;
	}

	protected function _processItems($items) {
		$defaults = array(
			'title' => null,
			'link' => true,
			'weight' => 10,
			'params' => array(),
			'children' => array(),
		);
		$processed = array();
		$items = $this->_weight($items);
		foreach ($items as $key => $item) {
			if(!empty($item['children'])) $item['children'] = $this->_processItems($item['children']);
			$processed[] = $item + $defaults;
		}
		return $processed;
	}


	/**
	 * Allows you to configure a default set of options which are included on a per-method basis,
	 * and configure method template overrides.
	 *
	 * To force all `<label />` elements to have a default `class` attribute value of `"foo"`,
	 * simply do the following:
	 *
	 * {{{
	 * $this->form->config(array('label' => array('class' => 'foo')));
	 * }}}
	 *
	 * Note that this can be overridden on a case-by-case basis, and when overriding, values are
	 * not merged or combined. Therefore, if you wanted a particular `<label />` to have both `foo`
	 * and `bar` as classes, you would have to specify `'class' => 'foo bar'`.
	 *
	 * You can also use this method to change the string template that a method uses to render its
	 * content. For example, the default template for rendering a checkbox is
	 * `'<input type="checkbox" name="{:name}"{:options} />'`. However, suppose you implemented your
	 * own custom UI elements, and you wanted to change the markup used, you could do the following:
	 *
	 * {{{
	 * $this->form->config(array('templates' => array(
	 * 	'checkbox' => '<div id="{:name}" class="ui-checkbox-element"{:options}></div>'
	 * )));
	 * }}}
	 *
	 * Now, for any calls to `$this->form->checkbox()`, your custom markup template will be applied.
	 * This works for any `Form` method that renders HTML elements.
	 *
	 * @see lithium\template\helper\Form::$_templateMap
	 * @param array $config An associative array where the keys are `Form` method names (or
	 *              `'templates'`, to include a template-overriding sub-array), and the
	 *              values are arrays of configuration options to be included in the `$options`
	 *              parameter of each method specified.
	 * @return array Returns an array containing the currently set per-method configurations, and
	 *         an array of the currently set template overrides (in the `'templates'` array key).
	 */
	public function config(array $config = array()) {
		if (!$config) {
			$keys = array('base' => '', 'text' => '', 'textarea' => '', 'attributes' => '');
			return array('templates' => $this->_templateMap) + array_intersect_key(
				$this->_config, $keys
			);
		}
		if (isset($config['templates'])) {
			$this->_templateMap = $config['templates'] + $this->_templateMap;
			unset($config['templates']);
		}
		return ($this->_config = Set::merge($this->_config, $config)) + array(
			'templates' => $this->_templateMap
		);
	}

	/**
	 * Builds the defaults array for a method by name, according to the config.
	 *
	 * @param string $method The name of the method to create defaults for.
	 * @param string $name The `$name` supplied to the original method.
	 * @param string $options `$options` from the original method.
	 * @return array Defaults array contents.
	 */
	protected function _defaults($method, $name, $options) {
		$methodConfig = isset($this->_config[$method]) ? $this->_config[$method] : array();
		$options += $methodConfig + $this->_config['base'];
		$options = $this->_generators($method, $name, $options);

		$hasValue = (
			(!isset($options['value']) || $options['value'] === null) &&
			$name && $value = 'bar'
		);
		$isZero = (isset($value) && ($value === 0 || $value === "0"));
		if ($hasValue || $isZero) {
			$options['value'] = $value;
		}
		if (isset($options['value']) && !$isZero) {
			$isZero = ($options['value'] === 0 || $options['value'] === "0");
		}
		if (isset($options['default']) && empty($options['value']) && !$isZero) {
			$options['value'] = $options['default'];
		}
		unset($options['default']);

		$generator = $this->_config['attributes']['name'];
		$name = $generator($method, $name, $options);

		$tplKey = isset($options['template']) ? $options['template'] : $method;
		$template = isset($this->_templateMap[$tplKey]) ? $this->_templateMap[$tplKey] : $tplKey;
		return array($name, $options, $template);
	}

	/**
	 * Iterates over the configured attribute generators, and modifies the settings for a tag.
	 *
	 * @param string $method The name of the helper method which was called, i.e. `'text'`,
	 *               `'select'`, etc.
	 * @param string $name The name of the field whose attributes are being generated. Some helper
	 *               methods, such as `create()` and `end()`, are not field-based, and therefore
	 *               will have no name.
	 * @param array $options The options and HTML attributes that will be used to generate the
	 *              helper output.
	 * @return array Returns the value of the `$options` array, modified by the attribute generators
	 *         added in the `'attributes'` key of the helper's configuration. Note that if a
	 *         generator is present for a field whose value is `false`, that field will be removed
	 *         from the array.
	 */
	protected function _generators($method, $name, $options) {
		foreach ($this->_config['attributes'] as $key => $generator) {
			if ($key == 'name') {
				continue;
			}
			if ($generator && !isset($options[$key])) {
				if (($attr = $generator($method, $name, $options)) !== null) {
					$options[$key] = $attr;
				}
				continue;
			}
			if ($generator && $options[$key] === false) {
				unset($options[$key]);
			}
		}
		return $options;
	}

}
?>