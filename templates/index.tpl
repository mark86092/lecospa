{extends file='bootstrap.html'}

{block name=head}
<link href="css/responsive-full-background-image.css" rel="stylesheet">
<link href="css/homepage.css" rel="stylesheet">
{/block}

{block name=body}
{strip}
{* 導覽列 *}
<nav class="navbar navbar-default">
<div class="container">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="http://lecospa.ntu.edu.tw/symposium/2015/">Lecospa</a>
	</div>
	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav ">
			<li><a href="#">Bulletin</a></li>
			<li><a href="#">Registration</a></li>
			<li><a href="#">Committee</a></li>
			<li><a href="#">Invited Speaker</a></li>
			<li><a href="#">Talk Submission</a></li>
			<li><a href="#">Program</a></li>
			<li><a href="#">Social Activities </a></li>
			<li><a href="visiting.php">Visiting Taiwan</a></li>
			<li><a href="#">Accommodation</a></li>
			<li><a href="#">Photo Gallery</a></li>
		</ul>
	</div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>
{/strip}

<div class="container">
	<div id="header">
		<a href="img/lecospa-logo.png"><img src="img/lecospa-logo.png" class="img-responsive"></a>
	</div>
	<div stlye="height: 20px; width: 100%;">&nbsp;</div>
	<div id="bulletin">
		<div class="item col-width" style="background-color: rgba(10,140,190,0.8);"><img src="img/poster.png" class="img-responsive"></div>
		<div class="item col-width" style="background-color: rgba(255, 255, 255, 0.8); color: black;">Things 2</div>
		<div class="item col-width" style="background-color: rgba(92, 154, 92, 0.8);">Things 3</div>
		<div class="item col-width" style="background-color: white;">
			<div class="fb-like-box" data-href="https://www.facebook.com/pages/LeCosPA/153896001443097" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="true" data-show-border="false" data-width="250px"></div>
{* Facebook API *}
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&appId=622070731147437&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
{* End of Facebook API *}
		</div>
	</div>
</div>

{/block}


{block name=body_script}{literal}
<script src="js/masonry.pkgd.min.js"></script>
<script>
var container = document.querySelector('#bulletin');
var msnry = new Masonry( container, {
  columnWidth: container.querySelector('.col-width'),
  itemSelector: '.item'
});
$(window).bind("load", function() {
	msnry.layout();
});
</script>
{/literal}{/block}
