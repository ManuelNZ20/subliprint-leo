<?php
include ('../../../app/views/layout/buttons.php');
// include (__DIR__.'/buttons.php');

function cardInformation($urlGeneral,$title,$information,$url,$class,$img,$textBtn){
    $btnDirection = btnDirection($textBtn,$url,$class);
    return 
            '<div class="col-sm-6 mb-3 mb-sm-0">'.
            '<a href="'.$urlGeneral.'" class="link-default">'.
                '<div class="card align-items-center shadow-sm rounded">'.
                    '<div class="row g-0">'.
                        '<div class="col-md-8">'.
                            '<div class="card-body">'.
                            '<h5 class="card-title">'.$title.'</h5>'.
                            '<p class="card-text">'.$information.'</p>'.
                            $btnDirection.
                            '</div>'.
                        '</div>'.
                        '<div class="col-md-4">'.
                        '<img src="'.$img.'" class="img-card rounded-end h-100" alt="img-cards-information">'.
                        '</div>'.
                    '</div>'.
                '</div>'.
            '</a>'.
            '</div>'
            ;
}

?>