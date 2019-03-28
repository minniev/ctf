$(document).ready(
		function() {
			$("#Transfer").click(
					function() {
						var tcuser = $("#tcuser").val();
						var tcnum = $("#tcnum").val();
						// Returns successful data submission message when the
						// entered information is stored in database.
						var dataString = 'tcuser=' + tcuser + '&tcnum=' + tcnum
								+ '&Transfer=Transfer';
						if (tcuser == '' || tcnum == '') {
							alert("Please Fill All Fields");
						} else {
							$.ajax({
								type : "POST",
								url : "level5_process.php",
								data : dataString,
								cache : false,
								success : function() {
									alert("Successful Transfer!");
								}
							});
						}
						return false;
					});
		});