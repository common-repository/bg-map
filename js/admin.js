// Copy Sortcode
function bg_mapCopy() {
	/* Get the text field */
	let copyText = document.getElementById("bg_map-copy");

	/* Select the text field */
	copyText.select();
	copyText.setSelectionRange(0, 99999); /* For mobile devices */

	/* Copy the text inside the text field */
	navigator.clipboard.writeText(copyText.value);
}
