<div class="personal-cabinet">
    <form action="/cabinet/update" class="profile" method="post">

        <div class="me-link">
            <?=anchor('/users/'.$user->id, $this->lang->line('me_on_users_page'))?>
        </div>
        <div class="cabinet-message">
            <?=$this->session->flashdata('cabinet_message')?>
        </div>
        <div class="photo">
            <? if(!isset($user->photo)) $user->photo = NOPHOTO;?>
            <img id ="user-photo" src="../<?=$user->photo?>"/>
            <br>
            <a href="javascript:void(0)" id="change-photo" onclick="loadUserPhoto()"><?=$this->lang->line('change_photo')?></a>
        </div>
        <br>

        <div>
            <label for="surname"><?=$this->lang->line('surname')?></label>
            <input type="text" name="surname" value="<?=set_value('surname', $user->surname)?>" maxlength="30"/>
            <?=form_error('surname');?>
        </div>

        <div>
            <label for="name"><?=$this->lang->line('name')?></label>
            <input type="text" name="name" value="<?=set_value('name', $user->name)?>" maxlength="30"/>
            <?=form_error('name');?>
        </div>

        <div>
            <label for="patronymic"><?=$this->lang->line('patronymic')?></label>
            <input type="text" name="patronymic" value="<?=set_value('patronymic', $user->patronymic)?>" maxlength="30"/>
            <?=form_error('patronymic');?>
        </div>

        <br>

        <div>
            <label for="email"><?=$this->lang->line('email')?></label>
            <input type="text" name="email" value="<?=set_value('email', $user->email)?>" class="long"/>
            <?=form_error('email');?>
        </div>

        <input type="hidden" name="id" value="<?=$user->id?>"/>
        <input type="submit" value="<?=$this->lang->line('send')?>"/>
    </form>
</div>