const password = document.getElementById('password');
const start = document.getElementById('start');

start.addEventListener('click', e => {
	if (password.value.length <= 0) {
		console.log('psw too short');
		e.preventDefault();
		return;
	}
});
