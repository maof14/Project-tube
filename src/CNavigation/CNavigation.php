<?php 

class CNavigation {
	public static function GenerateMenu($items, $class) {
		$html = "<nav class='{$class} inactive'>\n";
		foreach($items as $key => $item) {
			$selected = basename($_SERVER['PHP_SELF'], '.php') == $key ? 'selected' : null;
			$html .= "<a href='{$item['url']}' class='{$selected}'>{$item['text']}</a>\n";
		}
		$html .= "</nav>\n";
		return $html;
	}
}