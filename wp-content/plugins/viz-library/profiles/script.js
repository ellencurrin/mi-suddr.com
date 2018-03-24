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

function layout(){
	var h = $("body").height();
	var w = $("body").width();
	$("#sidebar,#instructions").height(h-74);
	$("#map").width(w-354);
	$("#map").height(h-20);
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

function content(c){
	var url = "get_data.php?county="+c;
	var x;
	$.get(url,function(d){
		//Basic
		$("#cname").text(d.COUNTY+" COUNTY");
		$("#tpop").text(formatNum(d.POP_2014));
		var pc = d.PC_PCT;
		if(pc>0){ 
			$("#pchange").text("+"+pc+"%").css({"color":"green"});
		}else{
			$("#pchange").text(pc+"%").css({"color":"#DD0000"});
			}
		
		//Race & Ethnicity
		var r = [d.WHITE, d.BLACK, d.HISPANIC, d.ASIAN, d.NATIVE, d.PACIFIC, 100];
		$("#race dd").each(function(i){
			var pct = ((r[i]/d.TP_2013)*100).toFixed(1);
			if(i==6){ pct = parseFloat(r[i]).toFixed(1); }
			if(pct > 2 || i==6){ $(this).width(pct+"%").attr({"data-pct":pct+"%"}); r[6]-=pct; }
			else{ $(this).width(0); }
			});
		
		//Families & Poverty
		$("#fp_pct").text(d.FP+"%");
		var fams = Math.round(parseFloat(d.FAMILIES) * (parseFloat(d.FP)/100) );
		$("#fp_total").text( formatNum(fams) + " Families" );
		
		//Employment Status
		var r = [d.EM, (d.LF-d.EM), (100-d.LF)];
		$("#emp_status dd").each(function(i){
			var pct = parseFloat(r[i]).toFixed(1)+"%";
			$(this).width(pct).attr({"data-pct":pct});
			});
			
		//Educational Attainment
		var r = [ parseFloat(d.EDU1)+parseFloat(d.EDU2), parseFloat(d.EDU3), parseFloat(d.EDU4),
			parseFloat(d.EDU5), parseFloat(d.EDU6), 100 ];
		
		$("#edu_attainment dd").each(function(i){
			var pct = r[i].toFixed(1)+"%";
			$(this).width(pct).attr({"data-pct":pct});
			r[5]-=r[i];
			});
		console.log("content")	
	});
}

function makeMap(){
	var mh = $("#map").height();
	var map = "";
	var features = paths.features;

	sw = latLngSVG([paths.bbox[0],paths.bbox[1]]);
	ne = latLngSVG([paths.bbox[2],paths.bbox[3]]);
	height = Math.abs(sw[1]-ne[1]);
	viewbox = sw[0]+" "+ne[1]+" ";
	viewbox += Math.abs(sw[0]-ne[0])+" "+height;

	map += "<svg width='100%' height='100%' style='display:block; margin:0;' viewbox='"+viewbox+"' >";
	map += "<g stroke-width='"+((height/mh)*1.5)+"' > ";
	for( f in features){
		// var x = features[f]["properties"][gt_join];
		var color = "#D4E3C8";
		// if( typeof data[x] !== "undefined" ){
		// 	var val = data[x][current_series][current_column];
		// 	color = getHex(minColor, maxColor, val, axis_max);
		// 	}

		var path = "";

		var geometry = features[f].geometry;
		if(geometry.type == "Polygon"){
			path = walkPath(geometry.coordinates);
		}
		else if(geometry.type == "MultiPolygon"){
			path = "";
			for(x in geometry.coordinates){
				path += walkPath(geometry.coordinates[x]);
			}
		}

		var county = features[f].properties.name;
		map += "<path class='unit' d='"+path+" z' style='fill:"+color+"' data-county='"+county+"'/>";
	}

	map += "<path id='highlight' d='M 0 0 l 0 0 0 0 z'  style='fill:none;' fill='none' />";		
	map += "</g>";
	map += "</svg>";
	console.log("making map")
	$("#map").html(map)

//DEFAULT TO WAYNE COUNTY	
	content('Wayne')
	$("#instructions").fadeOut();
	window.current = $('.unit[data-county="Wayne"')[0]
	window.current.style.fill = "pink";


}


$(document).ready(function(){
	$(window).resize(function(){layout();});
	
	$("body").on("mouseover",".brownie dd", function(e){
		var p = $(this).attr("data-pct");
		var n = $(this).attr("data-name");
		$("#ttip").html("<dt>"+n+"</dt><dd>"+p+"</dd>");
		var h = $("#ttip").outerHeight();
		var y = ( (e.pageY + h) > $(document).height() )? e.pageY - h - 30 : e.pageY + 10;
		var x = ( (e.pageX + 100) > $(window).width() )? e.pageX - 100 : e.pageX;
		$("#ttip").stop(true,true).css({"left":x, "top":y }).show();	
		});

	$("body").on("mousemove",".brownie dd", function(e){
		var h = $("#ttip").outerHeight();
		var y = ( (e.pageY + h) > $(document).height() )? e.pageY - h - 30 : e.pageY + 10;
		var x = ( (e.pageX + 100) > $(window).width() )? e.pageX - 100 : e.pageX;
		$("#ttip").stop(true,true).css({"left":x, "top":y }).show();	
		});
		
	$("body").on("mouseout",".brownie dd", function(){
		$("#ttip").delay(200).fadeOut(100).css({"left":"-400em","top":"-2000em"});
		});

	$("body").on("mouseenter",".unit",function(e){
		// var path = $(this).attr("d");
		// $("#highlight").attr("d",path).css({"stroke":"#FF0000"});
		var y = ( (e.pageY + 60) < $(document).height() )? e.pageY : e.pageY - 60;
		var c = $(this).attr("data-county");
		$("#popup").stop(true,true).css({"left":e.pageX+10, "top":y }).html(c).show();	
		});

	$("body").on("mousemove",".unit",function(e){
		var y = ( (e.pageY + 60) < $(document).height() )? e.pageY : e.pageY - 60;
		$("#popup").stop(true,true).css({"left":e.pageX+10, "top":y });
		});
	
	$("body").on("mouseout",".unit",function(e){
		$("#highlight").css({"stroke":"transparent"});
		$("#popup").delay(200).fadeOut(100);
		});

//SELECTING THE COUNTY HERE
	$("body").on("click",".unit",function(){
		if(window.current){ window.current.style.fill = "#D4E3C8"}
		window.current = this;		
		this.style.fill = "pink";
		var county = $(this).attr("data-county");
		content(county);
		$("#instructions").fadeOut();
		});
///////////////////////////

	$("body").on("click",".section b",function(){
		$(this).hide().parent().addClass("engaged");				
		$(".section:not(.engaged)").fadeTo(400,0).animate({"height":"0px","padding":"0px"},function(){
			$(".breakdown").fadeIn(200);
			$(".return").fadeTo(200,1)
			});
		// $(".section:not(.engaged)").fadeTo(400,0, function(){ $(this).addClass("hidden"); $(".breakdown, i").fadeIn(); });
		});

	$("body").on("click",".return",function(){
		// $(".engaged").removeClass("engaged");
		// $("#sidebar").animate({scrollTop:0},200, function(){
		// 	$(".breakdown").fadeOut(200,0,function(){
		// 		$(".section:not(.engaged)").animate({"height":"83","padding":"10px 0px"},400).fadeTo(400,1);
		// 	});
		// });
		$(".return").fadeTo(200,0);
		$(".engaged").removeClass("engaged").fadeTo(200,0,function(){
			$(".breakdown").hide();
			$(".return").css({"display":"none"});
			$(".section").css({"height":"auto","padding":"10px 0px"}).fadeTo(400,1);
			$("b").fadeIn()
			});




	});

});
