<!-- 콘솔 및 alert 출력 위한 유틸리티 클래스 -->

<?php
    class LogUtil {
        public static function log($text) {
            echo "<script>console.log('$text');</script>";
        }

        public static function error($text) {
            echo "<script>console.error('$text');</script>";
        }

        public static function alert($text) {
            echo "<script>alert('$text');</script>";
        }
    }
?>