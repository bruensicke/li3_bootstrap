<?php
namespace li3_bootstrap\extensions\helper;

use lithium\util\Set;
use lithium\util\Inflector;

/**
 * Allows easy rendering of bootstrap tabs
 *
 * requires li3_mustache
 *
 * {{{
 *	$tabs = array(
 *		array(
 *			'url' => '#tab1',
 *			'name' => 'Tab 1',
 *			'icon' => 'dashboard',
 *			'active' => true,
 *			'content' => $this->_render('element', 'tab1'),
 *		),
 *		array(
 *			'url' => '#tab2',
 *			'name' => 'Tab 2',
 *			'icon' => 'users',
 *			'content' => $this->_render('element', 'tab2'),
 *		),
 *		array(
 *			'url' => '#settings',
 *			'name' => 'Settings',
 *			'content' => $this->_render('element', 'settings'),
 *			'class' => 'pull-right',
 *			'tab' => false,
 *		),
 *	);
 *	echo $this->tab->render($tabs);
 * }}}
 *
 *
 */
class Tab extends \lithium\template\Helper {

	public $mustache;

	protected $defaults = array(
		'tab' => array('id' => '', 'class' => '', 'active' => false, 'tab' => true),
		'pane' => array('id' => '', 'content' => '', 'class' => '', 'active' => false),
	);

	public function render($data, $contents = array(), array $options = array()) {
		$this->_mustache();
		$defaults = array('id' => '', 'class' => '', 'hash' => true, 'right' => '');
		$options += $defaults;
		$tabs = $panes = array();
		foreach ($data as $slug => $tab) {
			if (!is_array($tab)) {
				$tab = array('name' => $tab);
			}
			$slug = (is_numeric($slug))
				? strtolower(Inflector::slug($tab['name']))
				: $slug;
			$tab = $this->_tab($tab, array('id' => $slug));

			if (empty($tab['url'])) {
				$tab['url'] = ($options['hash']) ? sprintf('#%s', $slug) : $slug;
			} else {
				$slug = str_replace('#', '', $tab['url']);
			}
			if (isset($tab['content'])) {
				$panes[] = $this->_pane($tab['content'], $tab);
				unset($tab['content']);
			}
			$tabs[] = $tab;
		}
		$params = $options += compact('tabs', 'panes');
		return $this->mustache->render('tabs', $params, array('library' => 'li3_bootstrap'));
	}

	protected function _tab($data = array(), array $options = array()) {
		$defaults = array('id' => '', 'active' => false);
		$options += $defaults;
		if (!is_array($data)) {
			$data = array('name' => $data);
		}
		$data += $this->defaults['tab'];
		if ($options['active']) {
			$data['active'] = true;
		}
		if ($options['id']) {
			$data['id'] = $options['id'];
		}
		return $data;
	}

	protected function _pane($data = array(), array $options = array()) {
		$defaults = array('id' => '', 'active' => false);
		$options += $defaults;
		if (!is_array($data)) {
			$data = array('content' => $data);
		}
		$data += $this->defaults['pane'];
		if ($options['active']) {
			$data['active'] = true;
		}
		if ($options['id']) {
			$data['id'] = $options['id'];
		}
		return $data;
	}

	public function _mustache() {
		return $this->mustache = $this->_context->helper('mustache');
	}

}