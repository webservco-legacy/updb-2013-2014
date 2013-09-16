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

	public function GetPubAddForm($userId) {

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
				
				if (empty($form['data']['pub_title_sort'])) {
					
					$form['data']['pub_title_sort'] = $form['data']['pub_title'];
				}
				
				if (empty($form['errors'])) {
					
					$pub_id = $this->Pub()->PubMainAdd($form['data']);
					
					if (!empty($pub_id)) {
						
						foreach ($app_langs as $lang => $locale) {
							
							$pub_description = $form['data']["pub_description_{$lang}"];
							
							if (!$this->Pub()->PubDetailsAddModify($pub_id, $locale, $pub_description)) {
								
								$form['errors']['_result'][] = __('Error saving details data.');
							}
						}
						
						$this->UpdateEditLog($userId, $pub_id, 'pub', 'add');
					
					} else {
						
						$form['errors']['_result'][] = __('Error saving main data.');
					}
					
					if (!empty($form['errors'])) {
						
						return $form;
					}
					
					Core::Router()->Redirect("Pub/App/PubView/pub/{$pub_id}");
					
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
					
					$this->Pub()->PubMainModify($pubId, $form['data']);
					
					foreach ($app_langs as $lang => $locale) {
						
						$pub_description = $form['data']["pub_description_{$lang}"];
						
						$this->Pub()->PubDetailsAddModify($pubId, $locale, $pub_description);
					}
					
					$this->UpdateEditLog($userId, $pubId, 'pub', 'modify');
					
					if (!empty($form['errors'])) {
						
						return $form;
					}
					
					Core::Router()->Redirect("Pub/App/PubView/pub/{$pubId}");
					
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
			
			$pub_main = $this->Pub()->GetPubMain($pubId);
			
			$pub_details = $this->Pub()->GetPubDetails($pubId);
			
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

	public function GetPubIssueAddForm($userId, $pubId) {

		Core::Form()->SetMethod('post');
		
		$form_config = Core::Config()->Get('pub.form.pub_issue');
		
		if (empty($form_config)) {
			
			return FALSE;
		}
		
		$app_langs = Core::I18n()->GetAvailableLangs();
		
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
					
					$pub_issue_id = $this->Pub()->PubIssueMainAdd($pubId, $form['data']);
					
					if (!empty($pub_issue_id)) {
						
						foreach ($app_langs as $lang => $locale) {
							
							$pub_issue_description = !empty($form['data']["pub_issue_description_{$lang}"]) ? $form['data']["pub_issue_description_{$lang}"] : NULL;
							
							if (!$this->Pub()->PubIssueDetailsAddModify($pub_issue_id, $locale, $pub_issue_description)) {
								
								$form['errors']['_result'][] = __('Error saving details data.');
							}
						
						}
						
						foreach ($pub_content_types as $pub_content_type) {
							
							if (isset($form['data']["pub_issue_content_{$pub_content_type['pub_content_type_id']}"])) {
								
								if (!empty($pub_content_type['contains_data'])) {
									
									$data = isset($form['data']["pub_issue_content_{$pub_content_type['pub_content_type_id']}"]) ? $form['data']["pub_issue_content_{$pub_content_type['pub_content_type_id']}"] : NULL;
									
									$pub_issue_content_data = array_map('trim', explode(',', $data));
									
									if (!$this->Pub()->PubIssueContentAddData($pub_issue_id, $pub_content_type['pub_content_type_id'], $pub_issue_content_data)) {
										
										$form['errors']['_result'][] = __('Error saving content data.');
									}
								
								} else {
									
									if (!$this->Pub()->PubIssueContentAddValue($pub_issue_id, $pub_content_type['pub_content_type_id'], $form['data']["pub_issue_content_{$pub_content_type['pub_content_type_id']}"])) {
										
										$form['errors']['_result'][] = __('Error saving content data.');
									}
								
								}
							}
						}
						
						$this->UpdateEditLog($userId, $pub_issue_id, 'pub_issue', 'add');
					
					} else {
						$form['errors']['_result'][] = __('Error saving main data.');
					}
					
					Core::Router()->Redirect("Pub/App/PubIssueView/issue/{$pub_issue_id}");
					
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

	public function GetPubIssueModifyForm($userId, $pubIssueId) {

		Core::Form()->SetMethod('post');
		
		$form_config = Core::Config()->Get('pub.form.pub_issue');
		
		if (empty($form_config)) {
			
			return FALSE;
		}
		
		$app_langs = Core::I18n()->GetAvailableLangs();
		
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
					
					$this->Pub()->PubIssueMainModify($pubIssueId, $form['data']);
					
					foreach ($app_langs as $lang => $locale) {
						
						$pub_issue_description = !empty($form['data']["pub_issue_description_{$lang}"]) ? $form['data']["pub_issue_description_{$lang}"] : NULL;
						
						if (!$this->Pub()->PubIssueDetailsAddModify($pubIssueId, $locale, $pub_issue_description)) {
							
							$form['errors']['_result'][] = __('Error saving details data.');
						}
					}
					
					foreach ($pub_content_types as $pub_content_type) {
						
						if (isset($form['data']["pub_issue_content_{$pub_content_type['pub_content_type_id']}"])) {
							
							$this->Pub()->PubIssueContentDelete($pubIssueId, $pub_content_type['pub_content_type_id']);
							
							if (!empty($pub_content_type['contains_data'])) {
								
								$data = isset($form['data']["pub_issue_content_{$pub_content_type['pub_content_type_id']}"]) ? $form['data']["pub_issue_content_{$pub_content_type['pub_content_type_id']}"] : NULL;
								
								$pub_issue_content_data = array_map('trim', explode(',', $data));
								
								if (!$this->Pub()->PubIssueContentAddData($pubIssueId, $pub_content_type['pub_content_type_id'], $pub_issue_content_data)) {
									
									$form['errors']['_result'][] = __('Error saving content data.');
								}
							
							} else {
								
								if (!$this->Pub()->PubIssueContentAddValue($pubIssueId, $pub_content_type['pub_content_type_id'], $form['data']["pub_issue_content_{$pub_content_type['pub_content_type_id']}"])) {
									
									$form['errors']['_result'][] = __('Error saving content data.');
								}
							
							}
						}
					}
					
					$this->UpdateEditLog($userId, $pubIssueId, 'pub_issue', 'modify');
					
					if (!empty($form['errors'])) {
						
						return $form;
					}
					
					Core::Router()->Redirect("Pub/App/PubIssueView/issue/{$pubIssueId}");
					
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
			
			$pub_issue_main = $this->Pub()->GetPubIssueMain($pubIssueId);
			
			$pub_issue_details = $this->Pub()->GetPubIssueDetails($pubIssueId);
			
			if (!empty($pub_issue_main)) {
				
				foreach ($pub_issue_main as $key => $value) {
					
					$form['data'][$key] = $value;
				}
			}
			
			foreach ($app_langs as $lang => $locale) {
				
				if (!empty($pub_issue_details[$locale]['pub_issue_description'])) {
					
					$form['data']["pub_issue_description_{$lang}"] = $pub_issue_details[$locale]['pub_issue_description'];
				}
			}
			
			foreach ($pub_content_types as $pub_content_type) {
				
				if (!empty($pub_content_type['contains_data'])) {
					
					$pub_issue_content = $this->Pub()->GetPubIssueContentData($pubIssueId, $pub_content_type['pub_content_type_id']);
					
					if (!empty($pub_issue_content)) {
						
						$form['data']["pub_issue_content_{$pub_content_type['pub_content_type_id']}"] = implode(', ', $pub_issue_content);
					}
				} else {
					
					$form['data']["pub_issue_content_{$pub_content_type['pub_content_type_id']}"] = $this->Pub()->GetPubIssueContentValue($pubIssueId, $pub_content_type['pub_content_type_id']);
				}
			}
		}
		
		return $form;
	}
}
?>
