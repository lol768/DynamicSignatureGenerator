<?php
use SignatureGenerator\Storage;

require("bootstrap.php");
function ife($var, $te=false) {
    if ($var != null && !empty($var)) {
        if ($te) {
            echo $var;
        } else {
            echo ' value="' . $var . '" ';
        }
    } else {
        return;
    }
}

if (array_key_exists("load", $_GET)) {
    $fn = $_GET['load'];
    if (Storage::signatureExists($fn)) {
        $data = getcwd() . DIRECTORY_SEPARATOR . "s" . DIRECTORY_SEPARATOR . $fn;
        $data = file_get_contents($data);
        $data = Storage::loadData($data);
        $inpQuotes = implode("\n", $data->quotes);
        $inpHeader = $data->header;
        $inpSubHeader = $data->subheader;
        $inpDetails = $data->details;
    }
}
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Signature Generator</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <meta name="author" content="lol768">
    <!-- If I was being paid this would look unique. Looks don't matter right now though, so bootstrap will do ;) Sorry nkrecklow -->
    <style type="text/css">
        .container {
            margin-left: 15px;
            margin-right: 15px;
        }

        #load {
            float: right;
        }

        @media (max-width: 700px) {
            #thumb {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="page-header">
            <h1>Signature generator
                <small>hosted by Jade</small>
                <img src="load.gif" id="load">
            </h1>
        </div>
        <form class="form-horizontal" role="form">
            <div class="form-group">
                <label for="inputHeader" class="col-sm-2 control-label">Header</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputHeader" name="header"
                           placeholder="lol768 is awesome"<?php ife($inpHeader) ?>>
                </div>
            </div>
            <div class="form-group">
                <label for="inputSubheader" class="col-sm-2 control-label">Subheader</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputSubheader" name="subheader"
                           placeholder="lol768 is really awesome"<?php ife($inpSubHeader) ?>>
                </div>
            </div>
            <div class="form-group">
                <label for="inputDetails" class="col-sm-2 control-label">Details</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputDetails"
                           name="details" placeholder="lol768 is really really awesome"<?php ife($inpDetails) ?>>
                </div>
            </div>
            <div class="form-group">
                <label for="inputQuotes" class="col-sm-2 control-label">Quotes</label>

                <div class="col-sm-10">
                    <textarea placeholder="One per line" name="quotes" id="inputQuotes" class="form-control"
                              rows="5"><?php ife($inpQuotes, true) ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" class="btn btn-default" value="Save">
                </div>
            </div>

        </form>
        <div id="thumb">
            <h2>Preview
                <small><a href="#" id="refresh"><i class="glyphicon glyphicon-refresh"></i> refresh</a></small>
            </h2>

            <a class="thumbnail" style="width: 700px;">
                <img src="http://placehold.it/700x100&text=Fill+in+the+fields+for+a+preview" id="preview"
                     style="width: 700px;">
            </a></div>
        <div id="link">
            <h2><a href="?load=1" id="permalink"><i class="glyphicon glyphicon-link"></i></a> Your image link
                <small>click to select</small>
            </h2>
            <input type="text" class="form-control" value="woo" id="linkBox" readonly>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(function () {
        $("#link").hide();
        $("#load").hide();

        function getRandomInt(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        }

        function preview() {
            var header = $("#inputHeader").val();
            var subHeader = $("#inputSubheader").val();
            var details = $("#inputDetails").val();
            var quotes = $("#inputQuotes").val().split("\n");
            if (header != "" && subHeader != "" && details != "" && quotes.length > 0) {
                var time = new Date().getTime();
                //for now, we'll calculate the random quote clientside
                var quote = quotes[getRandomInt(0, quotes.length - 1)];
                $("#preview").attr("src", "preview.php?h=" + encodeURIComponent(header) + "&s=" + encodeURIComponent(subHeader) + "&d=" + encodeURIComponent(details) + "&q=" + encodeURIComponent(quote) + "&t=" + time);
            }
        }

        preview();


        function save() {
            var vals = $("form").serializeArray();
            $("#load").show();

            $.post("save.php", vals, function (data) {
                $("#link").slideDown();
                $("#load").fadeOut();
                var linkArray = data.split("/");
                $("#permalink").attr("href", "?load=" + linkArray[linkArray.length-1]);
                $("#linkBox").val(data);
            });
        }

        $("form").submit(function (e) {
            save();
            e.preventDefault();
            return false;
        });


        $("#refresh").click(function () {
            preview();
        });

        $("input[type='text']").keyup(function () {
            preview();
        });

        $("textarea").keyup(function () {
            preview();
        });

        $("#linkBox").focus(function () {
            var $this = $(this);
            $this.select();

            // Work around Chrome's little problem
            $this.mouseup(function () {
                // Prevent further mouseup intervention
                $this.unbind("mouseup");
                return false;
            });
        });
    });
</script>
</body>
</html>
