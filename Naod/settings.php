<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/30/18
 * Time: 11:22 AM
 */
session_start();

?>
<style type="text/css">
    .panel-title .glyphicon{
        font-size: 14px;
    }

    .companyData{
        clear:both;
        font-size: 16px;
        line-height: 36px;
    }

    .company-data{
        width: 80%;
        float: right;
    }

    .labelText{
        width: 20%;
        float:left;
    }

    #toggle-system-button,#toggle-document-button,#toggle-security-button{
        text-align: center;
        margin-top:5%;
    }
    .company-logo{
        height:100px;
        width:100px;
    }

    #change-logo-div{
        margin-right: 20%;
    }

</style>
<script>
    $(document).ready(function(){
        // Add minus icon for collapse element which is open by default
        $(".collapse.in").each(function(){
            $(this).siblings(".panel-heading").find(".glyphicon").addClass("glyphicon-minus").removeClass("glyphicon-plus");
        });

        // Toggle plus minus icon on show hide of collapse element
        $(".collapse").on('show.bs.collapse', function(){
            $(this).parent().find(".glyphicon").removeClass("glyphicon-plus").addClass("glyphicon-minus");
        }).on('hide.bs.collapse', function(){
            $(this).parent().find(".glyphicon").removeClass("glyphicon-minus").addClass("glyphicon-plus");
        });


    });



</script>
<body>
<div class="container">
    <h3>Settings</h3>
    <div class="panel-group" id="settings-accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="glyphicon glyphicon-plus"></span> System</a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="companyData">
                        <div class="labelText">Name of System: </div>
                        <div class="company-data" id="system-name"><?php echo $_SESSION['appname']; ?></div>
                    </div>

                    <div id="toggle-system-button">
                        <div id="buttonsystemedit" class="company-data">
                            <button type="button" class="btn btn-link" onclick="toggleEditSystemButton();">Edit</button>
                        </div>
                        <div id="buttonsystemsave" class="company-data" style="display: none;">
                            <button type="button" class="btn btn-primary btn-md-2" onclick="saveNewSystemData();">Save</button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="glyphicon glyphicon-plus"></span> Documents Header Content</a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">

                    <div class="companyData">
                        <div class="labelText">Name of the Company: </div>
                        <div id="company-name" class="company-data"><?php echo $_SESSION['company']; ?></div>
                    </div>


                    <div class="companyData">
                        <div class="labelText">Location: </div>
                        <div id="company-location" class="company-data"><?php echo $_SESSION['location']; ?></div>
                    </div>

                    <div class="companyData">
                        <div class="labelText">Mailing Address: </div>
                        <div id="company-mailing-address" class="company-data"><?php echo $_SESSION['mailing_address']; ?></div>
                    </div>


                    <div class="companyData">
                        <div class="labelText">Telephone</div>
                        <div id="company-telephone" class="company-data"><?php echo $_SESSION['telephone']; ?></div>
                    </div>

                    <div class="companyData">
                        <div class="labelText">Email Address: </div>
                        <div id="company-email" class="company-data"><?php echo $_SESSION['email']; ?></div>
                    </div>

                    <div class="companyData">
                        <div class="labelText">&nbsp; </div>
                        <div id="company-email" class="company-data">&nbsp;</div>
                    </div>


                    <div id="toggle-document-button">

                        <div id="buttondocumentedit" class="company-data">
                            <button type="button" class="btn btn-link" onclick="toggleEditDocumentButton();">Edit</button>
                        </div>
                        <div id="buttondocumentsave" class="company-data" style="display: none;">
                            <button type="button" class="btn btn-primary btn-md-2" onclick="saveNewDocumentData();">Save</button>
                        </div>
                    </div>

                    <div class="companyData">
                        <div class="labelText">Company Logo: </div>
                        <div id="company-logo" class="company-data"><img src="data:image;base64,<?php echo $_SESSION['logo']; ?>" class="company-logo" /> <div id="change-logo-div" style="display: none;"><button type="button" id="edit-logo" class="btn btn-link" onclick="setLogoFileField();">Change Logo</button></div></div>

                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span class="glyphicon glyphicon-plus"></span>Security</a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="companyData">
                        <div class="labelText">Adminstrator Username: </div>
                        <div id="company-admin-username" class="company-data"><?php echo $_SESSION['username']; ?></div>
                    </div>

                    <div class="companyData">
                        <div class="labelText">Administrator Password: </div>
                        <div id="company-admin-password" class="company-data">********</div>
                    </div>



                    <div id="toggle-security-button">
                        <div id="buttonsecurityedit" class="company-data">
                            <button type="button" class="btn btn-link" onclick="toggleEditSecurityButton();">Edit</button>
                        </div>
                        <div id="buttonsecuritysave" class="company-data" style="display: none;">
                            <button type="button" class="btn btn-primary btn-md-2" onclick="saveNewSecurityData();">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function toggleEditDocumentButton() {
        var name = document.getElementById('company-name').innerHTML;
        var location = document.getElementById('company-location').innerHTML;
        var mailing_address = document.getElementById('company-mailing-address').innerHTML;
        var telephone = document.getElementById('company-telephone').innerHTML;
        var email = document.getElementById('company-email').innerHTML;

        //Preparing input fields
        document.getElementById('company-name').innerHTML = '<input type="text" value="'+name+'" id="edited-company-name" class="form-control" />';
        document.getElementById('company-location').innerHTML = '<input type="text" value="'+location+'" id="edited-company-location" class="form-control" />';
        document.getElementById('company-mailing-address').innerHTML = '<input type="text" value="'+mailing_address+'" id="edited-mailing_address" class="form-control" />';
        document.getElementById('company-telephone').innerHTML = '<input type="text" value="'+telephone+'" id="edited-company-telephone" class="form-control" />';
        document.getElementById('company-email').innerHTML = '<input type="text" value="'+email+'" id="edited-company-email" class="form-control" />';

        document.getElementById('buttondocumentedit').style.display = 'none';
        document.getElementById('buttondocumentsave').style.display = 'block';
        document.getElementById('change-logo-div').style.display = 'block';
    }

    function setLogoFileField(){
    }

    function saveNewDocumentData(){
        var edited_company_name = document.getElementById('edited-company-name').value;
        var edited_company_location = document.getElementById('edited-company-location').value;
        var edited_company_mailing_address = document.getElementById('company-mailing-address');
        var edited_company_telephone = document.getElementById('edited-company-telephone').value;
        var edited_company_email = document.getElementById('edited-company-email').value;


    }

        function toggleEditSystemButton(){
            var system_name = document.getElementById('system-name').innerHTML;

            document.getElementById('system-name').innerHTML = '<input type="text" value="'+system_name+'" class="form-control" />';

            document.getElementById('buttonsystemedit').style.display = 'none';
            document.getElementById('buttonsystemsave').style.display = 'block';
        }

    function saveNewSystemData(){
        alert('OK');
    }

        function toggleEditSecurityButton(){
            var username = document.getElementById('company-admin-username').innerHTML;

            document.getElementById('company-admin-username').innerHTML = '<input type="text" value="'+username+'" id="edited-username" class="form-control" />';
            document.getElementById('company-admin-password').innerHTML = '<input type="password" value="" id="edited-password" class="form-control" />';
            document.getElementById('SecurityText').innerHTML += '<div class="companyData"><div class="labelText">Confirm Password: </div><div id="company-admin-password" class="company-data"><input type="password" class="form-control" /> </div></div>';

            document.getElementById('buttonsecurityedit').style.display = 'none';
            document.getElementById('buttonsecuritysave').style.display = 'block';

        }

    function saveNewSecurityData(){
        alert('OK');
    }
</script>