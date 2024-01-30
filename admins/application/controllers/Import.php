<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Import extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('import_model');
	}

	public function import_data()
	{

		$target_dir = 'import/files/';

		if (!file_exists($target_dir)) {

			mkdir($target_dir, 0777, true);
		}

		$target_file = $target_dir . basename($_FILES["imported_data"]["name"]);

		if (move_uploaded_file($_FILES["imported_data"]["tmp_name"], $target_file)) {

			$e = explode(".", $target_file);
			$path = reset($e);

			$zip = new ZipArchive;
			$res = $zip->open($target_file);
			if ($res === TRUE) {

				$zip->extractTo($path);
				$zip->close();
			} else {

				die("failure to extract");
			}

			$zip = zip_open($target_file);

			if ($zip) {

				$server = $this->import_model->fetch_server($this->import_model->loginId)['server'];

				if ($server == "server_tal") {

					$tk  = "tk_talibon";
					$pis = "pis";
				} else if ($server == "server_tub") {

					$tk  = "tk_tubigon";
					$pis = "pis";
				} else if ($server == "server_colonnade") {

					$tk  = "tk_colonnade";
					$pis = "pis_colonnade";
				} else if ($server == "server_tag") {

					$tk  = "timekeeping";
					$pis = "pis";
				} else {

					die("failure");
				}

				while ($zip_entry = zip_read($zip)) {

					$filename = zip_entry_name($zip_entry);
					$file = explode(".", $filename);
					$v = reset($file);

					if ($filename != 'termination.sql' && $filename != 'employee3.sql' && $filename != 'applicant.sql' && $filename != 'promo_vendor_lists.sql' && $filename != 'locate_promo_company.sql' && $filename != 'photo.sql' && $filename != 'promo_record.sql') {

						if ($filename == "assign_mul_sc_cs.sql" || $filename == "assign_mul_sc_odaf.sql") {
							$sql = "LOAD DATA LOCAL INFILE '$path/$filename' REPLACE
					       				INTO TABLE assign_mul_sc CHARACTER SET utf8mb4";
						} else {
							$sql = "LOAD DATA LOCAL INFILE '$path/$filename' REPLACE
					       				INTO TABLE $v CHARACTER SET utf8mb4";
						}
						$query = $this->import_model->query_this($tk, $sql);
					} else if ($filename == 'termination.sql' || $filename == 'employee3.sql' || $filename == 'applicant.sql' || $filename == 'promo_record.sql' || $filename == 'promo_vendor_lists.sql' || $filename == 'locate_promo_company.sql') {

						$sql = "LOAD DATA LOCAL INFILE '$path/$filename' REPLACE
					 				INTO TABLE $v CHARACTER SET utf8mb4";
						$query = $this->import_model->query_this($pis, $sql);
					} else {

						/*if ($filename == "photo.sql") {
 							
 							$p = file_get_contents($path."/".$filename);
 							$ph = explode('..', $p);

 							for ($i= 1; $i < count($ph); $i++) { 
 								
 								$ps = substr($ph[$i], 14);
 								if ($server == "server_colonnade") {
 									
 									$remote_file = "http://10.32.6.213/hrms/images/users/".trim($ps);
 								} else {

 									$remote_file = "http://172.16.161.34:8080/hrms/images/users/".trim($ps);
 								}

 								$photo = 'http://altsportal.com/assets/img/users/'.trim($ps);
 								if (!file_exists($photo)) {

	 								$conn_id = ftp_connect("67.23.226.158") or die("Error in FTP connection");  // the FTP server you want to connect to.
	 								$login_status = ftp_login($conn_id, "altsportal@altsportal.com", "(f=BuHYFCy?U") or die("Error in FTP login");  // Login to the FTP server.
	 								ftp_pasv($conn_id, true) or die("Cannot switch to passive mode");
	 								// Now go ahead, and upload the file.
	 								$upload_status = ftp_put($conn_id,'/assets/img/users/'.trim($ps), $remote_file, FTP_BINARY);

	 								if (!$upload_status)
	 								{
	 								    // do whatever it is that you want to do when you are unable to upload the file.
	 								   	// echo $remote_file ."\n";
	 								}

	 								// Close the FTP connection after you are done.
	 								ftp_close($conn_id);
						    	}
 							}
 						}*/
					}
				}

				zip_close($zip);
			}

			if (is_dir($path) === true) {

				$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);

				foreach ($files as $file) {

					if (in_array($file->getBasename(), array('.', '..')) !== true) {

						if ($file->isDir() === true) {

							rmdir($file->getPathName());
						} else if (($file->isFile() === true) || ($file->isLink() === true)) {

							unlink($file->getPathname());
						}
					}
				}

				rmdir($path);
			} else if ((is_file($path) === true) || (is_link($path) === true)) {

				unlink($path);
			}

			$this->rmdir_recursive($target_dir);

			/*if (is_dir($target_dir)) {

		        $objects = scandir($target_dir);
		            foreach ($objects as $object) {
		                if ($object != "." && $object != "..") {
		                    if (filetype($target_dir.$object) == "dir") rrmdir($target_dir.$object); else unlink($target_dir.$object);
		                }
		            }
		        reset($objects);
		        rmdir($target_dir);
			}*/

			die("success");
		} else {

			die("failure");
		}
	}

	public function import_violation_data()
	{
		$target_dir = 'import/violation_files/';

		if (!file_exists($target_dir)) {

			mkdir($target_dir, 0777, true);
		}

		$target_file = $target_dir . basename($_FILES["imported_data"]["name"]);

		if (move_uploaded_file($_FILES["imported_data"]["tmp_name"], $target_file)) {

			$e = explode(".", $target_file);
			$path = reset($e);

			$zip = new ZipArchive;
			$res = $zip->open($target_file);
			if ($res === TRUE) {

				$zip->extractTo($path);
				$zip->close();
			} else {

				die("failure to extract");
			}

			$zip = zip_open($target_file);

			if ($zip) {

				$server = $this->import_model->fetch_server($this->import_model->loginId)['server'];

				if ($server == "server_tal") {

					$tk  = "tk_talibon";
					$pis = "pis";
				} else if ($server == "server_tub") {

					$tk  = "tk_tubigon";
					$pis = "pis";
				} else if ($server == "server_colonnade") {

					$tk  = "tk_colonnade";
					$pis = "pis_colonnade";
				} else if ($server == "server_tag") {

					$tk  = "timekeeping";
					$pis = "pis";
				} else {

					die("failure");
				}

				while ($zip_entry = zip_read($zip)) {

					$filename = zip_entry_name($zip_entry);
					$file = explode(".", $filename);
					$v = reset($file);

					// if ($filename != 'termination.sql' && $filename != 'employee3.sql' && $filename != 'applicant.sql' && $filename != 'photo.sql' && $filename != 'promo_record.sql') {

					// if($filename == "assign_mul_sc_cs.sql" || $filename == "assign_mul_sc_odaf.sql" ){
					// 	$sql = "LOAD DATA LOCAL INFILE '$path/$filename' REPLACE
					//       				INTO TABLE assign_mul_sc";

					// }else{
					$sql = "LOAD DATA LOCAL INFILE '$path/$filename' REPLACE
					       				INTO TABLE $v";

					// }
					$query = $this->import_model->query_this($tk, $sql);

					// } else if ($filename == 'termination.sql' || $filename == 'employee3.sql' || $filename == 'applicant.sql' || $filename == 'promo_record.sql') {

					// $sql = "LOAD DATA LOCAL INFILE '$path/$filename' REPLACE
					// 				INTO TABLE $v";
					// 	$query = $this->import_model->query_this($pis, $sql);

					// } else {

					// }
				}

				zip_close($zip);
			}

			if (is_dir($path) === true) {

				$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);

				foreach ($files as $file) {

					if (in_array($file->getBasename(), array('.', '..')) !== true) {

						if ($file->isDir() === true) {

							rmdir($file->getPathName());
						} else if (($file->isFile() === true) || ($file->isLink() === true)) {

							unlink($file->getPathname());
						}
					}
				}

				rmdir($path);
			} else if ((is_file($path) === true) || (is_link($path) === true)) {

				unlink($path);
			}

			$this->rmdir_recursive($target_dir);

			/*if (is_dir($target_dir)) {

		        $objects = scandir($target_dir);
		            foreach ($objects as $object) {
		                if ($object != "." && $object != "..") {
		                    if (filetype($target_dir.$object) == "dir") rrmdir($target_dir.$object); else unlink($target_dir.$object);
		                }
		            }
		        reset($objects);
		        rmdir($target_dir);
			}*/

			die("success");
		} else {

			die("failure");
		}
	}

	/*private function rmdir_recursive($dir) {

	    $it = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
        $it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach($it as $file) {
            if ($file->isDir()) rmdir($file->getPathname());
            else unlink($file->getPathname());
        }
        rmdir($dir);
	}*/

	private function rmdir_recursive($dir)
	{
		foreach (scandir($dir) as $file) {
			if ('.' === $file || '..' === $file) continue;
			if (is_dir("$dir/$file")) $this->rmdir_recursive("$dir/$file");
			else unlink("$dir/$file");
		}
		rmdir($dir);
	}
}
