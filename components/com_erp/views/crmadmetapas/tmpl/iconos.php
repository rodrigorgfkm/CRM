<?php defined('_JEXEC') or die;
if(validaAcceso('CRM Etapas')){
$editor =& JFactory::getEditor();
?>
<div class="modal fade" tabindex="-1" role="dialog" id="fontsaw">
  <div class="modal-dialog modal-primary modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Eleija un Icono</h4>
      </div>
      <div class="modal-body">
          <div class="row fontawesome-icon-list">
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-adjust"></i> fa-adjust</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-anchor"></i> fa-anchor</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-archive"></i> fa-archive</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-area-chart"></i> fa-area-chart</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-arrows"></i> fa-arrows</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-arrows-h"></i> fa-arrows-h</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-arrows-v"></i> fa-arrows-v</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-asterisk"></i> fa-asterisk</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-at"></i> fa-at</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-automobile"></i> fa-automobile
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-balance-scale"></i> fa-balance-scale</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-ban"></i> fa-ban</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-bank"></i> fa-bank 
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-bar-chart"></i> fa-bar-chart</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-bar-chart-o"></i> fa-bar-chart-o
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-barcode"></i> fa-barcode</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-bars"></i> fa-bars</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-battery-0"></i> fa-battery-0
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-battery-1"></i> fa-battery-1
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-battery-2"></i> fa-battery-2
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-battery-3"></i> fa-battery-3
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-battery-4"></i> fa-battery-4
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-battery-empty"></i> fa-battery-empty</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-battery-full"></i> fa-battery-full</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-battery-half"></i> fa-battery-half</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-battery-quarter"></i> fa-battery-quarter</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-battery-three-quarters"></i>
                      fa-battery-three-quarters
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-bed"></i> fa-bed</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-beer"></i> fa-beer</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-bell"></i> fa-bell</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-bell-o"></i> fa-bell-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-bell-slash"></i> fa-bell-slash</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-bell-slash-o"></i> fa-bell-slash-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-bicycle"></i> fa-bicycle</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-binoculars"></i> fa-binoculars</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-birthday-cake"></i> fa-birthday-cake</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-bolt"></i> fa-bolt</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-bomb"></i> fa-bomb</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-book"></i> fa-book</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-bookmark"></i> fa-bookmark</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-bookmark-o"></i> fa-bookmark-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-briefcase"></i> fa-briefcase</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-bug"></i> fa-bug</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-building"></i> fa-building</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-building-o"></i> fa-building-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-bullhorn"></i> fa-bullhorn</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-bullseye"></i> fa-bullseye</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-bus"></i> fa-bus</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-cab"></i> fa-cab 
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-calculator"></i> fa-calculator</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-calendar"></i> fa-calendar</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-calendar-check-o"></i> fa-calendar-check-o
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-calendar-minus-o"></i> fa-calendar-minus-o
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-calendar-o"></i> fa-calendar-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-calendar-plus-o"></i> fa-calendar-plus-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-calendar-times-o"></i> fa-calendar-times-o
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-camera"></i> fa-camera</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-camera-retro"></i> fa-camera-retro</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-car"></i> fa-car</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-caret-square-o-down"></i>
                      fa-caret-square-o-down
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-caret-square-o-left"></i>
                      fa-caret-square-o-left
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-caret-square-o-right"></i>
                      fa-caret-square-o-right
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-caret-square-o-up"></i> fa-caret-square-o-up
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-cart-arrow-down"></i> fa-cart-arrow-down</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-cart-plus"></i> fa-cart-plus</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-cc"></i> fa-cc</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-certificate"></i> fa-certificate</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-check"></i> fa-check</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-check-circle"></i> fa-check-circle</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-check-circle-o"></i> fa-check-circle-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-check-square"></i> fa-check-square</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-check-square-o"></i> fa-check-square-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-child"></i> fa-child</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-circle"></i> fa-circle</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-circle-o"></i> fa-circle-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-circle-o-notch"></i> fa-circle-o-notch</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-circle-thin"></i> fa-circle-thin</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-clock-o"></i> fa-clock-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-clone"></i> fa-clone</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-close"></i> fa-close 
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-cloud"></i> fa-cloud</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-cloud-download"></i> fa-cloud-download</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-cloud-upload"></i> fa-cloud-upload</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-code"></i> fa-code</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-code-fork"></i> fa-code-fork</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-coffee"></i> fa-coffee</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-cog"></i> fa-cog</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-cogs"></i> fa-cogs</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-comment"></i> fa-comment</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-comment-o"></i> fa-comment-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-commenting"></i> fa-commenting</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-commenting-o"></i> fa-commenting-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-comments"></i> fa-comments</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-comments-o"></i> fa-comments-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-compass"></i> fa-compass</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-copyright"></i> fa-copyright</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-creative-commons"></i> fa-creative-commons
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-credit-card"></i> fa-credit-card</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-crop"></i> fa-crop</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-crosshairs"></i> fa-crosshairs</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-cube"></i> fa-cube</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-cubes"></i> fa-cubes</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-cutlery"></i> fa-cutlery</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-dashboard"></i> fa-dashboard
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-database"></i> fa-database</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-desktop"></i> fa-desktop</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-diamond"></i> fa-diamond</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-dot-circle-o"></i> fa-dot-circle-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-download"></i> fa-download</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-edit"></i> fa-edit 
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-ellipsis-h"></i> fa-ellipsis-h</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-ellipsis-v"></i> fa-ellipsis-v</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-envelope"></i> fa-envelope</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-envelope-o"></i> fa-envelope-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-envelope-square"></i> fa-envelope-square</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-eraser"></i> fa-eraser</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-exchange"></i> fa-exchange</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-exclamation"></i> fa-exclamation</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-exclamation-circle"></i> fa-exclamation-circle
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-exclamation-triangle"></i>
                      fa-exclamation-triangle
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-external-link"></i> fa-external-link</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-external-link-square"></i>
                      fa-external-link-square
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-eye"></i> fa-eye</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-eye-slash"></i> fa-eye-slash</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-eyedropper"></i> fa-eyedropper</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-fax"></i> fa-fax</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-feed"></i> fa-feed 
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-female"></i> fa-female</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-fighter-jet"></i> fa-fighter-jet</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-file-archive-o"></i> fa-file-archive-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-file-audio-o"></i> fa-file-audio-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-file-code-o"></i> fa-file-code-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-file-excel-o"></i> fa-file-excel-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-file-image-o"></i> fa-file-image-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-file-movie-o"></i> fa-file-movie-o
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-file-pdf-o"></i> fa-file-pdf-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-file-photo-o"></i> fa-file-photo-o
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-file-picture-o"></i> fa-file-picture-o
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-file-powerpoint-o"></i> fa-file-powerpoint-o
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-file-sound-o"></i> fa-file-sound-o
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-file-video-o"></i> fa-file-video-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-file-word-o"></i> fa-file-word-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-file-zip-o"></i> fa-file-zip-o
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-film"></i> fa-film</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-filter"></i> fa-filter</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-fire"></i> fa-fire</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-fire-extinguisher"></i> fa-fire-extinguisher
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-flag"></i> fa-flag</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-flag-checkered"></i> fa-flag-checkered</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-flag-o"></i> fa-flag-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-flash"></i> fa-flash 
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-flask"></i> fa-flask</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-folder"></i> fa-folder</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-folder-o"></i> fa-folder-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-folder-open"></i> fa-folder-open</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-folder-open-o"></i> fa-folder-open-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-frown-o"></i> fa-frown-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-futbol-o"></i> fa-futbol-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-gamepad"></i> fa-gamepad</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-gavel"></i> fa-gavel</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-gear"></i> fa-gear 
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-gears"></i> fa-gears 
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-gift"></i> fa-gift</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-glass"></i> fa-glass</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-globe"></i> fa-globe</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-graduation-cap"></i> fa-graduation-cap</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-group"></i> fa-group 
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-hand-grab-o"></i> fa-hand-grab-o
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-hand-lizard-o"></i> fa-hand-lizard-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-hand-paper-o"></i> fa-hand-paper-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-hand-peace-o"></i> fa-hand-peace-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-hand-pointer-o"></i> fa-hand-pointer-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-hand-rock-o"></i> fa-hand-rock-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-hand-scissors-o"></i> fa-hand-scissors-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-hand-spock-o"></i> fa-hand-spock-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-hand-stop-o"></i> fa-hand-stop-o
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-hdd-o"></i> fa-hdd-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-headphones"></i> fa-headphones</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-heart"></i> fa-heart</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-heart-o"></i> fa-heart-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-heartbeat"></i> fa-heartbeat</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-history"></i> fa-history</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-home"></i> fa-home</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-hotel"></i> fa-hotel 
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-hourglass"></i> fa-hourglass</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-hourglass-1"></i> fa-hourglass-1
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-hourglass-2"></i> fa-hourglass-2
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-hourglass-3"></i> fa-hourglass-3
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-hourglass-end"></i> fa-hourglass-end</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-hourglass-half"></i> fa-hourglass-half</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-hourglass-o"></i> fa-hourglass-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-hourglass-start"></i> fa-hourglass-start</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-i-cursor"></i> fa-i-cursor</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-image"></i> fa-image 
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-inbox"></i> fa-inbox</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-industry"></i> fa-industry</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-info"></i> fa-info</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-info-circle"></i> fa-info-circle</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-institution"></i> fa-institution
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-key"></i> fa-key</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-keyboard-o"></i> fa-keyboard-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-language"></i> fa-language</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-laptop"></i> fa-laptop</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-leaf"></i> fa-leaf</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-legal"></i> fa-legal 
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-lemon-o"></i> fa-lemon-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-level-down"></i> fa-level-down</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-level-up"></i> fa-level-up</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-life-bouy"></i> fa-life-bouy
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-life-buoy"></i> fa-life-buoy
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-life-ring"></i> fa-life-ring</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-life-saver"></i> fa-life-saver
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-lightbulb-o"></i> fa-lightbulb-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-line-chart"></i> fa-line-chart</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-location-arrow"></i> fa-location-arrow</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-lock"></i> fa-lock</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-magic"></i> fa-magic</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-magnet"></i> fa-magnet</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-mail-forward"></i> fa-mail-forward
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-mail-reply"></i> fa-mail-reply
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-mail-reply-all"></i> fa-mail-reply-all
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-male"></i> fa-male</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-map"></i> fa-map</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-map-marker"></i> fa-map-marker</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-map-o"></i> fa-map-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-map-pin"></i> fa-map-pin</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-map-signs"></i> fa-map-signs</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-meh-o"></i> fa-meh-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-microphone"></i> fa-microphone</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-microphone-slash"></i> fa-microphone-slash
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-minus"></i> fa-minus</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-minus-circle"></i> fa-minus-circle</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-minus-square"></i> fa-minus-square</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-minus-square-o"></i> fa-minus-square-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-mobile"></i> fa-mobile</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-mobile-phone"></i> fa-mobile-phone
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-money"></i> fa-money</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-moon-o"></i> fa-moon-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-mortar-board"></i> fa-mortar-board
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-motorcycle"></i> fa-motorcycle</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-mouse-pointer"></i> fa-mouse-pointer</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-music"></i> fa-music</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-navicon"></i> fa-navicon
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-newspaper-o"></i> fa-newspaper-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-object-group"></i> fa-object-group</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-object-ungroup"></i> fa-object-ungroup</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-paint-brush"></i> fa-paint-brush</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-paper-plane"></i> fa-paper-plane</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-paper-plane-o"></i> fa-paper-plane-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-paw"></i> fa-paw</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-pencil"></i> fa-pencil</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-pencil-square"></i> fa-pencil-square</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-pencil-square-o"></i> fa-pencil-square-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-phone"></i> fa-phone</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-phone-square"></i> fa-phone-square</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-photo"></i> fa-photo 
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-picture-o"></i> fa-picture-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-pie-chart"></i> fa-pie-chart</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-plane"></i> fa-plane</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-plug"></i> fa-plug</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-plus"></i> fa-plus</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-plus-circle"></i> fa-plus-circle</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-plus-square"></i> fa-plus-square</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-plus-square-o"></i> fa-plus-square-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-power-off"></i> fa-power-off</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-print"></i> fa-print</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-puzzle-piece"></i> fa-puzzle-piece</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-qrcode"></i> fa-qrcode</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-question"></i> fa-question</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-question-circle"></i> fa-question-circle</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-quote-left"></i> fa-quote-left</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-quote-right"></i> fa-quote-right</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-random"></i> fa-random</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-recycle"></i> fa-recycle</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-refresh"></i> fa-refresh</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-registered"></i> fa-registered</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-remove"></i> fa-remove
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-reorder"></i> fa-reorder
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-reply"></i> fa-reply</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-reply-all"></i> fa-reply-all</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-retweet"></i> fa-retweet</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-road"></i> fa-road</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-rocket"></i> fa-rocket</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-rss"></i> fa-rss</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-rss-square"></i> fa-rss-square</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-search"></i> fa-search</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-search-minus"></i> fa-search-minus</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-search-plus"></i> fa-search-plus</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-send"></i> fa-send 
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-send-o"></i> fa-send-o
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-server"></i> fa-server</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-share"></i> fa-share</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-share-alt"></i> fa-share-alt</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-share-alt-square"></i> fa-share-alt-square
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-share-square"></i> fa-share-square</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-share-square-o"></i> fa-share-square-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-shield"></i> fa-shield</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-ship"></i> fa-ship</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-shopping-cart"></i> fa-shopping-cart</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-sign-in"></i> fa-sign-in</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-sign-out"></i> fa-sign-out</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-signal"></i> fa-signal</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-sitemap"></i> fa-sitemap</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-sliders"></i> fa-sliders</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-smile-o"></i> fa-smile-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-soccer-ball-o"></i> fa-soccer-ball-o
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-sort"></i> fa-sort</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-sort-alpha-asc"></i> fa-sort-alpha-asc</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-sort-alpha-desc"></i> fa-sort-alpha-desc</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-sort-amount-asc"></i> fa-sort-amount-asc</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-sort-amount-desc"></i> fa-sort-amount-desc
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-sort-asc"></i> fa-sort-asc</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-sort-desc"></i> fa-sort-desc</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-sort-down"></i> fa-sort-down
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-sort-numeric-asc"></i> fa-sort-numeric-asc
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-sort-numeric-desc"></i> fa-sort-numeric-desc
                    </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-sort-up"></i> fa-sort-up
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-space-shuttle"></i> fa-space-shuttle</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-spinner"></i> fa-spinner</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-spoon"></i> fa-spoon</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-square"></i> fa-square</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-square-o"></i> fa-square-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-star"></i> fa-star</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-star-half"></i> fa-star-half</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-star-half-empty"></i> fa-star-half-empty
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-star-half-full"></i> fa-star-half-full
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-star-half-o"></i> fa-star-half-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-star-o"></i> fa-star-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-sticky-note"></i> fa-sticky-note</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-sticky-note-o"></i> fa-sticky-note-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-street-view"></i> fa-street-view</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-suitcase"></i> fa-suitcase</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-sun-o"></i> fa-sun-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-support"></i> fa-support
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-tablet"></i> fa-tablet</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-tachometer"></i> fa-tachometer</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-tag"></i> fa-tag</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-tags"></i> fa-tags</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-tasks"></i> fa-tasks</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-taxi"></i> fa-taxi</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-television"></i> fa-television</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-terminal"></i> fa-terminal</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-thumb-tack"></i> fa-thumb-tack</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-thumbs-down"></i> fa-thumbs-down</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-thumbs-o-down"></i> fa-thumbs-o-down</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-thumbs-o-up"></i> fa-thumbs-o-up</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-thumbs-up"></i> fa-thumbs-up</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-ticket"></i> fa-ticket</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-times"></i> fa-times</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-times-circle"></i> fa-times-circle</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-times-circle-o"></i> fa-times-circle-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-tint"></i> fa-tint</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-toggle-down"></i> fa-toggle-down
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-toggle-left"></i> fa-toggle-left
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-toggle-off"></i> fa-toggle-off</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-toggle-on"></i> fa-toggle-on</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-toggle-right"></i> fa-toggle-right
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-toggle-up"></i> fa-toggle-up
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-trademark"></i> fa-trademark</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-trash"></i> fa-trash</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-trash-o"></i> fa-trash-o</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-tree"></i> fa-tree</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-trophy"></i> fa-trophy</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-truck"></i> fa-truck</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-tty"></i> fa-tty</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-tv"></i> fa-tv
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-umbrella"></i> fa-umbrella</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-university"></i> fa-university</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-unlock"></i> fa-unlock</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-unlock-alt"></i> fa-unlock-alt</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-unsorted"></i> fa-unsorted
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-upload"></i> fa-upload</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-user"></i> fa-user</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-user-plus"></i> fa-user-plus</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-user-secret"></i> fa-user-secret</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-user-times"></i> fa-user-times</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-users"></i> fa-users</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-video-camera"></i> fa-video-camera</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-volume-down"></i> fa-volume-down</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-volume-off"></i> fa-volume-off</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-volume-up"></i> fa-volume-up</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-warning"></i> fa-warning
                      </div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-wheelchair"></i> fa-wheelchair</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-wifi"></i> fa-wifi</div>
                    <div class="col-md-3 col-sm-4"><i class="fa fa-fw fa-wrench"></i> fa-wrench</div>
                  </div>
      </div>      
      <div class="modal-footer">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<? }else{vistaBloqueada();}?>