function copyToClipboard() {
    var copyText = document.getElementById("urlBox");
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices
    document.execCommand("copy");
    alert("URLs copied to clipboard!");
}
