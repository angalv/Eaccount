<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Email Template</title>
	<meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">	
	<style>	

	@font-face{
	    font-family: "Corbel";
	    src: url(fonts/Corbel.ttf); /* .eot - Internet Explorer */
	}

	a
	{
		text-decoration: none;
	}

	article.description
	{
		background-color: white;
		box-shadow: 5px 5px 10px #a1a1a1;
		border: 1px solid #a1a1a1;
		border-radius: 0.5em;		
		font-size: 1.3em;
		margin-left: 2.2em;
		margin-right: 2.2em;
		/*margin-top: 1em;*/
		/*overflow: auto;
		overflow-y: hidden;*/ 
		position: relative;

	}

	article.description > p
	{
		padding: 1em;		
	}

	article.description > p.datos
	{
		padding: 1em;		
		margin-bottom: 1.5em;		
	}	

	article.description > a.button
	{
		border: 1px solid #224d71;
		background-color: #2c6494;
		border-radius: 0.3em;
		bottom: -1.2em;
		color: white;
		left: 18%;
		/*right: 18%;*/
		font-size: 1.2em;
		/*margin-left: 343px;*/
		/*margin-right: 0;*/
		/*text-decoration: none;*/
		text-align: center;
		padding: 0.5em 1em 0.5em 1em;
		position: absolute;
	}

	article.footer
	{
		/*position: absolute;*/
		width: 782px;
		bottom: 0;
		margin-top: 5em;
		/*top: 100%;*/
		/*right: 0;*/
	}
	article.footer > ul
	{
		background-color: #2c6494;		
		list-style-type: none;
		margin: 0;
		padding: 0.5em 0 0.5em 0;
		text-align: center;

	}

	article.redirect
	{
		padding: 1em;
		text-align: center;
		font-size: 1em;
		margin-top: 2.5em;
		margin-bottom: 1.5em;
	}
	
	article.redirect > a
	{
		color: #2c6494;
		display: block;
		margin-top: 0.5em;
		/*text-decoration: none;*/
	}
	
	article.aplicaciones
	{
		background-color: white;
		/*position: absolute;*/
		width: 100%;
		padding: 0.5em 0 0.5em 0;
	}

	article.aplicaciones > picture
	{
		margin-left: 3.5em;
	}

	article.footer > ul > li
	{
		display: inline;
		margin-left: 0.5em;
	}

	article.footer > ul > li > a
	{
		color: white;
	/*	display: block;
		float: left;		*/
	}

	body
	{
		/*background-color: #ededed;*/
		font-family: "Corbel";
		font-size: 18px;
		margin: 0;
		padding: 0;	
		width: 782px;
		height: 100%;
		min-height: 100%;
	}

	h1, p
	{
		margin: 0;
		padding: 0;
	}
	header
	{		
		position: relative;
		background-color: #2c6494;
		color: white;
		height: 150px;
	}
	header > h1
	{
		font-weight: normal;
		left: 4em;		
		position: absolute;
		top: 1.5em;
	}
	section
	{		
		background-color: #ededed;
		color: #4d4d4d;
		padding-top: 1.2em;
		/*padding-bottom: 12em;*/
		height: auto;
		min-height: 100%;
		/*overflow: auto;*/
		/*position: relative;*/
		/*width: 100%;*/
	}
	
	.logos img
	{
		height: 100px;
		width: 180px;

	}
	</style>
</head>
<body>
	<header>
		<h1>BIENVENIDO A SAVVY SYSTEMS!</h1>
	</header>
	<section>
		<article class="description">
			<p>
				Gracias por crear una cuenta con nosotros, con ella podrás iniciar sesion en nuestro sistema para utilizar todas las aplicaciones que desarrollamos para facilitarte la administración de tu negocio.
			</p>
			<p>
				Ingresa en el sitio de Savvy Systems cualquiera de los siguientes datos seguido de tu contraseña para iniciar sesión.
			</p>
			<p class="datos">
				Tu correo: <b>&lt;email de usuario&gt;</b>
				<br>
				Tu nombre de usuario: <b>&lt;nombre de usuario&gt;</b>	
			</p>
			<a class="button" href="#"><span>ACTIVAR MI CUENTA AHORA</span></a>			
		</article>
		<article class="redirect">
			<p>
				Si el botón no abre una nueva ventana, copie y pegue la siguiente liga en su navegador:
			</p>
			<a href="#">http://savvysystems.com.mx/ejemplo-de-liga/para-confirmar-cuenta</a>
		</article>
		<article class="aplicaciones">			
			<picture>
				<a class="logos" href="#"><img src="http://savvysystems.com.mx/img/header_externo/HEADER%20EXTERNO.%20LOGO%20FACTURAS.png" alt=""></a>
			</picture>
			<picture>
				<a class="logos" href="#"><img src="http://savvysystems.com.mx/img/header_externo/HEADER%20EXTERNO.%20LOGO%20FACTURAS.png" alt=""></a>
			</picture>
			<picture>
				<a class="logos" href="#"><img src="http://savvysystems.com.mx/img/header_externo/HEADER%20EXTERNO.%20LOGO%20FACTURAS.png" alt=""></a>
			</picture>
		</article>
		<article class="footer">
			<ul>
				<li ><a href="">Savvy Systems ©</a></li>
				<li ><a href="">Centro de Ayuda</a></li>
				<li ><a href="">Terminos y Privacidad</a></li>
			</ul>
		</article>
	</section>	
</body>
</html>