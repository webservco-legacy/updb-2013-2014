<?php
/**
 * $Id$
 *
 * Pub module.
 *
 * @author     Radu Maier <radu@webserv.co>
 * @copyright  Copyright (c) 2008 - 2013, Radu Maier
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    UpdbApp
 * @subpackage PubModule
 * @version    $Revision$
 * @since      Version 7
 * @access     public
 * @filesource
 */

if (!defined('_WEB')) {
	exit();
}

/**
 * Module_Pub
 * Model class for Pub module.
 * 
 * @author Radu Maier <radu@webserv.co>
 * @package UpdbApp
 * @subpackage PubModule
 */
class Module_Pub extends ModuleApp {

	public function GetPubIssueAddForm($userId) {

		Core::Form()->SetMethod('post');
		
		$form_config = Core::Config()->Get('pub.form.pub_issue');
		
		if (empty($form_config)) {
			
			return FALSE;
		}
		
		$pub_content_types = $this->Pub()->GetPubContentTypes();
		
		foreach ($pub_content_types as $pub_content_type) {
			
			$type = !empty($pub_content_type['contains_data']) ? 'text' : 'checkbox';
			
			$description = !empty($pub_content_type['contains_data']) ? "Comma separated list of values, eg \"Animal Rights, Strongly Opposed Records, Veganism\"." : "yes/no";
			
			$form_config["pub_issue_content_{$pub_content_type['pub_content_type_id']}"] = array(
				'type' => $type,
				'title' => $pub_content_type['pub_content_type_title'],
				'description' => $description,
				'required' => 0,
				'filters' => 'StripTags',
				'conditions' => NULL
			);
		}
		
		Core::Form()->SetData($form_config);
		
		$publications = $this->Pub()->GetPublications();
		
		if (!empty($publications)) {
			
			$pub_list = array();
			
			foreach ($publications as $pub_id => $pub_data) {
				
				$pub_list[$pub_id] = $pub_data['pub_title'];
			}
			
			Core::Form()->SetMeta('pub_id', 'options', $pub_list);
		}
		
		$pub_format_list = $this->Pub()->GetPubFormats();
		
		if (!empty($pub_format_list)) {
			
			Core::Form()->SetMeta('pub_format_id', 'options', $pub_format_list);
		}
		
		$form['meta'] = Core::Form()->GetMeta();
		
		$form['errors'] = array();
		
		if (!empty($_POST)) {
			
			$result_validation = Core::Form()->Validate();
			
			if (FALSE !== $result_validation) {
				
				$form['data'] = Core::Form()->GetEscapedFilteredData();
				
				if (empty($form['errors'])) {
					
					var_dump($form);
					exit(); // XXX
				
				} else {
					
					$form['data'] = Core::Form()->GetData();
				}
			
			} else {
				
				$form['data'] = Core::Form()->GetData();
				
				$form['errors'] = Core::Form()->GetErrors();
			}
		
		} else {
			
			$form['data'] = Core::Form()->GetData();
		}
		
		return $form;
	}

	public function GetPubAddForm($userId) {

		Core::Form()->SetMethod('post');
		
		$form_config = Core::Config()->Get('pub.form.pub');
		
		if (empty($form_config)) {
			
			return FALSE;
		}
		
		Core::Form()->SetData($form_config);
		
		$pub_types = $this->Pub()->GetPubTypes();
		
		if (!empty($pub_types)) {
			
			Core::Form()->SetMeta('pub_type_id', 'options', $pub_types);
		}
		
		$countries = Core::Geo()->GetCountries();
		
		if (!empty($countries)) {
			
			Core::Form()->SetMeta('country_code', 'options', $countries);
		}
		
		$form['meta'] = Core::Form()->GetMeta();
		
		$form['errors'] = array();
		
		if (!empty($_POST)) {
			
			$result_validation = Core::Form()->Validate();
			
			if (FALSE !== $result_validation) {
				
				$form['data'] = Core::Form()->GetEscapedFilteredData();
				
				if (empty($form['data']['pub_title_sort'])) {
					
					$form['data']['pub_title_sort'] = $form['data']['pub_title'];
				}
				
				if (empty($form['errors'])) {
					
					$pub_id = $this->PubMainAdd($form['data']);
					
					if (!empty($pub_id)) {
						
						$app_langs = Core::I18n()->GetAvailableLangs();
						
						foreach ($app_langs as $lang => $locale) {
							
							$pub_description = $form['data']["pub_description_{$lang}"];
							
							if (!empty($pub_description)) {
								
								if (!$this->PubDetailsAdd($pub_id, $locale, $pub_description)) {
									
									$form['errors']['_result'][] = __('Error saving details data.');
								}
							}
						}
						
						$this->UpdateEditLog($userId, $pub_id, 'pub', 'add');
					
					} else {
						
						$form['errors']['_result'][] = __('Error saving main data.');
					}
					
					if (!empty($form['errors'])) {
						
						return $form;
					}
					
					Core::Router()->Redirect("Pub/Edit/Success");
					
					exit();
				
				} else {
					
					$form['data'] = Core::Form()->GetData();
				}
			
			} else {
				
				$form['data'] = Core::Form()->GetData();
				
				$form['errors'] = Core::Form()->GetErrors();
			}
		
		} else {
			
			$form['data'] = Core::Form()->GetData();
		}
		
		return $form;
	}

