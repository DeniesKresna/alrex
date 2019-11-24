const filters =
[
    {
        name: "family_relationship",
        execute: (value) =>{
            switch(value){
                case 'ayah': return 'Ayah'; break;
                case 'ibu': return 'Ibu'; break;
                case 'saudara lelaki': return 'Saudara Laki-laki'; break;
                case 'saudara perempuan': return 'Saudara Perempuan'; break;
                default: return value;
            }
        }
    },
    {
        name: "is_dead",
        execute: (value) =>{
            switch(value){
                case 'live': return 'Masih Hidup'; break;
                case 'dead': return 'Meninggal'; break;
                default: return value;
            }
        }
    }
]

export default filters

/*
Vue.filter("toFullDate", value => {
		var hari= ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];
        var bulan= ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        var timenumb = new Date(value);
        var day = hari[timenumb.getDay()];
        var mon = bulan[timenumb.getMonth()];
        var dat = timenumb.getDate();
        var year = timenumb.getFullYear();
        var jam = timenumb.getHours();
        if(jam<10)
        {
        	jam = "0"+jam;
        }
        var mnt = timenumb.getMinutes();
        if(mnt<10)
        {
        	mnt = "0"+mnt;
        }
        return day + ", " + dat + " " + mon + " " + year + " " + jam + ":" + mnt;
    });

Vue.filter("toStatusKet", value=>{
	var statusKet=["Tidak ada","menunggu Admin","menunggu Pembayaran..","menunggu Expert..","ditolak..","Room disiapkan..","Selesai"];
	return statusKet[value];
});

Vue.filter("toDd-Mm-Yyyy", value =>{
    var timenumb = new Date(value);
    var year = timenumb.getFullYear();
    var mon = timenumb.getMonth();
    var dat = timenumb.getDate();
    if(dat<10)
    {
        dat = "0"+dat;
    }
    if(mon<10)
    {
        mon = "0"+mon;
    }
    return dat + "-" + mon + "-" + year;
});

Vue.filter("timeDifference", value =>{
    var bulan= ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            var now = new Date();
            var theTime = new Date(value);
            var secondsPast = (now.getTime() - theTime.getTime()) / 1000;
            if(secondsPast < 60){
              return parseInt(secondsPast) + 's';
            }
            if(secondsPast < 3600){
              return parseInt(secondsPast/60) + 'm';
            }
            if(secondsPast <= 86400){
              return parseInt(secondsPast/3600) + 'h';
            }
            if(secondsPast > 86400){
                var day = theTime.getDate();
                var month = bulan[theTime.getMonth()];
                var year = theTime.getFullYear() == now.getFullYear() ? "" :  " "+theTime.getFullYear();
                return day + " " + month + year;
            }
});*/

