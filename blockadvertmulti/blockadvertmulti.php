<?php
/*
  Block advertising multiple

  Copyright (C) 2012-2013 FeliBV
  Copyright (C) 2013 Madman

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in
  all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
  THE SOFTWARE.

  @orignal author	FeliBV
  @2nd author		Madman
  @copyright	2012-2013 FeliBV
  @copyright	2013 Madman
  @link			https://github.com/PhpMadman/PrestaShop-MultiAdv
  @tested		Prestashop 1.5.4.1
  @license		Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Spain License http://creativecommons.org/licenses/by-nc-sa/3.0/es/deed.en
*/

if (!defined('_PS_VERSION_'))
	exit;

class blockadvertmulti extends Module
{
	protected $maxImageSize = 1207200; /** @var max image size */

	function __construct()
	{
		$this->name = 'blockadvertmulti';
		$this->tab = 'advertising_marketing';
		$this->version = '0.11';
		$this->author = 'FeliBV & Madman';
		$this->need_instance = 0;
		parent::__construct();
        $this->displayName = $this->l('Block advertising multiple');
		$this->description = $this->l('Adds a blocks to display images on top/right/left/home/footer.');
		$this->img_wpath = _PS_IMG_.'bnrs/';
		$this->img_fpath = _PS_IMG_DIR_.'bnrs/';
	}

	function install()
	{
		if ( parent::install() == false
		  OR $this->registerHook('backOfficeHeader') == false
		  OR $this->_createTables() == false
		  OR $this->registerHook('header') == false
		  OR $this->registerHook('top') == false
		  OR $this->registerHook('leftColumn') == false
		  OR $this->registerHook('rightColumn') == false
		  OR $this->registerHook('home') == false
		  OR $this->registerHook('footer') == false
		)
			return false;

		if (!file_exists($this->img_fpath))
			if (!@mkdir($this->img_fpath, 0777))
				return false;
		return true;
	}

	function uninstall()
	{
		$db = Db::getInstance();
		$query = 'DROP TABLE `'._DB_PREFIX_.'blockadvertmulti`';
		$result = $db->Execute($query);
        if (!parent::uninstall() OR !$result)
			return false;
		return true;
	}

