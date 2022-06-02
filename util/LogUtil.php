<?php
    class LogUtil {
        public static function log($text) {
            echo "<script>console.log('$text');</script>";
        }

        public static function alert($text) {
            echo "<script>alert('$text');</script>";
        }

        public static function error($text) {
            echo "<script>console.error('$text');</script>";
        }
    }
?>