<!DOCTYPE html>
<html class="no-js" lang="vi"> <!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Email Checker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Email checker."/>
    <meta name="keywords" content="Email checker"/>
    <meta name="author" content="K6VN-Team"/>
    <link rel="shortcut icon" href="">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Prata" rel="stylesheet">
    <link rel="stylesheet" href="assets/animate.css">
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <link rel="stylesheet" href="assets/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/jquery.min.js" type="text/javascript"></script>
    <script src="assets/bootstrap.min.js" type="text/javascript"></script>
    <style>
        textarea[name='data'] {
            height: 200px;
            resize: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1 style="text-align: center"></h1>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <!-- CHECK CC -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">
                                    Check live email -
                                    <strong><a style="text-decoration: underline;" href="https://tienichmmo.top">TIENICHMMO.TOP</a></strong>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class='alert alert-danger text-center info' style="display: none"></div>
                                <form method="post" action="check.php" role="form" id="form">
                                    <div class="form-group">
                                        <textarea class="form-control" id="data" name="data" title="email|password" placeholder="email|password" required="required"></textarea>
                                    </div>
                                    <div class="col-6 col-md-offset-5">
                                        <div class="form-group">
                                            <button type="submit" id="start" name="valid" class="btn btn-success">Start</button>
                                            <button type="button" id="stop" class="btn btn-danger">Stop</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Info success -->
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">Live
                                    <span class="badge live">0</span>
                                </h3>
                            </div>
                            <div class="panel-body success"></div>
                        </div>

                        <!-- Info error -->
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title">Die
                                    <span class="badge die">0</span>
                                </h3>
                            </div>
                            <div class="panel-body danger"></div>
                        </div>

                        <!-- Info unknown -->
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <h3 class="panel-title">Unknown
                                    <span class="badge unknown">0</span>
                                </h3>
                            </div>
                            <div class="panel-body warning"></div>
                        </div>

                        <!-- Footer -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function (){
        //var $run = false;
        let $stop = false;
        $("#stop").click(function (){
            $stop = true;
        });
        let $live, $die, $unk;
        $("#form").submit(function (e){
            e.preventDefault();
            $("#start").prop("disabled", true).text("Checking...");
            let data = $("#data").val();
            let lines = data.split(/\n/);
            let total = lines.length;
            $live = $die = $unk = 0;
            $.each(lines, function(index, line){
                $.post(
                    "check.php",
                    {data: line},
                    function(e){
                        if (e.status === 'LIVE') {
                            $live++;
                            $(".badge.live").text($live);
                            $(".panel-body.success").append(`<div><b style="color:#008000;">Live</b> | ${e.email} | ${e.password} | [${e.data}] @/Tienich-MMO</div>`);
                        } else if (e.status === 'DIE') {
                            $die++;
                            $(".badge.die").text($die);
                            $(".panel-body.danger").append(`<div><b style="color:#FF0000;">Die</b> | ${e.email} | ${e.password} | [${e.data}] @/Tienich-MMO</div>`);
                        } else if (e.status === 'UNKNOWN') {
                            $unk++;
                            console.log($unk);
                            $(".badge.unknown").text($unk);
                            $(".panel-body.warning").append(`<div><b style="color:#800080;">Unknown</b> | ${e.email} | ${e.password} | [${e.data}] | @/Tienich-MMO</div>`);
                        }
                    }, 'json'
                );
                if ($stop || index === total - 1) {
                    $("#start").attr("disabled", false).text("Start");
                    return false;
                }
            })
        })
    })
</script>
</body>
</html>