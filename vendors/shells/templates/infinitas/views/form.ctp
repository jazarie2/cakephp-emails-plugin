<?php
	/**
	 * Custom bake view add / edit
	 *
	 * creates a custom views for infinitas.
	 *
	 * Copyright (c) 2009 Carl Sutton ( dogmatic69 )
	 *
	 * Licensed under The MIT License
	 * Redistributions of files must retain the above copyright notice.
	 *
	 * @filesource
	 * @copyright     Copyright (c) 2009 Carl Sutton ( dogmatic69 )
	 * @link          http://infinitas-cms.org
	 * @package       Shell
	 * @subpackage    Shell.templates.views.index
	 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
	 *
	 * availabel vars
	 * ===================

	 [directory] => views
	 [filename] => form
	 [vars] =>
	 [themePath] => c:\xampp\htdocs\thinkmoney\vendors\shells\templates\infinitas\
	 [templateFile] => c:\xampp\htdocs\thinkmoney\vendors\shells\templates\infinitas\views\form.ctp
	 [action] => admin_add
	 [plugin] => compare
	 [modelClass] => Supplier
	 [schema] => Array
	 [primaryKey] => id
	 [displayField] => name
	 [singularVar] => supplier
	 [pluralVar] => suppliers
	 [singularHumanName] => Supplier
	 [pluralHumanName] => Suppliers
	 [fields] => Array
	 [associations] => array
	 */

	$ignore = array(
		$primaryKey,
		'locked', 'locked_by', 'locked_since',
		'deleted_date',
		'created', 'modified', 'updated',

		'active', 'deleted'
	);

	$configs = array(
		'active'
	);

	echo "<?php\n".
	"\t/**\n".
	"\t * $modelClass view/edit\n".
	"\t *\n".
	"\t * Add some documentation for $modelClass.\n".
	"\t *\n".
	"\t * Copyright (c) {yourName}\n".
	"\t *\n".
	"\t * Licensed under The MIT License\n".
	"\t * Redistributions of files must retain the above copyright notice.\n".
	"\t *\n".
	"\t * @filesource\n".
	"\t * @copyright     Copyright (c) 2009 {yourName}\n".
	"\t * @link          http://infinitas-cms.org\n".
	"\t * @package       $modelClass\n".
	"\t * @subpackage    $modelClass.views.$pluralVar.index\n".
	"\t * @license       http://www.opensource.org/licenses/mit-license.php The MIT License\n".
	"\t */\n\n";

	echo "\techo \$this->Form->create('Post');\n".
        "\t\techo \$this->Infinitas->adminEditHead(\$this);\n".
        "\t\techo \$this->Design->niceBox(); ?>\n";
		echo "\t\t\t<div class=\"data\">\n";
			echo "\t\t\t\t<?php\n";
				echo "\t\t\t\t\techo \$this->Form->input('$primaryKey');\n";
				$end = '';
				foreach ($fields as $field) {
					if (!empty($associations['belongsTo'])) {
						foreach ($associations['belongsTo'] as $alias => $details) {
							if ($field === $details['foreignKey']) {
								$configs[] = $field;
								continue;
							}
						}
					}
					if (!in_array($field, $ignore) && (str_replace('_count', '', $field) == $field)) {
						switch($schema[$field]['type']){
							case 'text':
								$end .= "\t\t\t\t\techo \$this->".ucfirst($plugin)."->wysiwyg('{$modelClass}.{$field}');\n";
								break;

							default:
								echo "\t\t\t\t\techo \$this->Form->input('{$field}');\n";
						} // switch
					}
				}
				echo $end;
			echo "\t\t\t\t?>\n";
        echo "\t\t\t</div>\n\n";

        echo "\t\t\t<div class=\"config\">\n";
	        echo "\t\t\t\t<?php\n";
		        echo "\t\t\t\t\techo \$this->Design->niceBox();\n";
					foreach ($fields as $field) {
						if (in_array($field, $configs)) {
							echo "\t\t\t\t\t\techo \$this->Form->input('{$field}');\n";
						}
					}

					if (!empty($associations['hasAndBelongsToMany'])) {
				        echo "\t\t\t\t\t\t<h2>$assocName</h2>";
						foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
							echo "\t\t\t\t\t\techo \$this->Form->input('{$assocName}');\n";
						}
					}
		        echo "\t\t\t\t\techo \$this->Design->niceBoxEnd();\n";
	        echo "\t\t\t\t?>\n";
        echo "\t\t\t</div><?php\n";
        echo "\t\techo \$this->Design->niceBox();\n";
	echo "\techo \$this->Form->end();\n";
echo "?>\n";

?>