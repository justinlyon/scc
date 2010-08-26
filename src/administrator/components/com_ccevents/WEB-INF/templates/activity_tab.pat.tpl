<mos:comment>
/**
 *  $Id$: activity_tab.pat.tpl, Oct 14, 2006 1:36:33 PM nchanda
 *  Copyright (c) 2006, Tachometry Corporation
 * 	http://www.tachometry.com
 * 
 *  Licensed under terms of the Apache License 2.0
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Tachometry Applications and Professional Services (TAPS)
 **/
</mos:comment>

<mos:tmpl name="activity_tab">

	<fieldset>
	<legend style="font-size:0.8em;color:#555;">Add {SCOPE}</legend>
		<table >
			<tr>
				<th valign="top" style="color:#900;">Start Time:</th>
				<td align="left">
					<mos:tmpl src="option_lists/startdate.pat.tpl" relative="yes" /><br/>
					<mos:tmpl src="option_lists/starttime.pat.tpl" relative="yes" /><br/><br/>
				</td>
				<th valign="top">&nbsp;Status</th>
				<td><mos:tmpl src="option_lists/activity_status.pat.tpl" relative="yes"/></td>
			</tr>
			<tr>
				<th valign="top">End Time:</th>
				<td align="left">
					<mos:tmpl src="option_lists/enddate.pat.tpl" relative="yes" /><br/>
					<mos:tmpl src="option_lists/endtime.pat.tpl" relative="yes" /><br/><br/>
				</td>
				<th valign="top">&nbsp;Ticket Code:</th>
				<td><input type="text" name="activityTicket"/></td>
			</tr>
			<tr>
				<th valign="top">Venue:</th>
				<td align="left" colspan="3">
					<mos:tmpl src="option_lists/activity_venue.pat.tpl" relative="yes"/><br/><br/>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="button" onclick="addActivity();" value="Add {SCOPE}" /></td>
			</tr>
		</table>
	</fieldset>
	
	
	<fieldset>
	<legend style="font-size:0.8em;color:#555;">Current {SCOPE}s</legend>
		<div id="activity_list">
			
		</div>	
	</fieldset>
	
	<input type="hidden" name="activityStartTime" value="{START_TIME}"/>
	<input type="hidden" name="activityEndTime" value="{END_TIME}"/>
	<input type="hidden" name="activityVenueList" value="{VENUE_ID}"/>
	<input type="hidden" name="activityVenueName" value="{VENUE_NAME}"/>
	<input type="hidden" name="activityStatusList" value="{ACTIVITY_STATUS}"/>
	<input type="hidden" name="activityTicketList" value="{ACTIVITY_TICKET}"/>
	<input type="hidden" name="activityChanged" value="0" />
	
	<script>
		var TOKEN = "|";
		
		function addActivity() {
			form = document.adminForm;
			
			// start time as string
			stime = form.startYear.value +"-"+ form.startMonth.value +"-"+ form.startDay.value;
			shour = form.startHour.value;
			if (shour == 12) {
				shour = 0;
			}
			if (form.startAmpm.value == 'PM') {
				shour = parseInt(shour) + 12;
			}
			stime += " "+ shour +":"+ form.startMinute.value +":00";
			
			// end time as tring
			etime = form.endYear.value +"-"+ form.endMonth.value +"-"+ form.endDay.value;
			ehour = form.endHour.value;
			if (ehour == 12) {
				ehour = 0;
			}
			if (form.endAmpm.value == 'PM') {
				ehour = parseInt(ehour) + 12;
			}
			etime += " "+ ehour +":"+ form.endMinute.value +":00";
			
						
			var index = form.activityVenue.selectedIndex;
			if (index == 0) {
				alert('Please select a Venue for this {SCOPE}');
				return;
			}
			var activity = new Array();		
			activity["startTime"] = stime;
			activity["endTime"] = etime;
			activity["venueId"] = form.activityVenue.value;
			activity["venueName"] = form.activityVenue.options[index].text;
			activity["status"] = form.activityStatus.value;
			activity["ticket"] = form.activityTicket.value;
			
			// clean up the form 
			form.activityStatus.value = "";
					
			storeActivity(activity);
			renderActivityList();
			
		}	
		
		function storeActivity(activity) {
						
			if (activity != null) {
				
				// start time
				stlist = document.adminForm.activityStartTime.value;
				if (stlist == "") {
					stlist = activity['startTime'];
				} else {
					stlist += TOKEN + activity['startTime'];
				}
				document.adminForm.activityStartTime.value = stlist;
				
				// end time
				elist = document.adminForm.activityEndTime.value;
				if (elist == "") {
					elist = activity['endTime'];
				} else {
					elist += TOKEN + activity['endTime'];
				}
				document.adminForm.activityEndTime.value = elist;
				
				// venue id
				vlist = document.adminForm.activityVenueList.value;
				if (vlist == "") {
					vlist = activity['venueId'];
				} else {
					vlist += TOKEN + activity['venueId'];
				}
				document.adminForm.activityVenueList.value = vlist;
				
				// venue name
				vname = document.adminForm.activityVenueName.value;
				if (vname == "") {
					vname = activity['venueName'];
				} else {
					vname += TOKEN + activity['venueName'];
				}
				document.adminForm.activityVenueName.value = vname;
				
				// activity status
				aslist = document.adminForm.activityStatusList.value;
				if (aslist == "") {
					aslist = activity['status'];
				} else {
					aslist += TOKEN + activity['status'];
				}
				document.adminForm.activityStatusList.value = aslist;
				
				// ticket code
				codes = document.adminForm.activityTicketList.value;
				if (codes == "") {
					codes = activity['ticket'];
				} else {
					codes += TOKEN + activity['ticket'];
				}
				document.adminForm.activityTicketList.value = codes;
				
				// throw the changed flag
				triggerChange();
			}
		}
		
		function renderActivityList() {
		
			var st = document.adminForm.activityStartTime.value.split(TOKEN);
			var et = document.adminForm.activityEndTime.value.split(TOKEN);
			var vn = document.adminForm.activityVenueName.value.split(TOKEN);
			var as = document.adminForm.activityStatusList.value.split(TOKEN);
			var tc = document.adminForm.activityTicketList.value.split(TOKEN);
			
			var render = "<table width=100% id='activity_summary'><tr><th>&nbsp;</th><th>Start Time</th><th>End Time</th><th>Venue</th>";
			render += "<th>Status</th><th>Code</th><th>Action</th></tr>";
			
			if (document.adminForm.activityStartTime.value == "") {
				render += "<tr><td>&nbsp;</td><td colspan='6'>There are currently no scheduled times for this event</td></tr>";
			} else {
				for (i=0; i<st.length; i++) {
					render += "<tr><td>"+ (i+1) +".</td>";
					render += "<td>"+ getFormattedDate(st[i]) +"</td>";
					render += "<td>"+ getFormattedDate(et[i]) +"</td>";
					render += "<td>"+ vn[i] +"</td>";
					render += "<td>"+ getFormattedStatus(as[i],i) +"</td>";
					render += "<td>"+ tc[i] +"</td>";
					render += "<td><a href='javascript:void(0);' onclick=removeActivity("+ i +")>remove</a></td></tr>";
				}
			}		
			render += "</table>";
			var alist = document.getElementById("activity_list");
			alist.innerHTML = render;
		}
		
		function getFormattedDate(dateStr) {
			//return dateStr;
			
			dateTimeArray = dateStr.split(" ");
			dateArray = dateTimeArray[0].split("-");
			timeArray = dateTimeArray[1].split(":");
	
			dateObj = new Date();
			dateObj.setYear(dateArray[0]);
			dateObj.setMonth(parseInt(dateArray[1])-1);
			dateObj.setDate(dateArray[2]);
			dateObj.setHours(timeArray[0]);
			dateObj.setMinutes(timeArray[1]);
			
			
			return formatDate(dateObj,'E, NNN d, y<br>h:mm a');
		}
		
		function getFormattedStatus(status, index) {		
			return '<a href="javascript:void(0);" onclick="changeStatus('+ index +')">'+ status +'</a>';
		}
		
		function removeActivity(index) {
			var st = document.adminForm.activityStartTime.value.split(TOKEN);
			var et = document.adminForm.activityEndTime.value.split(TOKEN);
			var vn = document.adminForm.activityVenueList.value.split(TOKEN);
			var vx = document.adminForm.activityVenueName.value.split(TOKEN);
			var as = document.adminForm.activityStatusList.value.split(TOKEN);
			var tc = document.adminForm.activityTicketList.value.split(TOKEN);
			
			st.splice(index,1);
			et.splice(index,1);
			vn.splice(index,1);
			vx.splice(index,1);
			as.splice(index,1);
			tc.splice(index,1);
			
			document.adminForm.activityStartTime.value = st.join(TOKEN);
			document.adminForm.activityEndTime.value = et.join(TOKEN);
			document.adminForm.activityVenueList.value = vn.join(TOKEN);
			document.adminForm.activityVenueName.value = vx.join(TOKEN);
			document.adminForm.activityStatusList.value = as.join(TOKEN);
			document.adminForm.activityTicketList.value = tc.join(TOKEN);
			
			document.adminForm.activityChanged.value = 1;
			renderActivityList();
		}
		
		function changeStatus(index) {
			
			var options = document.adminForm.activityStatus.options;
			var activityStatus = document.adminForm.activityStatusList.value.split(TOKEN);
			var as = activityStatus[index];
			
			for (i=0; i<options.length; i++) {
				if (options[i].value == as) {
					var next = i+1;
					if (next >= options.length) {
						next = 0;
					}
					activityStatus[index] = options[next].value;
					break;
				}
			}
			
			document.adminForm.activityStatusList.value = activityStatus.join(TOKEN);
			document.adminForm.activityChanged.value = 1;
			renderActivityList();
		}
		
		
		function triggerChange() {
			document.adminForm.activityChanged.value = 1;
		}

		function updateEndTime() {
			document.adminForm.endMonth.value = document.adminForm.startMonth.value;
			document.adminForm.endYear.value = document.adminForm.startYear.value;
			document.adminForm.endDay.value = document.adminForm.startDay.value;
			document.adminForm.endMinute.value = document.adminForm.startMinute.value;
			document.adminForm.endAmpm.value = document.adminForm.startAmpm.value;
			var newHour = parseInt(document.adminForm.startHour.value) + 2;
			if (newHour > 12) {
				newHour = newHour - 12;
			}
			document.adminForm.endHour.value = newHour;
		}

		function initControl() {
			today = new Date();
			
			document.adminForm.startYear.value = today.getFullYear();
			document.adminForm.startMonth.value = parseInt(today.getMonth()) + 1;
			document.adminForm.startDay.value = today.getDate();
			document.adminForm.startHour.value = 8;
			document.adminForm.startAmpm.value = "PM";

			document.adminForm.endYear.value = today.getFullYear();
                        document.adminForm.endMonth.value = parseInt(today.getMonth()) + 1;
                        document.adminForm.endDay.value = today.getDate();    
                        document.adminForm.endHour.value = 10;
                        document.adminForm.endAmpm.value = "PM"; 	
		}
		
		initControl();

