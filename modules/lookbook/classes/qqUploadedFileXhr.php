<?php
require_once(realpath(dirname(__FILE__).'/../../../config/config.inc.php'));
require_once(realpath(dirname(__FILE__).'/../../../init.php'));
include_once(dirname(__FILE__).'/../lookbook.php');
/**
 * Handle file uploads via XMLHttpRequest
 */
class qqUploadedFileXhr
{
	/**
	 * Save the file to the specified path
	 * @return boolean TRUE on success
	 */
	function save($path)
	{
		$input = fopen("php://input", "r");
		$temp = tmpfile();
		$realSize = stream_copy_to_stream($input, $temp);
		fclose($input);
		
		if ($realSize != $this->getSize()){			   
			return false;
		}
		
		$target = fopen($path, "w");		
		fseek($temp, 0, SEEK_SET);
		stream_copy_to_stream($temp, $target);
		fclose($target);
		
		return true;
	}

	function getName()
	{
		return $_GET['qqfile'];
	}

	function getSize()
	{
		if (isset($_SERVER["CONTENT_LENGTH"]))
		{
			return (int)$_SERVER["CONTENT_LENGTH"];			   
		}
		else
		{
			throw new Exception('Getting content length is not supported.');
		}	   
	}	
}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm
{
	/**
	 * Save the file to the specified path
	 * @return boolean TRUE on success
	 */
	function save($path)
	{
		if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path))
		{
			return false;
		}
		return true;
	}


	function getName()
	{
		return $_FILES['qqfile']['name'];
	}


	function getSize()
	{
		return $_FILES['qqfile']['size'];
	}
}

class qqFileUploader
{
	private $allowedExtensions = array();
	private $sizeLimit = 2048000;
	private $file;

	function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760)
	{
		$allowedExtensions = array_map("strtolower", $allowedExtensions);
			
		$this->allowedExtensions = $allowedExtensions;		  
		$this->sizeLimit = $sizeLimit;
		
		$this->checkServerSettings();		

		if (isset($_GET['qqfile']))
		{
			$this->file = new qqUploadedFileXhr();
		}
		elseif (isset($_FILES['qqfile']))
		{
			$this->file = new qqUploadedFileForm();
		}
		else
		{
			$this->file = false; 
		}
	}
	
	private function checkServerSettings()
	{
		$postSize = $this->toBytes(ini_get('post_max_size'));
		$uploadSize = $this->toBytes(ini_get('upload_max_filesize'));

		if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit)
		{
			$size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';
			die("{'error':'increase post_max_size and upload_max_filesize to $size'}");	   
		}		 
	}
	
	private function toBytes($str)
	{
		$val = trim($str);
		$last = strtolower($str[strlen($str)-1]);

		switch($last) {
			case 'g':
				$val *= 1024 * 1024 * 1024;
				break;
			case 'm':
				$val *= 1024 * 1024;
				break;
			case 'k':
				$val *= 1024;
				break;
			default :
				break;
		}
		return $val;
	}
	
	/**
	 * Returns array('success'=>true) or array('error'=>'error message')
	 */
	function handleUpload($uploadDirectory, $replaceOldFile = FALSE)
	{
		if (!is_writable($uploadDirectory)){
			return array('error' => "Server error. Upload directory isn't writable.");
		}
		if (!is_writable($uploadDirectory.'thumbs/')){
            return array('error' => "Server error. Thumbs directory isn't writable.");
        }
		
		if (!$this->file){
			return array('error' => 'No files were uploaded.');
		}
		
		$size = $this->file->getSize();
		
		if ($size == 0)
		{
			return array('error' => 'File is empty');
		}
		
		if ($size > $this->sizeLimit) {
			return array('error' => 'File is too large');
		}
		
		$pathinfo = pathinfo($this->file->getName());
		$filename = $pathinfo['filename'];
		//$filename = md5(uniqid());
		$ext = $pathinfo['extension'];

		if ($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions))
		{
			$these = implode(', ', $this->allowedExtensions);
			return array('error' => 'File has an invalid extension, it should be one of '. $these . '.');
		}
		
		if (!$replaceOldFile){
			/// don't overwrite previous files that were uploaded
			while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
				$filename .= rand(10, 99);
			}
		}
		
		if ($this->file->save($uploadDirectory . $filename . '.' . $ext)){

		/* BT MOD For lookbook, Start of mod */
			$l = new Lookbook;
			$l->loadConfiguration();
			$width = $l->getConfigurationValue('LOOKBOOK_IMG_DIMENSIONS');
			$thWidth = $l->getConfigurationValue('LOOKBOOK_IMG_TH_DIMENSIONS');
			list($width_orig, $height_orig) = getimagesize($uploadDirectory . $filename . '.' . $ext);

			if ($width_orig >= $height_orig)
			{
				$height = floor(($height_orig*$width)/$width_orig);
				$thHeight = floor(($height_orig*$thWidth)/$width_orig);
			}
			else
			{
				$height = floor(($height_orig * $width) / $width_orig);
				$thHeight = floor(($height_orig * $thWidth) / $width_orig);
			}
			/*
			$dim = array(	
					'width_orig'=>$width_orig,
					'width'=>$width,
					'thWidth'=>$thWidth,
					'height_orig'=>$height_orig,
					'height'=>$height,
					'thHeight'=>$thHeight,
				);
			*/

			//print_r($dim); die();

			// Resample
			// for image
			$image_p = imagecreatetruecolor($width, $height);
			$image = imagecreatefromjpeg($uploadDirectory . $filename . '.' . $ext);
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
			// for thumb
			$thImage_p = imagecreatetruecolor($thWidth, $thHeight);
			$thImage = imagecreatefromjpeg($uploadDirectory . $filename . '.' . $ext);
			imagecopyresampled($thImage_p, $image, 0, 0, 0, 0, $thWidth, $thHeight, $width_orig, $height_orig);
			
			// Output
			if(isset($_GET['id_lookbook']) && $_GET['id_lookbook'] > 0 && isset($_GET['id_lang']) && $_GET['id_lang'] > 0)
			{
				$newImageName = $_GET['id_lookbook'].'-'.$_GET['id_lang'];
				if(imagejpeg($image_p, $uploadDirectory.$newImageName.'.'.$ext, 100))
				{
					imagedestroy($image_p);
				}
				else
				{
					return array('error'=> 'Could not save uploaded file.');
				}
					
				if (imagejpeg($thImage_p, $uploadDirectory . 'thumbs/'.$newImageName.'.'.$ext, 100))
				{
					imagedestroy($thImage_p);
					unlink($uploadDirectory . $filename . '.' . $ext);
				}
				else
				{
					return array('error'=> 'Could not save uploaded file.');
				}
				
				$l->registerLookbookImage($_GET['id_lookbook'],$_GET['id_lang']);
					
				return array('success'=>true);
			}
			else
			{
				return array('error'=> 'Lookbook can\'t be found.');
			}
		}
		else
		{
			return (
				array(
					'error'=> 'Could not save uploaded file. The upload was cancelled, or server error encountered'
				)
			);
		}
		
	}	 
}

// list of valid extensions, ex. array("jpeg", "xml", "bmp")
$allowedExtensions = array('jpg', 'jpeg');
// max file size in bytes
$sizeLimit = 2 * 1024 * 1024;

if( !file_exists("../uploads") )
{
	mkdir("../uploads/thumbs", 0777, true);
}

if( !file_exists("../uploads/thumbs") )
{
	mkdir("../uploads/thumbs", 0777, true);
}

$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
$result = $uploader->handleUpload('../uploads/', TRUE);
// to pass data through iframe you will need to encode all html tags
echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
