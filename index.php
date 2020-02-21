<?php

# ORIGINAL: https://github.com/miglen/uagent/blob/master/uagent.php
class UAgent
{
	const MOZILLA = 'Mozilla/5.0 ';

	public static $processors = [
		'lin' => ['i686', 'x86_64'],
		'mac' => ['Intel', 'PPC', 'U; Intel', 'U; PPC'],
		'win' => ['foo']
	];

	public static $browsers = [
		34 => [
			89 => ['chrome', 'win'],
			9  => ['chrome', 'mac'],
			2  => ['chrome', 'lin']
		],
		32 => [
			100 => ['iexplorer', 'win']
		],
		25 => [
			83 => ['firefox', 'win'],
			16 => ['firefox', 'mac'],
			1  => ['firefox', 'lin']
		],
		7 => [
			95 => ['safari', 'mac'],
			4  => ['safari', 'win'],
			1  => ['safari', 'lin']
		],
		2 => [
			91 => ['opera', 'win'],
			6  => ['opera', 'lin'],
			3  => ['opera', 'mac']
		]
	];

	public static $languages = [
		'af-ZA', 'ar-AE', 'ar-BH', 'ar-DZ', 'ar-EG', 'ar-IQ', 'ar-JO', 'ar-KW', 'ar-LB',
		'ar-LY', 'ar-MA', 'ar-OM', 'ar-QA', 'ar-SA', 'ar-SY', 'ar-TN', 'ar-YE', 'be-BY',
		'bg-BG', 'ca-ES', 'cs-CZ', 'Cy-az-AZ', 'Cy-sr-SP', 'Cy-uz-UZ', 'da-DK', 'de-AT',
		'de-CH', 'de-DE', 'de-LI', 'de-LU', 'div-MV', 'el-GR', 'en-AU', 'en-BZ', 'en-CA', 
		'en-CB', 'en-GB', 'en-IE', 'en-JM', 'en-NZ', 'en-PH', 'en-TT', 'en-US', 'en-ZA', 
		'en-ZW', 'es-AR', 'es-BO', 'es-CL', 'es-CO',  'es-CR', 'es-DO', 'es-EC', 'es-ES',
		'es-GT', 'es-HN', 'es-MX', 'es-NI', 'es-PA', 'es-PE', 'es-PR', 'es-PY', 'es-SV',
		'es-UY', 'es-VE', 'et-EE', 'eu-ES', 'fa-IR', 'fi-FI', 'fo-FO', 'fr-BE', 'fr-CA',
		'fr-CH', 'fr-FR', 'fr-LU', 'fr-MC', 'gl-ES', 'gu-IN', 'he-IL', 'hi-IN', 'hr-HR', 
		'hu-HU', 'hy-AM', 'id-ID', 'is-IS', 'it-CH', 'it-IT', 'ja-JP', 'ka-GE', 'kk-KZ',
		'kn-IN', 'kok-IN', 'ko-KR', 'ky-KZ', 'Lt-az-AZ', 'lt-LT', 'Lt-sr-SP', 'Lt-uz-UZ', 
		'lv-LV', 'mk-MK', 'mn-MN', 'mr-IN', 'ms-BN', 'ms-MY', 'nb-NO', 'nl-BE', 'nl-NL', 
		'nn-NO', 'pa-IN', 'pl-PL', 'pt-BR', 'pt-PT', 'ro-RO', 'ru-RU', 'sa-IN', 'sk-SK', 
		'sl-SI', 'sq-AL', 'sv-FI', 'sv-SE', 'sw-KE', 'syr-SY', 'ta-IN', 'te-IN', 'th-TH', 
		'tr-TR', 'tt-RU', 'uk-UA', 'ur-PK', 'vi-VN', 'zh-CHS', 'zh-CHT', 'zh-CN', 'zh-HK', 
		'zh-MO', 'zh-SG', 'zh-TW',   
	];	

	public static function generate_platform(){
		$rand = mt_rand(1, 100);
		$sum = 0;

		foreach (self::$browsers as $share => $freq_os){
			$sum += $share;

			if ($rand <= $sum){
				$rand = mt_rand(1, 100);
				$sum = 0;

				foreach ($freq_os as $share => $choice){
					$sum += $share;
					if ($rand <= $sum){
						return $choice;
					}
				}
			}
		}

		throw new Exception('Sum of $browsers frequency is not 100.');
	}

	private static function array_random($array){
		$i = array_rand($array, 1);
		return $array[$i];
	}

	private static function get_language($lang=[]){
		return self::array_random(empty($lang) ? self::$languages : $lang);
	}

	private static function get_processor($os){
		return self::array_random(self::$processors[$os]);
	}

	private static function get_version_nt(){   
		# Win2k (5.0) to Win 7 (6.1).
		return mt_rand(5, 6).'.'.mt_rand(0, 1);
	}

