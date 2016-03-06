<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="/canteen/application/themes/canteen_styles.min.css" />
	<link rel="stylesheet" href="/canteen/application/themes/jquery.mobile.icons.min.css" />
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.3/jquery.mobile.structure-1.4.3.min.css">
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.3/jquery.mobile-1.4.3.min.js"></script>
    <link href="http://fonts.googleapis.com/css?family=PT+Sans:regular,italic,bold,bolditalic" rel="stylesheet" type="text/css" />
		<style type="text/css">
dl { font-family: "Times New Roman", Times, serif; padding: 1em; }
dt { font-size: 2em; font-weight: bold; }
dt span { font-size: .5em; color: #777; margin-left: .5em; }
dd { font-size: 1.25em; margin: 1em 0 0; padding-bottom: 1em; border-bottom: 1px solid #eee; }
.back-btn { float: right; margin: 0 2em 1em 0; }
.menuitems{
    padding:10px;
    text-align: center;
    box-shadow: 0 0 10px 5px #DDD;
    margin-left: 5px;
    margin-right: 5px;
    margin-bottom: 30px;
    border-radius: 15px;
}
.menuitems a{
    text-decoration: none;
}
h2{
    text-align: center;
}
.nowrap{
    box-shadow: none;
}
.price {
  font-family: 'PT Sans', serif;
  }
</style>
<script>
    $( document ).on( "pagecreate", "#demo-page", function() {
    $("#pb").on("click", function(){
        $( "#left-panel" ).panel( "open" );
    });
    $( document ).on( "swipeleft swiperight", "#demo-page", function( e ) {
        if ( $( ".ui-page-active" ).jqmData( "panel" ) !== "open" ) {
            if ( e.type === "swipeleft" ) {
                $( "#right-panel" ).panel( "open" );
            } else if ( e.type === "swiperight" ) {
                $( "#left-panel" ).panel( "open" );
            }
        }
    });
});
</script>
</head>
<body>    

        <div data-role="page" data-theme="a" id="demo-page">
        <div data-role="header" data-position="inline"><a id="pb" class="ui-btn ui-corner-all ui-icon-menu ui-icon-grid ui-btn-icon-notext">Home Icon</a>
            <h1>Столовая</h1>
            <a data-ajax="false" href="/canteen/myorder"><?php $sum=0; if(sizeof($_SESSION["orders"])>0)foreach ($_SESSION["orders"] as $key => $value) { $sum +=$value["price"];  } echo $sum;?><span class="price">&#8381;</span></a>
        </div>
        <div data-role="panel" id="left-panel" data-theme="a">
            
            <a href="/canteen/breakfast" data-ajax="false"><button class=" ui-btn ui-btn-a ui-btn-icon-left ui-shadow ui-corner-all" data-theme="a" data-form="ui-btn-up-a">Завтрак</button></a>
            <a href="/canteen/lunch" data-ajax="false"><button class=" ui-btn ui-btn-a ui-btn-icon-left ui-shadow ui-corner-all" data-theme="a" data-form="ui-btn-up-a">Обед</button></a>
            <a href="/canteen/dinner" data-ajax="false"><button class=" ui-btn ui-btn-a ui-btn-icon-left ui-shadow ui-corner-all" data-theme="a" data-form="ui-btn-up-a">Ужин</button></a>
        </div>


        <div id="fff" data-role="content" data-theme="a">
            <?php /*!!!*/include 'application/views/'.$content_view; ?>
        </div>

</div>
</body>
</html>