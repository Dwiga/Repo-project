<?php
/**
 * Created by PhpStorm.
 * User: avos
 * Date: 2/27/2016
 * Time: 4:38 PM
 */
require "key.php";
$admin = new adminPage();

switch($_GET['aksi']){
    default:
        try{
            $admin->beginTransaction();
            $admin->query("select * from movie");
            $admin->execute();
            $admin->endTransaction();
        }catch (PDOException $e){
            $err_kon .= "<div class='alert alert-danger'>{$e->getCode()} : Terjadi ERROR dalam pemanggilan data</div>";
        }
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Movie Watcher</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="dataTables/dataTables.bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="dataTables/jQuery/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" charset="utf-8" class="init">
        $(document).ready(function() {
            $('#tabelku').DataTable({
                "aProcessing": true,
                "aServerSide": true
            });
        } );
    </script>
</head>
<body>
<div class="panel-primary">
    <div class="panel-heading">
        <center><strong>My List</strong></center>
    </div>
    <div class="panel-body">
        <?php
        if (!isset($err_kon)):
            $tr .= '<table id="tabelku" class="tabelku table table-bordered table-striped table-hover table-condensed dt-responsive nowrap" cellspacing="0" width="100%">';
            $tr .= '<thead>';
            $tr .= '<tr>';
            $tr .= '<th>No.</th>';
            $tr .= '<th>Date</th>';
            $tr .= '<th>Title</th>';
            $tr .= '<th>Type</th>';
            $tr .= '<th>Comment</th>';
            $tr .= '</tr>';
            $tr .= '</thead><tbody>';
            if ($admin->rowCount() > 0):
                foreach ($admin->fetchAll() as $key):
                    $tr .= "<tr>";
                    $tr .= "<td>{$key->id}</td>";
                    $tr .= "<td>{$key->date}</td>";
                    $tr .= "<td>{$key->title}</td>";
                    $tr .= "<td>{$key->type}</td>";
                    $tr .= "<td>{$key->comment}</td>";
                    $tr .= "<td>";
                    $tr .= "<input type='checkbox' name='ids[]' value='$key->IDSticker'>";
                    //$tr .= "<a class='btn btn-xs btn-success' type='button' data-backdrop='static' title='Tambah History' data-toggle='' data-target='' href='../karet/add_karet.php?aksi=form&opsi=ubah&id={$key->IDSticker}'><i class='glyphicon glyphicon-pencil'></i></a>";
                    //$tr .= " ";
                    //$tr .= "<a class='btn btn-xs btn-primary' type='button' data-backdrop='static' title='Lihat History' data-toggle='' data-target='' href='../karet/show_karet.php?aksi=form&opsi=ubah&id={$key->IDSticker}'><i class='glyphicon glyphicon-search'></i></a>";
                    //$tr .= "<a class='btn btn-xs btn-success' type='button' data-backdrop='static' title='Lihat History' data-toggle='modal' data-target='#myModal' href='http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}?aksi=form&opsi=ubah&id={$key->IDSticker}'><i class='glyphicon glyphicon-open'></i></a>";
                    $tr .= "</td>";
                    $tr .= "</tr>";
                endforeach;
            endif;
            $tr .= '</tbody></table><script type="text/javascript">$(document).ready(function(){$("#tabelku").dataTable();});</script>';
        else:
            $tr .= $err_kon;
        endif;
        echo $tr; return; break;
        ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        AksiForm.init({
            formID: $('#formAksiHapus'),
            modalID: $('#myModal')
        }, panggilAjaxTable);
        $('.fileinput').fileinput();
    });
</script>
</body>
</html>
<?php
}