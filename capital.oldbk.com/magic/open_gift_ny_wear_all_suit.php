<?
if (!($_SESSION['uid'] >0)) header("Location: index.php");

//$expdate=mktime(0,0,0,01,15,2011); //����� ��������� ������ ������ ����������� ����� �������� � ��������.
//���� ����� ���������� � �������� ��������� � ��������� ����������.
//����� ����������� �������. ����� ���������� open_gift_suit.php - � ��� ��� ��� ����������
$expdate=time()+60*60*24*15;
//  ������� �������, ��������� ������
if($user[sex]==1)
		{
            $s='dm';
			$txt='������ ���� ������';
		}
		else
		{
			$s='sn';
			$txt='������ ����������';
		}
//		������ ������-�������� �������
		$img=array(
				4=>'clip_ny_'.$s,
				41=>'scarf_ny_'.$s,
				1=>'armor_ny_'.$s,
				22=>'overclothes_ny_'.$s,
				42=>'ring_ny_'.$s,
				24=>'cap_ny_'.$s,
				21=>'gloves_ny_'.$s,
				3=>'shield_ny_'.$s,
				2=>'boots_ny_'.$s
		);
	//����� �������
include "open_gift_suit.php";


?>
