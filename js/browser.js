const new_dir_form = document.getElementById('new_dir_form');
const new_dir_text = document.getElementById('new_dir');
const new_dir_err = document.getElementById('new_dir_error');
const confirmDeleteModal = document.getElementById('confirmDeleteModal');
const confirmDelete = document.getElementById('confirmDelete');
const deleteButtons = Array.from(document.querySelectorAll('.delete'));
const uploadModal = document.getElementById('uploadModal');
const closeUploadModal = document.getElementById('closeUploadModal');
const downloadButtons = Array.from(document.querySelectorAll('.download'));
const search = document.getElementById('search');
const allItems = document.querySelectorAll('[data-search]');

// Some input preventions
if (new_dir_form) {
	new_dir_form.addEventListener('submit', e => {
		const folderName = new_dir_text.value;
		const symbolRegex = /\W/g;
		if (symbolRegex.test(folderName)) {
			e.preventDefault();
			new_dir_err.innerText = 'Error! Try not using special characters';
		}
		const dirs = Array.from(document.querySelectorAll('.folder'));
		const allDirectories = dirs.map(dir => dir.innerText.toLowerCase());
		if (!allDirectories.every(el => el !== folderName.toLowerCase())) {
			e.preventDefault();
			new_dir_err.innerText = 'Error! A folder by this name already exists';
		}
		if (new_dir_text.value.length === 0) {
			new_dir_err.innerText = 'Error! You might want to name your folder';
			e.preventDefault();
			return;
		}
	});
}
if (confirmDelete !== null) {
	confirmDelete.addEventListener('click', e => {
		if (!e.target.classList.contains('yes')) {
			e.preventDefault();
			confirmDeleteModal.classList.remove('modal_overlay--active');
		}
	});
}
deleteButtons.forEach(btn => {
	btn.addEventListener('mouseover', e => {
		if (e.target.classList.contains('delete')) {
			const parentDiv = e.target.parentNode.parentNode;
			parentDiv.classList.add('bg_hover');
		}
	});
});
deleteButtons.forEach(btn => {
	btn.addEventListener('mouseleave', e => {
		const parentDiv = e.target.parentNode.parentNode;
		parentDiv.classList.remove('bg_hover');
	});
});
downloadButtons.forEach(btn => {
	btn.addEventListener('mouseover', e => {
		if (e.target.classList.contains('download')) {
			const parentDiv = e.target.parentNode.parentNode;
			parentDiv.classList.add('bg_hover--2');
		}
	});
});
downloadButtons.forEach(btn => {
	btn.addEventListener('mouseleave', e => {
		const parentDiv = e.target.parentNode.parentNode;
		parentDiv.classList.remove('bg_hover--2');
	});
});

if (uploadModal) {
	closeUploadModal.addEventListener('click', e => {
		e.preventDefault();
		uploadModal.classList.remove('modal_overlay--active');
	});
}
// search

if (search) {
	search.addEventListener('keyup', () => {
		allItems.forEach(item => {
			item.classList.add('hidden');
			if (
				item
					.getAttribute('data-search')
					.toLowerCase()
					.includes(search.value)
			) {
				item.classList.remove('hidden');
			}
		});
	});
}