// ===================================================================
// Author: Matt Kruse <matt@mattkruse.com>
// WWW: http://www.mattkruse.com/
//
// NOTICE: You may use this code for any purpose, commercial or
// private, without any further permission from the author. You may
// remove this notice from your final code if you wish, however it is
// appreciated by the author if at least my web site address is kept.
//
// You may *NOT* re-distribute this code in any way except through its
// use. That means, you can include it in your product, or your web
// site, or any other form where the code is actually being used. You
// may not put the plain javascript up on your site for download or
// include it in your javascript libraries for download. 
// If you wish to share this code with others, please just point them
// to the URL instead.
// Please DO NOT link directly to my .js files from your site. Copy
// the files to your server and use them there. Thank you.
// ===================================================================

var MONTH_NAMES=new Array('January','February','March','April','May','June','July','August','September','October','November','December','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');var DAY_NAMES=new Array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sun','Mon','Tue','Wed','Thu','Fri','Sat');
function LZ(x){return(x<0||x>9?"":"0")+x}
function isDate(val,format){var date=getDateFromFormat(val,format);if(date==0){return false;}return true;}
function compareDates(date1,dateformat1,date2,dateformat2){var d1=getDateFromFormat(date1,dateformat1);var d2=getDateFromFormat(date2,dateformat2);if(d1==0 || d2==0){return -1;}else if(d1 > d2){return 1;}return 0;}
function formatDate(date,format){format=format+"";var result="";var i_format=0;var c="";var token="";var y=date.getYear()+"";var M=date.getMonth()+1;var d=date.getDate();var E=date.getDay();var H=date.getHours();var m=date.getMinutes();var s=date.getSeconds();var yyyy,yy,MMM,MM,dd,hh,h,mm,ss,ampm,HH,H,KK,K,kk,k;var value=new Object();if(y.length < 4){y=""+(y-0+1900);}value["y"]=""+y;value["yyyy"]=y;value["yy"]=y.substring(2,4);value["M"]=M;value["MM"]=LZ(M);value["MMM"]=MONTH_NAMES[M-1];value["NNN"]=MONTH_NAMES[M+11];value["d"]=d;value["dd"]=LZ(d);value["E"]=DAY_NAMES[E+7];value["EE"]=DAY_NAMES[E];value["H"]=H;value["HH"]=LZ(H);if(H==0){value["h"]=12;}else if(H>12){value["h"]=H-12;}else{value["h"]=H;}value["hh"]=LZ(value["h"]);if(H>11){value["K"]=H-12;}else{value["K"]=H;}value["k"]=H+1;value["KK"]=LZ(value["K"]);value["kk"]=LZ(value["k"]);if(H > 11){value["a"]="PM";}else{value["a"]="AM";}value["m"]=m;value["mm"]=LZ(m);value["s"]=s;value["ss"]=LZ(s);while(i_format < format.length){c=format.charAt(i_format);token="";while((format.charAt(i_format)==c) &&(i_format < format.length)){token += format.charAt(i_format++);}if(value[token] != null){result=result + value[token];}else{result=result + token;}}return result;}
function _isInteger(val){var digits="1234567890";for(var i=0;i < val.length;i++){if(digits.indexOf(val.charAt(i))==-1){return false;}}return true;}
function _getInt(str,i,minlength,maxlength){for(var x=maxlength;x>=minlength;x--){var token=str.substring(i,i+x);if(token.length < minlength){return null;}if(_isInteger(token)){return token;}}return null;}
function getDateFromFormat(val,format){val=val+"";format=format+"";var i_val=0;var i_format=0;var c="";var token="";var token2="";var x,y;var now=new Date();var year=now.getYear();var month=now.getMonth()+1;var date=1;var hh=now.getHours();var mm=now.getMinutes();var ss=now.getSeconds();var ampm="";while(i_format < format.length){c=format.charAt(i_format);token="";while((format.charAt(i_format)==c) &&(i_format < format.length)){token += format.charAt(i_format++);}if(token=="yyyy" || token=="yy" || token=="y"){if(token=="yyyy"){x=4;y=4;}if(token=="yy"){x=2;y=2;}if(token=="y"){x=2;y=4;}year=_getInt(val,i_val,x,y);if(year==null){return 0;}i_val += year.length;if(year.length==2){if(year > 70){year=1900+(year-0);}else{year=2000+(year-0);}}}else if(token=="MMM"||token=="NNN"){month=0;for(var i=0;i<MONTH_NAMES.length;i++){var month_name=MONTH_NAMES[i];if(val.substring(i_val,i_val+month_name.length).toLowerCase()==month_name.toLowerCase()){if(token=="MMM"||(token=="NNN"&&i>11)){month=i+1;if(month>12){month -= 12;}i_val += month_name.length;break;}}}if((month < 1)||(month>12)){return 0;}}else if(token=="EE"||token=="E"){for(var i=0;i<DAY_NAMES.length;i++){var day_name=DAY_NAMES[i];if(val.substring(i_val,i_val+day_name.length).toLowerCase()==day_name.toLowerCase()){i_val += day_name.length;break;}}}else if(token=="MM"||token=="M"){month=_getInt(val,i_val,token.length,2);if(month==null||(month<1)||(month>12)){return 0;}i_val+=month.length;}else if(token=="dd"||token=="d"){date=_getInt(val,i_val,token.length,2);if(date==null||(date<1)||(date>31)){return 0;}i_val+=date.length;}else if(token=="hh"||token=="h"){hh=_getInt(val,i_val,token.length,2);if(hh==null||(hh<1)||(hh>12)){return 0;}i_val+=hh.length;}else if(token=="HH"||token=="H"){hh=_getInt(val,i_val,token.length,2);if(hh==null||(hh<0)||(hh>23)){return 0;}i_val+=hh.length;}else if(token=="KK"||token=="K"){hh=_getInt(val,i_val,token.length,2);if(hh==null||(hh<0)||(hh>11)){return 0;}i_val+=hh.length;}else if(token=="kk"||token=="k"){hh=_getInt(val,i_val,token.length,2);if(hh==null||(hh<1)||(hh>24)){return 0;}i_val+=hh.length;hh--;}else if(token=="mm"||token=="m"){mm=_getInt(val,i_val,token.length,2);if(mm==null||(mm<0)||(mm>59)){return 0;}i_val+=mm.length;}else if(token=="ss"||token=="s"){ss=_getInt(val,i_val,token.length,2);if(ss==null||(ss<0)||(ss>59)){return 0;}i_val+=ss.length;}else if(token=="a"){if(val.substring(i_val,i_val+2).toLowerCase()=="am"){ampm="AM";}else if(val.substring(i_val,i_val+2).toLowerCase()=="pm"){ampm="PM";}else{return 0;}i_val+=2;}else{if(val.substring(i_val,i_val+token.length)!=token){return 0;}else{i_val+=token.length;}}}if(i_val != val.length){return 0;}if(month==2){if( ((year%4==0)&&(year%100 != 0) ) ||(year%400==0) ){if(date > 29){return 0;}}else{if(date > 28){return 0;}}}if((month==4)||(month==6)||(month==9)||(month==11)){if(date > 30){return 0;}}if(hh<12 && ampm=="PM"){hh=hh-0+12;}else if(hh>11 && ampm=="AM"){hh-=12;}var newdate=new Date(year,month-1,date,hh,mm,ss);return newdate.getTime();}
function parseDate(val){var preferEuro=(arguments.length==2)?arguments[1]:false;generalFormats=new Array('y-M-d','MMM d, y','MMM d,y','y-MMM-d','d-MMM-y','MMM d');monthFirst=new Array('M/d/y','M-d-y','M.d.y','MMM-d','M/d','M-d');dateFirst =new Array('d/M/y','d-M-y','d.M.y','d-MMM','d/M','d-M');var checkList=new Array('generalFormats',preferEuro?'dateFirst':'monthFirst',preferEuro?'monthFirst':'dateFirst');var d=null;for(var i=0;i<checkList.length;i++){var l=window[checkList[i]];for(var j=0;j<l.length;j++){d=getDateFromFormat(val,l[j]);if(d!=0){return new Date(d);}}}return null;}



 
		renderActivityList();
	</script>

</mos:tmpl>

