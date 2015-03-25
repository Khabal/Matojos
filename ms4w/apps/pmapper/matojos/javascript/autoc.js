// createSearchInput: function(jsonObj){
	// var searchitemsElem=$('#searchitems');
	// var itemLayout=searchitemsElem.attr('class').replace(/pm_search_/,'');
	// var searchitem=jsonObj.searchitem;
	// var fields=jsonObj.fields;
	// var hc='<table id="searchitems_container1" class="pm-searchitem" border="0" cellspacing="0" cellpadding="0">';
	// var itemsAppendTo='searchitems_container1';
	// if(itemLayout=='inline'){
		// hc+='<tr id="searchitems_container2"></tr>';
		// itemsAppendTo='searchitems_container2';
	// };
	// hc+='</table>';searchitemsElem.html('');
	// $(hc).appendTo(searchitemsElem);
	// var html='';
	// var htmlend='';
	// for(var i=0;i<fields.length;i++){
		// var description=fields[i].description;
		// var fldname=fields[i].fldname;
		// var fldsize=fields[i].fldsize;
		// var fldsizedesc=fields[i].fldsizedesc;
		// var fldinline=fields[i].fldinline;
		// var definition=fields[i].definition;
		// var inputsize=fldsize?' size="'+fldsize+'" ' : '';
		// var sizedesc=fldsizedesc?' style="position:absolute;left:'+fldsizedesc+'em"' : '';
		// if(!definition){
			// var hi='<td class="pm-searchdesc">'+description+'</td>';
			// hi+='<td'+sizedesc+'>'+'<input type="text" class="pm-search-textinput" id="pmsfld_'+fldname+'" name="'+fldname+'"'+inputsize+'></td>';
			// if(itemLayout !="inline")hi='<tr>'+hi+'</tr>';
			// $(hi).appendTo('#'+itemsAppendTo);
		// }
		// else{
			// if(definition.type=='options'){
				// var ho='<td class="pm-searchdesc">'+description+'</td>';
				// ho+='<td>'+this.json2Select(definition,definition.firstoption)+'</td>';
				// if(itemLayout !="inline")ho='<tr>'+ho+'</tr>';
				// $(ho).appendTo('#'+itemsAppendTo);
			// }
			// else if(definition.type=='suggest'){
				// var hs='<td class="pm-searchdesc">'+description+'</td>';
				// hs+='<td><input type="text" id="pmsfld_'+fldname+'" name="'+fldname+'" alt="Search Criteria"'+inputsize+' '+definition.events+'/></td>';
				// if(itemLayout !="inline")hs='<tr>'+hs+'</tr>';
				// $(hs).appendTo('#'+itemsAppendTo);
				// var searchitem=definition.searchitem;
				// var minlength=definition.minlength;
				// var suggesturl=PM_XAJAX_LOCATION+'x_suggest.php?'+SID+'&searchitem='+searchitem+'&fldname='+fldname;
				// var dependFields=definition.dependfld;
				// var xParamsParts={};
				// if(dependFields){
					// dependFields=dependFields.split(',');
					// $.each(dependFields,function(){
						// var dependfld=this;
						// xParamsParts['dependfldval_'+dependfld]=function(){
							// var fldName=eval('dependfld');
							// return $('#pmsfld_'+fldName+':checkbox').is(':not(:checked)')?'' : $('#pmsfld_'+fldName).val();
						// };
					// });
				// };
				// var xParams=xParamsParts?xParamsParts : false;
				// $('#pmsfld_'+fldname).autocomplete(suggesturl,PM.Query.suggestOptions).setOptions({minChars: minlength,extraParams: xParams});
				// if(definition.nosubmit !=1&&PM.suggestLaunchSearch)$('#pmsfld_'+fldname).result(function(event,data,formatted){
					// if(data)PM.Query.submitSearch();
				// });
			// }
			// else if(definition.type=='checkbox'){
				// var value=definition.value;
				// var defchecked='';
				// var hcb='<td class="pm-searchdesc">'+description+'</td>';
				// hcb+='<td><input type="checkbox" id="pmsfld_'+fldname+'" name="'+fldname+'" '+'" value="'+value+'" '+defchecked+'/></td>';
				// if(itemLayout !="inline")hcb='<tr>'+hcb+'</tr>';
				// $(hcb).appendTo('#'+itemsAppendTo);
			// }
			// else if(definition.type=='radio'){
				// var inputlist=definition.inputlist;
				// var hra="";
				// for(var ipt in inputlist){
					// var defchecked=(definition.checked==ipt)?' checked="checked" ' : '';
					// hra+='<td><input type="radio" id="pmsfld_'+fldname+'" name="'+fldname+'" '+'" value="'+ipt+'" '+defchecked+'/></td>';
					// hra+='<td>'+inputlist[ipt]+'</td>';
				// };
				// if(itemLayout !="inline")hra='<tr>'+hra+'</tr>';
				// $(hra).appendTo('#'+itemsAppendTo);
			// }
			// else if(definition.type=='operator'){
				// var hop='<td class="pm-searchdesc">'+description+'</td>';
				// hop+='<td'+sizedesc+'>'+this.json2Select(definition,false);
				// hop+='<input type="text" class="pm-search-textinput-compare" id="pmsfld_'+fldname+'" name="'+fldname+'" '+inputsize+'></td>';if(itemLayout !="inline")hop='<tr>'+hop+'</tr>';$(hop).appendTo('#'+itemsAppendTo);}else if(definition.type=='hidden'){htmlend+='<input type="hidden" id="pmsfld_'+fldname+'" name="'+fldname+'" value="'+definition.value+'">';}}};html+='<td colspan="2" class="pm-searchitem">';html+='<table><tr><td><input type="button" value="'+_p('Search')+'" size="20" ';html+='onclick="PM.Query.submitSearch()" onmouseover="PM.changeButtonClr(this,\'over\')" onmouseout="PM.changeButtonClr(this,\'out\')"></td>';if(!this.seachBoxKeepSelectedValue){html+='<td><img src="images/close.gif" alt="" onclick="$(\'#searchitems\').html(\'\')"/></td>';}else{html+='<td><img src="images/close.gif" alt="" onclick="$(\'#searchitems\').html(\'\');_$(\'searchForm\').findlist.options[0].selected=true;"/></td>';};html+='</tr></table></td>';htmlend+='<input type="hidden" name="searchitem" value="'+searchitem+'"/>';if(itemLayout !="inline")html='<tr>'+html+'</tr>';$(html).appendTo('#'+itemsAppendTo);$(htmlend).appendTo(searchitemsElem);}});