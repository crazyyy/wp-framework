window.onload =  function () {
    document.querySelector('[data-slug="javascript-error-reporting-client"] .deactivate a').addEventListener('click', function (event) {
        event.preventDefault()
        if (confirm('Plugin deactivating. Would you like to also delete recorded data?')) {
            window.location.href = event.target.getAttribute('href')
        } else {
            window.location.href = event.target.getAttribute('href') + '&preserve'
        }
    })
}