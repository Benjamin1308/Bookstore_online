selectedItems = [];
// total = 0;

app = angular.module("app_bookstore", ["ngRoute","ngSanitize","angularUtils.directives.dirPagination"]);

app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
        .when("/", {
            templateUrl: "pages/pages_trang_chu.html",
            controller: "BookCtrl"
        })
		.when("/index.html", {
            templateUrl: "pages/pages_trang_chu.html",
            controller: "BookCtrl"
        })
        .when("/gioi-thieu", {
            templateUrl: "pages/pages_gioi_thieu.html",
            controller: "IntroCtrl"
        })
		.when("/lien-he", {
            templateUrl: "pages/pages_lien_he.html",
            controller: "BookCtrl"
        })
		.when("/tin-tuc", {
            templateUrl: "pages/pages_tin_tuc.html",
            controller: "NewsCtrl"
        })
		.when("/tin-tuc/:id", {
            templateUrl: "pages/pages_chi_tiet_tin.html",
            controller: "NewsCtrl"
        })
		.when("/gio-hang", {
            templateUrl: "pages/pages_gio_hang.html",
            controller: "GiohangCtrl"
        })
		.when("/dat-hang", {
            templateUrl: "pages/pages_dat_hang.html",
            controller: "DathangCtrl"
        })
        // .when("/admin", {
        //     templateUrl: "indexAdmin.html",
        //     controller: "AdminCtrl"
        // })
		.when("/dang-ky", {
            templateUrl: "pages/pages_dang_ky.html",
            controller: "SignUpCtrl"
        })
		.when("/dang-nhap", {
            templateUrl: "pages/pages_dang_nhap.html",
            controller: "LoginCtrl"
        })
		.when("/chi-tiet/:id", {
            templateUrl: "pages/pages_chi_tiet_sach.html",
            controller: "BookDetailCtrl"
        })
		.when("/loai-sach/:id", {
            templateUrl: "pages/pages_trang_chu_theo_loai.html",
            controller: "BookTypeCtrl"
        })
		.when("/admin/sach", {
            templateUrl: "pages/pages_adminSach.html",
            controller: "BookAdminCtrl"
        })
		.when("/admin/tin-tuc", {
            templateUrl: "pages/pages_admin_tin_tuc.html",
            controller: "NewsAdminCtrl"
        })
		.when("/admin/nxb", {
			templateUrl: "pages/pages_adminNxb.html",
            controller: "NxbAdminCtrl"
		})
		.when("/admin/tac-gia", {
			templateUrl: "pages/pages_adminTacgia.html",
            controller: "TacGiaAdminCtrl"
		})
		.when("/test_page", {
            templateUrl: "pages/pages_test.html",
            controller: "BookDetailCtrl"
        });
		

    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false
    });
});




app.controller('SessionCtrl', function ($scope, $routeParams, $http, $log) {
	// console.log('ready!');
	$scope.logout = function(){
		$http.get('./services/logout.php')
			.success(function (data) {
				window.location.href= "./index.html";
			})
			.error(function (err) {
				
			})
	}

	$http.get('./services/login.php')
		.success(function (data) {
			$scope.thong_tin_login = data;
			console.log(data);
		})
		.error(function (err) {
			$log.error(err);
		})
});

/////////////////////////////// ĐĂNG NHẬP + ĐĂNG KÝ CONTROLLER /////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
app.controller('LoginCtrl', function ($scope, $rootScope, $routeParams, $http, $log) {
	// console.log('ready!');

	$scope.login = function(){
		var encodedString = 'username=' + encodeURIComponent($scope.username) + '&password=' + encodeURIComponent($scope.password);
		$http({
			method: 'POST',
			url: './services/login.php',
			data: encodedString,
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		})
		.success(function (data, status, headers, config) {
			console.log(data);
			if(data!=''){
				alert('Đăng nhập thành công.');
				window.location.href= "./index.html";
			} 
			else alert('Đăng nhập không thành công.');
		})
		.error(function (err) {
			console.log('error');
		})
	}
	

	$http.get('./services/lay_loai_sach.php')
		.success(function (data) {
			$scope.ds_loai_sach = data;
			// console.log($scope.ds_loai_sach);
		})
		.error(function (err) {
			$log.error(err);
		})
});

