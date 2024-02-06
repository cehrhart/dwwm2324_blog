			function changePeriod(){
				if (document.formSearch.period.value == 1){
					document.getElementById("uniquedate").style.display = "none";
					document.getElementById("period").style.display 	= "block";
				}else{
					document.getElementById("period").style.display 	= "none";
					document.getElementById("uniquedate").style.display = "block";
				}
			}
