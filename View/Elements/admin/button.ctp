<?php

/**
 * Output button
 *
 * Options:
 * - label (required)
 * - icon (optional, string). If specified, button will have icon. Default: none
 * - url (optional, string). If specified, output link instead of button
 * - div (optional, boolean). If false and type is button, don't include div
 * - compact (optional, boolean). If true, output compact button
 * - ajax (optional, boolean). If true, add ajax class
 * - class (optional, string). Additional classes
 */

$compact = isset($compact) ? $compact : false;
$div = isset($div) ? $div : true;
$is_link = !empty($url);
$has_icon = !empty($icon);
$ajax = isset($ajax) ? $ajax : false;

$options = [];

$options['class'] = 'btn';

if (!empty($class)) {
	$options['class'] .= ' '.$class;
}

if ($compact) {
	$options['class'] .= ' btn-compact';
}

if ($ajax) {
	$options['class'] .= ' js-ajax';
}

if ($has_icon) {
	$label = '<span class="fa fa-'.$icon.'"></span> '.$label;
	$options['class'] .= ' btn-w-icon';
	$options['escape'] = false;
}

if ($is_link) {
	$options['escape'] = false;
} else {
	$options['type'] = 'button';
	$options['label'] = false;
	$options['div'] = $div;
}

if ($is_link) {
	echo $this->Html->link($label, $url, $options);
} else {
	echo $this->Form->input($label, $options);
}

?>
