</div>
<script>
function updateLang() {
    var e = document.getElementById("language");
    var cookieValue = e.options[e.selectedIndex].value;
    // write the cookie and reload the explorer
    document.cookie = "NG_TRANSLATE_LANG_KEY" + "=" + cookieValue + ";" + ";path=/";
    window.location.reload();
    return false;
}
</script>
</body>
</html>