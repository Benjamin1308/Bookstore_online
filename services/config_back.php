<?php
	define("__HOST__", "localhost");
	define("__USER__", "root");
	define("__PASS__", "");
	define("__BASE__", "ban_sach_online_db");

	class DB {
		private $con = false;
		private $data = array();

		public function __construct() {
			$this->con = new mysqli(__HOST__, __USER__, __PASS__, __BASE__);
			mysqli_set_charset($this->con,"utf8");
			if(mysqli_connect_errno()) {
				die("DB connection failed:" . mysqli_connect_error());
			}
		}

		public function get_user_by_email($email) {
			
			$sql = "SELECT * 
			FROM bs_nguoi_dung 
			WHERE email = '".$email."' ";
			$qry = $this->con->query($sql);
			if($qry->num_rows > 0) {
				while($row = $qry->fetch_object()) {
					if($row)
					{
						$this->data[] = $row;
					}			
				}
			} else {
				$this->data = null;
			}
			return $this->data;
			$this->con->close();
		}
		public function get_user_by_tai_khoan($tai_khoan) {
			
			$sql = "SELECT * 
			FROM bs_nguoi_dung 
			WHERE tai_khoan = '".$tai_khoan."' ";
			$qry = $this->con->query($sql);
			if($qry->num_rows > 0) {
				while($row = $qry->fetch_object()) {
					if($row)
					{
						$this->data[] = $row;
					}
				}
			} else {
				$this->data = null;
			}
			return $this->data;
			$this->con->close();
		}
		
		public function get_user_login($tai_khoan, $mat_khau) {
			
			$sql = "SELECT * 
			FROM bs_nguoi_dung 
			WHERE tai_khoan = '".$tai_khoan."' AND mat_khau = '".$mat_khau."' ";
			$qry = $this->con->query($sql);
			if($qry->num_rows > 0) {
				while($row = $qry->fetch_object()) {
					$this->data[] = $row;
				}
			} else {
				$this->data[] = null;
			}
			return $this->data;
			$this->con->close();
		}

		public function get_book() {
			
			$sql = "SELECT bs_sach.id, bs_sach.id_loai_sach, bs_sach.ten_sach, bs_tac_gia.ten_tac_gia, bs_sach.gioi_thieu, bs_sach.doc_thu, bs_nha_xuat_ban.ten_nha_xuat_ban, bs_sach.so_trang, bs_sach.ngay_xuat_ban, bs_sach.kich_thuoc, bs_sach.sku, bs_sach.trong_luong, bs_sach.hinh, bs_sach.don_gia, bs_sach.gia_bia 
			FROM bs_sach, bs_nha_xuat_ban, bs_tac_gia 
			WHERE bs_sach.id_tac_gia = bs_tac_gia.id and bs_sach.id_nha_xuat_ban = bs_nha_xuat_ban.id AND bs_sach.trang_thai = 1 
			ORDER BY bs_sach.id DESC";
			$qry = $this->con->query($sql);
			if($qry->num_rows > 0) {
				while($row = $qry->fetch_object()) {
					$this->data[] = $row;
				}
			} else {
				$this->data[] = null;
			}
			return $this->data;
			$this->con->close();
		}		

		public function lay_loai_sach() {
			
			$sql = "SELECT * FROM `bs_loai_sach` WHERE `id_loai_cha` = 0 ORDER BY `id` DESC";
			$qry = $this->con->query($sql);
			if($qry->num_rows > 0) {
				while($row = $qry->fetch_object()) {
					$this->data[] = $row;
				}
			} else {
				$this->data[] = null;
			}
			return $this->data;
			$this->con->close();
		}



		public function get_book_after_insert($sql=null) {
			if($sql == null) {
				$this->get_book();
			} else {
				$this->con->query($sql);
				$this->get_book();	
			}
			// $this->con->close();
			return $this->data;
		}	

	}
?>