	private static function get_version_osx(){
		return '10_'.mt_rand(5, 7).'_'.mt_rand(0, 9);
	}

	private static function get_version_webkit(){
		return mt_rand(531, 536).mt_rand(0, 2);
	}

	private static function get_verison_chrome(){
		return mt_rand(13, 15).'.0.'.mt_rand(800, 899).'.0';
	}

	private static function get_version_gecko(){
		return mt_rand(17, 31).'.0';
	}

	private static function get_version_ie(){
		return mt_rand(7, 9).'.0';
	}

	private static function get_version_trident(){
		return mt_rand(4, 7).'.0';
	}

	private static function get_version_net(){
		$frameworks = [
			'2.0.50727',
			'3.0.4506',
			'3.5.30729',
		];
		$rev = '.'.mt_rand(26, 648);
		return self::array_random($frameworks).$rev;
	}

	private static function get_version_safari(){
		if (mt_rand(0, 1) == 0){
			$ver = mt_rand(4, 5).'.'.mt_rand(0, 1);
		}else{
			$ver = mt_rand(4, 5).'.0.'.mt_rand(1, 5);
		}
		return $ver;
	}

	private static function get_version_opera(){
		return mt_rand(15, 19).'.0.'.mt_rand(1147, 1284).mt_rand(49, 100);
	}

	public static function opera($arch){
		$opera = ' OPR/'.self::get_version_opera();

		$engine = self::get_version_webkit();
		$webkit = ' AppleWebKit/'.$engine.' (KHTML, like Gecko)';
		$chrome = ' Chrome/'.self::get_verison_chrome();
		$safari = ' Safari/'.$engine;

		switch ($arch){
			case 'lin':
				return '(X11; Linux {proc}) '.$webkit.$chrome.$safari.$opera;
			case 'mac':
				$osx = self::get_version_osx();
				return '(Macintosh; U; {proc} Mac OS X '.$osx.')'.$webkit.$chrome.$safari.$opera;
			case 'win':
				# fall through.
			default:
				$nt = self::get_version_nt();
				return '(Windows NT '.$nt.'; WOW64) '.$webkit.$chrome.$safari.$opera;
		}
	}	

	public static function safari($arch){
		$version = ' Version/'.self::get_version_safari();

		$engine = self::get_version_webkit();
		$webkit = ' AppleWebKit/'.$engine.' (KHTML, like Gecko)';
		$safari = ' Safari/'.$engine;

		switch ($arch){
			case 'mac':
				$osx = self::get_version_osx();
				return '(Macintosh; U; {proc} Mac OS X '.$osx.'; {lang})'.$webkit.$version.$safari;
			case 'win':
				# fall through.
			default:
				$nt = self::get_version_nt();
				return '(Windows; U; Windows NT '.$nt.')'.$webkit.$version.$safari;
		}

	}

	public static function iexplorer($arch){
		$nt = self::get_version_nt();
		$ie = self::get_version_ie();
		$trident = self::get_version_trident();
		$net = self::get_version_net();

		return '(compatible' 
			. '; MSIE '.$ie 
			. '; Windows NT '.$nt 
			. '; WOW64'
			. '; Trident/'.$trident 
			. '; .NET CLR '.$net
			. ')';
	}

	public static function firefox($arch){
		$gecko = self::get_version_gecko();

		$trail = '20100101';

		$release = 'rv:'.$gecko;
		$version = 'Gecko/'.$trail.' Firefox/'.$gecko;

		switch ($arch){
			case 'lin':
				return '(X11; Linux {proc}; '.$release . ') '.$version;
			case 'mac':
				$osx = self::get_version_osx();
				return '(Macintosh; {proc} Mac OS X '.$osx.'; '.$release.') '.$version;
			case 'win':
				# fall through.
			default:
				$nt = self::get_version_nt();
				return '(Windows NT '.$nt.'; {lang}; '.$release . ') '.$version;
		}
	}

	public static function chrome($arch){
		$chrome = ' Chrome/'.self::get_verison_chrome();

		$engine = self::get_version_webkit();
		$webkit = ' AppleWebKit/' . $engine . ' (KHTML, like Gecko)';
		$safari = ' Safari/' . $engine;

		switch ($arch){
			case 'lin':
				return '(X11; Linux {proc}) '.$webkit.$chrome.$safari;
			case 'mac':
				$osx = self::get_version_osx();
				return '(Macintosh; U; {proc} Mac OS X '.$osx.')'.$webkit.$chrome.$safari;
			case 'win':
				# fall through.
			default:
				$nt = self::get_version_nt();
				return '(Windows NT '.$nt.') '.$webkit.$chrome.$safari;
		}
	}

	public static function random($lang=['en-US']){
		list($browser, $os) = self::generate_platform();
		return self::generate($browser, $os, $lang);
	}

