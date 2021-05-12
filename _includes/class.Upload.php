<?php 
class Upload {

	public $max_size				= 0;
	public $max_width				= 0;
	public $max_height				= 0;
	public $max_filename			= 0;
	public $allowed_types			= "";
	public $file_temp				= "";
	public $file_name				= "";
	public $orig_name				= "";
	public $file_type				= "";
	public $file_size				= "";
	public $file_ext				= "";
	public $upload_path				= "";
	public $overwrite				= FALSE;
	public $encrypt_name			= FALSE;
	public $is_image				= FALSE;
	public $image_width				= '';
	public $image_height			= '';
	public $image_type				= '';
	public $image_size_str			= '';
	public $error_msg				= array();
	public $mimes					= array();
	public $remove_spaces			= TRUE;
	public $xss_clean				= FALSE;
	public $temp_prefix				= "temp_file_";
	public $client_name				= '';

	protected $_file_name_override	= '';

	/**
	 * Constructor
	 *
	 * @access	public
	 */
	public function __construct($props = array())
	{
		if (count($props) > 0)
		{
			$this->initialize($props);
		}

		//log_message('debug', "Upload Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize preferences
	 *
	 * @param	array
	 * @return	void
	 */
	public function initialize($config = array())
	{
		$defaults = array(
							'max_size'			=> 0,
							'max_width'			=> 0,
							'max_height'		=> 0,
							'max_filename'		=> 0,
							'allowed_types'		=> "",
							'file_temp'			=> "",
							'file_name'			=> "",
							'orig_name'			=> "",
							'file_type'			=> "",
							'file_size'			=> "",
							'file_ext'			=> "",
							'upload_path'		=> "",
							'overwrite'			=> FALSE,
							'encrypt_name'		=> FALSE,
							'is_image'			=> FALSE,
							'image_width'		=> '',
							'image_height'		=> '',
							'image_type'		=> '',
							'image_size_str'	=> '',
							'error_msg'			=> array(),
							'mimes'				=> array(),
							'remove_spaces'		=> TRUE,
							'xss_clean'			=> FALSE,
							'temp_prefix'		=> "temp_file_",
							'client_name'		=> ''
						);


		foreach ($defaults as $key => $val)
		{
			if (isset($config[$key]))
			{
				$method = 'set_'.$key;
				if (method_exists($this, $method))
				{
					$this->$method($config[$key]);
				}
				else
				{
					$this->$key = $config[$key];
				}
			}
			else
			{
				$this->$key = $val;
			}
		}

		// if a file_name was provided in the config, use it instead of the user input
		// supplied file name for all uploads until initialized again
		$this->_file_name_override = $this->file_name;
	}

	// --------------------------------------------------------------------

	/**
	 * Perform the file upload
	 *
	 * @return	bool
	 */
	public function do_upload($field = 'userfile')
	{

	// Is $_FILES[$field] set? If not, no reason to continue.
		if ( ! isset($_FILES[$field])){

			$this->set_error('upload_no_file_selected');
			return FALSE;
		}

		// Is the upload path valid?
		if ( ! $this->validate_upload_path()){
			// errors will already be set by validate_upload_path() so just return FALSE
			return FALSE;
		}

		// Was the file able to be uploaded? If not, determine the reason why.
		if ( ! is_uploaded_file($_FILES[$field]['tmp_name']))
		{
			$error = ( ! isset($_FILES[$field]['error'])) ? 4 : $_FILES[$field]['error'];
			switch($error)
			{
				case 1:	// UPLOAD_ERR_INI_SIZE
					$error = $this->set_error('upload_file_exceeds_limit');
					break;
				case 2: // UPLOAD_ERR_FORM_SIZE
					$error = $this->set_error('upload_file_exceeds_form_limit');
					break;
				case 3: // UPLOAD_ERR_PARTIAL
					$error = $this->set_error('upload_file_partial');
					break;
				case 4: // UPLOAD_ERR_NO_FILE
					$error = $this->set_error('upload_no_file_selected');
					break;
				case 6: // UPLOAD_ERR_NO_TMP_DIR
					$error = $this->set_error('upload_no_temp_directory');
					break;
				case 7: // UPLOAD_ERR_CANT_WRITE
					$error = $this->set_error('upload_unable_to_write_file');
					break;
				case 8: // UPLOAD_ERR_EXTENSION
					$error = $this->set_error('upload_stopped_by_extension');
					break;
				default :   $error = $this->set_error('upload_no_file_selected');
					break;
			}
			return array(1,$error);
		}
		

		// Set the uploaded data as class variables
		$this->file_temp = $_FILES[$field]['tmp_name'];
		$this->file_size = $_FILES[$field]['size'];
		$this->_file_mime_type($_FILES[$field]);
		$this->file_type = preg_replace("/^(.+?);.*$/", "\\1", $this->file_type);
		$this->file_type = strtolower(trim(stripslashes($this->file_type), '"'));
		$this->file_name = $this->_prep_filename($_FILES[$field]['name']);
		$this->file_ext	 = $this->get_extension($this->file_name);
		$this->client_name = $this->file_name;
		
		// Is the file type allowed to be uploaded?
		if ( ! $this->is_allowed_filetype()){
			return array(1,$this->set_error('upload_invalid_filetype'));
		}

		// if we're overriding, let's now make sure the new name and type is allowed
		if ($this->_file_name_override != '')
		{
			$this->file_name = $this->_prep_filename($this->_file_name_override);

			// If no extension was provided in the file_name config item, use the uploaded one
			if (strpos($this->_file_name_override, '.') === FALSE)
			{
				$this->file_name .= $this->file_ext;
			}

			// An extension was provided, lets have it!
			else{
				$this->file_ext	 = $this->get_extension($this->_file_name_override);
			}

			if ( ! $this->is_allowed_filetype(TRUE))
			{
				return array(1,$this->set_error('upload_invalid_filetype'));
			}
		}

		// Convert the file size to kilobytes
		if ($this->file_size > 0)
		{
			$this->file_size = round($this->file_size/1024, 2);
		}

		// Is the file size within the allowed maximum?
		if ( ! $this->is_allowed_filesize())
		{
			return array(1,$this->set_error('upload_invalid_filesize'));
		}

		// Are the image dimensions within the allowed size?
		// Note: This can fail if the server has an open_basdir restriction.
		if ( ! $this->is_allowed_dimensions())
		{
			$this->set_error('upload_invalid_dimensions');
			return array(1,$this->set_error('upload_invalid_dimensions'));
		}

		// Sanitize the file name for security
		$this->file_name = $this->clean_file_name($this->file_name);

		// Truncate the file name if it's too long
		if ($this->max_filename > 0)
		{
			$this->file_name = $this->limit_filename_length($this->file_name, $this->max_filename);
		}

		// Remove white spaces in the name
		if ($this->remove_spaces == TRUE)
		{
			$this->file_name = preg_replace("/\s+/", "_", $this->file_name);
		}

		/*
		 * Validate the file name
		 * This function appends an number onto the end of
		 * the file if one with the same name already exists.
		 * If it returns false there was a problem.
		 */
		$this->orig_name = $this->file_name;

		if ($this->overwrite == FALSE)
		{
			$this->file_name = $this->set_filename($this->upload_path, $this->file_name);

			if ($this->file_name === FALSE)
			{
				return FALSE;
			}
		}

		/*
		 * Run the file through the XSS hacking filter
		 * This helps prevent malicious code from being
		 * embedded within a file.  Scripts can easily
		 * be disguised as images or other file types.
		 */
		if ($this->xss_clean)
		{
			if ($this->do_xss_clean() === FALSE)
			{
				return array(1,$this->set_error('upload_unable_to_write_file'));
			}
		}

		/*
		 * Move the file to the final destination
		 * To deal with different server configurations
		 * we'll attempt to use copy() first.  If that fails
		 * we'll use move_uploaded_file().  One of the two should
		 * reliably work in most environments
		 */
		if ( ! @copy($this->file_temp, $this->upload_path.$this->file_name))
		{
			if ( ! @move_uploaded_file($this->file_temp, $this->upload_path.$this->file_name))
			{
				return array(1,$this->set_error('upload_destination_error'));
			}
		}

		/*
		 * Set the finalized image dimensions
		 * This sets the image width/height (assuming the
		 * file was an image).  We use this information
		 * in the "data" function.
		 */
		 
		$this->set_image_properties($this->upload_path.$this->file_name);
		
		return $this->info_image();
	}
	function info_image(){
		return 
		array(
			0,
			array (
				"images"=>$this->file_name,
				"upload_path"=>$this->upload_path,
				"file_size" =>$this->file_size,
				"width"=>$this->image_width,
				"height"=>$this->image_height,
				"type" => $this->image_type
			)
		);
	}
	// --------------------------------------------------------------------

	/**
	 * Finalized Data Array
	 *
	 * Returns an associative array containing all of the information
	 * related to the upload, allowing the developer easy access in one array.
	 *
	 * @return	array
	 */
	public function data()
	{
		return array (
						'file_name'			=> $this->file_name,
						'file_type'			=> $this->file_type,
						'file_path'			=> $this->upload_path,
						'full_path'			=> $this->upload_path.$this->file_name,
						'raw_name'			=> str_replace($this->file_ext, '', $this->file_name),
						'orig_name'			=> $this->orig_name,
						'client_name'		=> $this->client_name,
						'file_ext'			=> $this->file_ext,
						'file_size'			=> $this->file_size,
						'is_image'			=> $this->is_image(),
						'image_width'		=> $this->image_width,
						'image_height'		=> $this->image_height,
						'image_type'		=> $this->image_type,
						'image_size_str'	=> $this->image_size_str,
					);
	}

	// --------------------------------------------------------------------

	/**
	 * Set Upload Path
	 *
	 * @param	string
	 * @return	void
	 */
	public function set_upload_path($path)
	{
		// Make sure it has a trailing slash
		$this->upload_path = rtrim($path, '/').'/';
	}

	// --------------------------------------------------------------------

	/**
	 * Set the file name
	 *
	 * This function takes a filename/path as input and looks for the
	 * existence of a file with the same name. If found, it will append a
	 * number to the end of the filename to avoid overwriting a pre-existing file.
	 *
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	public function set_filename($path, $filename)
	{
		if ($this->encrypt_name == TRUE)
		{
			mt_srand();
			$filename = md5(uniqid(mt_rand())).$this->file_ext;
		}

		if ( ! file_exists($path.$filename))
		{
			return $filename;
		}

		$filename = str_replace($this->file_ext, '', $filename);

		$new_filename = '';
		for ($i = 1; $i < 100; $i++)
		{
			if ( ! file_exists($path.$filename.$i.$this->file_ext))
			{
				$new_filename = $filename.$i.$this->file_ext;
				break;
			}
		}

		if ($new_filename == '')
		{
			$this->set_error('upload_bad_filename');
			return FALSE;
		}
		else
		{
			return $new_filename;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Set Maximum File Size
	 *
	 * @param	integer
	 * @return	void
	 */
	public function set_max_filesize($n)
	{
		$this->max_size = ((int) $n < 0) ? 0: (int) $n;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Maximum File Name Length
	 *
	 * @param	integer
	 * @return	void
	 */
	public function set_max_filename($n)
	{
		$this->max_filename = ((int) $n < 0) ? 0: (int) $n;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Maximum Image Width
	 *
	 * @param	integer
	 * @return	void
	 */
	public function set_max_width($n)
	{
		$this->max_width = ((int) $n < 0) ? 0: (int) $n;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Maximum Image Height
	 *
	 * @param	integer
	 * @return	void
	 */
	public function set_max_height($n)
	{
		$this->max_height = ((int) $n < 0) ? 0: (int) $n;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Allowed File Types
	 *
	 * @param	string
	 * @return	void
	 */
	public function set_allowed_types($types)
	{
		if ( ! is_array($types) && $types == '*')
		{
			$this->allowed_types = '*';
			return;
		}
		$this->allowed_types = explode('|', $types);
	}

	// --------------------------------------------------------------------

	/**
	 * Set Image Properties
	 *
	 * Uses GD to determine the width/height/type of image
	 *
	 * @param	string
	 * @return	void
	 */
	public function set_image_properties($path = '')
	{
		if ( ! $this->is_image())
		{
			return;
		}

		if (function_exists('getimagesize'))
		{
			if (FALSE !== ($D = @getimagesize($path)))
			{
				$types = array(1 => 'gif', 2 => 'jpeg', 3 => 'png');

				$this->image_width		= $D['0'];
				$this->image_height		= $D['1'];
				$this->image_type		= ( ! isset($types[$D['2']])) ? 'unknown' : $types[$D['2']];
				$this->image_size_str	= $D['3'];  // string containing height and width
			}
		}
		
		
	}

	// --------------------------------------------------------------------

	/**
	 * Set XSS Clean
	 *
	 * Enables the XSS flag so that the file that was uploaded
	 * will be run through the XSS filter.
	 *
	 * @param	bool
	 * @return	void
	 */
	public function set_xss_clean($flag = FALSE)
	{
		$this->xss_clean = ($flag == TRUE) ? TRUE : FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Validate the image
	 *
	 * @return	bool
	 */
	public function is_image()
	{
		// IE will sometimes return odd mime-types during upload, so here we just standardize all
		// jpegs or pngs to the same file type.

		$png_mimes  = array('image/x-png');
		$jpeg_mimes = array('image/jpg', 'image/jpe', 'image/jpeg', 'image/pjpeg');

		if (in_array($this->file_type, $png_mimes))
		{
			$this->file_type = 'image/png';
		}

		if (in_array($this->file_type, $jpeg_mimes))
		{
			$this->file_type = 'image/jpeg';
		}

		$img_mimes = array(
							'image/gif',
							'image/jpeg',
							'image/png',
						);

		return (in_array($this->file_type, $img_mimes, TRUE)) ? TRUE : FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Verify that the filetype is allowed
	 *
	 * @return	bool
	 */
	public function is_allowed_filetype($ignore_mime = FALSE)
	{
		
		if ($this->allowed_types == '*')
		{
			return TRUE;
		}

		if (count($this->allowed_types) == 0 OR ! is_array($this->allowed_types))
		{
			$this->set_error('upload_no_file_types');
			return FALSE;
		}

		$ext = strtolower(ltrim($this->file_ext, '.'));

		if ( ! in_array($ext, $this->allowed_types))
		{
			return FALSE;
		}

		// Images get some additional checks
		$image_types = array('gif', 'jpg', 'jpeg', 'png', 'jpe');

		if (in_array($ext, $image_types))
		{
			if (getimagesize($this->file_temp) === FALSE)
			{
				return FALSE;
			}
		}

		if ($ignore_mime === TRUE)
		{
			return TRUE;
		}

		$mime = $this->mimes_types($ext);

		if (is_array($mime))
		{
			if (in_array($this->file_type, $mime, TRUE))
			{
				return TRUE;
			}
		}
		elseif ($mime == $this->file_type)
		{
				return TRUE;
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Verify that the file is within the allowed size
	 *
	 * @return	bool
	 */
	public function is_allowed_filesize()
	{
		if ($this->max_size != 0  AND  $this->file_size > $this->max_size)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Verify that the image is within the allowed width/height
	 *
	 * @return	bool
	 */
	public function is_allowed_dimensions()
	{
		if ( ! $this->is_image())
		{
			return TRUE;
		}

		if (function_exists('getimagesize'))
		{
			$D = @getimagesize($this->file_temp);

			if ($this->max_width > 0 AND $D['0'] > $this->max_width)
			{
				return FALSE;
			}

			if ($this->max_height > 0 AND $D['1'] > $this->max_height)
			{
				return FALSE;
			}

			return TRUE;
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Validate Upload Path
	 *
	 * Verifies that it is a valid upload path with proper permissions.
	 *
	 *
	 * @return	bool
	 */
	public function validate_upload_path()
	{
		if ($this->upload_path == '')
		{
			$this->set_error('upload_no_filepath');
			return FALSE;
		}

		if (function_exists('realpath') AND @realpath($this->upload_path) !== FALSE)
		{
			$this->upload_path = str_replace("\\", "/", realpath($this->upload_path));
		}
		if ( ! @is_dir($this->upload_path))
		{
			$this->set_error('upload_no_filepath');
			return FALSE;
		}

		if ( ! $this->is_really_writable($this->upload_path))
		{
			$this->set_error('upload_not_writable');
			return FALSE;
		}

		$this->upload_path = preg_replace("/(.+?)\/*$/", "\\1/",  $this->upload_path);
		
		return TRUE;
	}
	function is_really_writable($file)
	{
		
		// If we're on a Unix server with safe_mode off we call is_writable
		if (DIRECTORY_SEPARATOR == '/' AND @ini_get("safe_mode") == FALSE)
		{
			return is_writable($file);
		}

		// For windows servers and safe_mode "on" installations we'll actually
		// write a file then read it.  Bah...
		if (is_dir($file))
		{
			/*
			$file = rtrim($file, '/').'/'.md5(mt_rand(1,100).mt_rand(1,100));
			
			if (($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE)
			{
				return FALSE;
			}

			fclose($fp);
			
			@chmod($file, DIR_WRITE_MODE);
			@unlink($file);*/
			return TRUE;
		}
		elseif ( ! is_file($file) OR ($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE)
		{
			return FALSE;
		}

		fclose($fp);
		return TRUE;
	}
	// --------------------------------------------------------------------

	/**
	 * Extract the file extension
	 *
	 * @param	string
	 * @return	string
	 */
	public function get_extension($filename)
	{
		$x = explode('.', $filename);
		return '.'.end($x);
	}

	// --------------------------------------------------------------------

	/**
	 * Clean the file name for security
	 *
	 * @param	string
	 * @return	string
	 */
	public function clean_file_name($filename)
	{
		$bad = array(
						"<!--",
						"-->",
						"'",
						"<",
						">",
						'"',
						'&',
						'$',
						'=',
						';',
						'?',
						'/',
						"%20",
						"%22",
						"%3c",		// <
						"%253c",	// <
						"%3e",		// >
						"%0e",		// >
						"%28",		// (
						"%29",		// )
						"%2528",	// (
						"%26",		// &
						"%24",		// $
						"%3f",		// ?
						"%3b",		// ;
						"%3d"		// =
					);

		$filename = str_replace($bad, '', $filename);

		return stripslashes($filename);
	}

	// --------------------------------------------------------------------

	/**
	 * Limit the File Name Length
	 *
	 * @param	string
	 * @return	string
	 */
	public function limit_filename_length($filename, $length)
	{
		if (strlen($filename) < $length)
		{
			return $filename;
		}

		$ext = '';
		if (strpos($filename, '.') !== FALSE)
		{
			$parts		= explode('.', $filename);
			$ext		= '.'.array_pop($parts);
			$filename	= implode('.', $parts);
		}

		return substr($filename, 0, ($length - strlen($ext))).$ext;
	}

	// --------------------------------------------------------------------

	/**
	 * Runs the file through the XSS clean function
	 *
	 * This prevents people from embedding malicious code in their files.
	 * I'm not sure that it won't negatively affect certain files in unexpected ways,
	 * but so far I haven't found that it causes trouble.
	 *
	 * @return	void
	 */
	public function do_xss_clean()
	{
		$file = $this->file_temp;

		if (filesize($file) == 0)
		{
			return FALSE;
		}

		if (function_exists('memory_get_usage') && memory_get_usage() && ini_get('memory_limit') != '')
		{
			$current = ini_get('memory_limit') * 1024 * 1024;

			// There was a bug/behavioural change in PHP 5.2, where numbers over one million get output
			// into scientific notation.  number_format() ensures this number is an integer
			// http://bugs.php.net/bug.php?id=43053

			$new_memory = number_format(ceil(filesize($file) + $current), 0, '.', '');

			ini_set('memory_limit', $new_memory); // When an integer is used, the value is measured in bytes. - PHP.net
		}

		// If the file being uploaded is an image, then we should have no problem with XSS attacks (in theory), but
		// IE can be fooled into mime-type detecting a malformed image as an html file, thus executing an XSS attack on anyone
		// using IE who looks at the image.  It does this by inspecting the first 255 bytes of an image.  To get around this
		// CI will itself look at the first 255 bytes of an image to determine its relative safety.  This can save a lot of
		// processor power and time if it is actually a clean image, as it will be in nearly all instances _except_ an
		// attempted XSS attack.

		if (function_exists('getimagesize') && @getimagesize($file) !== FALSE)
		{
			if (($file = @fopen($file, 'rb')) === FALSE) // "b" to force binary
			{
				return FALSE; // Couldn't open the file, return FALSE
			}

			$opening_bytes = fread($file, 256);
			fclose($file);

			// These are known to throw IE into mime-type detection chaos
			// <a, <body, <head, <html, <img, <plaintext, <pre, <script, <table, <title
			// title is basically just in SVG, but we filter it anyhow

			if ( ! preg_match('/<(a|body|head|html|img|plaintext|pre|script|table|title)[\s>]/i', $opening_bytes))
			{
				return TRUE; // its an image, no "triggers" detected in the first 256 bytes, we're good
			}
			else
			{
				return FALSE;
			}
		}

		if (($data = @file_get_contents($file)) === FALSE)
		{
			return FALSE;
		}

		
		return $this->xss_clean($data, TRUE);
	}
	public function xss_clean($str, $is_image = FALSE)
	{
		/*
		 * Is the string an array?
		 *
		 */
		if (is_array($str))
		{
			while (list($key) = each($str))
			{
				$str[$key] = $this->xss_clean($str[$key]);
			}

			return $str;
		}

		/*
		 * Remove Invisible Characters
		 */
		$str = remove_invisible_characters($str);

		// Validate Entities in URLs
		$str = $this->_validate_entities($str);

		/*
		 * URL Decode
		 *
		 * Just in case stuff like this is submitted:
		 *
		 * <a href="http://%77%77%77%2E%67%6F%6F%67%6C%65%2E%63%6F%6D">Google</a>
		 *
		 * Note: Use rawurldecode() so it does not remove plus signs
		 *
		 */
		$str = rawurldecode($str);

		/*
		 * Convert character entities to ASCII
		 *
		 * This permits our tests below to work reliably.
		 * We only convert entities that are within tags since
		 * these are the ones that will pose security problems.
		 *
		 */

		$str = preg_replace_callback("/[a-z]+=([\'\"]).*?\\1/si", array($this, '_convert_attribute'), $str);

		$str = preg_replace_callback("/<\w+.*?(?=>|<|$)/si", array($this, '_decode_entity'), $str);

		/*
		 * Remove Invisible Characters Again!
		 */
		$str = remove_invisible_characters($str);

		/*
		 * Convert all tabs to spaces
		 *
		 * This prevents strings like this: ja	vascript
		 * NOTE: we deal with spaces between characters later.
		 * NOTE: preg_replace was found to be amazingly slow here on
		 * large blocks of data, so we use str_replace.
		 */

		if (strpos($str, "\t") !== FALSE)
		{
			$str = str_replace("\t", ' ', $str);
		}

		/*
		 * Capture converted string for later comparison
		 */
		$converted_string = $str;

		// Remove Strings that are never allowed
		$str = $this->_do_never_allowed($str);

		/*
		 * Makes PHP tags safe
		 *
		 * Note: XML tags are inadvertently replaced too:
		 *
		 * <?xml
		 *
		 * But it doesn't seem to pose a problem.
		 */
		if ($is_image === TRUE)
		{
			// Images have a tendency to have the PHP short opening and
			// closing tags every so often so we skip those and only
			// do the long opening tags.
			$str = preg_replace('/<\?(php)/i', "&lt;?\\1", $str);
		}
		else
		{
			$str = str_replace(array('<?', '?'.'>'),  array('&lt;?', '?&gt;'), $str);
		}

		/*
		 * Compact any exploded words
		 *
		 * This corrects words like:  j a v a s c r i p t
		 * These words are compacted back to their correct state.
		 */
		$words = array(
			'javascript', 'expression', 'vbscript', 'script', 'base64',
			'applet', 'alert', 'document', 'write', 'cookie', 'window'
		);

		foreach ($words as $word)
		{
			$temp = '';

			for ($i = 0, $wordlen = strlen($word); $i < $wordlen; $i++)
			{
				$temp .= substr($word, $i, 1)."\s*";
			}

			// We only want to do this when it is followed by a non-word character
			// That way valid stuff like "dealer to" does not become "dealerto"
			$str = preg_replace_callback('#('.substr($temp, 0, -3).')(\W)#is', array($this, '_compact_exploded_words'), $str);
		}

		/*
		 * Remove disallowed Javascript in links or img tags
		 * We used to do some version comparisons and use of stripos for PHP5,
		 * but it is dog slow compared to these simplified non-capturing
		 * preg_match(), especially if the pattern exists in the string
		 */
		do
		{
			$original = $str;

			if (preg_match("/<a/i", $str))
			{
				$str = preg_replace_callback("#<a\s+([^>]*?)(>|$)#si", array($this, '_js_link_removal'), $str);
			}

			if (preg_match("/<img/i", $str))
			{
				$str = preg_replace_callback("#<img\s+([^>]*?)(\s?/?>|$)#si", array($this, '_js_img_removal'), $str);
			}

			if (preg_match("/script/i", $str) OR preg_match("/xss/i", $str))
			{
				$str = preg_replace("#<(/*)(script|xss)(.*?)\>#si", '[removed]', $str);
			}
		}
		while($original != $str);

		unset($original);

		// Remove evil attributes such as style, onclick and xmlns
		$str = $this->_remove_evil_attributes($str, $is_image);

		/*
		 * Sanitize naughty HTML elements
		 *
		 * If a tag containing any of the words in the list
		 * below is found, the tag gets converted to entities.
		 *
		 * So this: <blink>
		 * Becomes: &lt;blink&gt;
		 */
		$naughty = 'alert|applet|audio|basefont|base|behavior|bgsound|blink|body|embed|expression|form|frameset|frame|head|html|ilayer|iframe|input|isindex|layer|link|meta|object|plaintext|style|script|textarea|title|video|xml|xss';
		$str = preg_replace_callback('#<(/*\s*)('.$naughty.')([^><]*)([><]*)#is', array($this, '_sanitize_naughty_html'), $str);

		/*
		 * Sanitize naughty scripting elements
		 *
		 * Similar to above, only instead of looking for
		 * tags it looks for PHP and JavaScript commands
		 * that are disallowed.  Rather than removing the
		 * code, it simply converts the parenthesis to entities
		 * rendering the code un-executable.
		 *
		 * For example:	eval('some code')
		 * Becomes:		eval&#40;'some code'&#41;
		 */
		$str = preg_replace('#(alert|cmd|passthru|eval|exec|expression|system|fopen|fsockopen|file|file_get_contents|readfile|unlink)(\s*)\((.*?)\)#si', "\\1\\2&#40;\\3&#41;", $str);


		// Final clean up
		// This adds a bit of extra precaution in case
		// something got through the above filters
		$str = $this->_do_never_allowed($str);

		/*
		 * Images are Handled in a Special Way
		 * - Essentially, we want to know that after all of the character
		 * conversion is done whether any unwanted, likely XSS, code was found.
		 * If not, we return TRUE, as the image is clean.
		 * However, if the string post-conversion does not matched the
		 * string post-removal of XSS, then it fails, as there was unwanted XSS
		 * code found and removed/changed during processing.
		 */

		if ($is_image === TRUE)
		{
			return ($str == $converted_string) ? TRUE: FALSE;
		}

		//log_message('debug', "XSS Filtering completed");
		return $str;
	}

	// --------------------------------------------------------------------

	/**
	 * Set an error message
	 *
	 * @param	string
	 * @return	void
	 */
	public function set_error($msg)
	{
		/*
		$CI =& get_instance();
		$CI->lang->load('upload');*/
		if (is_array($msg)){
			foreach ($msg as $val){
				$msg1 = ($this->lang_line($val,$_FILES["userfile"]["name"]) == FALSE) ? $val : $this->lang_line($val,$_FILES["userfile"]["name"]);
				$this->error_msg[] = $msg1;
				//log_message('error', $msg1);
			}
		}
		else{
			$msg = ($this->lang_line($msg,$_FILES["userfile"]["name"]) == FALSE) ? $msg : $this->lang_line($msg,$_FILES["userfile"]["name"]);
			$this->error_msg[] = $msg;
			//log_message('error', $msg);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Display the error message
	 *
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	public function display_errors($open = '<p>', $close = '</p>')
	{
		$str = '';
		foreach ($this->error_msg as $val)
		{
			$str .= $open.$val.$close;
		}
		return $str;
	}

	// --------------------------------------------------------------------

	/**
	 * List of Mime Types
	 *
	 * This is a list of mime types.  We use it to validate
	 * the "allowed types" set by the developer
	 *
	 * @param	string
	 * @return	string
	 */
	public function mimes_types($mime)
	{
		global $mimes;
		$this->mimes = array(	'hqx'	=>	'application/mac-binhex40',
				'cpt'	=>	'application/mac-compactpro',
				'csv'	=>	array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel'),
				'bin'	=>	'application/macbinary',
				'dms'	=>	'application/octet-stream',
				'lha'	=>	'application/octet-stream',
				'lzh'	=>	'application/octet-stream',
				'exe'	=>	array('application/octet-stream', 'application/x-msdownload'),
				'class'	=>	'application/octet-stream',
				'psd'	=>	'application/x-photoshop',
				'so'	=>	'application/octet-stream',
				'sea'	=>	'application/octet-stream',
				'dll'	=>	'application/octet-stream',
				'oda'	=>	'application/oda',
				'pdf'	=>	array('application/pdf', 'application/x-download'),
				'ai'	=>	'application/postscript',
				'eps'	=>	'application/postscript',
				'ps'	=>	'application/postscript',
				'smi'	=>	'application/smil',
				'smil'	=>	'application/smil',
				'mif'	=>	'application/vnd.mif',
				'xls'	=>	array('application/excel', 'application/vnd.ms-excel', 'application/msexcel'),
				'ppt'	=>	array('application/powerpoint', 'application/vnd.ms-powerpoint'),
				'wbxml'	=>	'application/wbxml',
				'wmlc'	=>	'application/wmlc',
				'dcr'	=>	'application/x-director',
				'dir'	=>	'application/x-director',
				'dxr'	=>	'application/x-director',
				'dvi'	=>	'application/x-dvi',
				'gtar'	=>	'application/x-gtar',
				'gz'	=>	'application/x-gzip',
				'php'	=>	'application/x-httpd-php',
				'php4'	=>	'application/x-httpd-php',
				'php3'	=>	'application/x-httpd-php',
				'phtml'	=>	'application/x-httpd-php',
				'phps'	=>	'application/x-httpd-php-source',
				'js'	=>	'application/x-javascript',
				'swf'	=>	'application/x-shockwave-flash',
				'sit'	=>	'application/x-stuffit',
				'tar'	=>	'application/x-tar',
				'tgz'	=>	array('application/x-tar', 'application/x-gzip-compressed'),
				'xhtml'	=>	'application/xhtml+xml',
				'xht'	=>	'application/xhtml+xml',
				'zip'  =>   array('application/x-zip', 'application/zip', 'application/x-zip-compressed','application/force-download','application/octet-stream'),
				'mid'	=>	'audio/midi',
				'midi'	=>	'audio/midi',
				'mpga'	=>	'audio/mpeg',
				'mp2'	=>	'audio/mpeg',
				'mp3'	=>	array('audio/mpeg', 'audio/mpg', 'audio/mpeg3', 'audio/mp3'),
				'aif'	=>	'audio/x-aiff',
				'aiff'	=>	'audio/x-aiff',
				'aifc'	=>	'audio/x-aiff',
				'ram'	=>	'audio/x-pn-realaudio',
				'rm'	=>	'audio/x-pn-realaudio',
				'rpm'	=>	'audio/x-pn-realaudio-plugin',
				'ra'	=>	'audio/x-realaudio',
				'rv'	=>	'video/vnd.rn-realvideo',
				'wav'	=>	array('audio/x-wav', 'audio/wave', 'audio/wav'),
				'bmp'	=>	array('image/bmp', 'image/x-windows-bmp'),
				'gif'	=>	'image/gif',
				'jpeg'	=>	array('image/jpeg', 'image/pjpeg'),
				'jpg'	=>	array('image/jpeg', 'image/pjpeg'),
				'jpe'	=>	array('image/jpeg', 'image/pjpeg'),
				'png'	=>	array('image/png',  'image/x-png'),
				'tiff'	=>	'image/tiff',
				'tif'	=>	'image/tiff',
				'css'	=>	'text/css',
				'html'	=>	'text/html',
				'htm'	=>	'text/html',
				'shtml'	=>	'text/html',
				'txt'	=>	'text/plain',
				'text'	=>	'text/plain',
				'log'	=>	array('text/plain', 'text/x-log'),
				'rtx'	=>	'text/richtext',
				'rtf'	=>	'text/rtf',
				'xml'	=>	'text/xml',
				'xsl'	=>	'text/xml',
				'mpeg'	=>	'video/mpeg',
				'mpg'	=>	'video/mpeg',
				'mpe'	=>	'video/mpeg',
				'qt'	=>	'video/quicktime',
				'mov'	=>	'video/quicktime',
				'avi'	=>	'video/x-msvideo',
				'movie'	=>	'video/x-sgi-movie',
				'doc'	=>	'application/msword',
				'docx'	=>	array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip'),
				'xlsx'	=>	array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip'),
				'word'	=>	array('application/msword', 'application/octet-stream'),
				'xl'	=>	'application/excel',
				'eml'	=>	'message/rfc822',
				'json' => 	array('application/json', 'text/json'),
				'rar'  =>  	array('application/x-rar', 'application/rar','application/x-rar-compressed','application/force-download','application/octet-stream'),
			);

		return ( ! isset($this->mimes[$mime])) ? FALSE : $this->mimes[$mime];
	}

	// --------------------------------------------------------------------

	/**
	 * Prep Filename
	 *
	 * Prevents possible script execution from Apache's handling of files multiple extensions
	 * http://httpd.apache.org/docs/1.3/mod/mod_mime.html#multipleext
	 *
	 * @param	string
	 * @return	string
	 */
	protected function _prep_filename($filename){
		if (strpos($filename, '.') === FALSE OR $this->allowed_types == '*')
		{
			return $filename;
		}
		$parts		= explode('.', $filename);
		$ext		= array_pop($parts);
		$filename	= array_shift($parts);

		foreach ($parts as $part)
		{
			if ( ! in_array(strtolower($part), $this->allowed_types) OR $this->mimes_types(strtolower($part)) === FALSE)
			{
				$filename .= '.'.$part.'_';
			}
			else
			{
				$filename .= '.'.$part;
			}
		}

		$filename .= '.'.$ext;

		return $filename;
	}

	// --------------------------------------------------------------------

	/**
	 * File MIME type
	 *
	 * Detects the (actual) MIME type of the uploaded file, if possible.
	 * The input array is expected to be $_FILES[$field]
	 *
	 * @param	array
	 * @return	void
	 */
	protected function _file_mime_type($file)
	{
		// We'll need this to validate the MIME info string (e.g. text/plain; charset=us-ascii)
		$regexp = '/^([a-z\-]+\/[a-z0-9\-\.\+]+)(;\s.+)?$/';

		/* Fileinfo extension - most reliable method
		 *
		 * Unfortunately, prior to PHP 5.3 - it's only available as a PECL extension and the
		 * more convenient FILEINFO_MIME_TYPE flag doesn't exist.
		 */
		if (function_exists('finfo_file'))
		{
			$finfo = finfo_open(FILEINFO_MIME);
			if (is_resource($finfo)) // It is possible that a FALSE value is returned, if there is no magic MIME database file found on the system
			{
				$mime = @finfo_file($finfo, $file['tmp_name']);
				finfo_close($finfo);

				/* According to the comments section of the PHP manual page,
				 * it is possible that this function returns an empty string
				 * for some files (e.g. if they don't exist in the magic MIME database)
				 */
				if (is_string($mime) && preg_match($regexp, $mime, $matches))
				{
					$this->file_type = $matches[1];
					return;
				}
			}
		}

		/* This is an ugly hack, but UNIX-type systems provide a "native" way to detect the file type,
		 * which is still more secure than depending on the value of $_FILES[$field]['type'], and as it
		 * was reported in issue #750 (https://github.com/EllisLab/CodeIgniter/issues/750) - it's better
		 * than mime_content_type() as well, hence the attempts to try calling the command line with
		 * three different functions.
		 *
		 * Notes:
		 *	- the DIRECTORY_SEPARATOR comparison ensures that we're not on a Windows system
		 *	- many system admins would disable the exec(), shell_exec(), popen() and similar functions
		 *	  due to security concerns, hence the function_exists() checks
		 */
		if (DIRECTORY_SEPARATOR !== '\\')
		{
			$cmd = 'file --brief --mime ' . @escapeshellarg($file['tmp_name']) . ' 2>&1';

			if (function_exists('exec'))
			{
				/* This might look confusing, as $mime is being populated with all of the output when set in the second parameter.
				 * However, we only neeed the last line, which is the actual return value of exec(), and as such - it overwrites
				 * anything that could already be set for $mime previously. This effectively makes the second parameter a dummy
				 * value, which is only put to allow us to get the return status code.
				 */
				$mime = @exec($cmd, $mime, $return_status);
				if ($return_status === 0 && is_string($mime) && preg_match($regexp, $mime, $matches))
				{
					$this->file_type = $matches[1];
					return;
				}
			}

			if ( (bool) @ini_get('safe_mode') === FALSE && function_exists('shell_exec'))
			{
				$mime = @shell_exec($cmd);
				if (strlen($mime) > 0)
				{
					$mime = explode("\n", trim($mime));
					if (preg_match($regexp, $mime[(count($mime) - 1)], $matches))
					{
						$this->file_type = $matches[1];
						return;
					}
				}
			}

			if (function_exists('popen'))
			{
				$proc = @popen($cmd, 'r');
				if (is_resource($proc))
				{
					$mime = @fread($proc, 512);
					@pclose($proc);
					if ($mime !== FALSE){
						$mime = explode("\n", trim($mime));
						if (preg_match($regexp, $mime[(count($mime) - 1)], $matches)){
							$this->file_type = $matches[1];
							return;
						}
					}
				}
			}
		}

		// Fall back to the deprecated mime_content_type(), if available (still better than $_FILES[$field]['type'])
		if (function_exists('mime_content_type'))
		{
			$this->file_type = @mime_content_type($file['tmp_name']);
			if (strlen($this->file_type) > 0) // It's possible that mime_content_type() returns FALSE or an empty string
			{
				return;
			}
		}

		$this->file_type = $file['type'];
	}
	function lang_line($key,$filename){
		$lang['upload_userfile_not_set'] = "unable to find a post variable called userfile.";
		$lang['upload_file_exceeds_limit'] = " the uploaded file exceeds the maximum allowed size in your PHP configuration file.";
		$lang['upload_file_exceeds_form_limit'] = " the uploaded file exceeds the maximum size allowed by the submission form.";
		$lang['upload_file_partial'] = " the file was only partially uploaded.";
		$lang['upload_no_temp_directory'] = " the temporary folder is missing.";
		$lang['upload_unable_to_write_file'] = " the file could not be written to disk.";
		$lang['upload_stopped_by_extension'] = " the file upload was stopped by extension.";
		$lang['upload_no_file_selected'] = " you did not select a file to upload.";
		$lang['upload_invalid_filetype'] = " the filetype you are attempting to upload is not allowed.";
		$lang['upload_invalid_filesize'] = " the file you are attempting to upload is larger than the permitted size.";
		$lang['upload_invalid_dimensions'] = " the image you are attempting to upload exceedes the maximum height or width.";
		$lang['upload_destination_error'] = " a problem was encountered while attempting to move the uploaded file to the final destination.";
		$lang['upload_no_filepath'] = " the upload path does not appear to be valid.";
		$lang['upload_no_file_types'] = " you have not specified any allowed file types.";
		$lang['upload_bad_filename'] = " the file name you submitted already exists on the server.";
		$lang['upload_not_writable'] = " the upload destination folder does not appear to be writable.";
		return $filename.$lang[$key];
	}
	// --------------------------------------------------------------------

}
// END Upload Class

/* End of file Upload.php */
/* Location: ./system/libraries/Upload.php */
