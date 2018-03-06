function formatNum(x){
	if( x !== "" ){
		x = x.toString().split(".");
		c = x[0].split("").reverse().join("").match(/.{1,3}/g).join(",").split("").reverse().join("");
		if(typeof x[1] == "string" ){
			c += "."+x[1];
			}
		return c;	
	}else{
		return "N/A";
	}

	}

function table_sort(column,order){
	var y = [];
	var w = [];
	$(".drow").each(function(index){
		var n = $(this).children().eq(column).text();
		var a = parseFloat(n);
		if(index==0){
			if( isNaN(a) ){
				y.push(n);
			}else{
				y.push(a);
			}
			w.push(this);
		}
		else{
			var l = y.length;
			for (e = 0; e <= l; e++){
				b = y[e];
				if( isNaN(a) && isNaN(b) ){
					if( n == [n,b].sort()[0] ){
						y.splice(e,0,n);
						w.splice(e,0,this);	
						break;
					}		
				}else if( isNaN(a) && (isNaN(b) == false) ){
					y.splice(e,0,n);
					w.splice(e,0,this);
					break;					
				}else if(a<=b){
					y.splice(e,0,a);
					w.splice(e,0,this);
					break;
				}else if(e == l){
					y.push(a);
					w.push(this);
				}				
			}
		}
	});
	if(order == "dsc"){
		w.reverse();
		}
	var x = $("#tHeader,#tSubheader");
	$("#dtable").html("").append(x).append(w);
}

function barchart(data,series,columns){
	var bars = "";
	var legend = "";
	var left = 0;
	var num_bars = series.length * columns.length;
	var color_set = ( num_bars < 4 ? 3 : num_bars );
	var width = (num_bars==1 ? 30:(num_bars==2 ? 15: 10) );
	var set_width = (num_bars * width) + ((num_bars-1)*5) + 20;
	var z = 10000;
	
	var test = "AAA"
	$("body").append("<div id='tester' class='blabel'>"+test+"</div>");
	while( $("#tester").outerWidth() <= set_width ){
		test+="A";
		$("#tester").text(test);
		}
	var abbr = test.length - 1;
	$("#tester").remove();	
	
	for(d in data){
		var p=0;
		var n = d;
		if(typeof names == 'object'){ n = names[d];}
		var a = n.substr(0,abbr);

		bars+="<div class='barset' data-name='"+n+"' data-abbr='"+a+"' style='left:"+left+"px; width:"+set_width+"px; z-index:"+z+";'>";
		bars+="<div class='blabel'>"+a+"</div>";
		var bDisplay ="<table class='bdisplay'>";
		var sleft = 10;
		for(s in series){
		 	for(c in columns){
				var col = columns[c]; 
				var sval = series[s];
				var val;
				if( typeof data[d][sval] == "undefined"){
					val = 0;
					}
				else{
					val = data[d][sval][col];
					}
				var unit = fields[col]["units"];
		 		var height = (val/axis_max) * 100;
		 		var color = colors[color_set][p];
		 		bars+="<div class='bar' data-value='"+val+"'";
		 		bars+="style='height:"+height+"%; left:"+sleft+"px; width:"+width+"px; background:"+color+"'></div>"
		 		sleft+=width+5;
		 		p+=1;
				if(columns.length == 1){
					bDisplay += "<tr><td>"+sval+"</td><td class='bcVal'>"+formatNum(val)+" "+unit+"</td></tr>" ;
				}else{
					bDisplay += "<tr><td>"+col+" "+sval+"</td><td class='bcVal'>"+formatNum(val)+" "+unit+"</td></tr>" ;
				}
				
		 	}
		}
		bDisplay += "</table>";
		bars+= bDisplay+"</div>";
		left+=set_width;
		z=z-1;
	}

	var p = 0
	for(s in series){
		for(c in columns){
			var color = colors[color_set][p];
			var label = "";
			if(columns.length == 1){
				label = series[s];
			}else{
				label = columns[c]+", "+series[s];
			}
			legend+="<li style='background:"+color+";'><div>"+label+"</div></li>";
			p+=1;
		}
	}

	$("#bars").html(bars);
	$("#chart_legend").html(legend);
	var w = $("#chart_legend li div").first().outerWidth()+$(".bdisplay").last().outerWidth()+55;
	$("#bars").width(left+w);
	
}


