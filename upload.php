<pre>
<?php
include 'includes/login.php';

	// アップロード状況のメッセージ
	$msg = null;
	
	if(isset($_FILES['image']) 
		// ファイルが正しい手順でアップロードされているかを確認する
		&& is_uploaded_file($_FILES['image']['tmp_name'])) {
		// テンポラリにいるときの名前
		$old_name = $_FILES['image']['tmp_name'];
		// アルバムに保存するときの名前
		#$new_name = $_FILES['image']['name'];

		$new_name = date("YmdHis");
		$new_name .= mt_rand();

		switch(exif_imagetype($_FILES['image']['tmp_name'])) {
			case IMAGETYPE_JPEG:
				$new_name .= '.jpg';
				break;
			case IMAGETYPE_GIF:
				$new_name .= '.gif';
				break;
			case IMAGETYPE_PNG:
				$new_name .= '.png';
				break;
			default:
				header('Location: upload.php');
				exit();
		}
	}

	// テンポラリから画像をalbumフォルダに移動する
	// 正しく移動できればtrueが返ってくる
	if(move_uploaded_file($old_name, 'album/'.$new_name)) {
		$msg = 'アップロードしました';
	}	else {
		$msg = "アップロードできませんでした";
	}
?>
</pre>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;
charset="utf-8">
	<title>交流サイト：画像アップロード</title>
<link rel="stylesheet" type="text/css" href="mac.css"/>
</head>
<body>
	<h1>交流サイト：画像アップロード</h1>
	<p><a href="index.php">トップページに戻る</a></p>
	<?php
		if($msg) {
			echo '<p>'.$msg.'</p>';
		}
	?>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<input type="file" name="image">
		<input type="submit" value="アップロード">
	</form>
</body>
</html>