<?php
	session_start();
	include "connect.php";
	include "functions.php";

	if (!ADMIN) die();

		$shmots = array(
			"1","1","92","92","93","93","19","19","20","20","20","23","23","24","14","87","87","6","6",
			"17","17","17","17","11","11","12","12","12","28","28","43","43","36","36","36","37","37","37",
			"38","38","38","50","50","57","52","52","51","51","48","48","47","47","49","49","59","59","60",
			"60","61","61","63","64","64","65","65","66","66","68","68","69","69","70","70","4","5","79","79",
			"80","76","75","75","94","94","95","95","82","91","91","34","34","9","9","101101","101101",
			"101101","101101","650","650","650","650","651","651","651","651","652","652","652","652","653","653","653","653",
			"102","102","102","103","103","103","104","106","106","107","107","108","108","109",
			"110","111","112","112","113","113","114","121",
			// new from type
			"62","62","280","280",
			"222222236","222222236","222222236","222222236","222222236","222222236",
			"222222237","222222237","222222237","222222237","222222237","222222237",
			"657","657","657","657","657",
			"202","114",
			"207","207","207","207","207","207","207","207","207","207",
			"32","32","38","38","38","38","38","147","147","147","147","147","174","174","35","35","35","172","172","33","33","26",
			"26","28","28","28","28","31","31","31","27","27","24","24","24","22","22","22","23","23","23","16","16","16",
			"16","16","16","16","16","16","16","17","17","17","17","17","17","17","87","87","87","87","87","14","14","14",
			"14","14","15","15","15","15","15","173","173","74","74","73","73","70","70",
			"70","62","62","62","57","57","57","57","57",
			"82","82","111","111","83","83","131","131","96","96","5","5","5","78","78",
			"78","109","109","71","71","170","170","170","170","170","9","9","9","9","9",
			"654","654","654","654","654",
			"653","653","653","653","653","653","653","653","653","653",
			"653","653","653","653","653","653","653","653","653","653",
			"653","653","653","653","653","653","653","653","653","653",
			"231", "228", "45", "177", "178");
				$shmots[] = "240";
				$shmots[] = "239";
				$shmots[] = "234";
				$shmots[] = "190";
				$shmots[] = "5";
				$shmots[]="78";
				$shmots[] = "177";
				$shmots[] = "45";
				$shmots[] = "40";
				$shmots[] = "263";
				$shmots[] = "1120327606";
				$shmots[] = "1121104234";
				$shmots[] = "1490402627";
				$shmots[] = "178";
				$shmots[] = "43";
				$shmots[] = "10";
				$shmots[] = "1121104234";
				$shmots[] = "1220902600";
				$shmots[] = "228";
				$shmots[] = "263";
				$shmots[] = "231";
				$shmots[] = "1120327606";
				$shmots[] = "1561008724";
				$shmots[] = "1510721104";
				$shmots[] = "40";
				$shmots[] = "10";
				$shmots[] = "231";
				$shmots[] = "620";
				$shmots[] = "1160716230";
				$shmots[] = "1121104234";
				$shmots[] = "1300728624";
				$shmots[] = "1510721104";
				$shmots[] = "202"; //������ �������
				$shmots[] = "203"; //������
				$shmots[] = "204";  //�����
				$shmots[] = "200"; //�������� ���� ��������
				$shmots[] = "208";  //���� ������
				$shmots[] = "209"; //��� ����������
				$shmots[] = "210";  //��� �����������
				$shmots[] = "196"; //����� ������
				$shmots[] = "197";  //������ -����� �������-
				$shmots[] = "198";   //����. �����
				$shmots[] = "205";  //������� ������
				$shmots[] = "195"; //������� ������ �����
				$shmots[] = "201";  //������ �����
				$shmots[] = "201";   //������ �����
				$shmots[] = "201";  //������ �����
				$shmots[] = "1006241";
				$shmots[] = "1006242";
		$shmots[] = "206";
		$shmots[] = "199";
	$shmots[] = "194194"; $shmots[] = "194194"; $shmots[] = "194194"; $shmots[] = "194194";
	$shmots[] = "194194";
	$shmots[] = "194194";
	$shmots[] = "119";
	$shmots[] = "120";
	$shmots[] = "121";
	$shmots[] = "171";
	$shmots[] = "171";

	$shmots = array_unique($shmots);

	$src='http://i.oldbk.com/i/sh/';
	$dest = '/www/dtcache/';

	while(list($k,$v) = each($shmots)) {
		$q = mysql_query('SELECT * FROM shop WHERE id = '.$v);
		if ($q !== FALSE) {
			$data = mysql_fetch_assoc($q);
			if ($data !== FALSE) {
				$filename = $src.$data['img'];
				$img = file_get_contents($filename);
				file_put_contents($dest.$data['img'],$img);
			}
		}
	}
?>