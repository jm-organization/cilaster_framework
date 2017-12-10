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


class TableBody extends Table {
	private $data;

	public function __construct(array $options, $data) {
		$this->data = $data;

		parent::__construct($options);
	}

	public function createBody() {
		$options = $this->options['tbody'];

		$element = $this->getElementName($options[0]);
		$attributes = $this->getElementAttributes($options[0]);

		$buffer = "<$element$attributes>";
		$buffer .= $this->createColumns($options['columns']);
		$buffer .= "</$element>";

		return $buffer;
	}

	private function createColumns(array $options) {
		$buffer = '';
		$callbacks = $this->options['tbody']['callbacks'];

		if ($this->data) {
			foreach ($this->data as $datum) {
				$attributes = $callbacks['row']($datum);
				$buffer .= "<tr$attributes>";

				$item = 0;
				foreach ($options as $key) {
					$element = $this->getElementName($key);
					$attributes = $this->getElementAttributes($key);

					if (is_null($callbacks['columns'][$item])) {
						$column = "<$element$attributes>$datum[$item]</$element>";
					} else {
						$column = "<$element$attributes>".($callbacks['columns'][$item]($datum[$item]))."</$element>";
					}

					$buffer .= $column;
					$item++;
				}

				$buffer .= '</tr>';
			}
		}

		return $buffer;
	}
}