	/**
	*	createTables()
	*	Called from within blockadvertmulti.php when intalling
	*/
	public function _createTables()
	{
		$db = Db::getInstance();
		$query = 'CREATE TABLE `'._DB_PREFIX_.'blockadvertmulti` (
			  `id_blockadvertmulti` int(6) NOT NULL AUTO_INCREMENT,
			  `description` varchar(30) NOT NULL default "",
			  `image_name` varchar(255) NOT NULL default "",
			  `image_link` varchar(255) NOT NULL default "",
			  `open_blank` tinyint(1) NOT NULL default "0",
			  `active` tinyint(1) NOT NULL default "1",
			  `block_id` int(2) NOT NULL default "0",
			  `order` int(10) NOT NULL default "0",
			  `rotate` tinyint(1) NOT NULL default "0",
			  PRIMARY KEY (`id_blockadvertmulti`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8';
		$result = $db->Execute($query);
		if (!$result)
			return false;
		return true;
	}

	/**
	*	getContent()
	*	Called in Back Office when user clicks "Configure"
	*/
	function getContent()
	{
		$output = '<h2>'.$this->displayName.' v'.$this->version.'</h2>';
		if (Tools::isSubmit('submitSideBySide'))
		{
			$sideTop = Tools::getValue('sideTop');
			if ($sideTop != 0 && $sideTop != 1)
				$output .= '<div class="alert error">'.$this->l('sideTop : Invalid choice.').'</div>';
			else
				Configuration::updateValue('PS_MULTI_ADV_SIDE_TOP', (int)($sideTop));
			$output .= '<div class="conf confirm">'.$this->l('Settings updated').'</div>';
		}
		$output .= '
		<form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post">
			<fieldset>
				<legend>'.$this->l('Settings').'</legend>

				<label>'.$this->l('Side By Side').'</label>
				<div class="margin-form">
					<input type="radio" name="sideTop" id="sideTop_on" value="1" '.(Tools::getValue('sideTop', Configuration::get('PS_MULTI_ADV_SIDE_TOP')) ? 'checked="checked" ' : '').'/>
					<label class="t" for="sideTop_on"> <img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
					<input type="radio" name="sideTop" id="sideTop_off" value="0" '.(!Tools::getValue('sideTop', Configuration::get('PS_MULTI_ADV_SIDE_TOP')) ? 'checked="checked" ' : '').'/>
					<label class="t" for="sideTop_off"> <img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
					<p class="clear">'.$this->l('Set top side by side').'</p>
				</div>

				<center><input type="submit" name="submitSideBySide" value="'.$this->l('Save').'" class="button" /></center>
			</fieldset>
		</form><br><br>';
		$output .= $this->_postProcess().$this->_displayBO();

		return $output;
	}

	private function _displayBO()
	{
		global $smarty, $currentIndex, $cookie;

        $iso_code = Language::getIsoById( (int)$cookie->id_lang );
		if ( stripos('/es/fr/',$iso_code)===false) $iso_code = 'en';

		$smarty->assign(array( 'img_path'		=> $this->img_wpath
							 , 'banners_1'		=> $this->getBanners('1')
							 , 'banners_2'		=> $this->getBanners('2')
							 , 'banners_3'		=> $this->getBanners('3')
							 , 'banners_4'		=> $this->getBanners('4')
							 , 'banners_5'		=> $this->getBanners('5')
							 , 'leftBanners'	=> '2'
							 , 'currentIndex'	=> $currentIndex
							 , 'rand'			=> rand()
							 , 'lng'			=> $iso_code
		));
		return $this->display( dirname(__FILE__), 'blockadvertmulti_bo.tpl');
	}

	/**
	*	_postProcess()
	*	Called upon successful module configuration validation
	*/
	private function _postProcess()
	{
		$output = "";

		if ( Tools::isSubmit('updateSubmit'))
		{
			$banners = Tools::getValue('blockadvertmultiId');
			if ($banners AND is_array($banners) AND count($banners)) {
				foreach ($banners AS $row) {
					$bnr = array();
					$bnr['id'] = $row;
					$bnr['description'] = Tools::getValue('desc_'.$row);
					$bnr['image_link'] = Tools::getValue('link_'.$row);
					/* Patch by Madman start */
					if (isset($_FILES['banner_image_' . $row]) AND isset($_FILES['banner_image_' . $row]['tmp_name']) AND !empty($_FILES['banner_image_' . $row]['tmp_name'])) {
						$bnr['image_name'] = $_FILES['banner_image_' . $row]['name'];
					} else {
						$bnr['image_name'] = Tools::getValue('image_name_'.$row);
					}
					/* Patch by Madman end */
// 					$bnr['image_name'] = Tools::getValue('image_name_'.$row);
					$bnr['block_id'] = Tools::getValue('block_'.$row);
					$bnr['order'] = Tools::getValue('order_'.$row);
					$bnr['blank'] = (Tools::getValue('blank_'.$row) ? '1' : '0');
					$bnr['active'] = (Tools::getValue('active_'.$row) ? '1' : '0');
					$bnr['rotate'] = (Tools::getValue('rotate_'.$row) ? '1' : '0');
					$bnrs[] = $bnr;
					/* Patch by Madman start */
						if (isset($_FILES['banner_image_' . $row]) AND isset($_FILES['banner_image_' . $row]['tmp_name']) AND !empty($_FILES['banner_image_' . $row]['tmp_name'])) {
							Configuration::set('PS_IMAGE_GENERATION_METHOD', 1);
							$name = $_FILES['banner_image_' . $row]['name'];
							$ext = strtolower(substr($name, strrpos($name, ".") + 1));
							$path = $this->img_fpath.basename( $_FILES['banner_image_' . $row]['name']);
							if ( stripos('/png/gif/jpg/jpeg/bmp/', $ext) === false )
								$errors .= $this->displayError($this->l('Incorrect file type.'));
							if(_PS_VERSION_ < "1.5.4") { /* If version is less then 1.5.4 */
								if ($error = checkImage($_FILES['banner_image_' . $row], $this->maxImageSize))
									$errors .= $this->displayError($error);

								elseif (!move_uploaded_file($_FILES['banner_image_' . $row]['tmp_name'], $path))
									$errors .= $this->displayError($this->l('An error occurred during the image upload.'));
							} else { /* 1.5.4x */
								if ($error = ImageManager::validateUpload ($_FILES['banner_image_' . $row], $this->maxImageSize))
									$errors .= $this->displayError($error);

								elseif (!move_uploaded_file($_FILES['banner_image_' . $row]['tmp_name'], $path))
									$errors .= $this->displayError($this->l('An error occurred during the image upload.'));
							}
							if (isset($errors) && $errors)
								$errors .= $this->displayError($this->l('Error creating banner.'));

							elseif (!$this->updateBanner($bnr))
								$errors .= $this->displayError($this->l('Error creating banner on database.'));
						} else {
							$errors .= $this->displayError($this->l('An error occurred during the banner image update.'));
						}
					/* Patch by Madman end */

				}
				if ($this->saveBanners($bnrs))
					$output .= $this->displayConfirmation( $this->l('Banners updated successfully.'));
				else
					$output .= $this->displayError( $this->l('There were problems updating banners.'));
			}
		}
		elseif ( Tools::isSubmit('addSubmit'))
		{
			$bnr['description'] = Tools::getValue('banner_description');
			$bnr['image_link'] = Tools::getValue('banner_link');
			$bnr['image_name'] = $_FILES['banner_image']['name'];
			$bnr['block_id'] = Tools::getValue('banner_block_id');
			$bnr['order'] = Tools::getValue('banner_order');
			$bnr['blank'] = (Tools::getValue('banner_blank') ? '1' : '0');
			$bnr['active'] = (Tools::getValue('banner_active') ? '1' : '0');
			$bnr['rotate'] = (Tools::getValue('banner_rotate') ? '1' : '0');
			/* upload the image */
			if (isset($_FILES['banner_image']) AND isset($_FILES['banner_image']['tmp_name']) AND !empty($_FILES['banner_image']['tmp_name']))
			{
				Configuration::set('PS_IMAGE_GENERATION_METHOD', 1);
				$name = $_FILES['banner_image']['name'];
				$ext = strtolower(substr($name, strrpos($name, ".") + 1));
				$path = $this->img_fpath.basename( $_FILES['banner_image']['name']);
				if ( stripos('/png/gif/jpg/jpeg/bmp/', $ext) === false )
					$errors .= $this->displayError($this->l('Incorrect file type.'));
					if(_PS_VERSION_ < "1.5.4") { /* If version is less then 1.5.4 */
						if ($error = checkImage($_FILES['banner_image'], $this->maxImageSize))
							$errors .= $this->displayError($error);

						elseif (!move_uploaded_file($_FILES['banner_image']['tmp_name'], $path))
							$errors .= $this->displayError($this->l('An error occurred during the image upload.'));
					} else { /* 1.5.4x */
						if ($error = ImageManager::validateUpload ($_FILES['banner_image'], $this->maxImageSize))
							$errors .= $this->displayError($error);

						elseif (!move_uploaded_file($_FILES['banner_image']['tmp_name'], $path))
							$errors .= $this->displayError($this->l('An error occurred during the image upload.'));
					}

				if (isset($errors) && $errors)
					$errors .= $this->displayError($this->l('Error creating banner.'));

				elseif (!$this->addBanner($bnr))
					$errors .= $this->displayError($this->l('Error creating banner on database.'));
			} else {
				$errors .= $this->displayError($this->l('An error occurred during the banner creation.'));
			}
			$output .= (isset($errors) && $errors != '') ? $errors : $this->displayConfirmation($this->l('Banner added successfully.'));
		}
		elseif ( Tools::isSubmit('deleteSubmit'))
		{
			$bnr = Tools::getValue('bannerDelete');
			if ($this->deleteBanner($bnr))
				$output .= $this->displayConfirmation( $this->l('Banner succesfully deleted.'));
			else
				$output .= $this->displayError( $this->l('Problems deleting the banner.'));
		}

		return $output;
	}

	function hookTop($params)
	{
		return $this->_processHook( $params, 1);
	}

	function hookLeftColumn($params)
	{
		return $this->_processHook( $params, 2);
	}

	function hookRightColumn($params)
	{
		return $this->_processHook( $params, 3);
	}

	function hookHome($params)
	{
		return $this->_processHook( $params, 4);
	}

	function hookFooter($params)
	{
		return $this->_processHook( $params, 5);
	}

	function _processHook( $params, $hook ) {
		global $cookie, $smarty;
		$sideHook = array(
			1=> "top",
			2=> "left",
			3=> "right",
			4=> "home",
			5 => "footer",
		);
		if ($this->countBanners($hook)) {
			$smarty->assign(array( 'hook' => $hook
								 , 'banners' => $this->getBanners($hook, false)
								 , 'img_path' => $this->img_wpath
			));
			if($hook == 1) {
				$smarty->assign(array('side_by_side' => Configuration::get('PS_MULTI_ADV_SIDE_TOP') ) );
			}
				$side = $sideHook[$hook];
				$file = "blockadvertmulti-$side.tpl";
			return $this->display( dirname(__FILE__),$file);
		} else return '';
	}

	public function hookHeader()
	{
		Tools::addCSS(($this->_path).'css/blockadvertmulti.css', 'all');
		if ($this->countBanners(NULL, true))
			Tools::addJS(($this->_path).'js/jquery.innerfade.js');
	}

	public function hookBackOfficeHeader()
	{
		if ( Tools::getValue('tab') == 'AdminModules'
		 && (Tools::getValue('configure') == $this->name
		  || Tools::getValue('module_name') == $this->name ))
		{
			if (version_compare(_PS_VERSION_, '1.5', '>=')) {
				$this->context->controller->addJquery();
				$this->context->controller->addJQueryPlugin('fancybox');
				$this->context->controller->addJS($this->_path.'js/blockadvermulti_bo.js');
				$this->context->controller->addCSS($this->_path.'css/blockadvertmulti_bo.css', 'all');
				return '';
			}

			return '<script type="text/javascript" src="'.__PS_BASE_URI__.'js/jquery/jquery-ui-1.8.10.custom.min.js"></script>
					<script type="text/javascript" src="'.__PS_BASE_URI__.'js/jquery/jquery.fancybox-1.3.4.js"></script>
					<link type="text/css" rel="stylesheet" href="'.__PS_BASE_URI__.'css/jquery.fancybox-1.3.4.css" />
					<script type="text/javascript">
						var pos_select = \'0\';
						function loadTab(id)
						{};
					</script>
					<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tabpane.js"></script>
					<link type="text/css" rel="stylesheet" href="'.__PS_BASE_URI__.'css/tabpane.css" />
					<script type="text/javascript" src="'.$this->_path.'js/blockadvermulti_bo.js"></script>
					<link rel="stylesheet" media="screen" type="text/css" href="'.$this->_path.'css/blockadvertmulti_bo.css" />';
		}
	}

	/**
	*	addBanner($bnr)
	*	Add new banner
	*/
	public function addBanner($bnr)
	{
		$db = Db::getInstance();
		$values = array( 'active' => $bnr['active'], 'description' => pSQL($bnr['description']), 'image_name' => pSQL($bnr['image_name'])
		               , 'image_link' => pSQL($bnr['image_link']), 'block_id' => (int)$bnr['block_id'], 'order' => (int)$bnr['order']
					   , 'open_blank' => $bnr['blank'], 'rotate' => $bnr['rotate'] );
		$result = $db->autoExecute(_DB_PREFIX_.'blockadvertmulti', $values, 'INSERT' );
		if (!$result)
			return false;
		return true;
	}

	/* Patch by Madman */
	/**
	*	updateBanner($bnr)
	*	Changes image on a existing banner
	*/
	public function updateBanner($bnr)
	{
		$db = Db::getInstance();
		$values = array( 'active' => $bnr['active'], 'description' => pSQL($bnr['description']), 'image_name' => pSQL($bnr['image_name'])
		               , 'image_link' => pSQL($bnr['image_link']), 'block_id' => (int)$bnr['block_id'], 'order' => (int)$bnr['order']
					   , 'open_blank' => $bnr['blank'], 'rotate' => $bnr['rotate']);
		$result = $db->autoExecute(_DB_PREFIX_.'blockadvertmulti', $values, 'UPDATE', 'id_blockadvertmulti = '.$bnr['id'] );
		if (!$result)
			return false;
		return true;
	}
	/* Patch by Madman */

	/**
	*	saveBanners($bnrs)
	*	Save data of banners
	*/
	public function saveBanners($bnrs)
	{
		$success = true;
		$db = Db::getInstance();
		foreach ($bnrs as $bnr)
		{
			$values = array( 'active' => $bnr['active'], 'description' => pSQL($bnr['description']), 'image_name' => pSQL($bnr['image_name'])
		                   , 'image_link' => pSQL($bnr['image_link']), 'block_id' => (int)$bnr['block_id'], 'order' => $bnr['order']
					       , 'open_blank' => $bnr['blank'], 'rotate' => $bnr['rotate'] );
		    $result = $db->autoExecute(_DB_PREFIX_.'blockadvertmulti', $values, 'UPDATE', 'id_blockadvertmulti = '.$bnr['id'] );
			if (!$result) $success = false;
		}
		return $success;
	}

	/**
	*	deleteBanner($bnr)
	*	Delete a banner
	*/
	public function deleteBanner($bnr)
	{
		$db = Db::getInstance();
		$result = $db->delete(_DB_PREFIX_.'blockadvertmulti', 'id_blockadvertmulti = '.$bnr );
		return $result;
	}

	/**
	*	getBanners()
	*	Returns the banners from the database
	*/
	public function getBanners($hook, $all = true)
	{
		$db = Db::getInstance();
		$sql = "SELECT `id_blockadvertmulti`, `description`, `image_name`, `image_link`, `block_id`, `order`, `active`, `open_blank`, `rotate` FROM `"
		     ._DB_PREFIX_."blockadvertmulti` WHERE (`block_id` = ".$hook.($all ? "": " AND `active` = 1")
			 .") ORDER BY `block_id`, `rotate`, `order`";
		$result = $db->ExecuteS($sql);

		return $result;
	}

	public function countBanners($hook = NULL, $rotator = false)
	{
		$db = Db::getInstance();
		$sql = "SELECT count(*) FROM `"._DB_PREFIX_."blockadvertmulti` WHERE `active` = 1"
		     .($rotator ? " AND `rotate` != 0" : "")
		     .(isset($hook) ? " AND `block_id` = ".$hook : "");
		$result = $db->getValue($sql);

		return $result;
	}
}