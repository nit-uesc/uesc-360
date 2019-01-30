<html>
<head>
    <title>Cetak PDF</title>
</head>
<body>
<h1 style="text-align: center;">Data Siswa</h1>

<table border="1" width="100%">
<tr>
    <th>No</th>
    <th>NIS</th>
    <th>Nama</th>
    <th>Jenis Kelamin</th>
    <th>Telepon</th>
    <th>Alamat</th>
</tr>
<?php
if( ! empty($siswa)){
    $no = 1;
    foreach($siswa as $data){
        echo "<tr>";
        echo "<td>".$no."</td>";
        echo "<td>".$data->nis."</td>";
        echo "<td>".$data->nama."</td>";
        echo "<td>".$data->jenis_kelamin."</td>";
        echo "<td>".$data->telp."</td>";
        echo "<td>".$data->alamat."</td>";
        echo "</tr>";
        $no++;
    }
}
?>
</table>
</body>
</html>
