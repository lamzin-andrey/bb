<?php messages_ext($handler) ?>

<div id="mainsfrormadd">
	<div id="add_legend">Добавить свое объявление</div>
	<hr id="add_hr">
	<form method="POST" action="<?=WEB_ROOT?>/podat_obyavlenie">
		
		<fieldset>
			<legend><?=$lang['Select_a_category']?></legend>
			<?=$handler->category_select->block()?>
		</fieldset>
		<fieldset>
			<legend><?=$lang['Select_a_location']?></legend>
			<?=$handler->location_inputs->block()?>
		</fieldset>
		
		
		<p class="adtitle">
				<?=FV::labinp("title", "Заголовок объявления *", $handler->title);?>
			</p>
			<p class="add_text">
				<label for="addtext">Текст объявления <span class="red">*</span></label>
				<textarea id="addtext" name="addtext" rows="16" style="width:100%" rel="afctrl" maxlength="1000"><?=$handler->addtext?></textarea>
				<span class="right praf" id="afctrl">955 / 1000</span>
			</p>
			<p class="price">
					<?=FV::labinp("price", "Стоимость", $handler->price, 0, 'number');?>
				</p>
			<p class="image ">
				<img src="<?=($handler->image ? $handler->image : '/img/std/gazel.jpg') ?>" class="ii" id="imgview"/> <label for="image">Загрузите изображение</label><br/>
				<table>
					<tr>
						<td>
							<input type="file" id="image" name="image" style="width:173px"/>
						</td>
						<td>
							<img src="/images/l-w.gif" id="upLdr" class="hide"/>
						</td>
					</tr>
				</table>
				<input type="hidden" id="ipath" name="ipath" value="<?=$handler->image ?>"/>
			</p>
			<div class="clearfix"></div>
			<p class="adname">
				<?=FV::labinp("name", "Введите ваше имя или название компании *", $handler->name, 0, 0, $handler->authorized);?>
			</p>
			
			<p class="adphone">
				<?=FV::labinp("phone", "Введите ваш телефон *", $handler->phone, 0, 0, $handler->authorized);?>
			</p>
			<?php if (!$handler->authorized) {?>
			<div id="grb">
				<p class="register">Если хотите иметь возможность редактировать объявление, введите пароль
				<br/>Адрес электронной почты понадобится вам, если вы его забудете.</p>
				<p class="pwdmail">
					<?=FV::labinp("pwd", "Пароль *", '', 0, 1);?>
				</p>
				<p class="pwdmail">
					<?=FV::labinp("email", "Email *", $handler->email);?>
				</p>
			</div>
			<? } ?>
			
			<div class="clearfix"></div>
			
			<div class="left">
				<table class="capthtabl">
						<tr>
							<td> <img src="/img/random" width="174"id="cpi" /><br><a href="#" class="smbr" id="smbr">Кликните для обновления рисунка</a> </td>
							<td>
								<label for="cp">Введите текст <span class="red">*</span></label><br>
								<?=FV::i("cp", '')?>
							</td>
						</tr>
				</table>
			</div>
			
			<div class="right prmf">
				<input type="submit" value="Подать объявление" id="addsubmit" />
				<?=csrf()?>
			</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
	</form>
</div>
