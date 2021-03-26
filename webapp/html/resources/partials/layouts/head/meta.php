<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<meta name="application-name" content="<?=config('const.title')?>"/>
<meta property="og:site_name" content="<?=config('const.title')?>" />
<meta property="og:locale" content="ja_JP" />
<meta property="og:url" content="https://<?=$_SERVER['SERVER_NAME']?>" />
<meta property="og:title" content="<?=config('const.title')?>" />
<meta property="og:type" content="website">
<meta property="og:description" content="<?=config('const.description')?>" />
<meta property="og:image" content="<?=config('const.og_image')?>" />
<meta name="twitter:site" content="@s_yqual" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="<?=config('const.title')?>" />
<meta name="twitter:url" content="https://twitter.com/s_yqual" />
<meta name="twitter:description" content="<?=config('const.description')?>" />
<meta name="twitter:image" content="<?=config('const.og_image')?>" />
<meta name="page-id" content="<?=getPageName()?>">
<?php if(http_response_code() === 404): ?>
    <meta name="robots" content="noindex , nofollow" />
<?php endif; ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-152719184-3"></script>
<?php if(@$_SERVER['SERVER_NAME'] === 'php-pokemon.s-yqual.com'): ?>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-152719184-3');</script>
<?php endif; ?>
<title><?=config('const.title')?></title>
