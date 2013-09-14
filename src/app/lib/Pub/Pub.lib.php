<?php
if (!defined('_WEB')) {
	exit();
}

class Pub extends Library {

	/**
	 * Implement GetInstance() method.
	 * This is required for PHP < 5.3 compatibility (no late static binding)
	 * 
	 * @param string $className
	 *        	class name to instantiate
	 * @return object
	 */
	public static function GetInstance($className = __CLASS__) {

		/**
		 * Call parent method with current class name as parameter.
		 */
		return parent::_GetInstance($className);
	}

	public function GetPubTypes($i18nLocale = NULL) {

		$data = array();
		
		$i18n_locale = !empty($i18nLocale) ? $i18nLocale : Core::I18n()->GetLocale();
		
		$q = "SELECT M.pub_type_id, D.pub_type_title
			FROM up_pub_types_main AS M
			LEFT JOIN up_pub_types_details AS D ON (D.pub_type_id = M.pub_type_id AND D.i18n_locale = '{$i18n_locale}')
			ORDER BY D.pub_type_title
			";
		
		$rs = Core::Database()->Query($q);
		
		$t = $rs->num_rows;
		
		if (0 < $t) {
			
			while ($r = $rs->fetch_assoc()) {
				
				$data[$r['pub_type_id']] = $r['pub_type_title'];
			}
		}
		
		return $data;
	}

	public function GetPubFormats() {

		$data = array();
		
		$q = "SELECT M.pub_format_id, M.pub_format_title
		FROM up_pub_formats_main AS M
		ORDER BY M.pub_format_id
		";
		
		$rs = Core::Database()->Query($q);
		
		$t = $rs->num_rows;
		
		if (0 < $t) {
			
			while ($r = $rs->fetch_assoc()) {
				
				$data[$r['pub_format_id']] = $r['pub_format_title'];
			}
		}
		
		return $data;
	}
}
?>