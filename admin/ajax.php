<?php
session_start();
if($_SESSION['status']=="login"){
    if($_SESSION['hak_akses']!="admin"){
        header("location:../user");
    }
}
elseif($_SESSION['status']!="login"){
    header("location:../login.php");
}

include '../include/koneksi.php';

function jam(){
    date_default_timezone_set('Asia/Jakarta');
    $tgl= mktime(date("d"),date("m"),date("Y"));
    $date = date("Y-m-d", $tgl);
    return $jam = date("H:i:s");    
}
function tgl(){
    date_default_timezone_set('Asia/Jakarta');
    $tgl= mktime(date("d"),date("m"),date("Y"));
    return $date = date("Y-m-d", $tgl);   
}

if(con_db()!=1){
    ?>
    <div class="pad margin no-print">
      <div class="callout callout-danger" style="margin-bottom: 0!important;">
        Database Belum Terhubung
      </div>
    </div>
    <?php
}

if($_POST['name']=="hapus" && $_POST['id']!=NULL){
    $id=$_POST['id'];
    block_iklan($id);
}
elseif($_POST['name']=="block" && $_POST['id']!=NULL){
    $id=$_POST['id'];
    block_admin($id);
}
elseif($_POST['comentar']!=NULL && $_POST['id_user']!=NULL){
    $id_iklan=$_POST['id_iklan'];
    $id_user=$_POST['id_user'];
    $comentar = $_POST['comentar'];
    comentar($id_iklan, $id_user, $comentar);
     $query = "SELECT id_user FROM komentar WHERE id_iklan='$id_iklan'"; // cek id yang ada di komentar
     $result=  mysqli_query($query);
     while ($row = mysqli_fetch_array($result)) {
         $id_not=$row['id_user'];
         $cek_query = "SELECT * FROM notif_comentar WHERE id_user='$id_not' AND id_iklan='$id_iklan'";
         $cek_result = mysqli_query($cek_query);
         if($id_not!=$id_user){
            if(mysqli_num_rows($cek_result)>0){
                // update
                update_notif($id_not, $id_iklan);
            }
            else{
                //insert
                insert_notif($id_not, $id_iklan);
            } 
         }     
     }
     header("location:index.php");
}

else if($_POST['pas']!=$_POST['pass']){
    ?>
    <div class="pad margin no-print">
      <div class="callout callout-danger" style="margin-bottom: 0!important;">
        Password Tidak Cocok
      </div>
    </div>
    <?php
}


function block_iklan($id){
    $query = "UPDATE iklan SET status='0' WHERE id_iklan='$id'";
    mysqli_query($query);   
}
function block_admin($id){
    $query = "UPDATE user SET block='0' WHERE id_user='$id'";
    mysqli_query($query);
}
function comentar($id_iklan,$id_user,$message){
    $query = "INSERT INTO `komentar` 
                       (`id_komentar`, `id_iklan`, `id_user`, `isi_komentar`,`waktu_komentar`, `jam`)
                VALUES (NULL, '$id_iklan', '$id_user', '$message','".tgl()."', '".jam()."');";
    mysqli_query($query);
}
function insert_notif($id_user,$id_iklan){
                $insert_query = "INSERT INTO `notif_comentar` (`id_notif`, `id_iklan`, `id_user`, `status`)
                                                                   VALUES (NULL, '$id_iklan', '$id_user', '1');";
                mysqli_query($insert_query);
}
function update_notif($id_user,$id_iklan){
                $update_query ="UPDATE `notif_comentar` SET `status` = '1' WHERE `id_user` ='$id_user' AND `id_iklan`='$id_iklan';";
                mysqli_query($update_query); 
}
?>