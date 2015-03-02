<?php $page['id']='home';?>
<?php include("common/inc.php");?>
<?php include("common/head.php");?>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=FA00ef59da477d2f0a357931222a715a"></script>
<body style="overflow:hidden;">


<img id="bgImg" s class="bg-img" src="/static/default/images/map_bg.jpg?2" alt="水网之家" style="z-index:1;"/>


<div class="map-box" id="map-box">
	<div class="map-tit clearfix">
		<span class="map-tit-log" id="welcome_uname">
			<a href="javascript:void(0);" onclick="show_login();">登陆</a>  / 
			<a href="javascript:void(0);" onclick="show_login();">注册</a> 
		</span>
		叫水就上水来了
	
	
	</div>
	<div class="map-se-box clearfix">
		<form action="javascript:void(0);" onsubmit="water_map.search_show();return false;">
		<span class="map-now-city"><span>深圳</span> <em class="arr-down"></em></span>
		<span class="map-se-text-area">
			<input type="text" class="map-se-text" id="map-se-text" onblur="setTimeout(function(){$('.map-se-result').hide();},50);">
			<span class="map-se-result" style="display:none;"></span>
			<a href="javascript:void(0);" class="map-se-btn" onclick="water_map.search_show();">搜索</a>
		</span>
		<div class="map-se-bottom-result" style="display:none;">
			
		</div>
		</form>
	</div>
	
	
	
	<div class="map-main" id="map-main">
	
	</div>	
	
</div>
 
 
 <div id="map_float" style="display:none;">
 	<div class="map_float">
 	<p class="place">加载中..</p>
	<p class="desc">附近有 <em id="map-business-total">..</em> 家水站</p>
	<p><a href="<?php echo c_s_url();?>" target=_blank class="btn07 m-gotobtn">查看水站</a></p>
	</div>
 </div>


<div class="menu-wp">
    <?php include("common/nav.php");?>
</div>
<div class="fwm">
    <img class="iewm" src="/static/default/images/ewm.jpg" alt="水网之家"/>
    <p class="pwm yahei">扫一扫抢鲜体验手机订水</p>
</div>

<script type="text/javascript">
    $(function(){
       scr_resize();
       $(window).resize(scr_resize);
       water_map.run();
    })
    function scr_resize(){
        var w = $(window).width();
        var h = $(window).outerHeight(true);
        
        $('.bg-img').width(w).height(h-62);
        $('.dwh').width(w);
        $('.m-cd').css({
            'left':(w-760)/2,
            'top':(h-$('.m-cd').height())/2-80
        });
        $(".fwm").css("top",$(window).height()-220);
        if($(window).width()<1200){
            $("html").addClass("w1000");
        }else{
            $("html").removeClass("w1000");
        }
        if(!window.XMLHttpRequest){
            $(".brandInp").siblings("label").remove();
        }

		//地图
		var left=(w-$(".map-box").width())/2;
		var h2=(h-62)*0.8;
		var t2=(h-h2-62)/2;
		$(".map-box").css({left:left+"px",height:h2+"px",top:t2+"px"});
		$(".map-se-bottom-result").css({height:(h2-80)+"px"});
        
        
    }
    
    