	public static function generate($browser='chrome', $os='win', $lang=['en-US']){
		$ua = self::MOZILLA. self::{$browser}($os);

		$tags = [
			'{proc}' => self::get_processor($os),
			'{lang}' => self::get_language($lang),
		];

		$ua = str_replace(array_keys($tags), array_values($tags), $ua);
		return $ua;
	}
}

function curl($options=[]){
	if(!is_array($options))
		$options = ['url' => $options];
	if (!isset($options['url']))
		throw new  HolisticException('CURL options need URL parameter.');
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $options['url']);
	if (isset($options['header']) && $options['header'])
		curl_setopt($ch, CURLOPT_HEADER, 1);
	#if (isset($options['headers']) && is_array($options['headers']))
		#curl_setopt($ch, CURLOPT_HTTPHEADER, $options['headers']);
	#"Cache-Control: max-age=604800"
	$ip = '143.54.'.mt_rand(0,255).'.'.mt_rand(0,255);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge([
		"Accept-Language: ".(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? explode(';',$_SERVER['HTTP_ACCEPT_LANGUAGE'])[0] : 'pt-BR,pt'),
		#"Accept-Language: ".explode(',',explode(';',$_SERVER['HTTP_ACCEPT_LANGUAGE'])[0])[0],
		"REMOTE_ADDR: $ip",
		"HTTP_X_FORWARDED_FOR: $ip",
		"X-Forwarded-For: $ip",
		/*"HTTP_CLIENT_IP: $ip",
		"CLIENT_IP: $ip",
		"HTTP_CF_CONNECTING_IP: $ip"
		"CF_CONNECTING_IP: $ip"*/
	], isset($options['headers']) && is_array($options['headers']) ? $options['headers'] : []));
	#curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	#curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/".rand(3,5).".".rand(0,3)." (Windows NT ".rand(3,5).".".rand(0,2)."; rv:2.0.1) Gecko/20100101 Firefox/".rand(3,5).".0.1");
	curl_setopt($ch, CURLOPT_USERAGENT, UAgent::random());
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_COOKIESESSION, false);
	#curl_setopt($ch, CURLOPT_COOKIEJAR, 'curl_cookie.txt');
	#curl_setopt($ch, CURLOPT_COOKIEFILE, 'curl_cookie.txt');
	if (isset($options['referrer']))
		curl_setopt($ch, CURLOPT_REFERER, $options['referrer']);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	if (isset($options['method'],$options['data']) && $options['method'] == 'POST'){
		curl_setopt($ch, CURLOPT_POST, 1);				 
		curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($options['data']) ? http_build_query($options['data']) : $options['data']);
	}
	$data = curl_exec($ch);
	curl_close($ch);
	if (isset($options['type']) && $options['type'] == 'json'){
		return json_decode($data,true);
	}else{
		return $data;
	}
}

function uri(){
	if(!isset($_SERVER['REQUEST_URI'],$_SERVER['SCRIPT_NAME'])) return false;
	$u = $_SERVER['REQUEST_URI'];
	if(strpos($u,$_SERVER['SCRIPT_NAME']) === 0) $u = substr($u,strlen($_SERVER['SCRIPT_NAME']));
	elseif(strpos($u,dirname($_SERVER['SCRIPT_NAME'])) === 0) $u = substr($u,strlen(dirname($_SERVER['SCRIPT_NAME'])));
	if(strncmp($u,'?/',2) === 0) $u = substr($u,2);
	return ltrim($u,'/');
}

if(strlen($url = substr(uri(), 1)) > 0){
	if(filter_var($url, FILTER_VALIDATE_URL)){
		echo curl(['url'=>$url]);
	}else{
		if(substr(php_sapi_name(), 0, 3) == 'cgi'){
			header("Status: 404 Not Found");
		}else{
			header("HTTP/1.1 404 Not Found");
		}
		echo "Error: URL invalid.";
	}
	die;
}

