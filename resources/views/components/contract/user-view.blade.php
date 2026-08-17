<script>
document.addEventListener('click', function (e) {
    var row = e.target.closest('.user-contract-row-click');
    if (!row) return;
    var url = row.dataset.url;
    if (url) window.open(url, '_blank');
});
</script>
