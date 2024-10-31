<div class="wrap">
<h2>Q2W3 Thickbox</h2>

<form method="post" action="options.php">

<?php 
settings_fields(self::ID);

$options = get_option(self::ID);
?>

<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('jQuery code for setting "thickbox" class', self::ID)?> (<a class="tooltip" rel="<?php _e('Required for thickbox pop-up window functionality.', self::ID)?>">?</a>)</th>
<td><textarea name="<?php echo self::ID.'[class_setter]'?>" style="width: 350px; height: 120px;"><?php echo $options['class_setter'] ?></textarea>
<input type="button" class="button-primary" value="<?php _e('Default') ?>" id="restore1" /></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('jQuery code for setting "title" attribute ', self::ID)?> (<a class="tooltip" rel="<?php _e('Required for pop-up window comment. By default title equals image alt attribute.', self::ID)?>">?</a>)</th>
<td><textarea name="<?php echo self::ID.'[title_setter]'?>" style="width: 350px; height: 120px;"><?php echo $options['title_setter'] ?></textarea>
<input type="button" class="button-primary" value="<?php _e('Default') ?>" id="restore2" /></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('jQuery code for setting "rel" attribute', self::ID)?> (<a class="tooltip" rel="<?php _e('Required for naviagation links between images in gallery.', self::ID)?>">?</a>)</th>
<td><textarea name="<?php echo self::ID.'[gallery_setter]'?>" style="width: 350px; height: 120px;"><?php echo $options['gallery_setter'] ?></textarea>
<input type="button" class="button-primary" value="<?php _e('Default') ?>" id="restore3" /></td>
</tr>

</table>

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>

<script type="text/javascript">

jQuery("#restore1").bind("click", function default_class_setter() {

	jQuery("textarea[name='<?php echo self::ID.'[class_setter]'?>']").html('<?php echo self::CLASS_SETTER?>');

});

jQuery("#restore2").bind("click", function default_title_setter() {

	jQuery("textarea[name='<?php echo self::ID.'[title_setter]'?>']").html('<?php echo self::TITLE_SETTER?>');

});

jQuery("#restore3").bind("click", function default_gallery_setter() {

	jQuery("textarea[name='<?php echo self::ID.'[gallery_setter]'?>']").html('<?php echo self::GALLERY_SETTER?>');

});

</script>

<h2><?php _e('Notes')?></h2>

<ol>

<li><?php _e('Wordpress uses jQuery in', self::ID)?> <a href="http://docs.jquery.com/Using_jQuery_with_Other_Libraries#General" target="_blanc"><?php _e('no conflict mode', self::ID)?></a>. <?php _e('Standart function "$()" must be replaced by "jQuery()"', self::ID)?></li>

<li><?php _e("If you want to disable automatic class/attribute setters, just delete all corresponding jQuery code. In this case you'll be able to add classes and attributes manually in the post editor", self::ID)?></li>

<li><?php _e('Use "Default" button to restore initial jQuery code', self::ID)?></li>

<li><?php _e('Standard Wordpress gallery shortcode ([gallery]) should be used with the "link="file" option. Example: [gallery link="file"]', self::ID)?></li>

<li><a href="http://www.q2w3.ru/2009/11/29/748/" target="_blanc"><?php _e('Q2W3 Thickbox plugin homepage', self::ID)?></a></li>

</ol>

</div>