	public function GetPubModifyForm($userId, $pubId) {

		Core::Form()->SetMethod('post');
		
		$form_config = Core::Config()->Get('pub.form.pub');
		
		if (empty($form_config)) {
			
			return FALSE;
		}
		
		$app_langs = Core::I18n()->GetAvailableLangs();
		
		Core::Form()->SetData($form_config);
		
		$pub_types = $this->Pub()->GetPubTypes();
		
		if (!empty($pub_types)) {
			
			Core::Form()->SetMeta('pub_type_id', 'options', $pub_types);
		}
		
		$countries = Core::Geo()->GetCountries();
		
		if (!empty($countries)) {
			
			Core::Form()->SetMeta('country_code', 'options', $countries);
		}
		
		$form['meta'] = Core::Form()->GetMeta();
		
		$form['errors'] = array();
		
		if (!empty($_POST)) {
			
			$result_validation = Core::Form()->Validate();
			
			if (FALSE !== $result_validation) {
				
				$form['data'] = Core::Form()->GetEscapedFilteredData();
				
				if (empty($form['errors'])) {
					
					if (empty($form['data']['pub_title_sort'])) {
						
						$form['data']['pub_title_sort'] = $form['data']['pub_title'];
					}
					
					$this->PubMainModify($pubId, $form['data']);
					
					foreach ($app_langs as $lang => $locale) {
						
						$pub_description = $form['data']["pub_description_{$lang}"];
						
						$this->PubDetailsAdd($pubId, $locale, $pub_description);
					}
					
					$this->UpdateEditLog($userId, $pubId, 'pub', 'modify');
					
					if (!empty($form['errors'])) {
						
						return $form;
					}
					
					Core::Router()->Redirect("Pub/Edit/Success");
					
					exit();
				
				} else {
					
					$form['data'] = Core::Form()->GetData();
				}
			
			} else {
				
				$form['data'] = Core::Form()->GetData();
				
				$form['errors'] = Core::Form()->GetErrors();
			}
		
		} else {
			
			$form['data'] = Core::Form()->GetData();
			
			$pub_main = $this->GetPubMain($pubId);
			
			$pub_details = $this->GetPubDetails($pubId);
			
			if (!empty($pub_main)) {
				
				foreach ($pub_main as $key => $value) {
					
					$form['data'][$key] = $value;
				}
			}
			
			foreach ($app_langs as $lang => $locale) {
				
				if (!empty($pub_details[$locale]['pub_description'])) {
					
					$form['data']["pub_description_{$lang}"] = $pub_details[$locale]['pub_description'];
				}
			}
		}
		
		return $form;
	}

	public function PubMainAdd($data) {

		$q = "INSERT INTO up_pub_main (pub_title, pub_title_sort, pub_type_id, country_code) VALUES
		('{$data['pub_title']}', '{$data['pub_title_sort']}', '{$data['pub_type_id']}', '{$data['country_code']}')";
		
		return Core::Database()->Query($q) ? Core::Database()->GetInsertId() : FALSE;
	}

	public function PubMainModify($pubId, $data) {

		$q = "UPDATE up_pub_main SET
			pub_title = '{$data['pub_title']}',
			pub_title_sort = '{$data['pub_title_sort']}',
			pub_type_id = '{$data['pub_type_id']}',
			country_code = '{$data['country_code']}'
			WHERE pub_id = '{$pubId}' LIMIT 1
			";
		
		return Core::Database()->Query($q) ? Core::Database()->GetAffectedRows() : FALSE;
	}

	public function PubDetailsAdd($pubId, $i18nLocale, $pubDescription) {

		$q = "INSERT INTO up_pub_details (pub_id, i18n_locale, pub_description) VALUES
			('{$pubId}', '{$i18nLocale}', '{$pubDescription}')
			ON DUPLICATE KEY UPDATE pub_description = '{$pubDescription}'";
		
		return Core::Database()->Query($q) ? Core::Database()->GetAffectedRows() : FALSE;
	}

	public function GetPubMain($pubId) {

		$q = "SELECT pub_title, pub_title_sort, pub_type_id, country_code
			FROM up_pub_main
			WHERE pub_id = '{$pubId}' LIMIT 1";
		
		$rs = Core::Database()->Query($q);
		
		$t = $rs->num_rows;
		
		if (1 == $t) {
			
			return $rs->fetch_assoc();
		}
		
		return FALSE;
	}

	public function GetPubDetails($pubId) {

		$data = array();
		
		$q = "SELECT i18n_locale, pub_description FROM up_pub_details WHERE pub_id = '{$pubId}'";
		
		$rs = Core::Database()->Query($q);
		
		$t = $rs->num_rows;
		
		if (0 < $t) {
			
			while ($r = $rs->fetch_assoc()) {
				
				$data[$r['i18n_locale']] = $r;
			}
		}
		
		return $data;
	}
}
?>
