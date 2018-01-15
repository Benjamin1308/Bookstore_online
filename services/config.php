<?php

	class DB {
		public $con = false;
		public $data = array();

		public function __construct() {
			$this->con = new PDO('mysql:host=localhost;charset=utf8;dbname=ban_sach_online_db','root','');
   			$this->con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   
		}

		public function get_user_by_email($email) {
			$sql = "SELECT * FROM bs_nguoi_dung WHERE email = '".$email."' ";
			$qry = $this->con->prepare($sql);
			$qry->execute();
			if($qry->rowCount() > 0) {
				while($row = $qry->fetchAll(PDO::FETCH_OBJ)) {
					if($row)
					{
						$this->data = $row;
					}			
				}
			} else {
				$this->data = null;
			}
			return $this->data;
			$this->con = null;
		}
		public function get_user_by_tai_khoan($tai_khoan) {
			$sql = "SELECT * FROM bs_nguoi_dung WHERE tai_khoan = '".$tai_khoan."' ";
			$qry = $this->con->prepare($sql);
			$qry->execute();
			if($qry->rowCount() > 0) {
				while($row = $qry->fetchAll(PDO::FETCH_OBJ)) {
					if($row)
					{
						$this->data = $row;
					}
				}
			} else {
				$this->data = null;
			}
			return $this->data;
			$this->con = null;
		}
		
		public function get_user_login($tai_khoan, $mat_khau) {
			$sql = "SELECT * FROM bs_nguoi_dung WHERE tai_khoan = '".$tai_khoan."' AND mat_khau = '".$mat_khau."' ";
			$qry = $this->con->prepare($sql);
			$qry->execute();
			if($qry->rowCount() > 0) {
				while($row = $qry->fetchAll(PDO::FETCH_OBJ)) {
					$this->data = $row;
				}
			} else {
				$this->data = null;
			}
			return $this->data;
			$this->con = null;
		}

		public function get_book() {
			$sql = "SELECT bs_sach.id, bs_sach.id_loai_sach, bs_sach.ten_sach, bs_tac_gia.ten_tac_gia, bs_sach.gioi_thieu, bs_sach.doc_thu, bs_nha_xuat_ban.ten_nha_xuat_ban, bs_sach.so_trang, bs_sach.ngay_xuat_ban, bs_sach.kich_thuoc, bs_sach.sku, bs_sach.trong_luong, bs_sach.hinh, bs_sach.don_gia, bs_sach.gia_bia 
			FROM bs_sach, bs_nha_xuat_ban, bs_tac_gia 
			WHERE bs_sach.id_tac_gia = bs_tac_gia.id and bs_sach.id_nha_xuat_ban = bs_nha_xuat_ban.id AND bs_sach.trang_thai = 1 
			ORDER BY bs_sach.id DESC";
			$qry = $this->con->prepare($sql);
			$qry->execute();
			if($qry->rowCount() > 0) {
				while($row = $qry->fetchAll(PDO::FETCH_OBJ)) {
					$this->data = $row;
				}
			} else {
				$this->data = null;
			}
			return $this->data;
			$this->con = null;
		}		

		public function get_book_after_insert($sql=null) {
			if($sql == null) {
				$this->get_book();
			} else {
				$qry = $this->con->prepare($sql);
				$qry->execute();
				$this->get_book();	
			}
			// $this->con->close();
			return $this->data;
		}	

		public function lay_loai_sach() {
			$sql = "SELECT * FROM `bs_loai_sach` WHERE `id_loai_cha` = 0 ORDER BY `id` DESC";
			$qry = $this->con->prepare($sql);
			$qry->execute();
			if($qry->rowCount() > 0) {
				while($row = $qry->fetchAll(PDO::FETCH_OBJ)) {
					$this->data = $row;
				}
			} else {
				$this->data = null;
			}
			return $this->data;
			$this->con = null;
		}

		public function them_thong_tin($sql){
			$qry = $this->con->prepare($sql);
			$qry->execute();  
			
			$this->con = null;
		}

		public function them_thong_tin2($sql){
			$qry = $this->con->prepare($sql);
			$qry->execute();
			return $this->con->lastInsertId();    
		}

		public function xuat_binh_luan(){
			$sql = "SELECT bs_binh_luan.id,id_sach,id_nguoi_dung,noi_dung, ho_ten, FROM_UNIXTIME(ngay_binh_luan,'%d-%m-%Y') AS tg_binh_luan 
    				FROM bs_binh_luan INNER JOIN bs_nguoi_dung ON bs_binh_luan.id_nguoi_dung = bs_nguoi_dung.id
    				ORDER BY id DESC";
			$qry = $this->con->prepare($sql);
			$qry->execute();
			if($qry->rowCount() > 0) {
				while($row = $qry->fetchAll(PDO::FETCH_OBJ)) {
					$this->data = $row;
				}
			} else {
				$this->data = null;
			}
			return $this->data;
			$this->con = null;
		}

		public function xuat_tin_tuc(){
			$sql = "SELECT * from bs_tin_tuc ORDER BY id DESC";
			$qry = $this->con->prepare($sql);
			$qry->execute();
			if($qry->rowCount() > 0) {
				while($row = $qry->fetchAll(PDO::FETCH_OBJ)) {
					$this->data = $row;
				}
			} else {
				$this->data = null;
			}
			return $this->data;
			$this->con = null;
		}

		public function xuat_tin_tuc_after_insert($sql=null) {
			if($sql == null) {
				$this->xuat_tin_tuc();
			} else {
				$qry = $this->con->prepare($sql);
				$qry->execute();
				$this->xuat_tin_tuc();	
			}
			// $this->con->close();
			return $this->data;
		}

		public function get_nxb() {
			$sql = "SELECT bs_nha_xuat_ban.id, bs_nha_xuat_ban.ten_nha_xuat_ban, bs_nha_xuat_ban.dia_chi, bs_nha_xuat_ban.dien_thoai, bs_nha_xuat_ban.email
			FROM bs_nha_xuat_ban
			ORDER BY bs_nha_xuat_ban.id DESC";
			$qry = $this->con->prepare($sql);
			$qry->execute();
			if($qry->rowCount() > 0) {
				while($row = $qry->fetchAll(PDO::FETCH_OBJ)) {
					$this->data = $row;
				}
			} else {
				$this->data = null;
			}
			return $this->data;
			$this->con = null;
		}

		public function get_nxb_after_insert($sql=null) {
			if($sql == null) {
				$this->get_nxb();
			} else {
				$qry = $this->con->prepare($sql);
				$qry->execute();
				$this->get_nxb();	
			}
			// $this->con->close();
			return $this->data;
		}

		public function lay_tac_gia() {
			$sql = "SELECT bs_tac_gia.id, bs_tac_gia.ten_tac_gia, bs_tac_gia.ngay_sinh, bs_tac_gia.gioi_thieu  FROM bs_tac_gia ORDER BY id DESC";
			$qry = $this->con->prepare($sql);
			$qry->execute();
			if($qry->rowCount() > 0) {
				while($row = $qry->fetchAll(PDO::FETCH_OBJ)) {
					$this->data = $row;
				}
			} else {
				$this->data = null;
			}
			return $this->data;
			$this->con = null;
		}
		

		public function get_tac_gia_after_insert($sql=null) {
			if($sql == null) {
				$this->lay_tac_gia();
			} else {
				$qry = $this->con->prepare($sql);
				$qry->execute();
				$this->lay_tac_gia();	
			}
			// $this->con->close();
			return $this->data;
		}
		

	}
?>
