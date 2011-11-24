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
    <?php echo $rank; ?>
    <br>
    <?php echo $email; ?>
    <br>
    <?php
        foreach ($interests as $abbr => $title)
            echo '<abbr title="' . $title . '">' . $abbr . '</abbr> ';
    ?>
    <br>
</div>