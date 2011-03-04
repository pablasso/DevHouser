<?php 
session_start();
require_once 'registration.php';
require 'facebook/facebook.php';
$salt = "omgimasecretsaltforthelolzbbq";

$facebook = new Facebook(array(
	'appId'  => '168055916553567',
	'secret' => '364ffa54ea500f5e2913c1858ec03b5b',
	'cookie' => true,
));

$session = $facebook->getSession();
$me = array();

if ($session) {
	try {
		$uid = $facebook->getUser();
		$me = $facebook->api('/me');
	} catch (FacebookApiException $e) {
		error_log($e);
	}
}

$facebook_logout_url = $facebook->getLogoutUrl();
$registration = new Registration(array_merge($_POST, $_GET, $me));
$verified_is_registered = $registration->verified_is_registered();

$maps_key = $_SERVER['HTTP_HOST'] == "guadalajaradevhouse.org" ? 
									 "ABQIAAAAd24bisosjRxD6MwlWnednBTjQPnm6iBK50wNhgKXBJlqDEEyKRQWktDtV5S3V4JPoi_4Uf22wV5V-g":
									 "ABQIAAAAd24bisosjRxD6MwlWnednBRi_j0U6kJrkFvY4-OX2XYmEAa76BTFFOTq26iFsIWCCb0Z3ds5hLreGg";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
	<title>GuadalajaraDevHouse</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="icon" type="image/x-icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="styles_v2.css" />

	<script src="http://maps.google.com/maps?file=api&v=2&key=<?php echo $maps_key; ?>&sensor=false" type="text/javascript"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
	<script type="text/javascript" src="http://use.typekit.com/ylg7jyh.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

    <script type="text/javascript">

    function initialize() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"));
        map.setCenter(new GLatLng(20.677790, -103.372786), 15);
		var point = new GLatLng(20.677790, -103.372786);
    	map.addOverlay(new GMarker(point));
        map.setUIToDefault();
      }
    }

    </script>

	<!-- google analytics -->
	<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
	try {
	var pageTracker = _gat._getTracker("UA-380093-4");
	pageTracker._trackPageview();
	} catch(err) {}</script>
</head>

<body onload="initialize()" onunload="GUnload()">

<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId   : '<?php echo $facebook->getAppId(); ?>',
      session : <?php echo json_encode($session); ?>,
      status  : true,
      cookie  : true,
      xfbml   : true
    });

    FB.Event.subscribe('auth.login', function() {
      window.location.reload();
    });
  };

  (function() {
    var e = document.createElement('script');
    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
  }());
</script>

<?php if ($registration->status == "user_registered" || $registration->status == "user_already_registered" ||
 		  $registration->status == "form_error"): ?>
	<div class="message"><?php echo $registration->message; ?></div>
<?php endif ?>

<div id="content">
	
	<h1 title="Laptops not included!">GuadalajaraDevHouse</h1>
	
	<h3>¿Qué es?</h3>

	<p>El <strong>Guadalajara</strong>Dev<strong>House</strong> es un evento <em>muy</em> informal para personas interesadas en crear y aprender. El objetivo de estas reuniones es compartir conocimiento y colaborar con otros desarrolladores. Estamos inspirados en el <a href="http://superhappydevhouse.org">SuperHappyDevHouse</a> original y en el celebrado en la <a href="http://shdhmexicocity.org">Ciudad de México</a>.</p>

	<p>Estos eventos son frecuentados por desarrolladores para realizar pequeños proyectos que se puedan lograr en 12 horas o menos. Aún así no necesitas tener mil años de experiencia para asistir, con que tengas el interés de aprender es suficiente. Puede que no necesites ni saber programar, es común que los diseñadores también asistan a este tipo de eventos y se complementen muy bien con la gente técnica para crear proyectos.</p>

	<div class="next_event">
		<span class="small_next_event">5ta Edición</span> Sábado 26 de Febrero <span class="small_next_event">de 10am a 10pm</span>
	</div>

<?php if ($registration->status != "user_registered" && $registration->status != "user_already_registered"): ?>
	<h3>Registro</h3>

	<p>Te pedimos que te registres para confirmar tu asistencia, eso nos ayuda a darnos una idea de cuánta gente esperar y también es una forma de dar a conocer lo que vas a hacer. Puedes hacerlo con tu cuenta de Twitter o de Facebook.</p>
<?php endif ?>

