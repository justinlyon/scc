<mos:comment>
/**
 *  $Id$: summary_script.pat.tpl, Sep 5, 2006 9:00:17 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="script">
	<script>
		function setOids(checkbox, oid)
		{
			var myoids = new Array();
			if(document.adminForm.oids.value != "") {
				myoids = document.adminForm.oids.value.split(",");
			}
			if(checkbox.checked) {				
				var found = false;
				for(i=0; i<myoids.length; i++) {
					if(oid == myoids[i]) {
						found = true;
					}	
				}
				if(!found) {
					myoids.push(oid);
				}
				
			}
			else {
				var tmpoids = myoids;
				for(i=0; i<myoids.length; i++) {
					if(oid == myoids[i]) {
						tmpoids.splice(i,1);
					}	
				}
				myoids = tmpoids;
			}
			document.adminForm.oids.value = myoids.join();
		}
		function reorder(oid, direction)
		{
			document.adminForm.oids.value = oid;
			if (direction == 'orderup') {
				submitbutton('orderUp');
			} else {
				submitbutton('orderDown');
			}
			document.adminForm.submit();
		}
		function toggleButton(task, oid, value)
		{
			document.adminForm.task.value = task;
			document.adminForm.oids.value = oid;
			document.adminForm.toggle_value.value = value;
			document.adminForm.submit();
		}
	</script>
</mos:tmpl>