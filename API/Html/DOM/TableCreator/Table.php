<?php
/**
 * Created in JM Organization.
 *
 * @e-mail: admin@jm-org.net
 * @Author: Magicmen
 *
 * @Date: 07.12.2017
 * @Time: 20:27
 *
 * @Documentation:
 */

namespace Cilaster\API\Html\DOM\TableCreator;


class Table {
	private $buffer;

	public $options;

	public function setOptions($options) {
		$this->options = $options;
	}

	public function getBuffer() {
		return $this->buffer;
	}

	public function __construct(array $options) {
		$this->setOptions($options);
	}

	public function create(array $data) {
		$table_class = (trim($this->options['table']))?'class="'.trim($this->options['table']).'"':'class="table"';
		$table_id = ($this->getElementId($this->options['table']))?'id="'.$this->getElementId($this->options['table']).'"':'';

		$this->buffer = "<table$table_id $table_class>";
		$this->buffer .= (new TableHead($this->options))->createHead();
		$this->buffer .= (new TableBody($this->options, $data))->createBody();

		if ($this->options['tfoot']) {
			$this->buffer .= (new TableFooter($this->options))->createFooter();
		}

		$this->buffer .= '</table>';

		return $this;
	}

	public function render() {
		echo $this->buffer;
	}

	public function getElementAttributes($element) {
		$id = $this->getElementId($element);
		$class = $this->getElementClass($element);

		return (($id)?' id="'.$id.'"':'').(($class)?' class="'.$class.'"':'');
	}

	public function getElementClass($element) {
		preg_match_all("/\.[a-zA-Z0-9_-]*/i", $element, $class);

		return str_replace('.', '', implode(' ', $class[0]));
	}

	public function getElementId($element) {
		preg_match("/(\#[a-zA-Z0-9_]*)/", $element, $id);

		return str_replace('#', '', $id[0]);
	}

	public function getElementName($element) {
		preg_match("/table|thead|tbody|tfoot|tr|td|th/", $element, $name);

		return $name[0];
	}
}