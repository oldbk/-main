<?
if (!($_SESSION['uid'] >0)) header("Location: index.php");
		//��� �������� ������ � �����, ������ ��������
		$diff=1;
		$imf_count=12;
		$img_name='armor_';
		$otdel=array(1,11,12,13);
		$txt='������� ������';
		/*
				4=>'clip_ny_'.$s,
				41=>'scarf_ny_'.$s,
				1=>'armor_ny_'.$s,
				11=>'armor_ny_'.$s,
				12=>'armor_ny_'.$s,
				13=>'armor_ny_'.$s,
				22=>'overclothes_ny_'.$s,
				42=>'ring_ny_'.$s,
				24=>'cap_ny_'.$s,
				21=>'gloves_ny_'.$s,
				3=>'shield_ny_'.$s,
				2=>'boots_ny_'.$s
		*/
//����� �������
include "open_gift_gallery_single_wear.php";

?>
