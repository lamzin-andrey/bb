<?php
	$links = array(
		'/'  => 'Main_page',
		WEB_ROOT . '/podat_obyavlenie' => 'podat_obyavlenie',
		'current_task' => 'js_link'
	);
?>
<?php if(sess('uid')):?>
<?php
	$links = array(
		'/'  => 'Main_page',
		WEB_ROOT . '/cabinet' => 'my_advert'
	);
?>
<ul class="inline left">
	<? foreach ($links as $link => $langkey): ?>
<?php if ('/' . $app->base_url != $link):?>
	<?php if ($link != 'current_task'):?>
		<li><a href="<?=$link?>" <?if ($link == '#'):?>onclick="alert('In process...'); return false;"<? endif?>><?=$lang[$langkey]?></a></li>
	<?php else:?>
		<li><a href="#" onclick="alert('Hello js'); return false;"><?=$lang[$langkey]?></a></li>
	<?endif?>
<?php endif ?>
<?php endforeach ?>
</ul>
<div class="right">
	<ul class="inline">
		<li><?=$app->user_name?> <?=$app->user_surname ?></li>
		<li><a href="<?=WEB_ROOT?>/login?action=logout"><?=$lang['Exit']?></a></li>
	</ul>
</div>
<div class="clearfix"></div>
<? else: ?>
<ul class="inline left">
<? foreach ($links as $link => $langkey): ?>
<? if ('/' . $app->base_url != $link):?>
	<? if ($link != 'current_task'):?>
		<li><a href="<?=$link?>" <?if ($link == '#'):?>onclick="alert('In process...'); return false;"<? endif?>><?=$lang[$langkey]?></a></li>
	<?else:?>
		<li><a href="#" onclick="alert('Hello js'); return false;"><?=$lang[$langkey]?></a></li>
	<?endif?>
<? endif?>
<? endforeach?>
</ul>
<div class="right">
	<ul class="inline">
		<li><a href="javascript:;" id="regLink"><?=$lang['SignUp']?></a></li>
		<li><a href="<?=WEB_ROOT?>/signin" id="bSignin"><?=$lang['SignIn']?></a></li>
	</ul>
</div>
<div class="clearfix"></div>
<? endif?>
