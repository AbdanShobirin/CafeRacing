<!DOCTYPE html>
<?php
  include "connection/koneksi.php";
  $icon = "template/masuk/images/icon.jpg";
  ob_start();
  session_start();
?>
<html lang="en">
<head>
<title>Daftar</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="template/dashboard/css/bootstrap.min.css" />
<link rel="stylesheet" href="template/dashboard/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="template/dashboard/css/colorpicker.css" />
<link rel="stylesheet" href="template/dashboard/css/datepicker.css" />
<link rel="stylesheet" href="template/dashboard/css/uniform.css" />
<link rel="stylesheet" href="template/dashboard/css/select2.css" />
<link rel="stylesheet" href="template/dashboard/css/matrix-style.css" />
<link rel="stylesheet" href="template/dashboard/css/matrix-media.css" />
<link rel="stylesheet" href="css/bootstrap-wysihtml5.css" />
<link href="template/dashboard/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<link rel="icon" href="<?php echo $icon; ?>" type="image/jpg">
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="daftar.php">Restaurant</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">&nbsp;Selamat Datang Pendaftar</span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="index.php"><i class="icon-key"></i> Log in</a></li>
      </ul>
    </li>
  </ul>
</div>

<!--start-top-serch-->

<!--close-top-serch--> 

<!--sidebar-menu-->

<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-list"></i>&nbsp;Daftar</a>
  <ul>
    <li class="active"><a href="daftar.php"><i class="icon icon-book"></i> <span>Daftar</span></a> </li>
  </ul>
</div>

<!--close-left-menu-stats-sidebar-->

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="index.php" title="Go to Login" class="tip-bottom"><i class="icon-home"></i> Login</a> 
      <a href="daftar.php" class="current">Daftar</a>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5>Isi data pendaftaran</h5>
          </div>
          <div class="widget-content nopadding">
            <form action="" method="post" class="form-horizontal">
              <div class="control-group">
                <label class="control-label">Nama :</label>
                <div class="controls">
                  <input name="nama_user" type="text" class="span11" placeholder="Nama Anda" required />
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Username :</label>
                <div class="controls">
                  <input name="username" type="text" class="span11" placeholder="Username" required />
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Password :</label>
                <div class="controls">
                  <input name="password" type="password" class="span11" placeholder="Enter Password" required />
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Level Pengguna:</label>
                <div class="controls">
                  <select class="span11" name="id_level" required>
                    <option value="2">Waiter</option>
                    <option value="3">Kasir</option>
                    <option value="4">Owner</option>
                    <option value="5">Pelanggan</option>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Company Code:</label>
                <div class="controls">
                  <input name="company_code" type="text" class="span11" placeholder="Company Code" required />
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Created By:</label>
                <div class="controls">
                  <input name="created_by" type="text" class="span11" placeholder="Created By" required />
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Last Updated By:</label>
                <div class="controls">
                  <input name="last_updated_by" type="text" class="span11" placeholder="Last Updated By" required />
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" name="kirim_daftar" class="btn btn-success"><i class='icon icon-save'></i>&nbsp; Daftar</button>
              </div>
            </form>

            <?php
            if (isset($_POST['kirim_daftar'])) {
              // Ambil data dari form
              $nama_user = $_POST['nama_user'];
              $username = $_POST['username'];
              $password = $_POST['password'];
              $id_level = $_POST['id_level'];
              $company_code = $_POST['company_code'];
              $created_by = $_POST['created_by'];
              $last_updated_by = $_POST['last_updated_by'];
              $status = 'nonaktif'; // Default status
              $is_deleted = 0; // Default value, 0 for not deleted
              $created_date = date('Y-m-d H:i:s'); // Tanggal pembuatan
              $last_update_date = date('Y-m-d H:i:s'); // Tanggal update terakhir

              // Query untuk menyimpan data ke database
              $query_daftar = "
                INSERT INTO tb_user (
                  username, password, nama_user, id_level, status, 
                  CompanyCode, isDeleted, CreatedBy, CreatedDate, 
                  LastUpdatedBy, LastUpdateDate
                ) VALUES (
                  '$username', '$password', '$nama_user', '$id_level', '$status', 
                  '$company_code', '$is_deleted', '$created_by', '$created_date', 
                  '$last_updated_by', '$last_update_date'
                )";

              // Eksekusi query
              $sql_daftar = mysqli_query($conn, $query_daftar);
              
              // Jika berhasil, alihkan ke halaman login
              if ($sql_daftar) {
                header('location: index.php');
                $_SESSION['daftar'] = 'sukses';
              }
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> <?php echo date('Y'); ?> &copy; Restaurant <a href="#">by henscorp</a> </div>
</div>
<!--end-Footer-part--> 
<script src="template/dashboard/js/jquery.min.js"></script> 
<script src="template/dashboard/js/jquery.ui.custom.js"></script> 
<script src="template/dashboard/js/bootstrap.min.js"></script> 
<script src="template/dashboard/js/bootstrap-colorpicker.js"></script> 
<script src="template/dashboard/js/bootstrap-datepicker.js"></script> 
<script src="template/dashboard/js/jquery.toggle.buttons.js"></script> 
<script src="template/dashboard/js/masked.js"></script> 
<script src="template/dashboard/js/jquery.uniform.js"></script> 
<script src="template/dashboard/js/select2.min.js"></script> 
<script src="template/dashboard/js/matrix.js"></script> 
<script src="template/dashboard/js/wysihtml5-0.3.0.js"></script> 
<script src="template/dashboard/js/jquery.peity.min.js"></script> 
<script src="template/dashboard/js/bootstrap-wysihtml5.js"></script> 
<script>
	$('.textarea_editor').wysihtml5();
</script>
</body>
</html>
<?php 
  ob_flush();
?>