function makeTable(units,series,columns){
	var rowspan = (series.length == 1)?1:2;
	var rows = "<tbody>";
	rows += "<tr id='tHeader'><td class='hVal' rowspan='"+rowspan+"'>"+gt_join;
	rows += "<div class='sort' data-col='0'> <div class='up'></div> <div class='down'></div> </div>";
	rows += "</td>"+header+"</tr>";
	rows += "<tr id='tSubheader'>"+subheader+"</tr>";
	var i = 1;
	for(d in data){
		// var Class = ( (i%2)==0 ? 'even' : 'odd' );
		var n = d;
		if(typeof names == 'object'){ n = names[d];}	
		rows += "<tr class='drow'><td>"+n+"</td>";
		var r = data[d];
		rows += makeRow(r);
		rows +="</tr>";
		i++;
	}
	rows += "</tbody>";
	
//	$("#hrow").html(header);
	$("#dtable").html(rows);
}


function makeMap(){
	var map = "";
	if(svg == true){
		map += "<svg width='100%' height='100%' style='display:block; margin:8px auto;' viewbox='0 -1 500 510'>";
		for(x in paths){
			var p = paths[x];
			var d = "";
			for(i in p){
				d += "M "+p[i].slice(0,2).join(" ")+" l "+p[i].slice(2).join(" ");
				}
				d+= " z";
			var color = "#EeEeEe";
			if( typeof data[x] !== "undefined" ){
				var val = data[x][current_series][current_column];
				color = legend[val]["Max"];
				}
			map += "<path class='unit' d='"+d+"' data-unit='"+x+"' style='fill:"+color+"' />";
		}
		map += "<path id='highlight' d='M 0 0 l 0 0 0 0'  style='fill:none;' fill='none' />";		
		map += "</svg>";
	}
	else if(vml == true){
//		map += '<v:group style="position:absolute;left:0px;top:0px;width:1000px;height:1000px;" coordsize="1000,1000" coordorigin="0,0">';
		for(x in paths){
			var p = paths[x];
			var d = "";
			for(i in p){
				d = "m "+p[i].slice(0,2).join(",")+" r "+p[i].slice(2).join(",")+" x ";
				}
				d += " e";
			var color = "#DdDdDd";
			if( typeof data[x] !== "undefined" ){
				var val = data[x][current_series][current_column];
				color = getHex(minColor, maxColor, val, axis_max);
				}
			map += '<v:shape style="width:500px; height:500px; position:absolute;" strokecolor="red" strokeweight="1px" fillcolor="blue"  coordsize="500,500" coordorigin="0,0">';
			map += '<v:path v="'+d+'" />';		
			map += '</v:shape>';
		}

		// map = '<v:shape style="width:300px; height:300px" strokecolor="white" strokeweight="1px" fillcolor="blue" coordsize="1000,1000" coordorigin="0,0">';
		// map += '<v:path v="m 8,65 l 72,65,92,11,112,65,174,65,122,100,142,155,92,121,42,155,60,100 x e"/>';
		// map += '</v:shape>';
//		map += '</v:group>';
	}
	$("#canvas").html(map);
}

function latLngSVG(x){
	var width = 500;
	//Make Lat
	var r = width / (2 * Math.PI); // find radius
	var d = x[1] * (Math.PI/180); //convert to radians
	var ll = r * Math.log(Math.tan( (Math.PI/4)+(d/2) ));
	var h = width - ( (width/2) + ll );
	//Make Lng
	var w = width/2;
	var x = (x[0]/180) * w;
	var l = w + x;

	return [l,h];
}

function walkPath(c,p){
	// c = coordinate array
	// p = svg path as string
    if(typeof p == "undefined"){p = ""};
	for(x in c){
		if(typeof c[x][0][0] == "number" ){
			for (i in c[x]) {
				p+=(i==0 ? "M ":"L " );
				var l = latLngSVG(c[x][i]);
				p += l[0]+" "+l[1]+" ";
			}
		}
		else{ walkPath(c[x],p); }
	}
	return p;
}

function makeMap(){
	var mh = $("#canvas").height();
	var map = "";
	var features = paths.features;
	if(svg == true){
		sw = latLngSVG([paths.bbox[0],paths.bbox[1]]);
		ne = latLngSVG([paths.bbox[2],paths.bbox[3]]);
		height = Math.abs(sw[1]-ne[1]);
		viewbox = sw[0]+" "+ne[1]+" ";
		viewbox += Math.abs(sw[0]-ne[0])+" "+height;
		
		map += "<svg width='100%' height='100%' style='display:block; margin:8px auto;' viewbox='"+viewbox+"' >";
		map += "<g stroke-width='"+(height/mh)+"' > ";
		for( f in features){
			var x = features[f]["properties"][gt_join];
			var color = "#EeEeEe";
			var val = 0;
			if( typeof data[x] !== "undefined"){
				if( typeof data[x][current_series] !== "undefined" ){
				var val = data[x][current_series][current_column];
				color = legend[val]["Max"];
				}
			}
			d = walkPath(features[f].geometry.coordinates);
			map += "<path class='unit' d='"+d+" z' data-unit='"+x+"' style='fill:"+color+"' />";
		}
		
		map += "<path id='highlight' d='M 0 0 l 0 0 0 0 z'  style='fill:none;' fill='none' />";		
		map += "</g>";
		map += "</svg>";
	}
	$("#canvas").html(map)
}

