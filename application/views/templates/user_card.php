<div class="usercard">
    <?php
        if (isset($email) && $email != '')
            $email = '<a href=mailto:'.$email.'>'.$email.'</a>';
        if (!isset($interests))
            $interests = array();
        if (!isset($photo) || $photo == '' || $photo == NULL)
            $src = '/images/site/nophoto.jpg';
        else
            $src = '/'.$photo;
    ?>
    <div class="userphoto">
        <?php echo anchor('/users/' . $id, '<img src="' . $src . '">');?>
    </div>
    <p class="fio">
        <?php echo anchor('/users/' . $id, $surname . ' ' . $name . ' ' . $patronymic); ?>
    </p>
    <br>
    <?php if ($rank) echo span($this->lang->line('rank'),'field'). '::' . $rank.br(); ?>
    <?php if ($post) echo span($this->lang->line('post'),'field'). '::' .$post.br(); ?>
    <?php echo $email; ?>
    <br>
    <?php
        if (count($interests) > 0)
        {
            echo span($this->lang->line('interests'),'field');
            echo '::';
            $imploding = array();
            foreach ($interests as $abbr => $title)
                $imploding[] = '<abbr title="' . $title . '">' . $abbr . '</abbr> ';
            $result = implode(', ', $imploding);
            echo $result;
        }
    ?>
    <br>
</div>