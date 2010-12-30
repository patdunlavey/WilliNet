<?php
// $ID:  $
/**
 * @file
 *   Test imagecache preset.
 * 
 * Created on Dec 29, 2009
 *
 * @author 'dman' Dan Morrison http://coders.co.nz/
 */

$presets['cheap_dropshadow'] = array (
  'presetname' => 'cheap_dropshadow',
  '#weight' => '3.3',
  'actions' => 
  array (
    0 => 
    array (
      'weight' => '-10',
      'module' => 'imagecache_canvasactions',
      'action' => 'canvasactions_definecanvas',
      'data' => 
      array (
        'RGB' => 
        array (
          'HEX' => '999999',
        ),
        'under' => 0,
        'exact' => 
        array (
          'width' => '',
          'height' => '',
          'xpos' => 'center',
          'ypos' => 'center',
        ),
        'relative' => 
        array (
          'leftdiff' => '0',
          'rightdiff' => '0',
          'topdiff' => '0',
          'bottomdiff' => '0',
        ),
      ),
    ),
    1 => 
    array (
      'weight' => '-9',
      'module' => 'imagecache_canvasactions',
      'action' => 'canvasactions_definecanvas',
      'data' => 
      array (
        'RGB' => 
        array (
          'HEX' => '',
        ),
        'under' => 1,
        'exact' => 
        array (
          'width' => '',
          'height' => '',
          'xpos' => 'center',
          'ypos' => 'center',
        ),
        'relative' => 
        array (
          'leftdiff' => '20',
          'rightdiff' => '0',
          'topdiff' => '20',
          'bottomdiff' => '0',
        ),
      ),
    ),
    2 => 
    array (
      'weight' => '-8',
      'module' => 'imagecache_canvasactions',
      'action' => 'canvasactions_source2canvas',
      'data' => 
      array (
        'xpos' => 0,
        'ypos' => 0,
        'alpha' => '100',
      ),
    ),
    3 => 
    array (
      'weight' => '-7',
      'module' => 'imagecache',
      'action' => 'imagecache_scale',
      'data' => 
      array (
        'width' => '200',
        'height' => '100%',
        'upscale' => 0,
      ),
    ),
  ),
);