<?php if ($registration->status == "init" || !empty($registration->verified_user)): ?>

	<div class="login-buttons">
		<div class="twitter-button">
			<?php if ( $verified_is_registered || (!empty($registration->verified_user) && $registration->verified_user['social_web'] == "twitter") ): ?>
				<img src="images/twitter_signin_inactive.png" alt="Registrate con Twitter" title="Registrate con Twitter">
			<?php else: ?>
				<a href="twitter/redirect.php"><img src="images/twitter_signin.png" alt="Registrate con Twitter" title="Registrate con Twitter"></a>
			<?php endif ?>
		</div>
		<div class="facebook-button">
			<?php if ( $verified_is_registered ): ?>
				<img src="images/facebook_signin_inactive.png" alt="Registrate con Facebook" title="Registrate con Facebook">
			<?php elseif (!empty($me) && (!empty($registration->verified_user) && $registration->verified_user['social_web'] == "twitter")): ?>
				<a href="/"><img src="images/facebook_signin.png" alt="Registrate con Facebook" title="Registrate con Facebook"></a>
			<?php elseif (!empty($me)): ?>
				<img src="images/facebook_signin_inactive.png" alt="Registrate con Facebook" title="Registrate con Facebook">
			<?php else: ?>
				<fb:login-button v="2" onlogin="javascript:fb_login_button_click();">Login with Facebook</fb:login-button>
			<?php endif ?>
		</div>			
	</div>
<?php endif ?>

<?php if ( !$verified_is_registered && ($registration->status == "twitter_verified" || $registration->status == "facebook_form" || 
										$registration->status == "form_error") ): ?>
	
	<div class="register_container">
		<div class="register_left">
			<img src="<?php echo $registration->verified_user['social_avatar_url'];?>" width="48" height="48" alt="avatar de usuario"/><br />
			<img src="images/<?php echo $registration->verified_user['social_web']; ?>16x16.png" width="16" height="16" style="margin-top:10px;" alt="social web"/>
		</div>

		<div class="register_right">
			<form action="/" method="post" accept-charset="utf-8" style:"margin: 0px;">
				<input type="hidden" name="form_key" value="<?php echo md5($salt.$registration->verified_user['social_id']); ?>">
				<input type="hidden" name="social_web" value="<?php echo $registration->verified_user['social_web']; ?>">
				<input type="hidden" name="social_id" value="<?php echo $registration->verified_user['social_id']; ?>">
				<input type="hidden" name="social_username" value="<?php echo $registration->verified_user['social_username']; ?>">
				<input type="hidden" name="social_url" value="<?php echo $registration->verified_user['social_url']; ?>">
				<input type="hidden" name="social_avatar_url" value="<?php echo $registration->verified_user['social_avatar_url']; ?>">
				<label for="name">Nombre</label><br />
				<input type="text" size="90" name="name" value="<?php echo $registration->verified_user['name']; ?>" id="name" style="height:2em;"><br /><br />
				<label for="activity">¿Qué vas a hacer?</label><br />
				&nbsp;<textarea name="activity" value="" id="activity" cols="65" rows="3"></textarea><br />
				<input type="submit" value="Registrar">
			</form>
		</div>
	</div>
	<script type="text/javascript">$("#activity").focus();</script>
<?php endif ?>

	<h3>¿Qué necesito llevar?</h3>

	<ol>
		<li>Tu portátil.</li>
		<li>Dinero para tu comida. Solemos gastar entre $60 a $80 pesos en pizza y refrescos. También puedes llevar tu comida o salir por ella.</li>
		<li>Siempre estamos necesitados de extensiones eléctricas. Así que si llevas la tuya te lo agradecemos.</li>
		<li>Si lo necesitas, lleva tu cable de red.</li>
	</ol>

	<h3>¿Dónde es?</h3>

	<p>El evento es en las instalaciones del nuevo <strong><a href="http://hackergarage.mx/">HackerGarage</a></strong>.</p>

	<div style="width:100%; text-align:center;">
		<div id="map_canvas" style="width: 100%; height: 200px"></div>
		<p class="address">Justo Sierra #2202, Entre Bernardo de Balbuena y Américas.</p>
	</div>
	
	<h3>Contacto</h3>

	<p>Cualquier duda puedes contactarnos en la cuenta de twitter <a href="http://www.twitter.com/GdlDevHouse">@GdlDevHouse</a>.</p>

	<h3>Lista de Registrados (<?php echo count($registration->users); ?>)</h3>

	<table>
		<thead>
			<tr>
				<th></th>
				<th>Nombre</th>
				<th>Red Social</th>
				<th>¿Qué voy a hacer?</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($registration->users as $user): ?>
			<tr>
				<td><img src="<?php echo $user['social_avatar_url']; ?>" width="48" height="48" /></td>
				<td class="t_name"><?php echo $user['name']; ?></td>
				<td class="t_<?php echo $user['social_web']; ?>"><a href="<?php echo $user['social_url']; ?>"><?php echo $user['social_username']; ?></a></td>
				<td class="t_description"><?php echo $user['activity']; ?></td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>

</body>
</html>