app.controller("SignUpCtrl", function($scope, $routeParams, $http, $log){
	$scope.register = function(form){
		if (form.$valid){
			$http.post('./services/them_nguoi_dung.php', {"tai_khoan": $scope.username, "mat_khau": $scope.password, "id_loai_user" : $scope.kind,"ho_ten": $scope.fullname,
			"email": $scope.email,"ngay_sinh": $scope.birthday,"dia_chi": $scope.address,"dien_thoai": $scope.phone})
			.success(function (data) {
				//alert("success");
				console.log(data);
				if (data.indexOf("success") != -1){
					alert("Đăng ký thành công !");
					window.location.href= "./index.html";	
				}
				else if (data.indexOf("username") != -1){
					alert("Tên đăng nhập đã được sử dụng.");
				} 
				else if (data.indexOf("email") != -1){
					alert("Email đã được sử dụng.");
				} 
				else if (data.indexOf("both") != -1){
					alert("Email và tên đăng nhập đã được sử dụng.");
				} 
			})
		}
			
	};
});
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

app.controller('BookTypeCtrl', function ($scope, $rootScope, $routeParams, $http, $log) {
	$scope.id_loai_sach = $routeParams.id;

	$http.get('./services/lay_sach.php').success(function (data) {
		$scope.id_loai_sach = $routeParams.id;

		// $scope.books_by_id_type = data.filter(function (entry) {
		// 	return entry.id_loai_sach === $scope.id_loai_sach;
		// });
		$scope.books_by_id_type = data.filter(function (entry) {
			if ($scope.id_loai_sach == "2")
			{
				if (entry.id_loai_sach >= 15)
					return entry.id_loai_sach;
			}
			else
				return entry.id_loai_sach === $scope.id_loai_sach;
		});
	});
});

app.controller('BookDetailCtrl', function ($scope, $rootScope, $routeParams, $http, $log) {
	$scope.id = $routeParams.id;

	$http.get('./services/lay_sach.php').success(function (data) {
		$scope.id = $routeParams.id;

		$scope.books_by_id = data.filter(function (entry) {
			return entry.id === $scope.id;
		})[0];
	});
	
	//comment
	$scope.submitForm=function(){
		$id_nguoi_dung = '';

		$http.get('./services/login.php')
		.success(function (data) {
			if(data!=0){
				$id_nguoi_dung = data.id;
				$http.post('./services/them_binh_luan.php',{'noi_dung_nx':$scope.noi_dung_nx,'sach_id':$scope.id,'id_nguoi_dung':$id_nguoi_dung})
				.success(function(data, status, headers, config){
					if(data == "success")
					{
						$scope.noi_dung_nx = null;
						$http.get('./services/xuat_binh_luan.php')
						.success(function(data, status, headers, config){
							$scope.binh_luan = data;									
						});
						// $location.url('chi-tiet/' + $scope.id);
					}				
				});	
			}
			
			
		})
		.error(function (err) {
			$log.error(err);
		})
		
	};

	$http.get('./services/xuat_binh_luan.php')
	.success(function(data){
		$scope.binh_luan = data;
	});


	// dùng để chứa các sản phẩm đã bỏ vào giỏ hàng
	$rootScope.selectedItems = selectedItems;


	// Sự kiện click: chọn sản phẩm bỏ vào giỏ hàng
	$scope.addToCart = function (product,quantity) {
		
		// test thử
		$http.post('./services/them_gio_hang2.php',{'product_id':product.id,'product_name':product.ten_sach,'don_gia':product.don_gia,'quantity':quantity})
		.success(function(data, status, headers, config){
			if(data==0){
				alert('Vui lòng đăng nhập để mua sách.');
			}else{
				$scope.gio_hang = data;
				console.log($scope.gio_hang);
				alert('Thêm vào giỏ hàng thành công.');	
				window.location.href= "./gio-hang";
			}
			
		});
	};
});


