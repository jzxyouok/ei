var $app_url='/';
(function($){
	$.extend(jQuery.fn,{
		light_menu:function(menu_name,sub_menu_id){
			if(typeof menu_name =='undefined') return false;
			if(menu_name == 'index'){
				$('dl[menu_name]').show();
				return false;
			}
			//Top Navi
			$('.os_sys_menu_sel').removeClass('.os_sys_menu_sel');
			$('[menu_id="'+menu_name+'"]').addClass('os_sys_menu_sel');

			//Sub Nav
			$('dl[menu_name ="'+ menu_name +'"]').show();
			$('.current').removeClass('current');
			$('dl[menu_name="'+menu_name+'"]').find('[sub_menu_id='+sub_menu_id+']').parent().addClass('current');
		}
	});
})(jQuery);

//点击分页表格头部固定在上面
function resetTop(){
	var tableW = $(".os_main_data_th");
	var topTable = $(".os_main_data_th>table");
	topTable.fadeIn(400).css("top",0);
	tableW.scrollTop(0);	
};

$(document).ready(function(){
	(function(){
		//鼠标滚动时表格头部固定在上面
		var tableW = $(".os_main_data_th");
		var topTable = $(".os_main_data_th>table");
		topTable.css({'position':'absolute','left':'0'});
		tableW.scroll(function(){
			tableWH = $(this).scrollTop();
			topTable.stop(false,true).fadeIn(400).css("top",tableWH);
		});
	})();

	Tipper = new OSTipper();
	systemMsg = new OSMsg();
	var WHeight = $(window).height();
	if( WHeight  > 250){
		var tab_height=0;
		$("#content").height( WHeight -45);
		$(".os_leftframe").height( WHeight  -45);
		$("#right_side_content").height( WHeight  -45);
		if($('.tab_select').length>0) tab_height=$('.tab_select').height();
		$(".os_main_data_list").height( WHeight -145-tab_height);
		$(".os_main_data_list_02").height( WHeight -68);
	}

	$('.os_main_data_th').width(document.body.clientWidth - 175);

	$('dd').hover(function(){
		$(this).addClass('ui-menu-hover');
	},function(){
		$(this).removeClass('ui-menu-hover');
	});

	$('#_hide_left').click(function(){
		$('#_disp_left_m').click();
	});

	$('#_disp_left_m').toggle(function(){
		//hide
		$("#left_side").fadeOut(function(){
			$('.os_main_data_th').width(function(){
				return $(this).width() + 170 +'px';
			});
		});
		$(this).attr('title','显示左侧菜单');
	},function(){
		$('.os_main_data_th').width(function(){
			return $(this).width() - 170 +'px';
		});
		$("#left_side").fadeIn();
		$(this).attr('title','隐藏左侧菜单');
	});

	/*
	$('[sub_menu_id]').click(function(event){
		event.stopPropagation();
		$('.current').removeClass('current');
		$(this).parent().addClass('current');
		$('#mainFrame').load(  $(this).attr('hrefer')+'&app_page=null' );
	});
	
	$('[menu_id]').click(function(event){
		event.stopPropagation();
		$('.os_sys_menu_sel').removeClass('os_sys_menu_sel');
		$('#mainFrame').load(  $(this).attr('hrefer')+'&app_page=null' );
		$(this).parent().addClass('os_sys_menu_sel');
	});
	*/
});