</script>
<script type="text/javascript">
var water_map={
	map : null,
	run:function(){
		water_map.showmap();
		$("#map-se-text").keyup(water_map.key_search);
	},
	task_show_window:false,
	last_marker:null,
	marker_list:[],
	showmap:function (){
		water_map.map=new BMap.Map("map-main")
		
		water_map.map.enableScrollWheelZoom();    //启用滚轮放大缩小，默认禁用
		water_map.map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用
		water_map.map.addControl(new BMap.NavigationControl({anchor: BMAP_ANCHOR_TOP_RIGHT, type: BMAP_NAVIGATION_CONTROL_SMALL}));  //添加默认缩放平移控件
		var overViewOpen = new BMap.OverviewMapControl({isOpen:true, anchor: BMAP_ANCHOR_BOTTOM_RIGHT});
		water_map.map.addControl(overViewOpen);          //添加默认缩略地图控件
		water_map.map.centerAndZoom(new BMap.Point(114.066074,22.548724), 14);
		water_map.map.addEventListener("click", water_map.show_info);
	
	},
	key_search:function (){//alert(1);
		
		var key=$("#map-se-text").val();
		if(!key){
			$(".map-se-result").hide();
			return;
		}
		$(".map-se-result").show();
		var options = {
			onSearchComplete: function(results){
				// 判断状态是否正确
				if (local.getStatus() == BMAP_STATUS_SUCCESS){
					var code = '';
					for (var i = 0; i < results.getCurrentNumPois(); i ++){
						code+='<div><a href="#" onclick="water_map.get_result(this);">'+results.getPoi(i).address+results.getPoi(i).title+'</a></div>';
					}
					$(".map-se-result").html(code);
				}
			}
		};
		var local = new BMap.LocalSearch(water_map.map, options);
		local.search(key);
	},
	get_result:function(eobj){
		var key=$(eobj).html();
		$("#map-se-text").val(key);
		$(".map-se-result").hide();
		water_map.search_show();
	},
	show_info:function(e){//alert(e.overlay);
		if(e.overlay){  //判断是点击地图还是点击标注
			return false;
		}
		//water_map.map.clearOverlays(); 
		water_map.get_address(e);   
		//alert(e.point.lng + ", " + e.point.lat);
		var location_x=e.point.lng;
		var location_y=e.point.lat;

		var gourl='companys---'+location_x+'-'+location_y+'--0-1.html';
		$(".m-gotobtn").attr("href",gourl);

		if(water_map.last_marker){
			water_map.map.removeOverlay(water_map.last_marker);
		}	
		
		//water_map.map.centerAndZoom(new BMap.Point(location_x,location_y), 14);
		var sContent =$("#map_float").html();
		var point = new BMap.Point(location_x, location_y);
		water_map.last_marker = new BMap.Marker(point);
		
		water_map.map.addOverlay(water_map.last_marker);
		
		var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
		water_map.last_marker.openInfoWindow(infoWindow);
		water_map.last_marker.addEventListener("click", function(){     
		    this.openInfoWindow(infoWindow);
		   //图片加载完毕重绘infowindow
		});
		//请求数据
		var postdata={location_x:location_x,location_y:location_y};
		$.get("/companys/GetLbsCompanyTotals",postdata,function(jsonstr){
			try{
				var json=eval("("+jsonstr+")");
				if(json.state<=0){
					alert(json.msgwords);
				}else{
					var total=json.data;
					$("#map-business-total").html(total);
				}
			}catch(e){
				console.log(e.message);
			}
		})
		
	},
	//逆地址解析(根据 经纬度 解析出地址)
	get_address:function(e){
		var pt = e.point;
		var geoc = new BMap.Geocoder();   
		geoc.getLocation(pt, function(rs){
			var addComp = rs.addressComponents;
			//alert(addComp.province + "" + addComp.city + "" + addComp.district + "" + addComp.street + "" + addComp.streetNumber);
			$(".place").html(addComp.province + "" + addComp.city + "" + addComp.district + "" + addComp.street + "" + addComp.streetNumber);
		});
	},
	search_show:function(){
		$("#map-se-text").blur();
		$(".map-se-result").hide();
		$(".map-se-bottom-result").show();
		var key=$("#map-se-text").val();
		if(!key){
			$(".map-se-result").hide();
			return;
		}
		var options = {
			onSearchComplete: function(results){
				// 判断状态是否正确
				if (local.getStatus() == BMAP_STATUS_SUCCESS){
					var code = '';
					var points_data=[];
					var marker_data=[]
					for (var i = 0; i < results.getCurrentNumPois(); i ++){//alert($.toJSON(results.getPoi(i)));return;
						points_data.push({location_x:results.getPoi(i).point.lng,location_y:results.getPoi(i).point.lat});
						marker_data.push({location_x:results.getPoi(i).point.lng,location_y:results.getPoi(i).point.lat,address:results.getPoi(i).address,total:0});
						code+='<div class="map-se-result-block clearfix" onclick="water_map.show_marker(this,'+i+')"><img src="/static/default/images/local/lbs_'+(i+1)+'.gif" class="local_img"><span class="tit">'+results.getPoi(i).title+'</span><p class="result-address">'+results.getPoi(i).address+'</p><p class="result-stat">附近有<em id="se-result-total-box'+i+'"></em>家水站</p></div>';
					}
					$(".map-se-bottom-result").html(code);
					
					//请求水站的数量
					var postdata={points_data:points_data};//alert($.toJSON(postdata));
					$.get("/companys/GetMoreLbsCompanyTotals",postdata,function(jsonstr){
						try{
							var json=eval("("+jsonstr+")");
							if(json.state<=0){
								alert(json.msgwords);
							}else{
								for(var i2=0;i2<json.list.length;i2++){console.log(json.list[i2]);
									$("#se-result-total-box"+i2).html(json.list[i2]);
									marker_data[i2].total=json.list[i2];
								}
								//批量显示标注
								water_map.create_search_marker(marker_data);
								
							}
						}catch(e){
							console.log(e.message);
						}
					})
					
					
					
					
				}
			}
			//renderOptions:{map: water_map.map}
		};
		var local = new BMap.LocalSearch(water_map.map,options);
		local.search(key);

		
		
	},
	show_marker:function(eobj,index){
		$(".map-se-result-block").removeClass("map-se-result-block-current");
		$(eobj).addClass("map-se-result-block-current");
		water_map.show_marker_info(index);
		//var location_x=mobj.point.lng;
		//var location_y=mobj.point.lat;
		
	},
	//初始化的窗口
	create_search_marker:function(marker_data){
		for(var i=0;i<marker_data.length;i++){
			var sContent='<div class="map_float"><p class="place">'+marker_data[i].address+'</p><p class="desc">附近有 <em id="map-business-total">'+marker_data[i].total+'</em> 家水站</p><p><a href="companys---'+marker_data[i].location_x+'-'+marker_data[i].location_y+'--0-1.html" target=_blank class="btn07 m-gotobtn">查看水站</a></p></div>';
			var point = new BMap.Point(marker_data[i].location_x, marker_data[i].location_y);
			marker = new BMap.Marker(point);
			water_map.map.addOverlay(marker);
			var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
			//marker.openInfoWindow(infoWindow);
			marker.addEventListener("click", function(){     
				this.openInfoWindow(infoWindow);
			   //图片加载完毕重绘infowindow
			});
			water_map.marker_list[i]={marker:marker,data:marker_data[i]};
		}
	},
	//给检索列表 点击用的
	show_marker_info:function (i){
		try{	
			var emarker=water_map.marker_list[i];
			var sContent='<div class="map_float"><p class="place">'+emarker.data.address+'</p><p class="desc">附近有 <em id="map-business-total">'+emarker.data.total+'</em> 家水站</p><p><a href="companys---'+emarker.data.location_x+'-'+emarker.data.location_y+'--0-1.html" target=_blank class="btn07 m-gotobtn">查看水站</a></p></div>';
			var point = new BMap.Point(emarker.data.location_x, emarker.data.location_y);
			var marker = new BMap.Marker(point);
			water_map.map.addOverlay(marker);
			var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
			marker.openInfoWindow(infoWindow);
			// p.marker_arr[i].InfoWindow.enableAutoPan();
			emarker.marker.openInfoWindow(infoWindow);
			
			emarker.addEventListener("click", function(){     
				this.openInfoWindow(infoWindow);
			   //图片加载完毕重绘infowindow
			});
		}catch(e){console.log(e.message)};
		
	}
	
	

}
</script>

</body>
</html>
