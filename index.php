<?php

require ("key.php");
$admin = new adminPage();

/**
 * Created by PhpStorm.
 * User: ITCOMP03
 * Date: 12/3/2015
 * Time: 9:25 AM
 */

switch ($_GET['aksi']) {
default:
try {
    $admin->beginTransaction();
    $admin->query("SELECT * from movie");
    $admin->execute();
    $row = $admin->fetchAll();
    $admin->endTransaction();
}
catch
(PDOException $e){
    $err_kon .= "<div class='alert alert-danger'>{$e->getCode()} : Terjadi ERROR dalam pemanggilan data</div>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta content="text/html; charset=iso-8859-1" http-equiv="content-type"/>
    <title>Show Table Sticker History</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="dataTables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <script type="application/javascript" src="dataTables/jQuery/jquery-1.11.3.min.js"></script>
    <script type="application/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="application/javascript" src="dataTables/jQuery/jquery.dataTables.min.js"></script>
    <script type="application/javascript" charset="utf-8" class="init">
        $document.ready(function () {
            $('#tabelku').DataTable({
                "aProcessing": true,
                "aServerSide": true
            });
        });
    </script>
</head>
<body>
<div class="col-md-12">
<div class="panel panel-primary">
<div class="panel-heading">Tabel Detail Karet</div>
    <div class="panel-body">
<?php
if (!isset($err_kon)):
    $tr .= '<table id="tabelku" class="tabelku table table-bordered table-striped table-hover table-condensed dt-responsove nowrap" cellspacing="0" width="100%">';
    $tr .= '<thead>';
    $tr .= '<tr>';
    $tr .= '<th>Date</th>';
    $tr .= '<th>Title</th>';
    $tr .= '<th>Type</th>';
    $tr .= '<th>Comment</th>';
    $tr .= '</tr>';
    $tr .= '</thead><tbody>';
    if ($admin->rowCount() > 0):
        foreach ($admin->fetchAll() as $key):
            $tr .= "<tr>";
            $tr .= "<td>{$key->date}</td>";
            $tr .= "<td>{$key->title}</td>";
            $tr .= "<td>{$key->type}</td>";
            $tr .= "<td>{$key->comment}</td>";
        endforeach;
    endif;
    $tr .= '</tbody></table><script type="text/javascript">$(document).ready(function(){$("#tabelku").dataTable();});</script>';
else:
    $tr .= $err_kon;
endif;
echo $tr; return; break;
?>
<script type="text/javascript">
    $(document).ready(function() {
        AksiForm.init({
            formID: $('#formAksiHapus'),
            modalID: $('#myModal')
        }, panggilAjaxTable);
        $('.fileinput').fileinput();
    });
</script>
<?php
}
?>
        </div>
    </div>
    </div>
</body>
</html>
