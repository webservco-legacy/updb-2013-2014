<?php
/**
 * $Id$
 *
 * App controller.
 *
 * Module: Pub
 *
 * @author     Radu Maier <radu@webserv.co>
 * @copyright  Copyright (c) 2008 - 2013, Radu Maier
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    UpdbApp
 * @subpackage ContentModule
 * @version    $Revision$
 * @since      Version 7
 * @access     public
 * @filesource
 */

if (!defined('_WEB')) {
	exit();
}

/**
 * Controller_Content_App
 * App Controller for Content module.
 * 
 * @author Radu Maier <radu@webserv.co>
 * @package UpdbApp
 * @subpackage ContentModule
 */
class Controller_Pub_App extends ControllerApp {

	public function PubList() {

		$this->Init();
		
		$data = $this->Module()->GetData($this->_mRequest);
		
		$data['strings']['title'] = __('Publications list');
		
		$data['publications'] = $this->Pub()->GetPublications();
		
		echo $this->GetOutput($data);
		
		return TRUE;
	}

	public function PubView() {

		$this->Init();
		
		$data = $this->Module()->GetData($this->_mRequest);
		
		$data['strings']['title'] = __('Issues list');
		
		$data['pub_id'] = !empty($data['query']['pub']) ? $data['query']['pub'] : NULL;
		
		$data['pub'] = $this->Pub()->GetPublication($data['pub_id']);
		
		$data['pub_issues'] = $this->Pub()->GetPubIssues($data['pub_id']);
		
		echo $this->GetOutput($data);
		
		return TRUE;
	}

	public function PubIssueView() {

		$this->Init();
		
		$data = $this->Module()->GetData($this->_mRequest);
		
		$data['strings']['title'] = __('Issues list');
		
		$data['pub_issue_id'] = !empty($data['query']['issue']) ? $data['query']['issue'] : NULL;
		
		$data['issue'] = $this->Pub()->GetPubIssue($data['pub_issue_id']);
		
		if (!empty($data['issue']['pub_issue_id'])) {
			
			$data['pub'] = $this->Pub()->GetPublication($data['issue']['pub_issue_id']);
		}
		
		echo $this->GetOutput($data);
		
		return TRUE;
	}
}
?>