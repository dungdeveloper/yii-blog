<div id="tagCloud">
    <ul>
        <?php foreach ($tags as $t): ?>
            <li><?php 
                $name = $t->name.' ('.$t->frequency.')';
                echo CHtml::link($name, array('', 'tag'=>$t->name));
            ?></li>
        <?php endforeach; ?>
    </ul>
</div>