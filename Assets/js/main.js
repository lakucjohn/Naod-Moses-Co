var patient_id='';
function loadPagElements(){
	fetch_dashboard_contents('http://localhost/Naod-Moses-Co/Naod/dashboard_content.php');
 $('a.side_menu_bar').click(function(e){
     var	url= $(this).attr ('href');
       e.preventDefault();
		fetch_dashboard_contents(url);
    });

}
   function fetch_contents(url){
    $.ajax({
                        url:url, // point to server-side controller method
                        dataType: 'html', // what to expect back from the server
                        type: 'post',
                        data: {patientId:patient_id},
                        success: function (response) {
						$("#patient_contents").html(response);
                        },
                        error: function (response) {
                            //alert("error Occured!!!"); // display error response from the server
                        }
                    });
   }

function fetch_dashboard_contents(url){
    $.ajax({
                        url:url, // point to server-side controller method
                        dataType: 'html', // what to expect back from the server
                        type: 'get',
                        success: function (response) {
						$("#contents").html(response);
                        },
                        error: function (response) {
                            //alert("error Occured!!!"); // display error response from the server
                        }
                    });

}

function show_report_contents(s){
	var url='http://localhost/Naod-Moses-Co/Naod/'+s;
	//alert(url);
	 fetch_patient_contents(url);
}

function show_content(id,s){
	var url='http://localhost/Naod-Moses-Co/Naod/'+s;
	//alert(url);
	patient_id=id;
	//alert(patient_id+"patient id gotten");
   fetch_contents(url);
}
function replace_div_content(div_id,file) {
    $(document).ready(function () {
        $('#'+div_id).load(file);
    });
}
