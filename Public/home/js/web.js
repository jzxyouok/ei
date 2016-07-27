// JavaScript Document
$(document).ready(function() {
//图片延迟加载
	$("img").lazyload({ effect: "fadeIn" });
//导航隐藏
	$(".nav li").hover(function(){
		$(this).find(".nav_box").show();
	},function(){
		$(this).find(".nav_box").hide();
	});
	$(".nav li").eq(5).find(".nav_box").css("margin","53px 0 0 -627px");
	
	
	/*产品业绩 tab切换*/
	$(".pro_sheet tr.detail_has").each(function(index){
		$(this).mouseover(function(){
		$(".td_detail").addClass("dis");
		$(".td_detail:eq("+index+")").removeClass("dis");
		$(".pro_sheet tr.detail_has").removeClass("tr_cur");
		$(this).addClass("tr_cur");
			})						  				  
		})
	$(".about_tab .hd ul li").eq(2).css("border-right","none");
		
});



function xpFy() {
    this.tabId = "bg"; //表格ID
    this.tabBs = "id"; //表格#标识
    this.bt = false;
    var Hang = "tr"; //行
    var tabBs, bt;

    var hs = 0; //每页显示行数
    var djy = 1; //第几页
    var xsjg = 0; //显示几个 链接
    var ys = 1; //总页数
    var tab, tr, div, syy, xyy, ngl, a, spanKs, spanJs; //表格,行,下链DIV,上一页,下一页,哪个亮,DIV内的A,...,...

    function fid(g) {
        return document.getElementById(g);
    }

    function fjd(g, tagName) {
        return g.getElementsByTagName(tagName);
    }

    function aView() {
        var star = djy - xsjg; //前边几个
        var over = djy + xsjg; //后几个
        if (star <= 0) {
            over += Math.abs(star) + 1;
        }
        else if (over >= ys) {
            star = star - over + parseInt(ys);
        }

        for (var i = 2; i < ys; i++) {
            if (i >= star && i <= over) {
                a[i].style.display = "";
            }
            else {
                a[i].style.display = "none";
            }
        }
        if (a[2].style.display == "none") {
            spanKs.style.display = "";
        }
        else {
            spanKs.style.display = "none";
        }

        if (a[ys - 1].style.display == "none") {
            spanJs.style.display = "";
        }
        else {
            spanJs.style.display = "none";
        }
    } //。。。123 。。。  显示 隐藏

    function writeCookie(name, value, hours) {
        var expire = "";
        if (hours != null) {
            expire = new Date((new Date()).getTime() + hours * 3600000); //以毫秒记数
            expire = "; expires=" + expire.toGMTString();
        }
        document.cookie = name + "=" + escape(value) + expire;
    } //写名，写值，写时间(毫秒)

    function readCookie(name) {
        var cookieValue = "";
        var search = name + "=";
        if (document.cookie.length > 0) {
            var offset = document.cookie.indexOf(search);
            if (offset != -1) {
                offset += search.length;
                var end = document.cookie.indexOf(";", offset);
                if (end == -1) {
                    end = document.cookie.length;
                }
                cookieValue = unescape(document.cookie.substring(offset, end));
            }
        }
        return cookieValue;
    } //读cookie

    function hqxs(g) {//显示哪页
        if (g == 'x') {
            g = djy + 1;
        }
        if (g == 's') {
            g = djy - 1;
        }
        g = parseInt(g);
        var hsg1 = hs * g; //本页首行
        var hsg0 = hs * (g - 1); //上页首行
        var i = 0;
        if (bt) {
            i++;
            hsg1++;
            hsg0++;
        }
        for (var l = tr.length; i < l; i++) {
            if (i < hsg1 && i >= hsg0) {//因I从0开始 3>=3,4,5 && 6>3,4,5 4>123 6<789
                tr[i].style.display = "";
            }
            else {
                tr[i].style.display = "none";
            }
        }
        if (djy != g) {// djy不等于新连接
            ngl.setAttribute("href", "#ps|");
            ngl.onclick = function () {
                hqxs(this.innerHTML);
            };
            ngl.className = ""; //本页连接写回属性

            for (var i = 0; i < a.length; i++) {
                if (i == g) {
                    ngl = a[i];
                    a[i].removeAttribute("href");
                    a[i].className = "current";
                    a[i].onclick = null;
                    break;
                }
            }
        }
        if (g == 1) {
            syy.style.display = "none";
        }
        else {
            syy.style.display = "";
        }
        if (g == ys) {
            xyy.style.display = "none";
        }
        else {
            xyy.style.display = "";
        }
        djy = g;
        if (ys > 1) {
            aView();
        }
        writeCookie("xpFy" + tabBs, g, 1);
    }

    this.sx = function () {
        hqxs(djy);
    } //行数被改 刷新本页

    function xsDiv() {
        div = document.createElement("div");
        var shang = tab.parentNode;
        var Sj = shang.childNodes;
        for (var i = 0; i < Sj.length; i++) {
            if (Sj.item(i) === tab) {
                if (i + 1 >= Sj.length) {
                    shang.appendChild(div);
                    break;
                }
                else {
                    shang.insertBefore(div, Sj.item(i + 1));
                    break;
                }
            }
        }
        div.className = "fy";
    } //给TAB加DIV

    function cjSpan() {
        var span = document.createElement("span");
        div.appendChild(span);
        span.innerHTML = "...";
        span.style.display = "none";
        return span;
    }

    function tjA() {
        syy = document.createElement("a");
        div.appendChild(syy);
        syy.setAttribute("href", "#ps|");
        syy.onclick = function () {
            hqxs("s");
        };
        syy.innerHTML = "上一页";

        var vvv = document.createElement("input");
        vvv.setAttribute("type", "hidden");
        document.body.appendChild(vvv);

        for (var i = 1; i <= ys; i++) {
            var a = document.createElement("a");
            a.innerHTML = i;
            if (i == djy) {
                ngl = a;
                a.className = "current";
            }
            else {
                a.setAttribute("href", "#ps|");
                a.onclick = function () {
                    hqxs(this.innerHTML);
                };
            }

            if (i == 2) {
                spanKs = cjSpan();
            }
            if (i == ys - 1) {
                spanJs = cjSpan();
            }
            div.appendChild(a);
        }
        xyy = document.createElement("a");
        xyy.innerHTML = "下一页";
        div.appendChild(xyy);
        xyy.setAttribute("href", "#ps|");
        xyy.onclick = function () {
            hqxs("x");
        }

    } //添加A链接

    this.Main = function (hsp, xsjgp, lj) {//开始
        tab = fid(this.tabId);
        if (!tab) {
            return false;
        }
        tabBs = this.tabBs + "=";
        bt = this.bt;
        var css = document.createElement('link');
        css.setAttribute('href', lj);
        css.setAttribute('rel', 'stylesheet');
        document.getElementsByTagName('head')[0].appendChild(css);

        hs = hsp;
        xsjg = xsjgp;
        tr = fjd(tab, Hang);
        xsDiv(); //给TAB加DIV
        var trl = null;
        if (bt) {
            trl = tr.length - 1;
        }
        else {
            trl = tr.length;
        }
        if (trl == 0) {
            return false;
        }
        var Zys = trl / hs;
        ys = Math.floor(Zys); //总页数
        if (ys < Zys) {
            ys++;
        }
        tjA(); //添加A链接
        a = fjd(div, "a");

        var cok = readCookie("xpFy" + tabBs);
        if (cok != "") {
            var c = parseInt(cok);
            while (c > ys) {
                c--;
            }
            hqxs(c);
        }
        else {
            hqxs(djy); //显示哪页
        }
    }
    this.mainTB = function (hsp, xsjgp, lj) {
        Hang = "tr";
        this.Main(hsp, xsjgp, lj);
    }
    this.mainA = function (hsp, xsjgp, lj) {
        Hang = "a";
        this.Main(hsp, xsjgp, lj);
    }
    this.mainDIV = function (hsp, xsjgp, lj) {
        Hang = "div";
        this.Main(hsp, xsjgp, lj);
    }
    this.mainSpan = function (hsp, xsjgp, lj) {
        Hang = "span";
        this.Main(hsp, xsjgp, lj);
    }
    this.mainUL = function (hsp, xsjgp, lj) {
        Hang = "li";
        this.Main(hsp, xsjgp, lj);
    }
    this.mainULL = function (hsp, xsjgp, lj) {
        Hang = "ul";
        this.Main(hsp, xsjgp, lj);
    }
    this.mainDL = function (hsp, xsjgp, lj) {
        Hang = "dl";
        this.Main(hsp, xsjgp, lj);
    }
    this.mainHR = function (lj) {
        Hang = "hr";
        var wk = fid(this.tabId)
        var wkZf = wk.innerHTML;
        var zao = wkZf.split(/<hr>|<HR>/);
        if (zao.length > 1) {
            var ca = "";
            for (var i = 0; i < zao.length; i++) {
                zao[i] = "<dt>" + zao[i] + "</dt>";
                ca += zao[i];
            }
            wk.innerHTML = ca;
        }
        Hang = "dt";
        this.Main(1, 4, lj);
    }
    this.mainG = function (rowHeight, JHeight, xsjgP, lj) {
        var hs = Math.floor((parent.document.documentElement.clientHeight - JHeight) / rowHeight);
        if (hs < 0) {
            hs = 3;
        }
        this.Main(hs, xsjgP, lj);
    }
}