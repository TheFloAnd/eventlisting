<?php
namespace app\module;
    class notification
    {
        public static function error($txt){
            echo'<div class="alert alert-warning text-center alert-dismissible fade show" role="alert">
                    '. $txt .'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
        public static function info($txt){

        }
        public static function success($txt){
            echo'<div class="alert alert-success text-center alert-dismissible fade show" role="alert">
            '. $txt .'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }