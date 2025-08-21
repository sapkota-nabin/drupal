<?php if ($can_add): ?>
    <div class="faculty-add">
<!--        --><?php //print $add_link; ?>
        <?php
            print l('Add Faculty', 'admin/itonics-nabin-faculty/add');
        ?>
    </div>
<?php endif; ?>

<table>
    <thead>
    <tr>
        <th><?php print t('Name'); ?></th>
        <th><?php print t('Code'); ?></th>
        <th><?php print t('Students'); ?></th>
        <th><?php print t('Teachers'); ?></th>
        <th><?php print t('Actions'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($rows)): ?>
        <?php foreach ($rows as $i => $row): ?>
            <?php
                if ($i % 2 == 0) {
                    $row_class = "even";
                } else {
                    $row_class = "odd";
                }
            ?>
            <tr class="<?php print $row_class; ?>">
                <td><?php print $row['name']; ?></td>
                <td><?php print $row['code']; ?></td>
                <td><?php print $row['students']; ?></td>
                <td><?php print $row['teachers']; ?></td>
                <td><?php print $row['actions']; ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5"><?php print t('No faculties'); ?></td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php print theme('pager'); ?>
