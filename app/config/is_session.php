<?php
if (isset($_SESSION)) {
} else {
    echo "<script>
    document.location.href='/'
    </script>";
}
