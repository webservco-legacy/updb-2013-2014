<?php
/**
 * $Id$
 *
 * Edit controller.
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
 * Controller_Content_Edit
 * Edit Controller for Content module.
 * 
 * @author Radu Maier <radu@webserv.co>
 * @package UpdbApp
 * @subpackage ContentModule
 */
class Controller_Pub_Edit extends ControllerApp {

	public function PubAdd() {

		$this->Init();
		
		$data = $this->Module()->GetData($this->_mRequest);
		
		$this->CheckEditorAccess($data);
		
		$data['strings']['title'] = __('Add a publication to the database.');
		
		$data['form'] = $this->Module()->GetPubAddForm($data['user']['Id']);
		
		echo $this->GetOutput($data, 'pub_edit');
		
		return TRUE;
	}

	public function PubModify() {

		$this->Init();
		
		$data = $this->Module()->GetData($this->_mRequest);
		
		$this->CheckEditorAccess($data);
		
		$data['pub_id'] = !empty($data['query']['pub']) ? $data['query']['pub'] : NULL;
		
		$data['strings']['title'] = __('Edit publication.');
		
		$data['form'] = $this->Module()->GetPubModifyForm($data['user']['Id'], $data['pub_id']);
		
		echo $this->GetOutput($data, 'pub_edit');
		
		return TRUE;
	}

	public function PubIssueAdd() {

		$this->Init();
		
		$data = $this->Module()->GetData($this->_mRequest);
		
		$this->CheckEditorAccess($data);
		
		$data['strings']['title'] = __('Add a publication issue to the database.');
		
		$data['form'] = $this->Module()->GetPubIssueAddForm($data['user']['Id']);
		
		echo $this->GetOutput($data, 'pub_edit');
		
		return TRUE;
	}

	public function Success() {

		$this->Init();
		
		$data = $this->Module()->GetData($this->_mRequest);
		
		$this->CheckEditorAccess($data);
		
		$data['strings']['message'] = __('Success');
		
		echo $this->GetOutput($data, 'default');
		
		return TRUE;
	}
}
?>