<?php
/**
 * $Id$
 *
 * App controller.
 *
 * Module: Content
 *
 * @author     Radu Maier <radu@webserv.co>
 * @copyright  Copyright (c) 2008 - 2013, Radu Maier
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @package    DefaultApp
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
 * @package DefaultApp
 * @subpackage ContentModule
 */
class Controller_Content_App extends ControllerApp {

	public function Home() {

		/**
		 * If you need to output static data, just use this:
		 * (alternatively you could set the title (see Info())
		 */
		return $this->GetDefaultOutput();
	}

	public function Info() {

		return $this->GetDefaultOutput(__('Info'));
	}

	public function Debug() {

		$this->Init();
		
		$data = $this->Module()->GetData($this->_mRequest);
		
		/**
		 * Debug using the log instead of output in browser (useful for live apps).
		 */
		Core::Log()->Debug('Debugging $data', $data, 'info');
		
		echo $this->GetOutput($data);
		
		return TRUE;
	}
}
?>
