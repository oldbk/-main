<?
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

$proto_ids=array(900,901,902,903);
//����� ����� ���������� � 900-903

if (($user['id']!=$rowm['sowner']))
	{
	echo "����� ������������ ����� ���� ��� ����� ��������!";
	}
elseif (in_array($magic[id],$proto_ids))
	{
	$testeff = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '{$user['id']}' and `type` in (".implode(", ", $proto_ids).") LIMIT 1;"));
	if ($testeff['id']>0)
		{
		echo "�� ��������� ��� ���� ������ ������ ����!"; 		
		}
		else
		{
		$lvlm=$user['level'];
		if ($lvlm<=0) { $lvlm=1; }
		$ef_min=$lvlm*5;
		$ef_max=$lvlm*10;
		
		$ef_add=mt_rand($ef_min,$ef_max);
		mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`add_info`) values ('".$user['id']."','".$magic['name']."',".(time()+($magic['time']*60)).",".$magic['id'].",'".$ef_add."')");
			if(mysql_affected_rows()>0)
			{
			echo "<font color=red><b>�� ����������� �����, � ����� �������...</b></font>";
			$bet=1;
			$sbet=1;
			}
		}
	
	}

?>