define('URL', 'http'.(isset($_SERVER['HTTPS'])?'s':'').'://'.rtrim($_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']), '/\\').'/');
?>

<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="UTF-8" />
	<title>Cors42</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Pull contents from any page via API (as JSON/P or raw) and avoid Same-origin policy problems.">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/combine/gh/highlightjs/cdn-release@9.13.1/build/styles/default.min.css,npm/bulma@0.4.0/css/bulma.min.css" />
	<style>.button{padding:20px}pre{white-space:pre-wrap}.pre-wrapper{padding-bottom:20px}.header-titles{padding-bottom:50px}.content .main-text p:last-child{padding-bottom:30px}</style>
</head>

<body>
	<div class="hero-head">
		<section class="hero is-dark is-small" id="contact">
			<div class="hero-body">
				<div class="container">
					<div class="header-titles">
						<h3 class="title is-3 is-spaced">Cors42</h3>
						<h5 class="subtitle is-5 is-spaced">Pull contents from any page via API (as JSON/P or raw) and avoid Same-origin policy problems.</h5>
					</div>
					<div class="header-buttons">
						<span class="control"><a class="button is-dark is-inverted is-outlined" href="https://github.com/nicolauns/cors42"><span class="icon"> <i class="fab fa-github"></i> </span><span>Github</span></a></span>
						<span class="control"><a class="button is-dark is-inverted is-outlined" href="https://github.com/nicolauns/cors42/issues"><span class="icon"> <i class="fa fa-bug"></i> </span><span>Report Bug</span></a></span>
					</div>
				</div>
			</div>
		</section>
	</div>
	<div class="content-block">
		<section class="hero">
			<div class="hero-body">
				<div class="container">
					<div class="content">
						<div class="main-text">
							<p>A free and open source <a href="https://web.archive.org/web/20180807170914/http://anyorigin.com/" rel="nofollow">AnyOrigin</a> alternative, inspired by <a href="http://WhateverOrigin.org" rel="nofollow">Whatever Origin</a>.</p>
						</div>
						<h4 class="title is-4 is-spaced">Examples</h4>
						<div class="columns is-multiline">
							<div class="column is-6">
								<div class="pre-wrapper">
									<p>To <code>fetch</code> data from <a href="https://wikipedia.org">http://wikipedia.org</a>:</p>
									<pre><code class="language-js">fetch(<span class="hljs-string">`<?=URL?>?<span class="hljs-subst">${encodeURIComponent('https://wikipedia.org')}</span>`</span>)
					.then(data =&gt; <span class="hljs-built_in">console</span>.log(data));
				  </code></pre>
								</div>
							</div>
							<div class="column is-6">
								<div class="pre-wrapper">
									<p>Or with jQuery</p>
									<pre><code class="language-js">$.getJSON(<span class="hljs-string">'<?=URL?>?'</span> + <span class="hljs-built_in">encodeURIComponent</span>(<span class="hljs-string">'https://wikipedia.org'</span>), <span class="hljs-function"><span class="hljs-keyword">function</span> (<span class="hljs-params">data</span>) </span>{
					  alert(data);
				  });
				  </code></pre>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<hr />
	</div>

	<div class="content-block">
		<section class="hero">
			<div class="hero-body">
				<div class="container">
					<div class="content">
						<h4 class="title is-4">Try it yourself!</h4>
						<div class="main-text">
							<p>
								<form onSubmit="return GoGoGadget();">
									<?=URL?>
									<input class="input" type="text" id="url" value="https://archive.org/" />
									<button class="button is-dark">Fetch</button>
								</form>
								<br>
								<p>Example code</p>
								<p>
									<pre><code class="js" id="jsonp">...</code></pre> </p>
								<p>Example raw output</p>
								<p>
									<textarea id="output-raw" style="width:100%;" rows="4"></textarea>
								</p>
								<p>Example output on iframe</p>
								<p>
									<iframe id="output" style="border:1px solid; width: 100%; height: 250px"></iframe>
								</p>
							</p>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<script>
		function GoGoGadget() {
			var url = document.getElementById('url');
			var jsonp = document.getElementById('jsonp');
			var jsonpText = '';

			jsonpText += "// with fetch\n";
			jsonpText += "fetch(`<?=URL?>?" + url.value + "`).then(data => console.log(data));\n\n";

			jsonpText += "// with JQuery\n";
			jsonpText += "$.getJSON('<?=URL?>?" + url.value + "', function(data){\n";
			jsonpText += "\t$('#output').html(data.contents);\n";
			jsonpText += "});\n";

			jsonp.textContent = jsonpText;
			hljs.highlightBlock(jsonp);

			var xmlhttp = new XMLHttpRequest();

			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var myArr = this.responseText;
					updatePreview(myArr);
				}
			};

			xmlhttp.open('GET', '<?=URL?>?' + url.value, true);
			xmlhttp.send();

			function updatePreview(data) {
				var outputJSON = document.getElementById('output-raw');
				var iframe = document.getElementById('output');
				var doc = iframe.document;

				if (iframe.contentDocument) {
					doc = iframe.contentDocument;
				} else if (iframe.contentWindow) {
					doc = iframe.contentWindow.document;
				}
				doc.open();
				doc.writeln(data);
				doc.close();

				outputJSON.textContent = data;
			}
			return false;
		}
	</script>
	<script defer src="https://use.fontawesome.com/releases/v5.6.3/js/all.js" integrity="sha384-EIHISlAOj4zgYieurP0SdoiBYfGJKkgWedPHH4jCzpCXLmzVsw1ouK59MuUtP4a1" crossorigin="anonymous"></script>
	<script src="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.13.1/build/highlight.min.js"></script>
</body>
</html>
