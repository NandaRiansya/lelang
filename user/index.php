<html>
    <head>
        <?php
        include 'session.php';
        $query = "SELECT * FROM  `iklan` WHERE status='1' ORDER BY tgl_iklan DESC";
        $result = mysqli_query($query);        
        include 'css.php';        
        ?>     
    </head>
    
    <body class="hold-transition skin-blue layout-top-nav">
        <div class="wrapper">
            <?php include 'menu.php';
            ?>
            <!-- mulai nulis isinya -->
      <div class="content-wrapper">
        <div class="container">
          <section class="content-header">
            <h1></h1>
          </section>
          <section class="content">
              <div class="row">
                  <?php
                  while ($row = mysqli_fetch_array($result)) {
                  ?>
                <div class="col-md-6">
                  <div class="box box-widget">
                    <div class='box-header with-border'>
                      <div class='user-block'>
                        <img class='img-circle' src='../dist/img/user1-128x128.jpg' alt='user image'>
                        <span class='username'><a href="#"><?php echo $row['judul_iklan']; ?></a></span>
                        <span class='description'>Admin : <?php echo $row['tgl_iklan']; ?></span>
                      </div>
                    </div><!-- /.box-header -->
                    <div class='box-body'>                        
                        <?php echo $row['isi_iklan']; ?>
                        
                        <br>
                        <br>
                        <a href="../file/<?php echo $row['file_iklan']; ?>" class="btn btn-md btn-info pull-left">Download Lampiran</a>
                        <a href="ikut_lelang.php?id_iklan=<?php echo $row['id_iklan']; ?>" class="btn btn-md btn-info pull-right">Ikut Lelang</a>
                    </div>
                    
                    <?php
                    $que = "SELECT * FROM  `komentar` WHERE id_iklan ='".$row['id_iklan']."' ORDER BY id_komentar ASC ";
                    $res =  mysqli_query($que);
                    while ($ro = mysqli_fetch_array($res)) {
                    ?>

                    <div class='box-footer box-comments'>
                      <div class='box-comment'>
                        <img class='img-circle' src='../dist/img/user1-128x128.jpg' alt='user image'>
                        <div class='comment-text'>
                          <span class="username">
                            <?php
                            $nama = mysqli_fetch_array(mysqli_query("SELECT * FROM `user` WHERE id_user='".$ro['id_user']."'"));
                            echo $nama['nama'];
                            ?>
                            <span class='text-muted pull-right'><?php echo $ro['jam']; ?></span>
                          </span>
                            <?php echo $ro['isi_komentar']; ?>
                        </div><!-- /.comment-text -->
                      </div>
                    </div>
                    
                    <?php } ?>
                    
                    <div class="box-footer">
                        <form action="ajax.php" method="POST">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" name="comentar">
                                <input type="hidden" name='id_user' value="<?php echo $id_user; ?>">
                                <input type="hidden" name='id_iklan' value="<?php echo $row['id_iklan']; ?>">
                                <span class="input-group-btn">
                                    <input type="submit" class="btn btn-info btn-flat" name="coment" value="POST">
                                </span>
                            </div>
                        </form>
                    </div><!-- /.box-footer -->
                  </div><!-- /.box -->
                </div><!-- /.col -->  
                <?php } ?>
              </div>
          </section>          
            
        </div><!-- /.container -->
      </div>            
            
            <!-- batas nulis isinya -->
            <?php include 'footer.php'; ?>
        </div>
        
        <?php include 'js.php'; ?>
    </body>
</html>