app.controller("GiohangCtrl", function ($scope, $rootScope, $routeParams, $http, $log) {
	$http.get('./services/lay_gio_hang.php')
	.success(function (data) {
		if(data!=0){
			$scope.gio_hang = data;
			// console.log(data);
		}
	})
	.error(function (err) {
		$log.error(err);
	})

	$http.get('./services/lay_tong_tien.php')
	.success(function (data) {
		if(data!=0){
			$scope.tong_tien = data;
			console.log(data);
		}
	})
	.error(function (err) {
		$log.error(err);
	})

	$scope.cap_nhat = function(product,quantity){
		$http.post('./services/cap_nhat_gio_hang.php',{'product_id':product.id,'product_name':product.ten_sach,'don_gia':product.don_gia,'quantity':quantity})
		.success(function(data, status, headers, config){

			$scope.gio_hang = data;
			console.log($scope.gio_hang);	
		});	
	}


	$scope.dat_hang = function(product){
		console.log(product);
		// $http.get('./services/lay_gio_hang.php')
		// .success(function (data) {
		// 	if(data!=0){
		// 		$scope.gio_hang = data;
		// 		console.log(data.id);
		// 	}
		// })
		// .error(function (err) {
		// 	$log.error(err);
		// })
	}


	$scope.remove = function(id){
		//alert(id);
		$http.post('./services/xoa_gio_hang.php',{'product_id': id})
		.success(function(data, status, headers, config){
			$scope.gio_hang = data;
			console.log($scope.gio_hang);
			window.location.href= "./gio-hang";
		});	
	}

	

	$scope.getTotal = function () {
		var total = 0;
		angular.forEach($rootScope.selectedItems, function (item, index) {
			total += (item.don_gia * item.quantity);
		})

		return total;
	}
	
});


app.controller("DathangCtrl", function ($scope, $rootScope, $routeParams, $http, $log) {
	$http.get('./services/lay_tong_tien.php')
	.success(function (data) {
		if(data!=0){
			$scope.tong_tien = data;
			console.log(data);
		}else{
			alert('Bạn chưa chọn sách để mua.');
		}
	})
	.error(function (err) {
		$log.error(err);
	})
	
	$scope.dat_hang = function(form){
		$http.get('./services/login.php')
		.success(function (data) {
			if(data!=0){
				$id_nguoi_dung = data.id;
				if (form.$valid){
					$http.post('./services/them_don_hang.php', {"tong_tien": $scope.tong_tien, "id_nguoi_dung":$id_nguoi_dung, "ho_ten_nguoi_nhan": $scope.fullname, "email_nguoi_nhan": $scope.email,"dia_chi_nguoi_nhan": $scope.address,"so_dien_thoai_nguoi_nhan": $scope.phone})
					.success(function (data) {
						//alert("success");
						console.log(data);
						if (data.indexOf("success") != -1){
							alert("Đặt hàng thành công !");
							window.location.href= "./index.html";	
						}
					})
				}
			}else{
				alert('Chưa đăng nhập để mua hàng !');
			}
		})
			
	};
});



app.controller("BookCtrl", function ($scope, $rootScope, $routeParams, $http, $log) {
	$http.get('./services/lay_loai_sach.php')
		.success(function (data) {
			$scope.ds_loai_sach = data;
			// console.log($scope.ds_loai_sach);
		})
		.error(function (err) {
			$log.error(err);
		})
	
	$http.get('./services/lay_sach.php')
		.success(function (data) {
			
			$scope.currentPage = 0;
			$scope.pageSize = 12;
			$scope.books = data;
			$scope.numberOfPages=function(){
				return Math.ceil($scope.books.length/$scope.pageSize);                
			}
			// console.log($scope.books);
		})
		.error(function (err) {
			$log.error(err);
		})


});


app.controller("IntroCtrl", function($scope, $routeParams, $http, $log){
	
});

app.filter('startFrom', function() {
    return function(input, start) {
        if (!input || !input.length) { return; }
        start = +start; //parse to int
        return input.slice(start);
    }
});


//tin tức
app.controller("NewsCtrl", function ($scope, $rootScope, $routeParams, $http, $log) {
	$scope.id = $routeParams.id;
	$http.get('./services/xuat_tin_tuc.php')
		.success(function(data, status, headers, config){
			$scope.news = data;				
			$scope.chi_tiet_tin = data.filter(function (entry) {
				return entry.id == $scope.id;
			})[0];
			// console.log(news);
		});
});


