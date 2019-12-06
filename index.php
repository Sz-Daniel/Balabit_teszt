<?php

	//table:diary db:balabit_teszt
	require_once 'connect.php';
	if ($result = $db->query("SELECT * FROM diary ORDER BY day DESC LIMIT 1"))
	{
		$row = $result->fetch_assoc();
		//echo '<pre>',' ',$row['day'],' ',$row['feelRate'],' ',$row['actualGoal'],' ',$row['actualGoalStatus'],' ',$row['dailyDate'],'<br>';
		$lastDay=$row['day']; //int
		$lastFeelRate=$row['feelRate']; //int
		$lastActualGoal = $row['actualGoal']; //string
		$lastActualGoalStatus = $row['actualGoalStatus'];//int
		$lastDate = $row['dailyDate'];//date
	$result->free();
	}
	$db->close();
?>
<html>
<head>
<script type="text/javascript">

	//init sql from last day
	var progressDay = "<?php echo $lastDay ?>"; //sql
	var varFeelRate = " ";//read 
	var dailyPlan = "<?php echo $lastActualGoal ?> "; //sql
	var ruleDay = "<?php echo $lastActualGoalStatus ?>";//sql
	//ruledayNOW
	 
	//script date
	var dateObj = new Date();
	var month = dateObj.getUTCMonth() + 1; 
	var day = dateObj.getUTCDate();
	var year = dateObj.getUTCFullYear();
	var newdate = year + "/" + month + "/" + day;
	//goalstateNOW
	var varActualStatus = " ";//read
	//store
	var actual=[]; 
	
	var mainGoal = "Read your main goal again. <br> Be fit!<br> I used to be a normally body type, close to be “fit”. At the university I prioritised my studies but in the same time I forgot to make workout. I used to run a lot, in morning and before sleep. It helps to sleep deep, and wake up without like zombie.";
	
	//switchpage, hide what not need , default preview -> block;
	function switchpage(num)
	{
		switch(num) {
		  case 2:
			document.getElementById("preview").style.display = "none";
			document.getElementById("dailyForm").style.display = "block";
			document.getElementById("newPlan").style.display = "none";
			document.getElementById("rest").style.display = "none";
			break;
		  case 3:
			document.getElementById("preview").style.display = "none";
			document.getElementById("dailyForm").style.display = "none";
			document.getElementById("newPlan").style.display = "block";
			document.getElementById("rest").style.display = "none";
			break;
		  case 4:
			document.getElementById("preview").style.display = "none";
			document.getElementById("dailyForm").style.display = "none";
			document.getElementById("newPlan").style.display = "none";
			document.getElementById("rest").style.display = "block";
			break;
		} 
	}
	//dailyCheck
	function dailyAction() 
	{
		switchpage(2); 
		ruleDay++;		
		document.getElementById("displayTodayDate").innerHTML = newdate;
		//feelrate
		varFeelRate = document.getElementById("feelRate").value;
		//actualplan	
		varActualStatus = document.getElementById("Status").value;
		//dailyPlan = "Go to the gym to use Ergometer in this morning"  
		document.getElementById("displayDailyPlan").innerHTML = dailyPlan;
		document.getElementById("displayTodayDate").innerHTML = newdate;
		//progress checking 
		if (ruleDay == 1) document.getElementById("displayTodayDate").style.color = "green";
		if (ruleDay == 2) document.getElementById("displayTodayDate").style.color = "orange";
		if (ruleDay == 2) document.getElementById("warning").innerHTML = "You already skipped the last day, it's ok, you had some rest. Now DO IT!";
		if (ruleDay == 3) document.getElementById("displayTodayDate").style.color = "blue";
		if (ruleDay == 3) document.getElementById("warning").innerHTML = "2-day Rule! You have to watch for yourself! Do it for yourself, to build up something good! Now DO IT!";
		if (ruleDay > 3) document.getElementById("displayTodayDate").style.color = "red";
		if (ruleDay > 3) document.getElementById("warning").innerHTML = "Don't lose your inner fire! You can do it! Belive in yourself!";
		//maingoal
		document.getElementById("displayMainGoal").innerHTML = mainGoal; 	
	}   
	
	//statusswitch
	function CheckButton(actualArray)
	{
	  if (varActualStatus == "Not yet") insertDB();
	  if (varActualStatus == "Done") gotoNewPlan();
	}
	  
	function gotoNewPlan()
	{
	  switchpage(3);
	  
	  ruleDay = 1;
	} 
  
	function rest()   {
		switchpage(4);
		document.getElementById("feeltest").innerHTML = dailyPlan;
	} 
	
	function diary()   {
		
	} 

</script>
<style>
#preview {
display: block;
}
#dailyForm{
display: none;  
}
#newPlan{
display: none;  
}
#rest{
display: none;  
}
</style>
</head>

<body>

	<div id="preview" style="z-index:999" >
	  <p>Keep the light on! Your light! You must focusing on yourself.</p>
	  <button onclick="dailyAction()">Do it</button>
	  <a href="diary.php">Diary</a>
	  <p id="test"></p>
	</div>
	  
	<div id="dailyForm">
	  <p>How do you feel yourself? ( 1-5 )  <input type="number" id="feelRate" min="1" max="5" value="3"> </p>
	  <p id="displayDailyPlan"></p>
	  <p>Did you done your plan?
		<select id="Status">
		  <option value="Done">Done</option>
		  <option value="Not yet">Not yet</option>
		</select>
	  </p>
	  <p >Today <span id="displayTodayDate"></span></p>
	  <p id="warning"></p> 
	  <p id="displayMainGoal"></p>
	  <button onclick="gotoNewPlan()">Check</button>
	</div>   
	  
	<div id="newPlan">
	  <p>Gratulation! You reach your goal! Be proud to yourself!</p>
	  <p>Let's continue! New goal?</p>
	  <input type="text" id="newPlanText">
	  <button onclick="rest()">Get some rest!</button>
	</div>
	 
	<div id="rest">
		<p>Look at the diary!</p>
		<p id="feeltest"><p>
		
		<!-- <form action="diary.php" method="post"> -->
		<form action="" method="post"> 
			<input type="submit">
			<input id="feelRateId" type="int" name="feelRateSend"  value="10" style="display:none"><br>
			<input id="actualGoalId" type="text" name="actualGoalSend"  value="sadsads" style="display:none"<br>
			<input id="actualGoalStatusId" type="int" name="actualGoalStatusSend"  value="1" style="display:none"><br>
			
		</form>
		<script>
			var feelRate = varFeelRate;
			var actualGoal = dailyPlan;
			var actualGoalStatus = ruleDay;
			document.getElementById("feelRateId").value = feelRate;
			document.getElementById("actualGoalId").value = actualGoal;
			document.getElementById("actualGoalStatusId").value = teactualGoalStatusst;
		</script>
	</div>


</body>
</html>  
