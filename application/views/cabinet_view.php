<div class="personal-cabinet">
    <form action="/cabinet/update" class="profile">

        <div class="photo">
            <? if(!isset($user->photo)) $user->photo = NOPHOTO;?>
            <img id ="user-photo" src="<?=$user->photo?>"/>
            <br>
            <a href="javascript:void(0)" id="change-photo" onclick="loadUserPhoto()"><?=$this->lang->line('change_photo')?></a>
        </div>
        <br>

        <label for="surname"><?=$this->lang->line('surname')?></label>
        <input type="text" name="surname" value="<?=$user->surname?>"/>
        <br>

        <label for="name"><?=$this->lang->line('name')?></label>
        <input type="text" name="name" value="<?=$user->name?>"/>
        <br>

        <label for="patronymic"><?=$this->lang->line('patronymic')?></label>
        <input type="text" name="patronymic" value="<?=$user->patronymic?>"/>
        <br>
        <br>

        <label for="username"><?=$this->lang->line('login')?></label>
        <input type="text" name="username" value="<?=$user->username?>"/>
        <br>
        <br>

        <label for="email"><?=$this->lang->line('email')?></label>
        <input type="text" name="email" value="<?=$user->email?>"/>
        <br>

        <label for="cabinet"><?=$this->lang->line('cabinet')?></label>
        <input type="text" name="cabinet" value="<?=$user->cabinet?>"/>
        <br>

        <label for="skype">Skype</label>
        <input type="text" name="skype" value="<?=$user->skype?>"/>
        <br>

        <label for="url"><?=$this->lang->line('user_url')?></label>
        <input type="text" name="url" value="<?=$user->url?>"/>
        <br>

        <input type="hidden" value="<?=$user->id?>"/>
        <input type="submit" value="<?=$this->lang->line('send')?>"/>
    </form>
</div>