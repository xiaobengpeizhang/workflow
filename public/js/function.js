/**
 * Created by 小奔 on 2017-09-24.
 */
//获得指定日期的前n天
function getBeforNday(date, n) {
    var yesterday_milliseconds = date.getTime() - n * 1000 * 60 * 60 * 24;
    var yesterday = new Date();
    yesterday.setTime(yesterday_milliseconds);

    var strYear = yesterday.getFullYear();
    var strDay = yesterday.getDate();
    var strMonth = yesterday.getMonth() + 1;
    if (strMonth < 10) {
        strMonth = "0" + strMonth;
    }
    datastr = strYear + "/" + strMonth + "/" + strDay;
    return datastr;
}

//data类型转string,获得指定类型的日期
Date.prototype.format = function (format) {
    var o = {
        "M+": this.getMonth() + 1, //month
        "d+": this.getDate(),    //day
        "h+": this.getHours(),   //hour
        "m+": this.getMinutes(), //minute
        "s+": this.getSeconds(), //second
        "q+": Math.floor((this.getMonth() + 3) / 3),  //quarter
        "S": this.getMilliseconds() //millisecond
    }
    if (/(y+)/.test(format)) format = format.replace(RegExp.$1,
        (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o) if (new RegExp("(" + k + ")").test(format))
        format = format.replace(RegExp.$1,
            RegExp.$1.length == 1 ? o[k] :
                ("00" + o[k]).substr(("" + o[k]).length));
    return format;
}

//传入“yyyy-MM-dd”格式的字符串，判断日期大小
function isDateValid(start,end){
    var startdate = new Date(start.replace(/-/g,"/"));
    var enddate = new Date(end.replace(/-/g,"/"));
    if(startdate < enddate){
        return true;
    }else{
        return false;
    }
}

//通过AJAX请求加载页面
function pageLoad(url){
    $.get(url,function(data,status){
        if(status == 'success'){
            $('#content').html(data);
        }
    });
}

//弹窗
//function popUp(title,data){
//    $('#popUp').html(data);
//    layer.open({
//        title:title,
//        content:$('#popUp'),
//        shade: 0
//    })
//}

//新增数据成功后的消息提示
function message(content) {
    layer.msg(content, {
        icon: 1,
        time: 3000,
        offset: 't'
    });
}
