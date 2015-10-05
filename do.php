<?php

	if (isset($_POST['code'])){
		require './config.php';
		$the_SQL = mySQLi_connect($SQL_host, $SQL_user, $SQL_passwd, $SQL_name);
		if (!$the_SQL) show_error_exit('Could not connect to MySQL, fuck this world.');

		if ( !mysqli_query($the_SQL,"SELECT * FROM codes") ){

			$is_ok = mysqli_query($the_SQL,"CREATE TABLE codes (
				id int NOT NULL AUTO_INCREMENT,
				PRIMARY KEY(id),
				lang tinytext,
				code longtext
			)");

			if (!$is_ok) echo 'Could not create database table';

		}

		$the_code = $_POST['code'];
		$the_lang = $_POST['lang'];

		if( !preg_match('/^[A-Za-z0-9]+$/', $the_lang) ){
			echo "bad DATA";
		}

		$the_code = str_replace("&", "&amp;",$the_code);
		$the_code = str_replace("'", "&#39;",$the_code);
		$the_code = str_replace("\"", "&#42;",$the_code);
		$the_code = str_replace("=", "&#61;",$the_code);
		$the_code = str_replace("?", "&#63;",$the_code);
		$the_code = str_replace("\\", "&#92;",$the_code);
		$the_code = str_replace("<", "&lt;",$the_code);
		$the_code = str_replace(">", "&gt;",$the_code);

		mysqli_query($the_SQL, "INSERT INTO codes (lang, code) VALUES ('$the_lang', '$the_code');" );

		$result = mysqli_query($the_SQL, "SELECT count(*) FROM codes");

		$id = mysqli_fetch_array($result)[0];

		if($ReWrite){
			header("Location: ".$id);
		}else{
			header("Location: code.php?n=".$id);
		}

	}else {
		echo "no POST data";
	}

?>
