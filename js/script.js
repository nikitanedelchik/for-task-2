document.addEventListener('DOMContentLoaded', () => {
	let btnsDelete = document.querySelectorAll('.delete-object');
	if (btnsDelete) {
		btnsDelete.forEach((elem, index) => {
			elem.addEventListener('click', (e) => {
				let isDelete = confirm('Delete this user?');
				if (!isDelete) {
					e.preventDefault();
					location.reload()
				}
			})
		})
	}
})