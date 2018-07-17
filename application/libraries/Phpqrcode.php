<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PHP QR Code encoder
 *
 * This file contains MERGED version of PHP QR Code library.
 * It was auto-generated from full version for your convenience.
 *
 * This merged version was configured to not requre any external files,
 * with disabled cache, error loging and weker but faster mask matching.
 * If you need tune it up please use non-merged version.
 *
 * For full version, documentation, examples of use please visit:
 *
 *    http://phpqrcode.sourceforge.net/
 *    https://sourceforge.net/projects/phpqrcode/
 *
 * PHP QR Code is distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

/**
 * Version: 1.1.4
 * Build: 2010100721
 */

/**
 * @category   PHPQRCode
 * @package    PHPQRCode
 * @copyright  Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 * @license    PHP QR Code is distributed under LGPL 3
 * @version    1.1.4
 */

class PHPQRCode {

	var $height = null; //Alto de la imagen
	var $width = null;  //Ancho de la imagen
	var $code = null;   //Codigo del usuario para generar la imagen
	var $link = null;   //Direccion URL a dónde se dirige la imagen.
	
	/**
	 * Constructor de la clase PHPQRCode
	 * Carga las librerias requeridas para la generacion de imágenes de Códigos QR.
	 * @author dmdiazf
	 * @since  22/10/2015
	 */
	function __construct() {
		require_once("phpqrcode/qrlib.php");
	}

	/**
	 * Setter para el code de la imagen QR
	 * @author dmdiazf
	 * @since  22/10/2015
	 */
	public function setCode($code) {
		$this->code = $code;
	}
	
	/**
	 * Setter para el link de la imagen QR
	 * @author dmdiazf
	 * @since  22/10/2015
	 */
	public function setLink($link) {
		$this->link = $link;
	}
	
	/**
	 * Genera la imagen del código QR a partir de los datos que se reciben por parámetro.
	 * @author dmdiazf
	 * @author oagarzond
	 * @since 2017-04-27
	 */
	public function generateQRImage() {
		ob_start("callback");
		$this->link = $this->link . "/" . $this->code;
		$debugLog = ob_get_contents();
		ob_end_clean();
		QRcode::png($this->link, base_dir_files('QR/' . $this->code . '.png'), QR_ECLEVEL_Q, 3, 3);
	}
}
/* End of file PHPQRCode.php */