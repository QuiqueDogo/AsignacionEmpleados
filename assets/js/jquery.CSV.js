function csv() {
    var clean_text = function(text){
        text = text.replace(/"/g, '""');
        return '"'+text+'"';
    };
    
	$("#datatable").each(function(){
		var table = $("#datatable");
		var title = [];
		var rows = [];

		$("#datatable").find('tr').each(function(){
			var data = [];
			$("#datatable").find('th').each(function(){
                var text = clean_text($("#datatable").text());
				title.push(text);
				});
			$("#datatable").find('td').each(function(){
                var text = clean_text($("#datatable").text());
				data.push(text);
				});
			data = data.join(",");
			rows.push(data);
			});
		title = title.join(",");
		rows = rows.join("\n");

		var csv = title + rows;
		var uri = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
		var download_link = document.createElement('a');
		download_link.href = uri;
		var ts = new Date().getTime();
		download_link.download = ts+".csv";
		document.body.appendChild(download_link);
		download_link.click();
		document.body.removeChild(download_link);
	});   
};