<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<table border="1 aolid " cellpadding="5" cellspacing="3">
		<tr>
			<th>no</th>
			<th>nik</th>
			<th>deskripsi</th>
			<th>gambar</th>
			<th>tanggal</th>
			<th>status</th>
		</tr>
		<tr>
			<?php 
			$no = 1;
			foreach ($laporan as $lprn): ?>
				
			<td><?php echo $no++; ?></td>
			<td><?php echo $lprn->nik; ?></td>
			<td><?php echo $lprn->deskripsi; ?></td>
			<?php echo "<td><img src='".base_url("images/".$lprn->nama_file)."' width='100' height='100'></td>"; ?> 
			<td><?php echo $lprn->tgl; ?></td>
			<td><?php echo $lprn->status; ?></td>
		</tr>
		 <?php endforeach; ?>
	</table>
	<script type="text/javascript">
		window.print();
	</script>



</body>
</html>