// ADMIN tin tức
/////////////////////////////////////////////////////////
app.controller("NewsAdminCtrl", function ($scope, $rootScope, $routeParams, $http, $log) {
	$http.get('./services/login.php')
		.success(function (data) {
			// console.log(data.id_loai_user);
			if(data.id_loai_user==7){
				$scope.xu_ly_tt = function () {
					$('#form_tt').slideToggle();
				}		
				$scope.them_tt = function ($params) {
					$http.post('./services/them_tin_tuc.php', { 'tieu_de_tin': $params.tieu_de_tin, 'noi_dung_tom_tat': $params.noi_dung_tom_tat,
						'noi_dung_chi_tiet':$params.noi_dung_chi_tiet,'hinh_dai_dien':$params.hinh_dai_dien })
						.success(function (data) {
							$scope.news = data;
						})
						.error(function (err){
							$log.error(err);
						})
					}
				$http.get('./services/xuat_tin_tuc.php')
					.success(function (data) {
						$scope.news = data;
					})
					.error(function (err) {
						$log.error(err);
					})
				$scope.xoa_tt = function ($params) {
					var cnfrm = confirm("Are you sure to delete?");
					if (cnfrm) {
						$http.post('./services/xoa_tin_tuc.php', { 'id': $params})
							.success(function (data) {
								$scope.news = data;	
							})
							.error(function (err) {
								$log.error(err);
							})
					} else {
						// 
					}
				}
				$scope.bien={};
				$scope.edit_tt = function (info) {
					$scope.bien = info;
					$('#editForm_tt').slideToggle();
				}
				$scope.update_tt = function ($params) {
					$http.post('./services/cap_nhat_tin_tuc.php', {'id': $params.id, 'tieu_de_tin': $params.tieu_de_tin, 'noi_dung_tom_tat': $params.noi_dung_tom_tat, 'noi_dung_chi_tiet': $params.noi_dung_chi_tiet, 'hinh_dai_dien': $params.hinh_dai_dien})
					.success(function (data) {
						$scope.news = data;	
					})
					.error(function (err) {
						$log.error(err);
					});
				}	
				$scope.updatett = function (emp_id) {
					$('#editForm_tt').css('display', 'none');
				}

			}else{
				alert('Chưa đăng nhập quyền quản trị !');
				window.location.href= "./index.html";
			}
		})

	/////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////
		
});


app.controller("BookAdminCtrl", function ($scope, $rootScope, $routeParams, $http, $log) {
	$http.get('./services/login.php')
		.success(function (data) {
			if(data.id_loai_user==7){
				$scope.frmToggle = function () {
					$('#blogForm').slideToggle();
				}

				$http.get('./services/lay_sach.php')
					.success(function (data) {
						$scope.books = data;
						// console.log($scope.books);
					})
					.error(function (err) {
						$log.error(err);
					})

				$scope.pushData = function ($params) {
					$http.post('./services/them_sach.php', { 'ten_sach': $params.ten_sach, 'so_trang': $params.so_trang })
						.success(function (data) {
							$scope.books = data;
						})
						.error(function (err) {
							$log.error(err);
						})
				}

				$scope.removeData = function ($params) {
					var cnfrm = confirm("Are you sure to delete?");
					if (cnfrm) {
						$http.post('./services/xoa_sach.php', { 'id': $params })
							.success(function (data) {
								$scope.books = data;
							})
							.error(function (err) {
								$log.error(err);
							})
					} else {
						// 
					}
				}

				$scope.currentUser = {};
				$scope.editData = function (info) {
					$scope.currentUser = info;
					// $('#empForm').slideUp();
					$('#editForm').slideToggle();
				}

				$scope.UpdateInfo = function ($params) {
					$http.post('./services/cap_nhat_sach.php', { "id": $params.id, "ten_sach": $params.ten_sach })
						.success(function (data) {
							$scope.books = data;
						})
						.error(function (err) {
							$log.error(err);
						})
				}

				$scope.updateMsg = function (emp_id) {
					$('#editForm').css('display', 'none');
				}

			}else{
				alert('Chưa đăng nhập quyền quản trị !');
				window.location.href= "./index.html";
			}
		})
});


