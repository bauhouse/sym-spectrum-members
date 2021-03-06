<?php
	
	if (!defined('__IN_SYMPHONY__')) die('<h2>Symphony Error</h2><p>You cannot directly access this file</p>');
	
	class FieldReflection extends Field {
		protected $_driver = null;
		protected static $ready = true;
		
	/*-------------------------------------------------------------------------
		Definition:
	-------------------------------------------------------------------------*/
		
		public function __construct(&$parent) {
			parent::__construct($parent);
			
			$this->_name = 'Reflection';
			$this->_driver = $this->_engine->ExtensionManager->create('reflectionfield');
			
			// Set defaults:
			$this->set('show_column', 'yes');
			$this->set('allow_override', 'no');
			$this->set('hide', 'no');
		}
		
		public function createTable() {
			$field_id = $this->get('id');
			
			return $this->_engine->Database->query("
				CREATE TABLE IF NOT EXISTS `tbl_entries_data_{$field_id}` (
					`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
					`entry_id` INT(11) UNSIGNED NOT NULL,
					`handle` VARCHAR(255) DEFAULT NULL,
					`value` TEXT DEFAULT NULL,
					`value_formatted` TEXT DEFAULT NULL,
					PRIMARY KEY (`id`),
					KEY `entry_id` (`entry_id`),
					FULLTEXT KEY `value` (`value`),
					FULLTEXT KEY `value_formatted` (`value_formatted`)
				)
			");
		}
		
		public function allowDatasourceOutputGrouping() {
			return true;
		}
		
		public function allowDatasourceParamOutput() {
			return true;
		}
		
		public function canFilter() {
			return true;
		}
		
		public function canPrePopulate() {
			return true;
		}
		
		public function isSortable() {
			return true;
		}
		
	/*-------------------------------------------------------------------------
		Settings:
	-------------------------------------------------------------------------*/
		
		public function displaySettingsPanel(&$wrapper, $errors = null) {
			parent::displaySettingsPanel($wrapper, $errors);
			
			$order = $this->get('sortorder');
			
		/*---------------------------------------------------------------------
			Expression
		---------------------------------------------------------------------*/
			
			$group = new XMLElement('div');
			$group->setAttribute('class', 'group');
			
			$div = new XMLElement('div');
			$label = Widget::Label('Expression');
			$label->appendChild(Widget::Input(
				"fields[{$order}][expression]",
				$this->get('expression')
			));
			
			$help = new XMLElement('p');
			$help->setAttribute('class', 'help');
			
			$help->setValue('
				To access the other fields, use XPath: <code>{entry/field-one}
				static text {entry/field-two}</code>.
			');
			
			$div->appendChild($label);
			$div->appendChild($help);
			$group->appendChild($div);
			
		/*---------------------------------------------------------------------
			Text Formatter
		---------------------------------------------------------------------*/
			
			$group->appendChild($this->buildFormatterSelect(
				$this->get('formatter'),
				"fields[{$order}][formatter]",
				'Text Formatter'
			));
			$wrapper->appendChild($group);
			
		/*---------------------------------------------------------------------
			Allow Override
		---------------------------------------------------------------------*/
			
			/*
			$label = Widget::Label();
			$input = Widget::Input("fields[{$order}][allow_override]", 'yes', 'checkbox');
			
			if ($this->get('allow_override') == 'yes') {
				$input->setAttribute('checked', 'checked');
			}
			
			$label->setValue($input->generate() . ' Allow value to be manually overridden');
			$wrapper->appendChild($label);
			*/
			
		/*---------------------------------------------------------------------
			Hide input
		---------------------------------------------------------------------*/
			
			$label = Widget::Label();
			$input = Widget::Input("fields[{$order}][hide]", 'yes', 'checkbox');
			
			if ($this->get('hide') == 'yes') {
				$input->setAttribute('checked', 'checked');
			}
			
			$label->setValue($input->generate() . ' Hide this field on publish page');
			$wrapper->appendChild($label);
			
			$this->appendShowColumnCheckbox($wrapper);
		}
		
		public function commit() {
			if (!parent::commit()) return false;
			
			$id = $this->get('id');
			$handle = $this->handle();
			
			if ($id === false) return false;
			
			$fields = array(
				'field_id'			=> $id,
				'expression'		=> $this->get('expression'),
				'formatter'			=> $this->get('formatter'),
				'override'			=> $this->get('override'),
				'hide'				=> $this->get('hide')
			);
			
			$this->Database->query("
				DELETE FROM
					`tbl_fields_{$handle}`
				WHERE
					`field_id` = '{$id}'
				LIMIT 1
			");
			
			return $this->Database->insert($fields, "tbl_fields_{$handle}");
		}
		
	/*-------------------------------------------------------------------------
		Publish:
	-------------------------------------------------------------------------*/
		
		public function displayPublishPanel(&$wrapper, $data = null, $flagWithError = null, $prefix = null, $postfix = null) {
			$sortorder = $this->get('sortorder');
			$element_name = $this->get('element_name');
			$allow_override = null;
			
			if ($this->get('override') != 'yes') {
				$allow_override = array(
					'disabled'	=> 'disabled'
				);
			}
			
			if ($this->get('hide') != 'yes') {
				$label = Widget::Label($this->get('label'));
				$label->appendChild(
					Widget::Input(
						"fields{$prefix}[$element_name]{$postfix}",
						@$data['value'], 'text', $allow_override
					)
				);
				$wrapper->appendChild($label);
			}
		}
		
	/*-------------------------------------------------------------------------
		Input:
	-------------------------------------------------------------------------*/
		
		public function checkPostFieldData($data, &$message, $entry_id = null) {
			$this->_driver->registerField($this);
			
			return self::__OK__;
		}
		
		public function processRawFieldData($data, &$status, $simulate = false, $entry_id = null) {
			$status = self::__OK__;
			
			return array(
				'handle'			=> null,
				'value'				=> null,
				'value_formatted'	=> null
			);
		}
		
	/*-------------------------------------------------------------------------
		Output:
	-------------------------------------------------------------------------*/
		
		public function appendFormattedElement(&$wrapper, $data, $encode = false) {
			if (!self::$ready) return;
			
			$element = new XMLElement($this->get('element_name'));
			$element->setAttribute('handle', $data['handle']);
			$element->setValue($data['value_formatted']);
			
			$wrapper->appendChild($element);
		}
		
		public function prepareTableValue($data, XMLElement $link = null) {
			if (empty($data)) return;
			
			return parent::prepareTableValue(
				array(
					'value'		=> $data['value_formatted']
				), $link
			);
		}
		
	/*-------------------------------------------------------------------------
		Compile:
	-------------------------------------------------------------------------*/
		
		public function applyFormatting($data) {
			if ($this->get('formatter') != 'none') {
				if (isset($this->_ParentCatalogue['entrymanager'])) {
					$tfm = $this->_ParentCatalogue['entrymanager']->formatterManager;
					
				} else {
					$tfm = new TextformatterManager($this->_engine);
				}
				
				$formatter = $tfm->create($this->get('formatter'));
				$formatted = $formatter->run($data);
				
			 	return preg_replace('/&(?![a-z]{0,4}\w{2,3};|#[x0-9a-f]{2,6};)/i', '&amp;', $formatted);
			}	
			
			return null;		
		}
		
		public function compile($entry) {
			self::$ready = false;
			
			$xpath = $this->_driver->getXPath($entry);
			
			self::$ready = true;
			
			$entry_id = $entry->get('id');
			$field_id = $this->get('id');
			$expression = $this->get('expression');
			$replacements = array();
			
			// Find queries:
			preg_match_all('/\{[^\}]+\}/', $expression, $matches);
			
			// Find replacements:
			foreach ($matches[0] as $match) {
				$results = @$xpath->query(trim($match, '{}'));
				
				if ($results->length) {
					$replacements[$match] = $results->item(0)->nodeValue;
				} else {
					$replacements[$match] = '';
				}
			}
			
			// Apply replacements:
			$value = str_replace(
				array_keys($replacements),
				array_values($replacements),
				$expression
			);
			
			// Apply formatting:
			if (!$value_formatted = $this->applyFormatting($value)) {
				$value_formatted = General::sanitize($value);
			}
			
			// Save:
			$result = $this->Database->update(array(
				'handle'			=> Lang::createHandle($value),
				'value'				=> $value,
				'value_formatted'	=> $value_formatted
			), "tbl_entries_data_{$field_id}", "
				`entry_id` = '{$entry_id}'
			");
		}
		
	/*-------------------------------------------------------------------------
		Filtering:
	-------------------------------------------------------------------------*/
		
		public function buildDSRetrivalSQL($data, &$joins, &$where, $andOperation = false) {
			$field_id = $this->get('id');
			
			if (self::isFilterRegex($data[0])) {
				$this->_key++;
				$pattern = str_replace('regexp:', '', $this->cleanValue($data[0]));
				$joins .= "
					LEFT JOIN
						`tbl_entries_data_{$field_id}` AS t{$field_id}_{$this->_key}
						ON (e.id = t{$field_id}_{$this->_key}.entry_id)
				";
				$where .= "
					AND (
						t{$field_id}_{$this->_key}.handle REGEXP '{$pattern}'
						OR t{$field_id}_{$this->_key}.value REGEXP '{$pattern}'
					)
				";
				
			} else if (strpos($data[0], 'search:') == 0) {
				$data = trim(substr(implode(' + ', $data), 7));
				
				if ($data == '') return true;
				
				// Negative match?
				if (preg_match('/^not(\W)/i', $data)) {
					$mode = '-';
					
				} else {
					$mode = '+';
				}
				
				// Replace ' and ' with ' +':
				$data = preg_replace('/(\W)and(\W)/i', '\\1+\\2', $data);
				$data = preg_replace('/(^)and(\W)|(\W)and($)/i', '\\2\\3', $data);
				$data = preg_replace('/(\W)not(\W)/i', '\\1-\\2', $data);
				$data = preg_replace('/(^)not(\W)|(\W)not($)/i', '\\2\\3', $data);
				$data = preg_replace('/([\+\-])\s*/', '\\1', $mode . $data);
				
				//echo $data; exit;
				
				$data = $this->cleanValue($data);
				$this->_key++;
				$joins .= "
					LEFT JOIN
						`tbl_entries_data_{$field_id}` AS t{$field_id}_{$this->_key}
						ON (e.id = t{$field_id}_{$this->_key}.entry_id)
				";
				$where .= "
					AND MATCH (t{$field_id}_{$this->_key}.value) AGAINST ('{$data}' IN BOOLEAN MODE)
				";
				
			} elseif ($andOperation) {
				foreach ($data as $value) {
					$this->_key++;
					$value = $this->cleanValue($value);
					$joins .= "
						LEFT JOIN
							`tbl_entries_data_{$field_id}` AS t{$field_id}_{$this->_key}
							ON (e.id = t{$field_id}_{$this->_key}.entry_id)
					";
					$where .= "
						AND (
							t{$field_id}_{$this->_key}.handle = '{$value}'
							OR t{$field_id}_{$this->_key}.value = '{$value}'
						)
					";
				}
				
			} else {
				if (!is_array($data)) $data = array($data);
				
				foreach ($data as &$value) {
					$value = $this->cleanValue($value);
				}
				
				$this->_key++;
				$data = implode("', '", $data);
				$joins .= "
					LEFT JOIN
						`tbl_entries_data_{$field_id}` AS t{$field_id}_{$this->_key}
						ON (e.id = t{$field_id}_{$this->_key}.entry_id)
				";
				$where .= "
					AND (
						t{$field_id}_{$this->_key}.handle IN ('{$data}')
						OR t{$field_id}_{$this->_key}.value IN ('{$data}')
					)
				";
			}
			
			return true;
		}
		
	/*-------------------------------------------------------------------------
		Sorting:
	-------------------------------------------------------------------------*/
		
		public function buildSortingSQL(&$joins, &$where, &$sort, $order = 'ASC') {
			$field_id = $this->get('id');
			
			$joins .= "INNER JOIN `tbl_entries_data_{$field_id}` AS ed ON (e.id = ed.entry_id) ";
			$sort = 'ORDER BY ' . (strtolower($order) == 'random' ? 'RAND()' : "ed.value {$order}");
		}
		
	/*-------------------------------------------------------------------------
		Grouping:
	-------------------------------------------------------------------------*/
		
		public function groupRecords($records) {
			if (!is_array($records) or empty($records)) return;
			
			$groups = array(
				$this->get('element_name') => array()
			);
			
			foreach ($records as $record) {
				$data = $record->getData($this->get('id'));
				
				$value = $data['value_formatted'];
				$handle = $data['handle'];
				$element = $this->get('element_name');
				
				if (!isset($groups[$element][$handle])) {
					$groups[$element][$handle] = array(
						'attr'		=> array(
							'handle'	=> $handle,
							'value'		=> $value
						),
						'records'	=> array(),
						'groups'	=> array()
					);
				}
				
				$groups[$element][$handle]['records'][] = $record;
			}
			
			return $groups;
		}
	}
	
?>