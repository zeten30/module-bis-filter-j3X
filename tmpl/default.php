<?php
defined('_JEXEC') or die; // no direct access
?>

<noscript>
<p><?php echo JText::_('MOD_BIS_FILTER_ENABLE_JAVASCRIPT'); ?></p>
</noscript>


<?php
$filters_count = count($ordered_filters['filters']);
?>


<div id="mod_bis_filter_tabs" class="<?php echo $css_class; ?>">
  <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="mod-bis-filter-form">

    <?php
    if ($display_style == 'table-vertical' && $filters_count > 0) {
      ?>
      <table>
        <?php
        if ($label_style == 'left') {
          for ($i = 1; $i <= $filters_count; $i++) {
            ?>
            <tr>
              <td><?php echo $ordered_filters['labels'][$i]; ?></td>
              <td><?php echo $ordered_filters['filters'][$i]; ?></td>
            </tr>
            <?php
          }
        } else {
          for ($i = 1; $i <= $filters_count; $i++) {
            ?>
            <tr>
              <td><?php echo $ordered_filters['labels'][$i]; ?></td>
            </tr>
            <tr>
              <td><?php echo $ordered_filters['filters'][$i]; ?></td>
            </tr>
            <?php
          }
        }
        ?>
      </table>
      <?php
    }
    ?>


    <?php
    if ($display_style == 'table-horizontal' && $filters_count > 0) {
      ?>
      <table>
        <?php
        if ($label_style == 'left') {
          ?><tr><?php
            for ($i = 1; $i <= $filters_count; $i++) {
              ?>
              <td><?php echo $ordered_filters['labels'][$i]; ?></td>
              <td><?php echo $ordered_filters['filters'][$i]; ?></td>
              <?php
            }
            ?></tr><?php
        } else {
          ?><tr><?php
              for ($i = 1; $i <= $filters_count; $i++) {
                ?>
              <td><?php echo $ordered_filters['labels'][$i]; ?></td>
              <?php
            }
            ?></tr><?php
            ?><tr><?php
            for ($i = 1; $i <= $filters_count; $i++) {
              ?>
              <td><?php echo $ordered_filters['filters'][$i]; ?></td>
              <?php
            }
            ?></tr><?php
        }
        ?>
      </table>
      <?php
    }
    ?>

    <p class="mod-bis-filter-buttons-submit">
      <input type="submit" name="mod-bis-filter-submit" 
             id="mod-bis-filter-submit" value="<?php echo JText::_('MOD_BIS_FILTER') ?>"/>
    </p>
  </form>

  <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="mod-bis-filter-form-reset"> 
    <p>
      <input type="hidden" name="filter-by-date" id="filter-by-date-reset" value="" />
      <input type="hidden" name="filter-by-date-to" id="filter-by-date-to-reset" value="" />
      <input type="hidden" name="filter-by-organized" id="filter-by-organized-reset" value="" />
      <input type="hidden" name="filter-by-for" id="filter-by-for-reset" value="" />
      <input type="hidden" name="filter-by-type" id="filter-by-type-reset" value="" />
      <input type="hidden" name="filter-by-program" id="filter-by-program-reset" value="" />
      <input type="submit" name="mod-bis-filter-reset" 
             id="mod-bis-filter-reset" value="<?php echo JText::_('MOD_BIS_FILTER_RESET') ?>" />
    </p>
  </form>
</div>


