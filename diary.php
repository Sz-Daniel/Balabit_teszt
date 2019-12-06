<?php

	//table:diary db:balabit_teszt
	require_once 'connect.php';
	
	if ($result = $db->query("SELECT * FROM diary ORDER BY day DESC LIMIT 1"))
	{
		$row = $result->fetch_assoc();
		echo '<pre>',' ',$row['day'],' ',$row['feelRate'],' ',$row['actualGoal'],' ',$row['actualGoalStatus'],' ',$row['dailyDate'],'<br>';
		/*
		$lastDay=$row['day'];
		$lastFeelRate=$row['feelRate'];
		$lastActualGoal = $row['actualGoal'];
		$lastActualGoalStatus = $row['actualGoalStatus'];
		$lastDate = $row['date'];
		*/
	$result->free();
	}
	if ($result = $db->query("SELECT * FROM diary"))
	{
		if($result->num_rows){
				echo '<pre>';
				while($row = $result->fetch_assoc()){
					echo 'Day ',$row['day'],'. Happy Status:  ',$row['feelRate'],' Actual Goal: ',$row['actualGoal'],'. ',$row['actualGoalStatus'],' day in ', $row['dailyDate'],'<br>';
				}	
		}
	$result->free();
	}
	$db->close();
?>