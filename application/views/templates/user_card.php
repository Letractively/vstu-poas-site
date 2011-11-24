<div class="usercard">
    <?php
        $surname = 'Васин';
        $name = 'Вася';
        $patronimyc = 'Васевич';
        $rank = 'д.т.н.';
        $email = '<a href=mailto:e-mail@mail.e>e-mail@mail.e</a>';
        $interests = array('Android' => 'Программирования под Android', 'AI' => 'Artificial Intelligence');
        $src = '/images/site/nophoto.jpg'
    ?>
    <div class="userphoto">
        <img src="<?php echo $src?>">
    </div>
    <p class="fio"><?php echo $surname . ' ' . $name . ' ' . $patronimyc; ?></p>
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