<?php
/**
 * Created in JM Organization.
 *
 * @e-mail: admin@jm-org.net
 * @Author: Magicmen
 *
 * @Date: 07.12.2017
 * @Time: 20:56
 *
 * @Documentation:
 */

namespace Cilaster\API\Html\DOM\TableCreator;


class TableHead extends Table {
	public function __construct(array $options) {
		parent::__construct($options);
	}

	public function createHead() {
		$options = $this->options['thead'];

		$element = $this->getElementName($options[0]);
		$attributes = $this->getElementAttributes($options[0]);

		$buffer = "<$element$attributes>";
		$buffer .= $this->createColumns($options['columns']);
		$buffer .= "</$element>";

		return $buffer;
	}

	private function createColumns(array $options) {
		$buffer = '<tr>';

		foreach ($options as $key => $value) {
			$element = $this->getElementName($key);
			$attributes = $this->getElementAttributes($key);

			$buffer .= "<$element$attributes>$value</$element>";
		}

		$buffer .= '</tr>';

		return $buffer;
	}
}