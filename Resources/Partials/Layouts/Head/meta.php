<?php
$site_title = 'PHPポケモン';
$description = 'WEBブラウザで遊べる「PHPポケモン」。PHPやJavaScriptなどWEBプログラミングの技術を使ってどうやればゲームが作れるのか。プログラミング学習素材としてぜひプレイしてみてください。それではPHPポケモンの世界へレッツゴー！';
?>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<meta name="application-name" content="<?=$site_title?>"/>
<meta property="og:site_name" content="<?=$site_title?>" />
<meta property="og:locale" content="ja_JP" />
<meta property="og:url" content="https://php-pokemon.s-yqual.com" />
<meta property="og:title" content="<?=$site_title?>" />
<meta property="og:type" content="website">
<meta property="og:description" content="<?=$description?>" />
<meta property="og:image" content="https://php-pokemon.s-yqual.com/Assets/img/thumbnail.jpg" />
<meta name="twitter:site" content="@s_yqual" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="<?=$site_title?>" />
<meta name="twitter:url" content="https://twitter.com/s_yqual" />
<meta name="twitter:description" content="<?=$description?>" />
<meta name="twitter:image" content="https://php-pokemon.s-yqual.com/Assets/img/thumbnail.jpg" />
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-152719184-3"></script>
<?php if(@$_SERVER['SERVER_NAME'] === 'php-pokemon.s-yqual.com'): ?>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-152719184-3');</script>
<?php endif; ?>
<title><?=$site_title?></title>
