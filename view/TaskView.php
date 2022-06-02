<?php
	class TaskView {
		function getUserTask($view) {
			echo "
				<form name='getUserTask' method='post' action='$view'>
					<input type='text' name='content' />
					<input type='submit' value='Submit' />
				</form>
			";
		}
	}
?>