app.controller("NxbAdminCtrl", function ($scope, $rootScope, $routeParams, $http, $log) {
	$http.get('./services/login.php')
		.success(function (data) {
			if(data.id_loai_user==7){
				$scope.frmToggle = function () {
				$('#blogForm').slideToggle();
			}

			$http.get('./services/lay_nxb.php')
				.success(function (data) {
					$scope.nxbs = data;
				})
				.error(function (err) {
					$log.error(err);
				})

			$scope.pushData = function ($params) {
				$http.post('./services/them_nxb.php', { 'ten_nxb': $params.ten_nxb, 'dia_chi': $params.dia_chi, 'dien_thoai': $params.dien_thoai, 'email': $params.email })
					.success(function (data) {
						$scope.nxbs = data;
					})
					.error(function (err) {
						$log.error(err);
					})
			}

			$scope.removeData = function ($params) {
				var cnfrm = confirm("Are you sure to delete?");
				if (cnfrm) {
					$http.post('./services/xoa_nxb.php', { 'id': $params })
						.success(function (data) {
							$scope.nxbs = data;
						})
						.error(function (err) {
							$log.error(err);
						})
				} else {
					// 
				}
			}

			$scope.currentUser = {};
			$scope.editData = function (info) {
				$scope.currentUser = info;
				// $('#empForm').slideUp();
				$('#editForm').slideToggle();
			}

			$scope.UpdateInfo = function ($params) {
				$http.post('./services/cap_nhat_nxb.php', { 'id': $params.id, 'ten_nha_xuat_ban': $params.ten_nha_xuat_ban, 'dia_chi' : $params.dia_chi, 'dien_thoai': $params.dien_thoai })
					.success(function (data) {
						$scope.nxbs = data;
					})
					.error(function (err) {
						$log.error(err);
					})
			}

			$scope.updateMsg = function (emp_id) {
				$('#editForm').css('display', 'none');
			}

			}else{
				alert('Chưa đăng nhập quyền quản trị !');
				window.location.href= "./index.html";
			}
		})
});


app.controller("TacGiaAdminCtrl", function ($scope, $rootScope, $routeParams, $http, $log) {
	$http.get('./services/login.php')
		.success(function (data) {
			if(data.id_loai_user==7){
				$scope.frmToggle = function () {
				$('#blogForm').slideToggle();
			}

			$http.get('./services/lay_tac_gia.php')
				.success(function (data) {
					$scope.authors = data;
					//console.log($scope.authors);
				})
				.error(function (err) {
					$log.error(err);
				})

			$scope.pushData = function ($params) {
				$http.post('./services/them_tac_gia.php', { 'ten_tac_gia': $params.ten_tac_gia, 'gioi_thieu': $params.gioi_thieu })
					.success(function (data) {
						$scope.authors = data;
					})
					.error(function (err) {
						$log.error(err);
					})
				
			}

			$scope.removeData = function ($params) {
				var cnfrm = confirm("Are you sure to delete?");
				if (cnfrm) {
					$http.post('./services/xoa_tac_gia.php', { 'id': $params })
						.success(function (data) {
							$scope.authors = data;
						})
						.error(function (err) {
							$log.error(err);
						})
				} else {
					// 
				}
			}

			$scope.currentUser = {};
			$scope.editData = function (info) {
				$scope.currentUser = info;
				// $('#empForm').slideUp();
				$('#editForm').slideToggle();
			}

			$scope.UpdateInfo = function ($params) {
				$http.post('./services/cap_nhat_tac_gia.php', { "id": $params.id, "ten_tac_gia": $params.ten_tac_gia, "gioi_thieu" : $params.gioi_thieu })
					.success(function (data) {
						$scope.authors = data;
					})
					.error(function (err) {
						$log.error(err);
					})
			}

			$scope.updateMsg = function (emp_id) {
				$('#editForm').css('display', 'none');
			}

			}else{
				alert('Chưa đăng nhập quyền quản trị !');
				window.location.href= "./index.html";
			}
		})

});