function apply(){
	var d = {};
	$(".uOpts:checked").each(function(){
		var u = $(this).val();
		d[u] = data[u];
		});
		
	var series = [];
	var columns = [];
	$(".dOpts:checked").each(function(){
		var v = $(this).val().split(";");
		if( series.indexOf(v[0]) < 0 ){ series.push(v[0]) };
		if( columns.indexOf(v[1]) < 0 ){ columns.push(v[1]) };
	});

	barchart(d,series,columns);
	makeTable(d,series,columns);

	layout();
	
	$("#options").fadeOut();
	
}

function makeCSV(){
	var CSV = [];
	$("")
	$(".drow:visible").each(function(){
		var x = $(this).children("td:visible").map(function(){return $(this).text();}).get();
		x = '"'+x.join('","')+'"';
		CSV.push(x);
	});
	
	$("#content").val( CSV.join(";") );
}
function makeJPG(){
 	var x = $("svg");
	h = x.height()+"px";
	w = x.width()+"px";
 	x = document.getElementsByTagName("svg")[0];
	x.setAttribute("height",h);
	x.setAttribute("width",w);
	var c = $("#canvas").html()	
	$("#img_content").val( c );
	x.setAttribute("height","100%");
	x.setAttribute("width","100%");
}


function getHex(minColor, maxColor, val, max){
	var mnC = minColor.slice(1,7).match(/.{1,2}/g);
	var mxC = maxColor.slice(1,7).match(/.{1,2}/g);
	var c = "#";
	for(var i = 0; i<3; i++){
		var a = parseInt( mnC[i], 16 );
		var b = parseInt( mxC[i], 16 );		
		var d = a - Math.round( (a - b) * (val/max) );
		var y= d.toString(16);
		c += (y.length == 1 ? "0"+y : y);		
	}
	return c;
}

function layout(){
	var t = $("#header").outerHeight();
	var h = $("body").height() - t;
	var w = $("body").width();
	var tw = w - $("#nav").outerWidth() - 55;
	$("#vtitle").width(tw);
	$(".section").css({'height':h,'top':t });
	// $("#chart").height(h-15);

	$(".optgroup").height(h-20-2);
	
	// var aw = $("#axis").outerWidth();
	// var bw = (w - aw);
	// $("#barchart, #lines").css({"left":aw, "width":bw });
	// var h = $("#barchart")[0].clientHeight;
	// $("#lines,#axis,#bars").height( (h-30) );

	$("#hrow").html("<tr></tr>");
	$(".header th").each(function(index){
		w = $(this).width(); 
		$(this).clone().width(w).appendTo("#hrow");
		});
	var tw = $("#dtable").outerWidth();	
	$("#hrow").width(tw);
	}

var colors = {
	3: ["#a6cee3","#1f78b4","#b2df8a"],
	4: ["#a6cee3","#1f78b4","#b2df8a","#33a02c"],
	5: ["#a6cee3","#1f78b4","#b2df8a","#33a02c","#fb9a99"],
	6: ["#a6cee3","#1f78b4","#b2df8a","#33a02c","#fb9a99","#e31a1c"],
	7: ["#a6cee3","#1f78b4","#b2df8a","#33a02c","#fb9a99","#e31a1c","#fdbf6f"],
	8: ["#a6cee3","#1f78b4","#b2df8a","#33a02c","#fb9a99","#e31a1c","#fdbf6f","#ff7f00"],
	9: ["#a6cee3","#1f78b4","#b2df8a","#33a02c","#fb9a99","#e31a1c","#fdbf6f","#ff7f00","#cab2d6"],
	10: ["#a6cee3","#1f78b4","#b2df8a","#33a02c","#fb9a99","#e31a1c","#fdbf6f","#ff7f00","#cab2d6","#6a3d9a"],
	11: ["#a6cee3","#1f78b4","#b2df8a","#33a02c","#fb9a99","#e31a1c","#fdbf6f","#ff7f00","#cab2d6","#6a3d9a","#ffff99"],
	12: ["#a6cee3","#1f78b4","#b2df8a","#33a02c","#fb9a99","#e31a1c","#fdbf6f","#ff7f00","#cab2d6","#6a3d9a","#ffff99","#b15928"]
	};

