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

	public function Test() {

		$this->Init();
		
		$data = $this->Module()->GetData($this->_mRequest);
		
		$data['pub']['types'] = $this->Pub()->GetPubTypes();
		$data['pub']['formats'] = $this->Pub()->GetPubFormats();
		//$data['pub']['countries'] = Core::Geo()->GetCountries();;
		
		echo '<pre>';
		var_dump($data['pub']);
		echo '</pre>';
		
		// echo $this->GetOutput($data);
		
		return TRUE;
	}
}
?>
