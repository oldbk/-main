<?php
	// ����� ����� �����
	$q_status = array(
		0 => "��������� ������ ����� � ��������� � ��������",
		1 => "������� ������ ��������",
		2 => "�������� ������ � ����",
		3 => "�������� ����� ��������",
		4 => "������������ ������ �� ���������",
		5 => "�������� ������ ������� � ��������� ����� (%N1%/1), ����� ���������� (%N2%/1), �����-����� (%N3%/5)",
		6 => "������������ ����� ������",
		7 => "����� ��������� �� �����",
		8 => "��������� � ������",
		9 => "�������� �������� ����� ����",
		10 => "��������� � ����",
		11 => "�������� ���� ��� ������� (%N1%/1), ����� ����� (%N2%/5), ���� �� ��� ����������� (%N3%/1)",
		12 => "������� ��� � ������� �� ������ (%N1%/5)",
		13 => "��������� � ����",
		14 => "�������� �� ���� �������� ����",
		15 => "��������� � ������",
	);
	
	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 30) return;

	$step = $questexist['step'];
                                            
	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	$ai = explode("/",$questexist['addinfo']);

	// 3 - ������ �����
	// 9 - ������ �����
	// 13 - ������ �����
	// 14 - ��������� �����

	if ($sf == "mlwood") {
		if ($step == 0) {
			$mlqfound = false;
			$qi1 = QItemExistsID($user,3003211,1);
	
			if ($qi1 !== FALSE) {
				$mlqfound = true;
				$todel = $qi1;
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "��, ������ �� �������� ������? � ����� ����� ����� ������� �� ������, ��� � ���� ��� ������� ������!",
						3 => "��������� ���� �� ������, ��� ���. �� ���� ��� � ��������� ������� �������� ������� � �����.",
					);
				} elseif ($_GET['qaction'] == 3 && $mlqfound) {
					$mldiag = array(
						0 => "�� ��������� � ���� ��� ������ ��������, � ��� �� ������� � ���� ��. ������-�� �� � ��������, ����� ����, �� �����, ���� ��� �����������.",
						4 => "��� � ������. ����!",
					);
				} elseif ($_GET['qaction'] == 4 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,30,1) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 99) {
					mysql_query('START TRANSACTION') or QuestDie();
					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();		
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��, ��� � ������?",
					1 => "��, � �������� �����, ��� � ������. ��� ��� ����� ����� ���� �� ����� ������� ����. �� ��� �������� �� ����, ��� ���������� �� ����, ���� � �����������. � ����� �� ��� ��� ���� �������.",
					99 => "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)",
					11111 => "���� ��� ���, �������, ����� ������.",
				);
				if (!$mlqfound) unset($mldiag[1]);
			}	

		} else {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 99) {
					mysql_query('START TRANSACTION') or QuestDie();
					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();		
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ���-�� �����?",
					99 => "� ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)",
					11111 => "���, ������ ������������.",
				);
			}
		}
	}

	if ($sf == "mlhunter") {
		if ($step == 1 && QItemExistsID($user,3003211,1)) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "������� ������, �����? �� � �������� ������ ��������� �� ������, ��� �� ����������� �� ����� �� ������� ����. ��� ��� ��������� ���-�� � �� �� ������� �����, � �� �� � ������.",
						3 => "�� ������, ��� � ���� �������� ������ � ����� �������?",
					);
				} elseif ($_GET['qaction'] == 3) {
					$mldiag = array(
						0 => "���� ��� ������ �� �������� � � ���� ���� �������, �������� �����: �������� ��������, ������ � ���������, ������ ���� �� ������ ��� � ��� ������ � ����� �� �������. ������� � ���, ������ ����������.",
						4 => "������, ��������� ����� � �������. ����! ",
					);
				} elseif ($_GET['qaction'] == 4) {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,30,2) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��, ������, �� ���� ���� � ��� �� ����, ���� ��� ����������?",
					1 => "� ���� ���������! ������� ����� �������� � ���� ������. �� ������, ���� ����� ������������ ��� ������?",
					11111 => "������, ������ ���� ��������",
				);
			}	

		}
		if ($step == 3 && QItemExistsID($user,3003211,1) && QItemExistsID($user,3003212,1)) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "��-��, �� �������, ���� � ����� �������, ��� ��� ���� � ������� ���������� ���� � ���������� ���������, �������� � ������������� �������� ����������. �� ��� ������ �� ��� ����������. ������� ������� ���-�� ��� ���� ���-�� ��� ������. ���! ��� ���, �����!",
						3 => "���� ���-������, ��� ����� ���� ��� �������?",
					);
				} elseif ($_GET['qaction'] == 3) {
					$mldiag = array(
						0 => "��� ������� � �������� ������� � � ���� ��� �������: ������� � ������. ������� ����������� � ���, ��� ������ � ����, ��� ��� ������.",
						4 => "� ������?",
					);
				} elseif ($_GET['qaction'] == 4) {
					$mldiag = array(
						0 => "��, ��� ������ ������� �� ��� ���, � ��� ������, ��� ����� �� ������� � ��� ������. ��������� ����� ������ ����������� �������� ������ ��������� �� ��������. ���� ������ ����� � ��� �� ����������� �� ����� ���, ��� �� ��������� ��������� ������������ ������������ ���������.",
						5 => "��� �� ��� ������?",
					);
				} elseif ($_GET['qaction'] == 5) {
					$mldiag = array(
						0 => "���� ���� �� ����������� ������ ������ � �� ��� �� ����������� �� ������ � ������������ � � �������������� ���������. ����� �������� ������� ��������. ���� �� ������ ������ ���� �� ����� � ������ ������ �� ���� � ��������� ���� ����� ����������� ������. �� ���� � ��� �� ������ �� ����������� �� � ���������� �, ����� �� �������� �����, ��������� ��� �� ����",
						7 => "� ���������� � ������ ����������! ������ ��� ��� � ��� �� ��������� ������ �������, ��� �� ��������� ����� ������!",
						6 => "�� ���� ������� �� ��� ���.",
					);	
				} elseif ($_GET['qaction'] == 6) {
					// ����� �������
					mysql_query('START TRANSACTION') or QuestDie();

					$r = AddQuestRep($user,150) or QuestDie();
					$m = AddQuestM($user,3,"�������") or QuestDie();
					$e = AddQuestExp($user) or QuestDie();
	
					if ($user['level'] == 6) {
						$item = 33029;
					} elseif ($user['level'] == 7) {
						$item = 33030;
					} else {
						$item = 33031;
					}

					PutQItem($user,$item,"�������",0,array_merge(QItemExistsID($user,3003211),QItemExistsID($user,3003212)),255) or QuestDie();

					$msg = "<font color=red>��������!</font> �� �������� <b>���� �����</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
					addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
	
					UnsetQuest($user) or QuestDie();

					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 7) {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,30,4) or QuestDie();

					PutQItemTo($user,'�������',array_merge(QItemExistsID($user,3003211),QItemExistsID($user,3003212)));

					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � ������?",
					1 => "��, ��� �� ����� �����, � ������� �� �������, �����. ���, ������, �� ������� ������ � ��� ���������.",
					11111 => "��� ���, �� � ��������� �������",
				);
			}	
		}
		if ($step == 9) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "��� ��� ��� �������, ��, ��������, � ������� �� � ���.� ��� �� ��� �� ����, �����!",
						3 => "� ����. ����!",
					);
				} elseif ($_GET['qaction'] == 3) {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,30,10) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � ������?",
					1 => "� ���������, ���. � ���� �� ������� ������ �����. ��, �������� ������, �� ������ � ������, ��� �������� �������� ��� ������ �� ������������. ��� ���, �����, ������������ �� � ���.",
					11111 => "� ��� ��� � ������, ������� �������...",
				);
			}	
		}
	}

	if ($sf == "mlmage") {
		if ($step == 2 && QItemExistsID($user,3003211,1)) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "�� ���� ��� - ���������� ���� ��-�� ������ ���������. �� �� ������ ��� ��� �� � ���� � ������. �� ���� ������, ����� �������� ����������� ���� ���������� �����, �� ���� ���� � ������ �������, ������ ��� � ���, � ���� ��� ������� �� ������ ������ ������!",
						3 => "����� ��� �������������, �������! ��, ��� �� ��� ����� ����� �, ���, ������� �����! ������� ��� ���! �� ���� ����� ��������� ����! ����!",
					);
				} elseif ($_GET['qaction'] == 2) {
					// ������ �����
					$mldiag = array(
						0 => "� ���� ��� ������� �� ������ ��������! �����, ����� ����, ��� �� ��� ����� ������? ������� ������, �����? �������, ��� ���� ���-��� ���������.",
						4 => "�������-�������, � ���� ��� ����� ������ �� ����.",
					);
				} elseif ($_GET['qaction'] == 4) {
					// ������ �����
					$mldiag = array(
						0 => "����� ������, ��� �� ������ ������ �� ���. ����� ������ ���������� ����� ����, ��� ����� �� �������� ������ ��������� �� �����. ��� ��� ����� ��� ������?",
						5 => "��, ������ � ������� ������ ��������, � ����� ��������, ������� ����� �� ���-�� � ��� ����, ��, �� ���� ���������, �����. ",
					);
				} elseif ($_GET['qaction'] == 5) {
					// ������ �����
					$mldiag = array(
						0 => "� �������� ����� �� �����������. �� ������� �������, ��, ��� �� ���, ������� �������. � ��� ������� ����� ����� ���������. ������ � ���� ���������� � �����, ����� �� ��� �������� ������ � ����������� �� � ���, � ���� ������ �� ����� �� �������.",
						6 => "�� ����, �� � �� ������, ��� ��� ��������� � ����� ��������.",
					);
				} elseif ($_GET['qaction'] == 6) {
					// ������ �����
					$mldiag = array(
						0 => "��� ��� �� ��������. �������� ��� � � � � ����� �� ��������, � ������������� ���� �������� �����!",
						7 => "������. ����� � ���������� ����������. ����!",
					);
				} elseif ($_GET['qaction'] == 7) {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,30,9) or QuestDie();
					PutQItemTo($user,"���",QItemExistsID($user,3003211,1));
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 3) {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,30,3) or QuestDie();
					PutQItem($user,3003212,"���");

					addchp ('<font color=red>��������!</font> ��� ������� ��� <b>�������� ��������, ������ � ���������</b> ','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "�� ����� ���� ����� ���������. ����� ������ � �� ������ ����? ������.",
					1 => "�����������, ���� ������������! � ������ �� ��������� ��������. ������� ����� ������, ����� ��� � ����� �����, �� �������� ��� �������� ��������, ������ � ���������.",
					2 => "�� ��������, ������ ������� � ������� �����������. ������-�� � ������ � ���� �� ����� ������, �� ������, �� ��� �� �� ��������� �� ��� �������, ����� �������� ����� ��� � �� �����������.",
					33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
					44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
					11111 => "������ ��� ������ ��� �����.",
				);
			}	
		} elseif ($step == 9 || $step == 10) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $step == 10) {
					$mldiag = array(
						0 => "���������� �������. ������, ���� ���� �� ����, � �������, ��� �� ��� �� ������ ��� ��� ��� � ���. ������������ ��������, ��� � ��� �� �������� ��� ����������, �������, �� ���� ���������� ���������, ��� ����� ���� �������. �������� ������ ������ �� ��������� ���������. ������, � �� ������ � �� ������ � �����, ��� ��� ������� ������� �� ������.",
						3 => "��� �� ������ � ����, �������?",
					);
				} elseif ($_GET['qaction'] == 3) {
					$mldiag = array(
						0 => "Ÿ ������ �������� ���������� �������� ���. �� ����� ������� � �������, ��� ���, ����������, �� �� �� �������������� ��������� �����������. ������� ��� �� �����������, ����� � ���� ��������� ����������, ������� �� �������� ������ ������! ��� �����: ��� �������, 5 ������ ������� �����, ���� �� ��� �����������. ����������� �� ������.",
						4 => "������� �� ������������� ��� ������ ���������� � � ������� ������?",
					);
				} elseif ($_GET['qaction'] == 4) {
					$mldiag = array(
						0 => "������? � ��� ������� � ������? ��� ������ ����� ��� ������ �� �������... �� � ������: �� ��� ��� ����, ���� � ����, � ���� �� ����! ��� ���� - ������, ������� �� �� ��������� �� ������� ��� ���!",
						5 => "������, � ������ ���� ������ ��� �����������. ����!",
					);
				} elseif ($_GET['qaction'] == 5) {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,30,11) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��, ��� � ������?",
					1 => "��, � ������ �������� ��, ��� �� �����.",
					33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
					44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
					11111 => "��� ����� ��� ������",
				);
				if ($step == 9) unset($mldiag[1]);
			}	
		} elseif ($step == 11) {
			$mlqfound = false;
			$qi1 = QItemExistsID($user,3003216);
			$qi2 = QItemExistsID($user,3003218);
			$qi3 = QItemExistsCountID($user,3003217,5);
	
			if ($qi1 !== FALSE && $qi2 !== FALSE && $qi3 !== FALSE) {
				$mlqfound = true;
				$todel = array_merge($qi1,$qi2,$qi3);
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "�������, ����� � ��������� � ���������� ��������, � �� ��� �������� ������ ��� ���� � ������ � � ������ ������. ���� ����� ������� ������ ��� ���� ���. �� ������!",
						3 => "� ���� ������ ������� ���� � ���-�� ����������?",
					);
				} elseif ($_GET['qaction'] == 3 && $mlqfound) {
					$mldiag = array(
						0 => "� �� ��������. ��� ������ ��, �������������, ���� ����� �������, ����� ��������� � ��� � ������. ��������! ������-�� ���� ����� � ������ � ���� ����� ���. ���� �� ������ ����, � ������ �����, ��� ������ �� ����-��, ����� �� ��� ����� ����� �������� ��� �������, ��� ������������� ���. ��, ������.",
						4 => "������, ����� ������ ��� ����!",
					);
				} elseif ($_GET['qaction'] == 4 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();

					PutQItem($user,3003222,"���",0,$todel) or QuestDie();
					PutQItem($user,3003219,"���") or QuestDie();

					addchp ('<font color=red>��������!</font> ��� ������� ��� <b>���������� ����</b> ','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
					addchp ('<font color=red>��������!</font> ��� ������� ��� <b>����� ��� ���</b> ','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					SetQuestStep($user,30,12) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � ������?",
					1 => "�� �������, � ������ ��� �����������.",
					33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
					44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
					11111 => "���� ��� �� ������, ����� ��� �����",
				);
				if (!$mlqfound) unset($mldiag[1]);
			}
		} elseif ($step == 13) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "������������! ������ �����������! ��� ���� �������, �� ������ ������. ������ ��� �������� ��� ������ �� ������ �������� � ������ ��� �� ����� ���������?",
						3 => "���, � ������� �����.",
					);
				} elseif ($_GET['qaction'] == 3) {
					// ����� �������
					mysql_query('START TRANSACTION') or QuestDie();

					$r = AddQuestRep($user,150) or QuestDie();
					$m = AddQuestM($user,2,"���") or QuestDie();
					$e = AddQuestExp($user) or QuestDie();

					PutQItem($user,15567,"���",0,array(),255,"eshop") or QuestDie();	

					if ($user['level'] == 6) {
						$item = 5202;
						$txt = "90";
					} elseif ($user['level'] == 7) {
						$item = 5202;
						$txt = "90";
					} elseif ($user['level'] == 8) {
						$item = 5205;
						$txt = "180";
					} elseif ($user['level'] == 9) {
						$item = 5205;
						$txt = "180";
					} else {
						$item = 5205;
						$txt = "180";
					}

					PutQItem($user,$item,"���",0,array(),255,"eshop") or QuestDie();

					$msg = "<font color=red>��������!</font> �� �������� <b>������� ������ ����� �����������</b> � <b>������� ������ ��������������� ".$txt."HP�</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
					addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
	
					UnsetQuest($user) or QuestDie();

					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��, ��� � ������?",
					1 => "��, ��� �� � ������, ��� �������, � ������ � ���� � ���� ������ �����.",
					33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
					44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
					11111 => "���, � ��� �� ��� ������.",
				);
			}	
		} else {
			$mldiag = array(
				0 => "�� ����� ���� ����� ���������. ����� ������ � �� ������ ����? ������.",
				33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
				44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
				11111 => "������ ��� ������ ��� �����.",
			);
		}
	}

	if ($sf == "mlwitch") {
		if ($step == 4) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "���������? � ���� �� ��� ��������? � � � ���� ���������! ��� ������ � ��� �������� � ����� �� ������� ��������� ���!",
						3 => "�����, �������� �� ����� �� ������-�� ��� �������� ������, ��� ������� ������� � ���� ����, �� ���������� � �����.",
					);
				} elseif ($_GET['qaction'] == 3) {
					$mldiag = array(
						0 => "�������� �� �����, ��������? ��, ���� �������� � ��������� ��� ������ �� ������. ��������, �� ���������� �� ������ ��� ����� �� ���� �������� ��������? � ���� �������, ����������, �, ������� ��, �� ������ ��������������?",
						4 => "����� ������ ��� �� ����� ���������.",
					);
				} elseif ($_GET['qaction'] == 4) {
					$mldiag = array(
						0 => "���������� �������, ��� �����, �� ���� �� ������ ����� ���� ��� ������ ����� � �������� ������? ��, � �����, ������, ��� ����������� ��������� �����������: ��������� ������ ����, ����� ���������� �, ����� �������, ���� ������� �����-�����, ������� ������ �� ������.",
						5 => "� ������� ��� �����������. �� �������!",
					);
				} elseif ($_GET['qaction'] == 5) {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,30,5) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��������� ����� �� ��� ��������� �����, � ���� ���-�� ����. ��� ������� ���� � ��� ����?",
					1 => "����� �������� ��� ������, �� � ��� ������ ��� ������� �� ���������! � �����, ��� �� ������������ ���� � ������������� ���������!",
					11111 => "�������, � ������ �������",
				);
			}	
		}	

		if ($step == 5) {
			$mlqfound = false;
			$qi1 = QItemExistsID($user,3003213);
			$qi2 = QItemExistsID($user,3003214);
			$qi3 = QItemExistsCountID($user,3003215,5);
	
			if ($qi1 !== FALSE && $qi2 !== FALSE && $qi3 !== FALSE) {
				$mlqfound = true;
				$todel = array_merge($qi1,$qi2,$qi3);
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "� �� ����� ����������, ��� �� ����� ����� � ������ ����� ����������, ����� ������ ��� �� �������. ������ � ���������� �����, ���� �� ��� ������� � �������� �� ����� ���� ������ �����",
						3 => "��� �, ��� ����� �����, ��� ������ ����������� �� �� ����� ����.",
					);
				} elseif ($_GET['qaction'] == 3 && $mlqfound) {
					$mldiag = array(
						0 => "��-�� � ���. �� ����� ������, ������ ��� � ������ � ���. ���� ��� �������� ������������� ��� ������, ��, ��� ������ ����� ���������, ��� �������, ���� ����� � �����.",
						4 => "�� ����� ������ �������. � �������, ��� ������ ������� � ����. �� � ���� �� �������, ����, � ������ ��� ��� ���� � ���� �����. ����!",
					);
				} elseif ($_GET['qaction'] == 4 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();

					PutQItem($user,3003221,"������",0,$todel) or QuestDie();

					addchp ('<font color=red>��������!</font> ������ �������� ��� <b>����� ������</b> ','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					SetQuestStep($user,30,6) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � �������?",
					1 => "��, � ������ ��� ����������� � �����, ���� � ����� ����������. �����.",
					11111 => "���� ��� �� ������, ����� ��� �����",
				);
				if (!$mlqfound) unset($mldiag[1]);
			}	
		}

		if ($step == 6 || $step == 7 || $step == 8) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $step == 8) {
					$mldiag = array(
						0 => "��� ������������! � �������, ��� � ���� �� ���������� � �������� �����-�� ��������, �� �� ��� �������� �������� ������ �������, �� ��� ���� ������.",
						3 => "�������. � ��� ��� ���� ������ ����.",
					);
				} elseif ($_GET['qaction'] == 3 && $step == 8) {
					// ����� �������
					mysql_query('START TRANSACTION') or QuestDie();

					$r = AddQuestRep($user,150) or QuestDie();
					$m = AddQuestM($user,2,"������") or QuestDie();
					$e = AddQuestExp($user) or QuestDie();

					if ($user['level'] == 6) {
						$item = 5202;
						$txt = "90";
					} elseif ($user['level'] == 7) {
						$item = 5202;
						$txt = "90";
					} elseif ($user['level'] == 8) {
						$item = 5205;
						$txt = "180";
					} elseif ($user['level'] == 9) {
						$item = 5205;
						$txt = "180";
					} else {
						$item = 5205;
						$txt = "180";
					}

					PutQItem($user,$item,"������",0,array(),255,"eshop") or QuestDie();

					$item = 3101;
					$howmuch = 5;
					if (mt_rand(0,100) < 70) {
						$item = 3103;
						$howmuch = 20;
					}
	
					PutQItem($user,$item,"������",0,array(),255,"eshop") or QuestDie();
		
					$msg = "<font color=red>��������!</font> �� �������� <b>������� ������ ��������������� ".$txt."HP�</b> � <b>��� �� ������������ ".$howmuch." ��.</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
					addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
	
					UnsetQuest($user) or QuestDie();

					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��, ��� � �������?",
					1 => "� �������� �����, ��� ������ ������������� ����, ��� �������� ������ � ������ ���� ����� ��� ���������.",
					11111 => "��� ���",
				);
				if ($step != 8) unset($mldiag[1]);
			}	
		}

		if ($step == 12) {
			$mlqfound = false;
			$qi1 = QItemExistsID($user,3003219);
			$qi2 = QItemExistsID($user,3003222);
			$qi3 = QItemExistsCountID($user,3003220,5);
	
			if ($qi1 !== FALSE && $qi2 !== FALSE && $qi3 !== FALSE) {
				$mlqfound = true;
				$todel = array_merge($qi1,$qi2,$qi3);
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "���-�� ��� ���, ����� � ������������� ����, ������ ������������� ���. ���� ��� ������ �� ������, �� �����-�� �����",
						3 => "������ ������ ����, � ��� ��� ������� �������, �� �������. ��� � �������� ������.",
					);
				} elseif ($_GET['qaction'] == 3 && $mlqfound) {
					$mldiag = array(
						0 => "��, ���� ������ ��������, �� ��� ���� � �������, �� ��� ����� - �������. � ���� ����������� � ������� ������ ���� ���� � �� ����� �� ����� ������� � ���������",
						4 => "�� ��� ��, � �� ��� � ����� ���, ���� ������ ������-�� ����� �������. ���� ��� ����, ������ ����������. ����!",
						5 => "���������, �� ���� � ��� � ����� ���������, ���� ��� ��, �� ���� � ��� ������! �� �� ��������� ��� �����!",
					);
				} elseif ($_GET['qaction'] == 5 && $mlqfound) {
					// ������ �����
					$mldiag = array(
						0 => "� ��� ��� ��?",
						6 => "��� ���� ����� ���������, ����� � ����� ������ � ������ ���� ���� ���������, ��� �� ����� �� ��� ���� �������� ���� ��������! � � ����� ������ ��� ��� ������������ �������� �� �����.",
					);
				} elseif ($_GET['qaction'] == 6 && $mlqfound) {
					// ������ �����
					$mldiag = array(
						0 => "��� ��������� �� ������� ���������� � ���� ���� ������! �� ��� �� ������, ���������?! �������� ������!",
						7 => "������, ���� �� � ������ ��� ���-�� �������� ���� ����",
					);
				} elseif ($_GET['qaction'] == 7 && $mlqfound) {
					// ������ �����
					$mldiag = array(
						0 => "��������? ��, ������ ���-��� �������. ����� ���� ����� �������, � ���� ������ � ����� � �����. ������ ������ ���� ����� ��� �������� ����� ���������. ��� ����������� �� �����  ��� ��������� � �����������.",
						8 => "������, ��� � �������.",
					);
				} elseif ($_GET['qaction'] == 8 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();

					PutQItemTo($user,"������",array_merge($qi3,$qi1)) or QuestDie();

					SetQuestStep($user,30,14) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 4 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();

					PutQItemTo($user,"������",$todel) or QuestDie();

					SetQuestStep($user,30,13) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��������� ����� �� ��� ��������� �����, � ���� ���-�� ����. ��� ������� ���� � ��� ����?",
					1 => "�� ���, ��� �������, � ���� ������ - �� ����. � ������� ������, ��� ���� ��� ������ ����� ��� ����� ����������� ���.",
					11111 => "������ ����� �� ������, ��� �����",
				);
				if (!$mlqfound) unset($mldiag[1]);
			}	
		}
		if ($step == 14 || $step == 15) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $step == 15) {
					$mldiag = array(
						0 => "��, ����, ������, ��� �� ������. ������� �� ��, ��� ����������� � ����� ���������� ������ ����. ������, � ������ ����� �� ��������, �� �����-�� � ���� ���� ��������� ������. � �� �� ������� ��� ��� ��� � ����� � ���� �� ���������, ������ � �� ������� ������������, �� ��� �� ������, ��� �� �������� ��.",
						3 => "� ����� �� ����. ���, ����� ����, ���� �� ����.",
					);
				} elseif ($_GET['qaction'] == 3 && $step == 15) {
					$mldiag = array(
						0 => "���, ������ ��� �������� ������� � ���� ��������������� �� ��, ��� ������ ��� ������ ��������, ����� ���� �� � �� ���������� ������ �� �� �������������.",
						4 => "�������. � ����� ���� �������� ���� ���� ����� �����.",
					);

				} elseif ($_GET['qaction'] == 4 && $step == 15) {
					// ����� �������
					mysql_query('START TRANSACTION') or QuestDie();

					$r = AddQuestRep($user,200) or QuestDie();
					$m = AddQuestM($user,3,"������") or QuestDie();
					$e = AddQuestExp($user) or QuestDie();
	
					PutQItem($user,105,"������",7,array(),255) or QuestDie();
					PutQItem($user,15562,"������",0,array(),255,"eshop") or QuestDie();
			
					$msg = "<font color=red>��������!</font> �� �������� <b>������ �������</b> � <b>������� ������ �����������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
					addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
	
					UnsetQuest($user) or QuestDie();

					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��, ��� � �������?",
					1 => "��, �������� �� �������� �����, �� � ���� ���������� ����������� � ����.",
					11111 => "��� ���",
				);
				if ($step == 14) unset($mldiag[1]);
			}	

		}
	}

	if ($sf == "mlboat" && $step == 5) {
		$mlqfound = QItemExists($user,3003213);

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "��� ������������! ������ ������ �������� ������� ����� ���� ����, ����������� �� ������� � ������. ����� ��� ����� ������.",
					3 => "������� �� ����, ���� ������, ������ � �� �����, ��� ������ ������� ��� �������� ��� ����, ��� ������ �� ��������� ������ ��� � ���������� � ���������. ��� ��� �� ������ ������ ������� ������ �����.",
					
				);
			} elseif ($_GET['qaction'] == 3 && $mlqfound === FALSE) {
				$mldiag = array(
					0 => "��, ���� ��������, ��, � ����� ����, ��� � �������� ����� ������� �� �������� ����. ������� ���� �� ������, � ����� �������.",
					4 => "�������-�������, � �������.",
					
				);		
			} elseif ($_GET['qaction'] == 4 && $mlqfound === FALSE) {
				$mldiag = array(
					0 => "��, ��� � ���. �����-�� � ���, �����, �� ����� �� �������. ���, ����� ���� ���� � ������� ������, ��� �������� �������� ���������� �� ���� ��������� ��������.",
					5 => "������������� �������. ����!",
					
				);		
			} elseif ($_GET['qaction'] == 5 && $mlqfound === FALSE) {
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItem($user,3003213,"��������") or QuestDie();
				addchp ('<font color=red>��������!</font> �������� ������� ��� <b>������� � ��������� �����</b> ','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} elseif ($_GET['qaction'] == 2) {
				$mldiag = array(
					0 => "��������� ���������. ������� 1 ������, � �������.",
					33333 => "��������� 1 ������.",
					11111 => "����������� � ����.",
				);			
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "�����������. ��� ����� ������ � ������� ��������. ��������� ������� � ���������. ",
				1 => "��� �� ����� ��������������. � ����� �� ��������� ������. ���� ��� �� ������� ������ ��� �� ������ ��������� ���� �� ���� � ��� �������� �������� ���������� ���� � ���� �, �����, ���� ������� �������� � ���� ������ ����� ���������.",
				2 => "��� �� ������������� �� �� �������. ������� ��� ����� ������?",
				11111 => "���, �������, � ���� ����������",
			);
			if ($mlqfound !== FALSE) unset($mldiag[1]);
		}
	} elseif ($sf == "mlboat") {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 2) {
				$mldiag = array(
					0 => "��������� ���������. ������� 1 ������, � �������.",
					33333 => "��������� 1 ������.",
					11111 => "����������� � ����.",
				);			
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "�����������. ��� ����� ������ � ������� ��������. ��������� ������� � ���������. ",
				2 => "��� �� ������������� �� �� �������. ������� ��� ����� ������?",
				11111 => "���, �������, � ���� ����������",
			);
		}

	}

	if ($sf == "mlvillage" && $step == 5) {
		if (((isset($_GET['quest']) && $_GET['quest'] == 2) || (isset($_GET['qaction']) && $_GET['qaction'] > 2000 && $_GET['qaction'] < 3000))) {
			$mlqfound = false;
			$qi1 = QItemExistsID($user,3003214,1);
	
			if ($qi1 !== FALSE) {
				$mlqfound = true;
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 2001 && !$mlqfound) {
					$mldiag = array(
						0 => "����� �� ������ ��� ��� ����, ���� �����, ��� ���. ��� ��� ���� ����� ������ � �-��� � �������� ���������� � �� �������� ������.",
						2004 => "��� ��� ����������� � �������������� � ����� �������! ������ ����! ��� ��� � ���?!",
					);
				} elseif ($_GET['qaction'] == 2004 && !$mlqfound) {
					$mldiag = array(
						0 => "���?! � ��� �� ��� ���?! ��� � ���� ���?!",
						2005 => "�� ��� ��, � ��������",
					);
				} elseif ($_GET['qaction'] == 2005 && !$mlqfound) {
					$mldiag = array(
						0 => "��! ��� ���, �� ���, ������ � ���� �����?!",
						2006 => "����� ���, ������ ��� ���� �����-�� ���������, �������� ����.",
					);
				} elseif ($_GET['qaction'] == 2006 && !$mlqfound) {
					$mldiag = array(
						0 => "�� ��� ��, � ������ �� ������ � ���� ����� ",
						2007 => "���, ��� ��� ���� � � ��� �������. ������ ����, �� ��� ����� �������. ������ ��� ���� ����������� ��������. ����!",
					);
				} elseif ($_GET['qaction'] == 2007 && !$mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();
					PutQItem($user,3003214,"���������") or QuestDie();

					addchp ('<font color=red>��������!</font> �� �������� <b>����� ����������</b> ','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "����������� ����, ������, � ����� �������� �������. ������ �� �� ������� ������� � ��������� � ��������� ������ ��� ���������� �� ���� � ����� ������ ���������?",
					2001 => "������ ����������, ������ ����, � ���� ����� �����, ��� ��� �� ������� �������� ����� � ��������� �� ������� �����.",
					11111 => "���, ������ �������� ���� � ����� ��������������",
				);
				if ($mlqfound) unset($mldiag[2001]);
			}
		} 
	}
?>