$(document).ready(function(){
	
	var w = 0; 
	$(".label").each(function(){ 
		var x = $(this).outerWidth(); 
		if(x>w){w=x;}  
		});
	$("#axis").width(w);

	layout();
	// makeMap();
	
	$(".nav").on("click",function(){
		var section = "#"+$(this).attr("data-section");
		$(".nav").removeClass("active");
		$(this).addClass("active");
		$(".section").css({"left":"5000em","display":"block"});
		$(section).css({"left":"0em","display":"none"}).fadeIn();
		});
	$("body").on("click",".filter_list li", function(){
		$(this).toggleClass("active");
		});
	// $("body").on("mouseover",".barset",function(){
	// 	var x = $(this).attr("data-name");
	// 	$(this).find(".blabel").html(x).addClass("hover");
	// 	});
	// $("body").on("mouseout",".barset",function(){
	// 	var x = $(this).attr("data-abbr");
	// 	$(this).find(".blabel").html(x).removeClass("hover");
	// 	});
	// $("#tcont").on("scroll",function(){
	// 	var l = "-"+$(this).scrollLeft()+"px";
	// 	$("#hrow").css({"left": l })
	// 	});
	$("#ddown li").on("click",function(){
		$("#ddown li").removeClass("active");
		$(this).addClass("active");
		if( $("#ddown").hasClass("closed") == false ){
			var v = $(this).attr("data-value").split(";");
			current_series = v[0]; 
			current_column = v[1];
			// $(".unit").each(function(){
			// 	var unit = $(this).attr("data-unit");
			// 	var value = data[unit][current_series][current_column];
			// 	var color = getHex(minColor, maxColor, value, axis_max);
			// 	$(this).css({"fill":color});
			// 	});
			makeMap();
			}
		$("#ddown").toggleClass("closed");
		
		});		
		
	$(window).resize(function(){layout();});

	// $("body").on("mouseenter",".unit",function(e){
	// 	$("#info").stop(true,true);
	// 	var x = $(this).attr("data-unit");
	// 	var n = x;
	// 	if(typeof names == 'object'){ n = names[x]; }
	// 	var d = data[x][current_series][current_column];
	// 	var c = getHex(minColor,maxColor,d,axis_max);
	// 	$("#unit").text(n);
	// 	$("#value").text(formatNum(d)+" "+data_unit);
	// 	$("#info").css({"background":c}).show();
	// 	var path = $(this).attr("d");
	// 	$("#highlight").attr("d",path).css({"stroke":"#FF0000"});
	// 	});
	//
	// $("body").on("mouseout",".unit",function(){
	// 	$("#info").fadeOut("slow");
	// 	$("#highlight").css({"stroke":"transparent"});
	// 	});

	$("body").on("mouseenter",".unit",function(e){
		// var path = $(this).attr("d");
		// $("#highlight").attr("d",path).css({"stroke":"#FF0000"});
		$("#info").stop(true,true);		
		var x = $(this).attr("data-unit");
		var n = x;
		if(typeof names == 'object'){ n = names[x]; }
		var d = "No Data";
		if(typeof data[x] !== "undefined"){
			if(typeof data[x][current_series] !== "undefined"){
				if(typeof data[x][current_series][current_column] !== "undefined" ){
					d = data[x][current_series][current_column];
				}
			}
		}
		// var c = getHex(minColor,maxColor,d,axis_max);
		$("#unit").text(n);	
		$("#value").text(d+" "+data_unit);
		// $("#info").css({"background":c});
		var path = $(this).attr("d");
		$("#highlight").attr("d",path).css({"stroke":"#FF0000"});		
		var y = ( (e.pageY + 130) < $(document).height() )? e.pageY : e.pageY - 130;
		$("#info").stop(true,true).css({"left":e.pageX+10, "top":y }).show();		
		});

	$("body").on("mousemove",".unit",function(e){
		var y = ( (e.pageY + 130) < $(document).height() )? e.pageY : e.pageY - 130;
		$("#info").stop(true,true).css({"left":e.pageX+10, "top":y });
		});

	$("body").on("mouseout",".unit",function(e){
		$("#highlight").css({"stroke":"transparent"});
		$("#info").delay(200).fadeOut(100);
		});

	$("body").on("click",".sort",function(e){
		var column = parseInt( $(this).attr("data-col") );
		console.log(column);
		if( $(this).hasClass("asc") ){
			$(".sort").removeClass("asc dsc");
			$(this).removeClass("asc").addClass("dsc");
			table_sort(column,"dsc");
		}else{
			$(".sort").removeClass("asc dsc");
			$(this).removeClass("dsc").addClass("asc");
			table_sort(column,"asc");
			}

	});

	makeMap();
	// barchart(data,series,[current_column] );
	makeTable(data,series,[current_column] );
	});
