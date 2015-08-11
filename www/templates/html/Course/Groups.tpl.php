<?php
/* @var $context UNL_UndergraduateBulletin_Listing */
$groups = $context->getCourseGroups();
$groupCount = count($groups);
?>
<?php if ($groupCount): ?>
   <tr class="groups">
       <td class="label">Groups:</td>
       <td class="value">
        <?php foreach ($groups as $i => $group): ?>
        	<?php echo $group ?><?php if (++$i < $groupCount): ?>, <?php endif; ?>
    	<?php endforeach;?>
       </td>
   </tr>
<?php endif; ?>
