<!DOCTYPE html>

<?php
include "connection/koneksi.php";
$icon = "template/masuk/images/icon.jpg";
session_start();
ob_start();

$id = $_SESSION['id_user'];

if(isset($_SESSION['edit_menu'])){
  echo $_SESSION['edit_menu'];
  unset($_SESSION['edit_menu']);

}

if(isset ($_SESSION['username'])){
  
  $query = "select * from tb_user natural join tb_level where id_user = $id";

  mysqli_query($conn, $query);
  $sql = mysqli_query($conn, $query);

  while($r = mysqli_fetch_array($sql)){
    
    $nama_user = $r['nama_user'];

?>

<html lang="en">
<head>
<title>Pesanan</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="template/dashboard/css/bootstrap.min.css" />
<link rel="stylesheet" href="template/dashboard/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="template/dashboard/css/fullcalendar.css" />
<link rel="stylesheet" href="template/dashboard/css/matrix-style.css" />
<link rel="stylesheet" href="template/dashboard/css/matrix-media.css" />
<link href="template/dashboard/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="template/dashboard/css/jquery.gritter.css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<link rel="icon" href="<?php echo $icon; ?>" type="image/jpg">
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="entri_order.php">Pesanan</a></h1>
</div>
<!--close-Header-part--> 


<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Welcome <?php echo $r['nama_user'];?></span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="#"><i class="icon-user"></i><?php echo "&nbsp;&nbsp;".$r['nama_level'];?></a></li>
        <li><a href="logout.php"><i class="icon-key"></i> Log Out</a></li>
      </ul>
    </li>
    <li class=""><a title="" href="logout.php"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
  </ul>
</div>
<!--close-top-Header-menu-->
<!--start-top-serch-->

<!--close-top-serch-->
<!--sidebar-menu-->
<div id="sidebar"><a href="entri_order.php" class="visible-phone"><i class="icon shopping-cart"></i> <span>Pesanan</span></a>
  <ul>
    <?php
    if($r['id_level'] == 1){
  ?>
    <li> <a href="beranda.php"><i class="icon icon-home"></i> <span>Beranda</span></a> </li>
    <li> <a href="entri_referensi.php"><i class="icon icon-tasks"></i> <span>Daftar Menu</span></a> </li>
    <li class="active"> <a href="entri_order.php"><i class="icon icon-shopping-cart"></i> <span>Pesan Menu</span></a> </li>
    <li> <a href="entri_transaksi.php"><i class="icon icon-inbox"></i> <span>Daftar Transaksi</span></a> </li>
    <li> <a href="generate_laporan.php"><i class="icon icon-print"></i> <span>Generate Laporan</span></a> </li>
    <li> <a href="logout.php"><i class="icon icon-sign-out"></i> <span>Logout</span></a> </li>
  <?php
    } else if($r['id_level'] == 2){
  ?>
    <li><a href="beranda.php"><i class="icon icon-home"></i> <span>Beranda</span></a> </li>
    <li class="active"> <a href="entri_order.php"><i class="icon icon-shopping-cart"></i> <span>Pesan Menu</span></a> </li>
    <li> <a href="generate_laporan.php"><i class="icon icon-print"></i> <span>Generate Laporan</span></a> </li>
    <li> <a href="logout.php"><i class="icon icon-sign-out"></i> <span>Logout</span></a> </li>
  <?php
    } else if($r['id_level'] == 3){
  ?>
    <li><a href="beranda.php"><i class="icon icon-home"></i> <span>Beranda</span></a> </li>
    <li> <a href="entri_transaksi.php"><i class="icon icon-inbox"></i> <span>Daftar Transaksi</span></a> </li>
    <li> <a href="generate_laporan.php"><i class="icon icon-print"></i> <span>Generate Laporan</span></a> </li>
    <li> <a href="logout.php"><i class="icon icon-sign-out"></i> <span>Logout</span></a> </li>
  <?php
    } else if($r['id_level'] == 4){
  ?>
    <li><a href="beranda.php"><i class="icon icon-home"></i> <span>Beranda</span></a> </li>
    <li> <a href="generate_laporan.php"><i class="icon icon-print"></i> <span>Generate Laporan</span></a> </li>
    <li> <a href="logout.php"><i class="icon icon-sign-out"></i> <span>Logout</span></a> </li>
  <?php
    } else if($r['id_level'] == 5){
  ?>
    <li><a href="beranda.php"><i class="icon icon-home"></i> <span>Beranda</span></a> </li>
    <li class="active"> <a href="entri_order.php"><i class="icon icon-shopping-cart"></i> <span>Pesan Menu</span></a> </li>
    <li> <a href="logout.php"><i class="icon icon-sign-out"></i> <span>Logout</span></a> </li>
  <?php
    }
  ?>
  </ul>
</div>
<!--sidebar-menu-->

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="entri_order.php" title="Go to here" class="tip-bottom"><i class="icon icon-tasks"></i> Pesanan</a></div>
  </div>
<!--End-breadcrumbs-->
  
<!--Action boxes-->
  <div class="container-fluid">
    
    <?php
      if($r['id_level'] == 1 || $r['id_level'] == 2 || $r['id_level'] == 5){
    ?>
      <p></p>
      <?php
        $order = array();
        $query_lihat_order = "select * from tb_order";
        $sql_lihat_order = mysqli_query($conn, $query_lihat_order);
        while($r_dt_order = mysqli_fetch_array($sql_lihat_order)){
          if($r_dt_order['status_order'] != 'sudah bayar'){
            array_push($order, $r_dt_order['id_pengunjung']);
          }
        }
        if(in_array($id, $order)){
      ?>
    <div class="row-fluid">
      <div class="span6">
        <div class="widget-box span12">
          <div class="widget-title"> <span class="icon"> <i class="icon-hand-right"></i> </span>
            <h5>Notifications</h5>
          </div>
          <div class="widget-content">
            <div class="alert alert-info alert-block">
              <h4 class="alert-heading">Informasi !</h4>
              Terimakasih, Anda telah melakukan pemesanan.<br>
              Silahkan tunggu pesanan tiba di meja saudara. Apabila selesai menyantap hidangan, silahkan lakukan proses pembayaran di kasir !
            </div>
          </div>
        </div>
      </div>
      <div class="span6">
        <div class="widget-box span12">
          <div class="widget-title"> <span class="icon"> <i class="icon-shopping-cart"></i> </span>
            <h5>Menu yang dipesan</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-invoice-full">
              <thead>
                <tr>
                  <th class="head0">No.</th>
                  <th class="head1">Menu</th>
                  <th class="head0 right">Jumlah</th>
                  <th class="head1 right">Harga</th>
                  <th class="head0 right">Total</th>
                </tr>
              </thead>
              <tbody>
                <?php
  $no_order_fiks = 1;
  $query_order_fiks = "SELECT * FROM tb_pesan 
                       INNER JOIN tb_masakan ON tb_pesan.id_masakan = tb_masakan.id_masakan 
                       WHERE tb_pesan.id_user = $id AND tb_pesan.status_pesan != 'sudah'";
  $sql_order_fiks = mysqli_query($conn, $query_order_fiks);
  // echo $query_order_fiks;

  while($r_order_fiks = mysqli_fetch_array($sql_order_fiks)){
?>
  <tr>
    <td><center><?php echo $no_order_fiks++; ?>. </center></td>
    <td><?php echo $r_order_fiks['nama_masakan'];?></td>
    <td class="right"><center><?php echo $r_order_fiks['jumlah'];?></center></td>
    <td class="right">Rp. <?php echo number_format($r_order_fiks['harga'], 0, ',', '.');?>,-</td>
    <td class="right">
      <strong>
        Rp.
        <?php 
          $hasil = $r_order_fiks['harga'] * $r_order_fiks['jumlah'];
          echo number_format($hasil, 0, ',', '.');
        ?>,-
      </strong>
    </td>
  </tr>
<?php
  }

  $query_harga = "SELECT * FROM tb_order WHERE id_pengunjung = $id AND status_order = 'belum bayar'";
  $sql_harga = mysqli_query($conn, $query_harga);
  $result_harga = mysqli_fetch_array($sql_harga);
?>

                <tr>
                  <td></td>
                  <td><strong><center>Total</center></strong></td>
                  <td class="right"></td>
                  <td class="right"></td>
                  <td class="right"><strong>Rp. <?php echo number_format($result_harga['total_harga'], 0, ',', '.'); ?>,-</strong></td>
                </tr>
                <tr>
                  <td></td>
                  <td><strong><center>No. Meja</center></strong></td>
                  <td class="right"></td>
                  <td class="right"></td>
                  <td class="right"><center><strong><?php echo $result_harga['no_meja'];?></strong></center></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
      <?php
        } else {
      ?>
    <div class="row-fluid">
      <div class="span8">
        <div class="widget-box span12">
          <div class="widget-title bg_lg"><span class="icon"><i class="icon-th-large"></i></span>
            <h5>Menu Makanan</h5>
          </div>
          <div class="widget-content" >
            <ul class="thumbnails">
              <div class="btn-icon-pg">
                <ul>
                  <!--Looping-->
                  <?php
                    $pesan = array();

                    $query_lihat_pesan = "select * from tb_pesan where id_user = $id and status_pesan != 'sudah'";
                    $sql_lihat_pesan = mysqli_query($conn, $query_lihat_pesan);

                    while($r_dt_pesan = mysqli_fetch_array($sql_lihat_pesan)){
                      array_push($pesan, $r_dt_pesan['id_masakan']);
                    }

                    $query_data_makanan = "select * from tb_masakan where stok > 0 order by id_masakan desc";
                    $sql_data_makanan = mysqli_query($conn, $query_data_makanan);
                    $no_makanan = 1;

                    while($r_dt_makanan = mysqli_fetch_array($sql_data_makanan)){
                  ?>
                      <li class="span3" style="margin-bottom: 20px;"> <div class="thumbnail" style="height: 350px; overflow: hidden; display: flex; flex-direction: column;"> <a style="display: block; flex-grow: 1; overflow: hidden;"> <img src="gambar/<?php echo $r_dt_makanan['gambar_masakan']?>" alt="" style="width: 100%; object-fit: cover; height: 100%;"> </a>
                        <div class="actions">
                          <a class="lightbox_trigger" href="gambar/<?php echo $r_dt_makanan['gambar_masakan'];?>"><i class="icon-search"></i>&nbsp;Lihat</a> 
                        </div>
                        <table class="table table-bordered">
                          <tbody>
                            <tr>
                              <td><?php echo $r_dt_makanan['nama_masakan'];?></td>
                            </tr>
                            <tr>
                              <td>Harga / Porsi</td>
                              <td>Rp. <?php echo $r_dt_makanan['harga'];?>,-</td>
                            </tr>
                            <tr>
                              <td>Stok</td>
                              <td><?php echo $r_dt_makanan['stok'];?> Porsi</td>
                            </tr>
                          </tbody>
                        </table>
                        <form action="" method="post">
                          <?php
                            if(in_array($r_dt_makanan['id_masakan'], $pesan)){
                          ?>
                              <button type="submit" value="<?php echo $r_dt_makanan['id_masakan'];?>" name="tambah_pesan" class="btn btn-danger btn-mini" disabled>
                                <i class='icon-shopping-cart'></i>&nbsp;&nbsp;Telah dipesan &nbsp;&nbsp;
                              </button>
                          <?php
                            } else {
                          ?>
                              <button type="submit" value="<?php echo $r_dt_makanan['id_masakan'];?>" name="tambah_pesan" class="btn btn-success btn-mini">
                                <i class='icon-shopping-cart'></i>&nbsp;&nbsp;Pesan &nbsp;&nbsp;
                              </button>
                          <?php
                            }
                          ?>
                        </form>
                      </li>
                    <?php
                      }
                        if(isset($_REQUEST['tambah_pesan'])){
                        $id_masakan = $_REQUEST['tambah_pesan'];

                        $CompanyCode = 'CMP001';
                        $Status = 1;
                        $isDeleted = 0;
                        $CreatedBy = $nama_user;
                        $CreatedDate = date('Y-m-d H:i:s');
                        $LastUpdatedBy = $r['id_user'];
                        $LastUpdateDate = date('Y-m-d H:i:s');

                        $query_tambah_pesan = "INSERT INTO tb_pesan (id_pesan, id_user, id_order, id_masakan, jumlah, status_pesan, CompanyCode, Status, isDeleted, CreatedBy, CreatedDate, LastUpdatedBy, LastUpdateDate)
                                                VALUES('', '$id', '', '$id_masakan', '1', 'belum', '$CompanyCode', '$Status', '$isDeleted', '$CreatedBy', '$CreatedDate', '$LastUpdatedBy', '$LastUpdateDate')";
                        $sql_tambah_pesan = mysqli_query($conn, $query_tambah_pesan);

                        $query_lihat_pesannya = "SELECT * FROM tb_pesan ORDER BY id_pesan DESC LIMIT 1";
                        $sql_lihat_pesannya = mysqli_query($conn, $query_lihat_pesannya);
                        $result_lihat_pesannya = mysqli_fetch_array($sql_lihat_pesannya);

                        $id_pesannya = $result_lihat_pesannya['id_pesan'];

                        $query_olah_stok = "INSERT INTO tb_stok (id_stok, id_pesan, jumlah_terjual, status_cetak, CompanyCode, Status, isDeleted, CreatedBy, CreatedDate, LastUpdatedBy, LastUpdateDate)
                                            VALUES('', '$id_pesannya', '0', 'belum cetak', '$CompanyCode', '$Status', '$isDeleted', '$CreatedBy', '$CreatedDate', '$LastUpdatedBy', '$LastUpdateDate')";
                        $sql_olah_stok = mysqli_query($conn, $query_olah_stok);

                        if($sql_tambah_pesan){
                          header('location: entri_order.php');
                        }
                      }
                    ?>
                  <!--End Looping-->
                </ul>
              </div>
            </ul>
          </div>
        </div>
      </div>
      <div class="span4">
      <form action="" method="post">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-shopping-cart"></i> </span>
            <h5>Keranjang Pemesanan</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width: 50%">Menu Pesanan</th>
                  <th style="width: 30%">Jumlah</th>
                  <th style="width: 20%">Aksi</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $query_draft_pesan = "SELECT * FROM tb_pesan 
                      INNER JOIN tb_masakan ON tb_pesan.id_masakan = tb_masakan.id_masakan 
                      WHERE tb_pesan.id_user = $id AND tb_pesan.status_pesan != 'sudah'";
                $sql_draft_pesan = mysqli_query($conn, $query_draft_pesan);

                while($r_draft_pesan = mysqli_fetch_array($sql_draft_pesan)){
              ?>
                <tr class="odd gradeX">
                  <td><span id="<?php echo "nama".$r_draft_pesan['id_pesan']; ?>"><?php echo $r_draft_pesan['nama_masakan'];?></span></td>
                  <input id="<?php echo "harga".$r_draft_pesan['id_pesan']; ?>" class="span8" type="hidden" value="<?php echo $r_draft_pesan['harga'];?>"/>
                  <td>
                    <center>
                      <input id="<?php echo "jumlah".$r_draft_pesan['id_pesan']; ?>" class="span8" name="jumlah<?php echo $r_draft_pesan['id_masakan']; ?>" type="number" value="" placeholder="" onchange="return operasi()"/>
                    </center>
                  </td>
                  <td>
                    <form action="" method="post">
                      <button type="submit" value="<?php echo $r_draft_pesan['id_pesan'];?>" name="hapus_pesan" class="btn btn-danger btn-mini">
                        <i class='icon-trash'></i>
                      </button>
                    </form>
                  </td>
                </tr>
              <?php
                }
              ?>
                <tr class="odd gradeX">
                  <td>No. Meja</td>
                  <td>
                    <center>
                      <input class="span8" name="no_meja" type="number" value="" placeholder="" />
                    </center>
                  </td>
                  <td>
                    
                  </td>
                </tr>
                <tr class="odd gradeX">
                  <td>Total Harga</td>
                  <td>
                    <center>
                      <span class="label label-success">&nbsp;Rp. <span id="total_harga">0</span>,-&nbsp;</span>
                      <input class="span8" id="tot" name="total_harga" type="hidden" value="" placeholder="" />
                    </center>
                  </td>
                  <td>
                    
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <br>
          <center>
            <button type="submit" value="" name="proses_pesan" class="btn btn-mini btn-info">
              <i class='icon-share'></i> &nbsp;&nbsp;Proses Pesanan
            </button>
          </center>
          <hr>
        </div>
      </form>
      </div>
    </div>
      <?php
        }
          if(isset($_POST['hapus_pesan'])){
            $id_pesan = $_POST['hapus_pesan'];
            $query_hapus_pesan = "delete from tb_pesan where id_pesan = $id_pesan";
            $sql_hapus_pesan = mysqli_query($conn, $query_hapus_pesan);

            if($sql_hapus_pesan){
              header('location: entri_order.php');
            }
          }

            if(isset($_POST['proses_pesan'])){
            $id_admin = '';
            $id_pengunjung = $id;
            $no_meja = $_POST['no_meja'];
            $total_harga = $_POST['total_harga'];
            $uang_bayar = '';
            $uang_kembali = '';
            $status_order = 'belum bayar';

            date_default_timezone_set('Asia/Jakarta');
            $time = Date('YmdHis');

            $CompanyCode = 'CMP001';
            $Status = 1;
            $isDeleted = 0;
            $CreatedBy = $nama_user;
            $CreatedDate = date('d-m-Y H:i:s');
            $LastUpdatedBy = $r['id_user'];
            $LastUpdateDate = date('d-m-Y H:i:s');

            $query_simpan_order = "INSERT INTO tb_order 
            (id_order, id_admin, id_pengunjung, waktu_pesan, no_meja, total_harga, uang_bayar, uang_kembali, status_order, 
            CompanyCode, Status, isDeleted, CreatedBy, CreatedDate, LastUpdatedBy, LastUpdateDate)
            VALUES ('', '$id_admin', '$id_pengunjung', $time, '$no_meja', '$total_harga', '$uang_bayar', '$uang_kembali', '$status_order', 
            '$CompanyCode', '$Status', '$isDeleted', '$CreatedBy', '$CreatedDate', '$LastUpdatedBy', '$LastUpdateDate')";

            $sql_simpan_order = mysqli_query($conn, $query_simpan_order);

            $query_tampil_order = "SELECT * FROM tb_order WHERE id_pengunjung = $id ORDER BY id_order DESC LIMIT 1";
            $sql_tampil_order = mysqli_query($conn, $query_tampil_order);
            $result_tampil_order = mysqli_fetch_array($sql_tampil_order);

            $id_ordernya = $result_tampil_order['id_order'];

            $query_ubah_jumlah = "SELECT * FROM tb_pesan LEFT JOIN tb_masakan ON tb_pesan.id_masakan = tb_masakan.id_masakan WHERE id_user = $id AND status_pesan != 'sudah'";
            $sql_ubah_jumlah = mysqli_query($conn, $query_ubah_jumlah);

            while($r_ubah_jumlah = mysqli_fetch_array($sql_ubah_jumlah)){
              $tahu = $r_ubah_jumlah['id_masakan'];
              $tempe = $_POST['jumlah'.$tahu];
              $id_pesan = $r_ubah_jumlah['id_pesan'];

              $query_stok = "SELECT * FROM tb_masakan WHERE id_masakan = $tahu";
              $sql_stok = mysqli_query($conn, $query_stok);
              $result_stok = mysqli_fetch_array($sql_stok);
              $sisa_stok = $result_stok['stok'] - $tempe;

              $query_proses_ubah = "UPDATE tb_pesan SET jumlah = $tempe, id_order = $id_ordernya, LastUpdatedBy = '$LastUpdatedBy', LastUpdateDate = '$LastUpdateDate' WHERE id_masakan = $tahu AND id_user = $id AND status_pesan != 'sudah'";

              $query_kurangi_stok = "UPDATE tb_masakan SET stok = $sisa_stok WHERE id_masakan = $tahu";

              $query_kelola_stok = "UPDATE tb_stok SET jumlah_terjual = $tempe, LastUpdatedBy = '$LastUpdatedBy', LastUpdateDate = '$LastUpdateDate' WHERE id_pesan = $id_pesan";

              $sql_kelola_stok = mysqli_query($conn, $query_kelola_stok);
              $sql_kurangi_stok = mysqli_query($conn, $query_kurangi_stok);
              $sql_proses_ubah = mysqli_query($conn, $query_proses_ubah);
            }

            if($sql_simpan_order){
              header('location: entri_order.php');
            }
          }

        }
      ?>
    </div>
<!--End-Action boxes-->    
  </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->


<!--end-Footer-part-->

<script type="text/javascript">
  function operasi(){
    var pesan = new Array();
    var jumlah = new Array();
    var total = 0;
    for(var a = 0; a < 1000; a++){
      pesan[a] = $("#harga"+a).val();
      jumlah[a] = $("#jumlah"+a).val();
    } 
    for(var a = 0; a < 1000; a++){
      if(pesan[a] == null || pesan[a] == ""){
        pesan[a] = 0;
        jumlah[a] = 0;
      }
      total += Number(pesan[a] * jumlah[a]);
    }
    
    //alert(total);
    $("#total_harga").text(total);
    $("#tot").val(total);
  }
</script>

<script src="template/dashboard/js/excanvas.min.js"></script> 
<script src="template/dashboard/js/jquery.min.js"></script> 
<script src="template/dashboard/js/jquery.ui.custom.js"></script> 
<script src="template/dashboard/js/bootstrap.min.js"></script> 
<script src="template/dashboard/js/jquery.flot.min.js"></script> 
<script src="template/dashboard/js/jquery.flot.resize.min.js"></script> 
<script src="template/dashboard/js/jquery.peity.min.js"></script> 
<script src="template/dashboard/js/fullcalendar.min.js"></script> 
<script src="template/dashboard/js/matrix.js"></script> 
<script src="template/dashboard/js/matrix.dashboard.js"></script> 
<script src="template/dashboard/js/jquery.gritter.min.js"></script> 
<script src="template/dashboard/js/matrix.interface.js"></script> 
<script src="template/dashboard/js/matrix.chat.js"></script> 
<script src="template/dashboard/js/jquery.validate.js"></script> 
<script src="template/dashboard/js/matrix.form_validation.js"></script> 
<script src="template/dashboard/js/jquery.wizard.js"></script> 
<script src="template/dashboard/js/jquery.uniform.js"></script> 
<script src="template/dashboard/js/select2.min.js"></script> 
<script src="template/dashboard/js/matrix.popover.js"></script> 
<script src="template/dashboard/js/jquery.dataTables.min.js"></script> 
<script src="template/dashboard/js/matrix.tables.js"></script> 

<script type="text/javascript">
  // This function is called from the pop-up menus to transfer to
  // a different page. Ignore if the value returned is a null string:
  function goPage (newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
      if (newURL != "") {
      
          // if url is "-", it is this page -- reset the menu:
          if (newURL == "-" ) {
              resetMenu();            
          } 
          // else, send page to designated URL            
          else {  
            document.location.href = newURL;
          }
      }
  }

// resets the menu selection upon entry to this page:
function resetMenu() {
   document.gomenu.selector.selectedIndex = 2;
}
</script>
</body>
</html>
<?php
  }
} else {
  header('location: logout.php');
}
ob_flush();
?>