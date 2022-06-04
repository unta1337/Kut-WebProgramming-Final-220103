<!-- 텍스트의 악의적인 사용을 방지하는 유틸리티 -->

<?php
    class TextUtil {
        public static function asPlainText($text) {
            return htmlspecialchars($text, ENT_QUOTES);
        }
    }
?>