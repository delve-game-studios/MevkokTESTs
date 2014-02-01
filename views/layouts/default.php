<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://www.facebook.com/2008/fbml"
      xmlns:og="http://opengraphprotocol.org/schema/"
      xml:lang="en" 
      lang="<?php echo 'bg';?>" 
      itemscope itemtype="http://schema.org/Website">
    <head>
	<title><?php echo $this->title;?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="author" content="158ltd"/>
        
        <meta content="<?php echo $this->description;?>" name="description"/>
        
        <meta content="<?php echo $this->keywords;?>" name="keywords"/>
        
        <meta itemprop="name" content="<?php echo $this->title;?>"/>
        <meta itemprop="description" content="<?php echo $this->description;?>"/>
        <meta content="yes" name="allow-search"/>
        <meta content="all" name="audience"/>
        <meta content="" name="Generator"/>
        <meta content="en" name="Language"/>

        <meta content="global" name="distribution"/>
        <meta content="index, follow, all" name="robots"/>
        <meta content="index, follow, all" name="GOOGLEBOT"/>
        <meta content="7 days" name="revisit-after"/>
        
         <!-- Dublin core -->
        <meta name="DC.title" content="<?php $this->title;?>"/>
        <meta name="DC.description" content="<?php $this->description;?>" />
        <meta name="DC.subject" content="web page subject"/>
        <meta name="DC.creator" content="158 ltd."/>

        <meta name="DC.publisher" content="Azaret Framework">
        <meta name="DC.contributor" content="Developer Date">
        <meta name="DC.date" content="Example : 2011-06-01">
        <meta name="DC.format" content="text/html">
        <meta name="DC.identifier" content="158">
        <meta name="DC.source" content="text/html">
        <meta name="DC.type" content="Text">
        <meta name="DC.language" content="bg">
        <meta name="DC.coverage.placeName" content = "Bulgaria">
        <meta name="DC.rights" content="All rights reserved">
        <!-- END Dublin Core -->
        <link rel="stylesheet" href="<?= routeTo('/public/css/style.css') ?>">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    </head>
    <body>
        <?php
        if(isset($_SESSION['faction'], $_SESSION['user']) && $_SESSION['faction'] == 'ShadowBuilders' && (isset($_REQUEST['page']) && $_REQUEST['page'] == 'downloads')){
            $this->renderPartial('/pages/SlideMenu/index.php');
        }
        ?>
        <?= $this->content ?>
    </body>
</html>